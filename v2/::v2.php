<?php

namespace SlickInject;

class SlickInject{
  
    // SQLObject
    private static $SQLObject;
  
    function __construct($dbhost, $dbname, $dbpass, $dbname){
      return $this->_connect($a, $b, $c, $d);
    }
    private function _connect($a, $b, $c, $d){
      self::$SQLObject = new SlickInject\SQLObject($a, $b, $c, $d);
      return self::$SQLObject->ping();
    }
    static function connected{
      if(!(self::$SQLObject instanceof SlickInject\SQLObject) || !(self::$SQLObject->ping())) return false 
      return true;
    }
    
    public function SELECT($columns = [], "table", $where, $rr = true, $sql = null){
      if(!self::$connected){
        
      }
    }
}

interface Prepare{
    static function WHERE($object){
        $z    = "WHERE";
        $type = 0;
        if (count($object) < 1) return "";
        foreach ($a as $n => $v) {
            if (!empty($n) && !empty($v) && !(is_numeric($n))) {
                if ($type == 1) $z .= " AND";
                $type = 1;
                $z .= " `" . ($n) . "`=";
                if (is_numeric($v)) {
                    $z .= "?";
                    continue;
                }
                $z .= "?";
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
    static function INSERT($table, $object){
        $z    = "INSERT INTO `" . ($table) . "`";
        $keys = array(array(),array());
        foreach ($object as $n => $v) {
            if (!empty($n) && !empty($v) && !(is_numeric($n))) {
                array_push($keys[0], $n);
                if (is_numeric($v)) array_push($keys[1], $v);
                else array_push($keys[1], ":".$n);
                $object[$n] = ":".$n;
            }
        }
        $z .= " (" . (join(", ", $keys[0])) . ") VALUES (" . (join(", ", $keys[1])) . ")";
        return array($z, $object);
    }
}
