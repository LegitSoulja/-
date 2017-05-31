<?
class DELETE
{
    private static $data = array();
    
    public function __construct($table, $object = null)
    { self::$data = array($table,$object); }
    
    public function __toString()
    { return "DELETE FROM `" . self::$data[0] . "` " . (string) (new WHERE(self::$data[1])); }
}
