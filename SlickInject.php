<?
namespace SlickInject;

use SlickInject\Parser as Parser;
use SlickInject\SQLObject as SQLObject;

class SlickInject
{
    protected static $SQLObject;
	protected static $parser;
    function connect($dbhost, $dbuser, $dbpass, $dbname)
    {
        self::$SQLObject = new SQLObject();
        return self::$SQLObject->connect($dbhost, $dbuser, $dbpass, $dbname);
    }
    function isConnected()
    {
		return (gettype(self::$SQLObject) != null)?true:false;
    }
    static function INSERT($table, $object)
    {
        if (!self::isConnected())
            return new Parser\INSERT($table, $object);
        else
            return self::$SQLObject->query(new Parser\INSERT($table, $object,self::$SQLObject));
    }
    static function DELETE($table, $object)
    {
        if (!self::isConnected())
            return new Parser\DELETE($table, $object);
        else
            return self::$SQLObject->query(new Parser\DELETE($table, $object));
    }
    static function SELECT($table, $c = null, $where = null)
    {
        if (!self::isConnected())
            return new Parser\SELECT($table, $c, $where);
        else
            return self::$SQLObject->query(new Parser\SELECT($table, $c, $where,self::$SQLObject));
    }
    static function UPDATE($table, $object, $where)
    {
        if (!self::isConnected())
            return new Parser\UPDATE($table, $object, $where);
        else
            return self::$SQLObject->query(new Parser\UPDATE($table, $object, $where,self::$SQLObject));
    }
	function close(){
		if (!self::isConnected()) return;
		return self::$SQLObject->close();
	}
}
