<?
class UPDATE
{
    private static $data = array();
    function __construct($table, $object, $where, $sql = null)
    { self::$data = array($table,$object,$where,$sql); }
    function __toString()
    {
        $z      = "INSERT INTO %s SET";
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
