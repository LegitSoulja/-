<?php
namespace SlickInject\Parser;

class WHERE
{
    private static $data = array();
    
    function __construct($a, $sql = null)
    { self::$data = array($a,$sql); }
    
    public function __toString()
    {
        $z    = "WHERE";
        $type = 0;
        if (count(self::$data[0]) < 1) return "";
        foreach (self::$data[0] as $n => $v) {
            $n = ((!empty(self::$data[1])) ? self::$data[1]->escapeString($n) : mysql_escape_string($n));
            $v = ((!empty(self::$data[1])) ? self::$data[1]->escapeString($v) : mysql_escape_string($v));
            if (!empty($n) && !empty($v) && !(is_numeric($n))) {
                if ($type == 1) $z .= " AND";
                $type = 1;
                $z .= " `" . $n . "`=";
                if (is_numeric($v)) {
                    $z .= $v;
                    continue;
                }
                $z .= "'$v'";
            } else {
                $type = 2;
                $z .= " " . $v;
            }
            continue;
        }
        return $z;
    }
}

class INSERT
{
    private static $data = array();
    
    function __construct($table, $object, $sql = null)
    {  self::$data = array($table,$object,$sql); }
    
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

class SELECT
{
    private static $data = array();
	
    public function __construct($columns = [], $table, $where = null)
    {
        if (!is_array($columns)) throw new \Exception("Args index 0 is not an array.");
        self::$data = array($columns, $table, $where);
    }
	
    public function __toString()
    { return "SELECT " . ((empty(self::$data[0])) ? "*" : join(",", self::$data[0])) . " FROM `" . (self::$data[1]) . "` " . (string) ((empty(self::$data[2])) ? null : (new WHERE(self::$data[2]))); }
}

class DELETE
{
    private static $data = array();
    
    public function __construct($table, $object = null)
    { self::$data = array($table,$object); }
    
    public function __toString()
    { return "DELETE FROM `" . self::$data[0] . "` " . (string) (new WHERE(self::$data[1])); }
}

class UPDATE
{
    private static $data = array();
	
    function __construct($table, $object, $where, $sql = null)
    { self::$data = array($table,$object,$where,$sql); }
	
    function __toString()
    {
        $z      = "UPDATE TABLE %s SET";
        $where  = (new WHERE(self::$data[2]));
        $append = "";
        foreach (self::$data[1] as $n => $v) {
            $n = ((!empty(self::$data[4])) ? self::$data[4]->escapeString($n) : mysql_escape_string($n));
            $v = ((!empty(self::$data[4])) ? self::$data[4]->escapeString($v) : mysql_escape_string($v));
            if (!empty($n) && !empty($v) && !is_numeric($n)) {
                $append .= "`" . $n . "`=";
                if (is_numeric($v)) $append .= (int) $v . " ";
                else $append .= "'" . $v . "' ";
            }
        }
        $z = str_replace("%s", "`" . self::$data[0] . "`", $z);
        return $z .= " " . $append . $where;
    }
}
