<?
class TRUNCATE{
    private static $data = array();
    
    function __construct($table)
    { array_push(self::$data,$table); }
    
    function __toString()
    { return "TRUNCATE TABLE `".(self::$data[0])."`"; }
}
