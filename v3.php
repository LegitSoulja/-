<?php

class Parser{
  
  final static public function WHERE($arr){
    $append = $values = array();
    $flag = 1;
    foreach($arr as $k => $v){
      if(!is_numeric($k) && !empty($v)){
        array_push($append, "`".$k."`=?");
        array_push($append, 'AND');
        array_push($values, $v);
        $flag = 1;
      }else{
        if($flag === 1) array_pop($append);
        array_push($append, $v);
        $flag = 2;
      }
    }
    
    if($flag === 1) array_pop($append);
    
    $types = "";
    foreach($values as $v)
    { $types .= self::getType($v); }
    foreach(array_keys($values) as $i)
    { $values[$i] = &$values[$i]; }
    array_unshift($values, $types);
    return array($append, $values);
  }
  
  final static private function getType($type){
    switch(gettype($type)){
      case "string": return "s";
      case "boolean": // bool is recognized as an integer
      case "integer": return "i";
      case "double": return "d";
      default: throw new \Error("Unable to bind params");
    }
  }
  
  final static public function SELECT($columns, $table, $where, $explain = false){
    $columns = (count($columns) > 0)?$columns:array("*");
    $where = (count($where) > 0)?self::WHERE($where):NULL;
    $sql = (($explain)?"EXPLAIN ":""); 
    $sql .= "SELECT ".join(", ", $columns)." FROM `".$table."`";
    if($where != NULL)
      $sql .= " WHERE ".join(" ", $where[0]);
    return array($sql, $where[1]);
  }
  final static public function INSERT($table, $object){
    $sql = "INSERT INTO `".$table."` ";
    $names = array();
    $replace = array();
    $values = array();
    foreach($object as $k => $v){
      if(isset($k) && isset($v)){
        if(is_numeric($k)) return;
        array_push($names, "`".$k."`");
        array_push($replace, "?");
        array_push($values, $v);
      }
    }
    $sql .= "(".join(", ", $names).") VALUES ";
    $sql .= "(".join(", ", $replace).")";
    
    $types = "";
    foreach($values as $v)
    { $types .= self::getType($v); }
    
    foreach(array_keys($values) as $i)
    { $values[$i] = &$values[$i]; }
    
    array_unshift($values, $types);
    
    return array($sql, $values);
  }
  final static public function UPDATE($table, $object, $where){
    $insert = array();
    $values = array();
    $where = (count($where) > 0)?self::WHERE($where):NULL;
    $sql = "UPDATE `".$table."` SET";
    foreach($object as $k => $v){
      if(isset($k) && isset($v)){
        if(is_numeric($k)) continue;
        array_push($insert, "`".$k."`=?");
        array_push($values, $v);
      }
    }
    $sql .= " ".join(", ", $insert);
    if($where != NULL){
      $sql .= " WHERE ".join(" ", $where[0]);
    }
    
    $types = "";
    foreach($values as $v)
    { $types .= self::getType($v); }
    
    if($where != NULL){
      $types .= $where[1][0];
      array_shift($where[1]);
    }
    
    foreach(array_keys($values) as $i)
    { $values[$i] = &$values[$i]; }
    
    $ni = count($values);
    
    foreach($where[1] as $k => $v){
      $values[$ni] = $v;
      $ni++;
    }
    
    // fix
    foreach(array_keys($values) as $i)
    { $values[$i] = &$values[$i]; }
    

    array_unshift($values, $types);
    return array($sql, $values);
  }
  final static public function TRUNCATE(){}
  final static public function DELETE($table, $where){
    $sql = "DELETE FROM `".$table."`";
    if(count($where) > 0) {
      $where = self::WHERE($where);
      $sql .= " WHERE ".join(" ", $where[0]);
    }
    return array($sql, $where[1]);
  }
}

class SlickInject{
  
  private static $SQLObject;
  
  function __construct(){
    $args = func_get_args();
    if(count($args) === 4)
      return $this->connect($args[0], $args[1], $args[2], $args[3]);
  }
  
  public function connect($db_host, $db_user, $db_pass, $db_name){
    if($this->isConnected()) return;
    self::$SQLObject = new SQLObject($db_host, $db_user, $db_pass, $db_name);
  }
  
  public function isConnected(){
    return ((self::$SQLObject instanceof SQLObject))?true:false;
  }
  
  public function getSQLObject()
  { return self::$SQLObject; }
  
  public function close()
  { return self::$SQLObject->close(); }
  
  public function UPDATE($table, $object, $where){
    if(!$this->isConnected()) return;
    $update = Parser::UPDATE($table, $object, $where);
    $responce = self::$SQLObject->query($update[0], $update[1]);
    print_r($responce);
  }
  
  public function SELECT($columns, $table, $where){
    if(!$this->isConnected()) return;
    $select = Parser::SELECT($columns, $table, $where);
    $responce = self::$SQLObject->query($select[0], $select[1], true);
    print_r($responce);
  }
  
  public function INSERT($table, $object){
    if(!$this->isConnected()) return;
    $insert = Parser::INSERT($table, $object);
    $responce = self::$SQLObject->query($insert[0], $insert[1]);
    print_r($insert);
  }
}


class SQLResponce{
  
  private static $result;
  private static $rows;
  private static $row;
  private static $stmt;
  
  function __construct($result, $stmt){
    self::$result = $result;
    self::$stmt = $stmt;
    if($result->num_rows < 1) return;
    $rows = array();
    while($row = $result->fetch_assoc())
    { array_push($rows, $row); }
    if(count($rows) === 1) return self::$row = $rows;
    return self::$rows = $rows;
  }
  
  public function getResult()
  { return self::$result; }
  
  public function didAffect(){
    // check is any rows was affected.
    return (self::$stmt->affected_rows > 0)?true:false;
  }
  
  public function error()
  { return (self::$result)?true:false; }
  
  public function hasRows()
  { return ((count(self::$rows) > 0) || (count(self::$row) > 0))?true:false; }
  
  public function num_rows()
  { return self::$result->num_rows; }
  
  public function getData(){
    return (count(self::$rows) > 0)?self::$rows:self::$row;
  }

}

class SQLObject{
  private static $con;
  function __construct(){
    $args = func_get_args();
    if(count($args) === 4) 
      return $this->connect($args[0], $args[1], $args[2], $args[3]);
  }
  
  public function close()
  { return @\mysqli_close(self::$con); }
  
  public function connect($db_host, $db_user, $db_pass, $db_name){
    if($this->isConnected()) return;
    self::$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
  }
  
  public function isConnected()
  { return (isset(self::$con) && $this->ping())?true:false; }
  
  public function getConnectionError()
  { return @\mysqli_connect_error(); }
  
  public function getLastError()
  { return @\mysqli_error(self::$con); }
  
  public function escapeString(&$string)
  { return self::$con->real_escape_string($string); }
  
  public function ping()
  { return (@self::$con->ping())?true:false; }
  
  public function query($sql, $bind, $rr = false){
    print_r(func_get_args());
    try{
      $prep = self::$con->stmt_init();
      if($prep->prepare($sql)){
        call_user_func_array(array($prep, "bind_param"), $bind);
        if($prep->execute()){
          $result = new SQLResponce($prep->get_result(), $prep); // nd_mysqli && 
          if($rr) return ($result->hasRows())?$result->getData():array();
          return ($result->didAffect())?$result:false;
        }
      }
      throw new \Exception($this->getLastError());
    }catch(\Exception $ex){
      die("Error ".$ex->getMessage());
    }
  }
}
