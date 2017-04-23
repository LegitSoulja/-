<?
namespace SlickInject;

// In-Case composer isn't being used. Recommended to use my _load_all function in test.php, if no composer is being used.
if (!class_exists("SlickInject\\Parser\\WHERE"))
    include 'Parser.php';
if (!class_exists("SlickInject\\SQLObject\\SQLObject"))
    include 'SQLObject.php';

use SlickInject\Parser as Parser;
use SlickInject\SQLObject\SQLObject as SQLObject;

class SlickInject
{
    private static $SQLObject = null;
    function connect($dbhost, $dbuser, $dbpass, $dbname)
    {
        self::$SQLObject = new SQLObject();
        return self::$SQLObject->connect($dbhost, $dbuser, $dbpass, $dbname);
    }
    function isConnected()
    {
        return (!(self::$SQLObject instanceof "SlickInject\\SQLObject\\SQLObject")) ? false : true;
    }
    static function INSERT($table, $object)
    {
        if (!self::isConnected())
            return (string) new Parser\INSERT($table, $object);
        else
            return self::$SQLObject->query((string) new Parser\INSERT($table, $object, self::$SQLObject), false);
    }
    static function DELETE($table, $object = null)
    {
        if (!self::isConnected())
            return (string) new Parser\DELETE($table, $object);
        else
            return self::$SQLObject->query((string) new Parser\DELETE($table, $object), false);
    }
    static function SELECT($table, $c = null, $where = null)
    {
        if (!self::isConnected())
            return (string) new Parser\SELECT($table, $c, $where);
        else
            return self::$SQLObject->query((string) new Parser\SELECT($table, $c, $where), true);
    }
    static function UPDATE($table, $object, $where)
    {
        if (!self::isConnected())
            return (string) new Parser\UPDATE($table, $object, $where);
        else
            return self::$SQLObject->query((string) new Parser\UPDATE($table, $object, $where, self::$SQLObject), false);
    }
    static function TRUNCATE($table)
    {
        if (!self::isConnected())
            return "TRUNCATE TABLE `$table`";
        else
            return self::$SQLObject->query("TRUNCATE TABLE `$table`", false);
    }
    function close()
    {
        if (!self::isConnected())
            return;
        self::$SQLObject->close();
        return self::$SQLObject = null;
    }
}
