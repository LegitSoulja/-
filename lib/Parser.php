<?php
namespace SlickInject\Parser;

class Parser{
    static function escapeString(&$sql, $so) {
        return $sql = (!empty($so)) ? $so->escapeString($sql) : mysql_escape($sql);
    }
}

class WHERE
{
    static function __build($a, $sql = null)
    {
        $z    = "WHERE";
        $type = 0;
        if (count($a) < 1) return "";
        foreach ($a as $n => $v) {
            Parser::escapeString($n, $sql);
            Parser::escapeString($v, $sql);
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
                if(empty($v)) trigger_error("NULL WHERE $n", E_USER_ERROR);
                if(!is_numeric($n)) continue;
                $type = 2;
                $z .= " " . ($v);
            }
            continue;
        }
        return ($type === 0)?"":$z;
    }
}

class INSERT
{
   static function __build($table, $object, $sql = null)
    {
        $z    = "INSERT INTO `" . ($table) . "`";
        $keys = array(array(),array());
        
        foreach ($object as $n => $v) {
            Parser::escapeString($n, $sql);
            Parser::escapeString($v, $sql);
            if (!empty($n) && !empty($v) && !(is_numeric($n))) {
                array_push($keys[0], '`'.$n.'`');
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
    { return "SELECT " . ((count($columns) < 1) ? "*" : join(",", $columns)) . " FROM `" . ($table) . "` " . (($where != null) ? (WHERE::__build($where, $sql)) : ""); }
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
        $append = array();
        foreach ($object as $n => $v) {
            Parser::escapeString($n, $sql);
            Parser::escapeString($v, $sql);
            if (!empty($n) && !empty($v) && !is_numeric($n)) {
                $add = "`" . $n . "`=";
                if (is_numeric($v)) $add .= (int) $v . " ";
                else $add .= "'" . $v . "' ";
                array_push($append, $add);
            }
        }
        $z = str_replace("%s", "`" . ($table) . "`", $z);
        return $z .= " " . join(", ", $append) . ($where);
    }
}
