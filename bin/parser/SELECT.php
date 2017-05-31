<?
class SELECT
{
    private static $data = array();
    
    public function __construct($table, $columns = null, $where = null)
    {
        if (!is_array($columns)) throw new \Exception("Args index 1 is not an array.");
        array_push(self::$data, $table);
    }
    
    public function __toString()
    { return "SELECT " . ((empty($columns)) ? "*" : join(",", $columns)) . " FROM `" . (self::$data[0]) . "` " . (string) ((empty($where)) ? null : new WHERE($where)); }
}
