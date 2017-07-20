<?php

use SlickInject\Parser as Parser;
use SlickInject\SQLObject as SQLObject;

define("SI_VERSION", 102); // 1.0.2

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
    if(!$this->isConnected() || !isset($table) || !isset($object) || !isset($where)) return;
    $update = Parser::UPDATE($table, $object, $where);
    return self::$SQLObject->query($update[0], (isset($update[1]))?$update[1]:NULL);
  }
  
  public function SELECT($columns, $table, $where = NULL, $rr = true){
    if(!$this->isConnected() || !isset($columns) || !isset($table)) return;
    $select = Parser::SELECT($columns, $table, $where);
    return self::$SQLObject->query($select[0], (isset($select[1]))?$select[1]:NULL, $rr);
  }
  
  public function INSERT($table, $object){
    if(!$this->isConnected() || !isset($table) || !isset($object)) return;
    $insert = Parser::INSERT($table, $object);
    return self::$SQLObject->query($insert[0], $insert[1]);
  }
  
  public function TRUNCATE($table){
    if(!$this->isConnected() || !isset($table)) return;
    $insert = Parser::TRUNCATE($table);
    return self::$SQLObject->query($insert[0]);
  }
  
}
