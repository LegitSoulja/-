<?
namespace SlickInject;

if (!class_exists("SlickInject\\Parser\\WHERE")) include 'Parser.php';
if (!class_exists("SlickInject\\SQLObject")) include 'SQLObject.php';

use SlickInject\Parser as Parser;
use SlickInject\SQLObject as SQLObject;

class SlickInject
{
    private static $SQLObject = null;
    private static $data = array("SlickInject\\SQLObject");
  
    function connect($dbhost, $dbuser, $dbpass, $dbname)
    { return self::$SQLObject = new SQLObject($dbhost, $dbuser, $dbpass, $dbname); }
  
    function isConnected()
    {
        return (!(self::$SQLObject instanceof self::$data[0])) 
          ? false 
          : true;
    }
  
    static function INSERT($table, $object)
    {
      return (!self::isConnected())
        ? ((string) new Parser\INSERT($table, $object)) 
        : (self::$SQLObject->query((string) new Parser\INSERT($table, $object, self::$SQLObject), false));
    }
  
    static function DELETE($table, $object = null)
    {
        return (!self::isConnected()) 
          ? ((string) new Parser\DELETE($table, $object)) 
          : (self::$SQLObject->query((string) new Parser\DELETE($table, $object), false));
    }
  
    static function SELECT($c = [], $table, $where = null)
    {
        return (!self::isConnected()) 
          ? ((string) new Parser\SELECT($c, $table, $where)) 
          : (self::$SQLObject->query((string) new Parser\SELECT($c, $table, $where), true));
    }
  
    static function UPDATE($table, $object, $where)
    {
        return (!self::isConnected()) 
          ? ((string) new Parser\UPDATE($table, $object, $where)) 
          : (self::$SQLObject->query((string) new Parser\UPDATE($table, $object, $where, self::$SQLObject), false));
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
