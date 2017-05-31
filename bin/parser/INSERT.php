<?
class INSERT
{
    private static $data = array();
    
    function __construct($table, $object, $sql = null)
    { self::$data = array($table,$object,$sql); }
    
    public function __toString()
    {
        $z    = "INSERT INTO `" . (self::$data[0]) . "`";
        $keys = array(array(),array());
        
        foreach (self::$data[1] as $n => $v) {
            $n = ((!empty(self::$data[2])) ? self::$data[2]->escapeString($n) : mysql_escape_string($n));
            $v = ((!empty(self::$data[2])) ? self::$data[2]->escapeString($v) : mysql_escape_string($v));
            if (!empty($n) && !empty($v) && !(is_numeric($n))) {
                array_push($keys[0], $n);
                if (is_numeric($v)) array_push($keys[1], $v);
                else array_push($keys[1], "'" . $v . "'");
            }
        }
        return $z .= " (" . (join(",", $keys[0])) . ") VALUES (" . (join(",", $keys[1])) . ")";
    }
}
