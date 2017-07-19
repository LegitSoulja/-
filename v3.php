<?
class WHERE{
  
  static public function __build($arr){
    $append = $values = array();
    $flag = 1;
    foreach($arr as $k => $v){
      if(!is_numeric($k) && !empty($v)){
        array_push($append, "`".$k."`=?");
        array_push($append, 'AND');
        array_push($values, $v);
        $flag = 1;
      }else{
        if($flag === 1) array_pop($append);
        array_push($append, $v);
        $flag = 2;
      }
    }
    
    if($flag === 1) array_pop($append);
    
    $types = "";
    foreach($values as $v) $types .= self::getType($v);
    return array($append, $values, $types);
  }
  static private function getType($type){
    switch(gettype($type)){
      case "string": return "s";
      case "boolean": // bool is recognized as an integer
      case "integer": return "i";
      case "double": return "d";
      default: throw new \Error("Unable to bind params");
    }
  }
  
}

class SELECT{
  static public function __build($columns, $table, $where, $explain = false){
    $columns = (count($columns) > 0)?$columns:array("*");
    $where = WHERE::__build($where);
    $sql = (($explain)?"EXPLAIN ":""); 
    $sql .= "SELECT ".join(", ", $columns)." `".$table."` WHERE ".join(" ", $where[0]);
    print_r($sql);
    print_r($where);
    
  }
}

class UPDATE{}
class INSERT{}
