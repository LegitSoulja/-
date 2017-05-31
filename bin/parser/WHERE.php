<? /* LegitSoulja */
class WHERE
{
    private static $data = array();
    
    function __construct($a, $sql = null)
    { self::$data = array($a,$sql); }
  
    public function __toString()
    {
        $z    = "WHERE";
        $type = 0;
        foreach (self::$data[0] as $n => $v) {
            $n = ((!empty(self::$data[1])) ? self::$data[1]->escapeString($n) : mysql_escape_string($n));
            $v = ((!empty(self::$data[1])) ? self::$data[1]->escapeString($v) : mysql_escape_string($v));
            if (!empty($n) && !empty($v) && !(is_int($n))) {
                if ($type == 1) $z .= " AND";
                $type = 1;
                $z .= " `" . $n . "`=";
                if (is_int($v)) {
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
