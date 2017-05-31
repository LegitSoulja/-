class DELETE
{
    private static $object;
    private static $table;
    public function __construct($table, $object = null)
    {
        self::$object = $object;
        self::$table  = $table;
    }
    public function __toString()
    {
        $where = "";
				if(!empty(self::$object)) $where = new WHERE(self::$object);
        return "DELETE FROM " . self::$table . " " . $where;
    }
}
