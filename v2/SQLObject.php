<?php
namespace SlickInject;

class SQLResponce{
  private static $rows = array();
  private static $row = array();
  private static $responce;
    
  function __construct($resp){
    self::$responce = $resp;
    if($resp->num_rows < 1) return true;
    $rows = array();
    while($row = \mysqli_fetch_assoc($resp)) array_push($rows,$row);
    if(count($rows) == 1) return self::$row = $rows;
    return self::$rows = $rows;
  }
  function __destruct() { } // will be used in the future
    
  public function getResponce() 
  { return self::$responce; }
  
  public function error()
  { return (self::$responce) ? true : false; }
    
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
  
  public function close() // close database connected
  { return @\mysqli_close(self::$sql); }
    
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
    
  public function getConnectionError() // get connect error
  { return @\mysqli_connect_error(); }
   
  public function getLastError() // get last sql error
  { return @\mysqli_error(self::$sql); }
    
  public function escapeString($string) // escapes string using mysqli
  { return self::$sql->real_escape_string($string); }
 
  public function ping() // checks if sql is connected
  { return (@self::$sql->ping()) ? true : false; }
  
  public function execute($query, $data){
    if($r = self::$sql->prepare($query)){
      if($r->execute($data)){
        // todo
      }
    }
    return false;
  }
  
  public function query($query,$rr = false){ // rr = returnRows
    try{
      if($r = @\mysqli_query(self::$sql, $query)){
        if(($resp = new SQLResponce($r))){ // this will always return true
          if($rr) return ($resp->hasRows())?$resp->getData():array();
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
