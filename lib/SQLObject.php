<?
namespace SlickInject;

class SQLResponce{
  private static $rows = array();
  private static $row = array();
  private static $responce;
  function __construct($resp){
    self::$responce = $resp;
    if($resp->num_rows < 1) return true;
    $rows = array();
    while($row = mysqli_fetch_assoc($resp)) array_push($rows,$row);
    if(count($rows) == 1) return self::$row = $rows;
    return self::$rows = $rows;
  }
  function __destruct() { } // will be used in the future
    
  public function getResponce() 
  { return self::$responce; }
    
  public function hasRows()
  { return ((count(self::$rows) > 0) || (count(self::$row) > 0)) ? true : false; }
    
  public function num_rows()
  { return self::$responce->num_rows; }
    
  public function getData()
  { return (count(self::$rows) > 0) ? self::$rows : self::$row; }
}

class SQLObject{
  protected static $sql;
  function __construct()
  { 
      if(count(func_get_args()) === 4) return $this->connect(func_get_args()[0],func_get_args()[1],func_get_args()[2],func_get_args()[3]); 
  }
  
  public function close()
  { return mysqli_close(self::$sql); }
    
  public function connect($dbhost,$dbuser,$dbpass,$dbname){
    if(self::$sql) $this->close();
    try{
      self::$sql = @\mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
      // error handle
      if($this->getConnectionError() != 0 || !self::$sql) throw new \Exception($this->getConnectionError());
    }catch(\Exception $ex){
      die($ex->getMessage());
    }
  }
    
  function __destruct() {} // will be used in the future
    
  public function getConnectionError()
  { return mysqli_connect_error(); }
    
  public function getLastError()
  { return mysqli_error(self::$sql); }
    
  public function escapeString($string)
  { return self::$sql->real_escape_string($string); }
    
  public function query($query,$rr = false){ // rr = returnRows
    try{
      if($r = mysqli_query(self::$sql, $query)){
        if(($resp = new SQLResponce($r))){ // this will always return true
          if($resp->hasRows() && $rr) return $resp->getData();
          return $resp;
        }
      }else{
        throw new \Exception($this->getLastError());
      }
    }catch(\Exception $ex){
      die("Error ".$ex->getMessage());
    }
  }
}
