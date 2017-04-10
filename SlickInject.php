<?
namespace SlickInject;

include_once 'parser.php';

use SlickInject\Parser as Parser;

class SlickInject{
	public static function INSERT($table,$object){
		return new Parser\INSERT($table,$object);
	}
	public static function DELETE($table,$object){
		return new Parser\DELETE($table,$object);
	}
	public static function SELECT($table,$c=null, $where=null){
		return new Parser\SELECT($table,$c,$where);
	}
	public static function UPDATE($table,$object,$where){
		return new Parser\UPDATE($table,$object,$where);
	}
}
