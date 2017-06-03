<?php
namespace SlickInject;

if (!class_exists("SlickInject\\Parser\\WHERE")) include 'Parser.php';
if (!class_exists("SlickInject\\SQLObject")) include 'SQLObject.php';

use SlickInject\Parser as Parser;
use SlickInject\SQLObject as SQLObject;

class SlickInject
{
    private static $debug = false;
    private static $SQLObject = null;
  
    function __construct(){
      if(self::$debug) return;
      if(count(func_get_args()) === 4)
        $this->connect(func_get_args()[0],func_get_args()[1],func_get_args()[2],func_get_args()[3]);
    }
    
    /* soon to be deprecated/private */
    function connect($dbhost, $dbuser, $dbpass, $dbname)
    { return self::$SQLObject = new SQLObject($dbhost, $dbuser, $dbpass, $dbname); }
  
    static function isConnected()
    {
      if(self::$SQLObject instanceof SQLObject && !(self::$debug)) return self::$SQLObject->ping();
      return false;
    }

    static function INSERT($table, $object)
    {
      return (!self::isConnected())
        ? (Parser\INSERT::__build($table, $object)) 
        : (self::$SQLObject->query(Parser\INSERT::__build($table, $object, self::$SQLObject), false));
    }
  
    static function DELETE($table, $object = [])
    {
        return (!self::isConnected()) 
          ? (Parser\DELETE::__build($table, $object)) 
          : (self::$SQLObject->query(Parser\DELETE::__build($table, $object, self::$SQLObject), false));
    }
  
    static function SELECT($columns = [], $table, $where = [], $return = true)
    {
        return (!self::isConnected()) 
          ? (Parser\SELECT::__build($c, $table, $where)) 
          : (self::$SQLObject->query(Parser\SELECT::__build($columns, $table, $where, self::$SQLObject), $return));
    }
  
    static function UPDATE($table, $object, $where)
    {
        return (!self::isConnected()) 
          ? (Parser\UPDATE::__build($table, $object, $where)) 
          : (self::$SQLObject->query(Parser\UPDATE::__build($table, $object, $where, self::$SQLObject), false));
    }
  
    static function TRUNCATE($table)
    {
        return (!self::isConnected()) 
          ? ("TRUNCATE TABLE `$table`") 
          : self::$SQLObject->query("TRUNCATE TABLE `$table`", false);
    }
  
    function close()
    {
        if (!self::isConnected()) return;
        return self::$SQLObject->close();
    }
}
