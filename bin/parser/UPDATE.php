<?
class UPDATE
{
    private static $index = 0;
    private static $object;
    private static $where;
    private static $table;
    private static $sql;
    public function __construct($table, $object, $where, $sql = null)
    {
        self::$object = $object;
        self::$table  = $table;
        self::$where  = new WHERE($where, $sql);
        self::$sql    = $sql;
    }
    public function __toString()
    {
        $select = "UPDATE `" . self::$table . "` SET ";
        $c      = count(self::$object);
        foreach (self::$object as $a => $b) {
            $select .= $this->next($a, ((!empty(self::$sql)) ? self::$sql->escapeString($b) : mysql_escape_string($b)), $c);
            self::$index++;
        }
        $select .= " " . self::$where;
        return $select;
    }
    private static function next($a, $b, $c)
    {
        if ($c == 1) return $a . "='" . $b . "'";
        if (self::$index == $c - 1) return $a . "='" . $b . "'";
        return $a . "='" . $b . "',";
    }
}
