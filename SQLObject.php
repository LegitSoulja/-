<?
namespace SlickInject\SQLObject;
class SQLResponce{
  private static $request;
  private static $rows = array();
  private static $row = array();
  private static $rowsIstablished = false;
  function __construct($request){
    self::$request = $request;
  }
  function returnRows(){
    if($this->num_rows() == 0 || !self::$rowsIstablished) return false;
    if($this->num_rows() > 1) return self::$rows;
    return self::$row;
  }
  function rowsIstablished(){
    return self::$rowsIstablished;
  }
  function getRequest(){
    return self::$request;
  }
  function num_rows(){
    return self::$request->num_rows;
  }
  function setup($request){
	if($request->num_rows < 1) return;
    $return = array();
    $index = 0;
    while($row = mysqli_fetch_array($request)){
      $return[$index] = $row;
      $index++;
    }
    self::$rowsIstablished = true;
    if(count($return) > 1){
      self::$rows = $return;
    }else{
      self::$row = $return;
    }
	return true;
  }
}
class SQLObject{
  private static $sql;
  private static $connected = false;
  public function connect($dbhost, $dbuser, $dbpass, $dbname){
	self::$sql = @mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if(!self::$sql) throw new \Exception("Could not connect to database -> ".$this->getConnectionError());
	if($this->getConnectionError() == 0) return true;
	return true;
  }
  public function getConnectionError(){
    return mysqli_connect_error();
  }
  public function returnLastError(){
	  return mysqli_error(self::$sql);
  }
  public function isConnected(){
    return self::$connected;
  }
  public function close(){
    mysqli_close(self::$sql);
  }
  public function update($arr, $where, $table){ // $where as `ticket`=1
	  if(gettype($arr) != "array" || !$arr) throw new Exception("Array must be given with its key, and value");
	  if(empty($where)) throw new Error("Invalid use of update, WHERE is needed to update a specific table.");
	  $data = "(";
	  $count = 1;
	  foreach($arr as $key => $v){
		  if(strlen($data) > 1){$data .= ",";}
		  $data .= "`{$key}`='{$v}'";
	  }
	  return "UPDATE {$table} SET {$keys} VALUES {$value}";
  }
  public function escapeString($string){
	  return self::$sql->real_escape_string($string);
  }
  public function query($q, $returnRows = true){
    if($r = mysqli_query(self::$sql, $q)){
      $responce = new SQLResponce($r);
      if(!$returnRows) return $responce; // request good, ignore obtaining rows
      if($responce->setup($r)){
        return $responce;
        // $responce->returnRows();
        // $responce->num_rows();
        // $responce->getRequest();
      }
      return false;
    }
    return false;
  }
}
