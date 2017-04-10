<?php
namespace SlickInject\Parser;

class WHERE
{
    private static $object;
    private static $index = 0;
    function __construct($a)
    {
        self::$object = $a;
    }
    public function __toString()
    {
        $z = "";
        foreach (self::$object as $a => $b) {
            $z .= $this->format($a, mysql_escape_string($b), count(self::$object));
            self::$index++;
        }
        return $z;
    }
    private function format($a, $b, $c)
    {
        if (self::$index > $c)
            return;
        if ($c == 1)
            return "WHERE " . $a . "='" . $b . "'";
        if (self::$index < 1) {
            return "WHERE " . $a . "='" . $b . "' AND ";
        } else if (self::$index === $c - 1) {
            return "" . $a . "='" . $b . "'";
        } else {
            return "" . $a . "='" . $b . "' AND ";
        }
    }
}
class INSERT
{
    private static $index = 0;
    private static $object;
    private static $table;
    public function __construct($table, $object)
    {
        self::$object = $object;
        self::$table  = $table;
    }
    public function __toString()
    {
        $keys   = "";
        $values = "";
        $c      = count(self::$object);
        $dupes  = array();
        foreach (self::$object as $a => $b) {
            if (in_array($a, $dupes))
                continue;
            array_push($dupes, $a);
            $r = $this->next($a, mysql_escape_string($b), $c);
            $keys .= $r["a"];
            $values .= $r["b"];
            self::$index++;
        }
        return "INSERT INTO `" . self::$table . "` (" . $keys . ") VALUES (" . $values . ")";
    }
    private function next($a, $b, $c)
    {
        if ($c == 1)
            return array(
                "a" => $a,
                "b" => "'" . $b . "'"
            );
        if (self::$index == $c - 1) {
            return array(
                "a" => $a,
                "b" => "'" . $b . "'"
            );
        } else {
            return array(
                "a" => $a . ",",
                "b" => "'" . $b . "',"
            );
        }
    }
}
class UPDATE
{
    private static $index = 0;
    private static $object;
    private static $where;
    private static $table;
    public function __construct($table, $object, $where)
    {
        self::$object = $object;
        self::$table  = $table;
        self::$where  = new WHERE($where);
    }
    public function __toString()
    {
        $select = "UPDATE `" . self::$table . "` SET ";
        $c      = count(self::$object);
        foreach (self::$object as $a => $b) {
            $select .= $this->next($a, mysql_escape_string($b), $c);
            self::$index++;
        }
        $select .= " " . self::$where;
        return $select;
    }
    private static function next($a, $b, $c)
    {
        if ($c == 1)
            return $a . "='" . $b . "'";
        if (self::$index == $c - 1) {
            return $a . "='" . $b . "'";
        } else {
            return $a . "='" . $b . "',";
        }
    }
}
class SELECT
{
    private static $table;
    private static $columns;
    private static $where;
    private static $index;
    public function __construct($table, $columns = null, $where = null)
    {
        if (!is_array($columns))
            throw new \Exception("Args index 1 is not an array.");
        self::$table   = $table;
        self::$columns = (empty($columns)) ? "*" : join(",", $columns);
        self::$where   = (empty($where)) ? null : new WHERE($where);
    }
    public function __toString()
    {
        return "SELECT " . (self::$columns) . " FROM `" . (self::$table) . "` " . (self::$where);
    }
}
class DELETE
{
    private static $object;
    private static $table;
    public function __construct($table, $object)
    {
        self::$object = $object;
        self::$table  = $table;
    }
    public function __toString()
    {
        $where = new WHERE(self::$object);
        return "DELETE FROM " . self::$table . " " . $where;
    }
}
