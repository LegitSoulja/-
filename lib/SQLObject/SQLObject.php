<?
namespace SlickInject;

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
  { @\mysqli_close(self::$con); }
  
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
    try{
      $prep = self::$con->stmt_init();
      if($prep->prepare($sql)){
        if(isset($bind) && $bind != NULL) call_user_func_array(array($prep, "bind_param"), $bind);
        if($prep->execute()){
          $result = new SQLResponce($prep->get_result(), $prep); // nd_mysqli && 
          if($rr) return ($result->hasRows())?$result->getData():array();
          return $result;
        }
      }
      throw new \Exception($this->getLastError());
    }catch(\Exception $ex){
      die("Error ".$ex->getMessage());
    }
  }
}