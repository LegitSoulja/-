<?
class SELECT
{
    private static $table;
    private static $columns;
    private static $where;
    private static $index;
    public function __construct($table, $columns = null, $where = null)
    {
        if (!is_array($columns)) throw new \Exception("Args index 1 is not an array.");
        self::$table   = $table;
        self::$columns = (empty($columns)) ? "*" : join(",", $columns);
        self::$where   = (empty($where)) ? null : new WHERE($where);
    }
    public function __toString()
    {
        return "SELECT " . (self::$columns) . " FROM `" . (self::$table) . "` " . (self::$where);
    }
}
