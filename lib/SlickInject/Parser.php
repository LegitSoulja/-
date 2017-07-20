<?php
namespace SlickInject;

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
    if($where != NULL && count($where[1]) > 1 && isset($where[0])) {
      $sql .= " WHERE ".join(" ", $where[0]);
		}else if(isset($where[0])) {
			$sql .= " ".join(" ", $where[0]);
		}
    return array($sql, (isset($where[1]))?$where[1]:NULL);
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
  final static public function TRUNCATE($table){
    $sql = "TRUNCATE TABLE `".$table."`";
    return array($sql);
  }
  final static public function DELETE($table, $where){
    $sql = "DELETE FROM `".$table."`";
    if(count($where) > 0) {
      $where = self::WHERE($where);
      $sql .= " WHERE ".join(" ", $where[0]);
    }
    return array($sql, $where[1]);
  }
}