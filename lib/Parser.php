<?php
namespace SlickInject\Parser;

class WHERE
{
    static function __build($a, $sql = null)
    {
        $z    = "WHERE";
        $type = 0;
        if (count($a) < 1) return "";
        foreach ($a as $n => $v) {
            $n = (($sql != null) ? $sql->escapeString($n) : mysql_escape_string($n));
            $v = (($sql != null) ? $sql->escapeString($v) : mysql_escape_string($v));
            if (!empty($n) && !empty($v) && !(is_numeric($n))) {
                if ($type == 1) $z .= " AND";
                $type = 1;
                $z .= " `" . ($n) . "`=";
                if (is_numeric($v)) {
                    $z .= $v;
                    continue;
                }
                $z .= "'" . ($v) . "'";
            } else {
                $type = 2;
                $z .= " " . ($v);
            }
            continue;
        }
        return $z;
    }
}

class INSERT
{
   static function __build($table, $object, $sql = null)
    {
        $z    = "INSERT INTO `" . ($table) . "`";
        $keys = array(array(),array());
        
        foreach ($object as $n => $v) {
            $n = (($sql != null) ? $sql->escapeString($n) : mysql_escape_string($n));
            $v = (($sql != null) ? $sql->escapeString($v) : mysql_escape_string($v));
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
    static function __build($columns = [], $table, $where = null, $sql = null)
    { return "SELECT " . ((count($c) < 1) ? "*" : join(",", $c)) . " FROM `" . ($table) . "` " . (($where != null) ? (WHERE::__build($where, $sql)) : ""); }
}

class DELETE
{
    static function __build($table, $object, $sql = null)
    { return "DELETE FROM `" . ($table) . "` " .(WHERE::__build($object, $sql)); }
}

class UPDATE
{
    static function __build($table, $object, $where, $sql = null)
    {
        $z      = "UPDATE %s SET";
        $where  = (WHERE::__build($where, $sql));
        $append = "";
        foreach ($object as $n => $v) {
            $n = (($sql != null) ? $sql->escapeString($n) : mysql_escape_string($n));
            $v = (($sql != null) ? $sql->escapeString($v) : mysql_escape_string($v));
            if (!empty($n) && !empty($v) && !is_numeric($n)) {
                $append .= "`" . $n . "`=";
                if (is_numeric($v)) $append .= (int) $v . " ";
                else $append .= "'" . $v . "' ";
            }
        }
        $z = str_replace("%s", "`" . ($table) . "`", $z);
        return $z .= " " . ($append) . ($where);
    }
}
