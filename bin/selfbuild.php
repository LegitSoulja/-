<?php
// running @ http://legitsoulja.info/SlickInject.php
$status = (isset($_GET["status"]))?true:false;
include "PHP/Beautifier.php"; // http://pear.php.net/package/PHP_Beautifier/doc

$default = "America/Eastern";
$clean = array("<?php","<?","?>");

$o = (object) json_decode(file_get_contents('http://ip-api.com/json/' . (isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'])), true);
date_default_timezone_set(((isset($o->timezone))?$o->timezone:$default));

unset($o, $default);
function scopePos($content){
  $r = explode("#buildbelow", $content);
  $r = str_replace("#endbuild", "", $r[1]);
  return $r;
}

$sqo = scopePos(file_get_contents("https://raw.githubusercontent.com/LegitSoulja/SlickInject/master/lib/SQLObject/SQLObject.php?c=".time()/2));
$si = scopePos(file_get_contents("https://raw.githubusercontent.com/LegitSoulja/SlickInject/master/lib/SlickInject/SlickInject.php?c=".time()/2));
$parser = scopePos(file_get_contents("https://raw.githubusercontent.com/LegitSoulja/SlickInject/master/lib/SlickInject/Parser.php?c=".time()/2));
$d = date('l jS \of F Y h:i:s A');

if($status){
  header("Content-Type: text/plain");
}else{
  header("Content-Type: application/octet-stream");
  header("Content-Transfer-Encoding: Binary");
  header("Content-disposition: attachment; filename=\"SlickInject.php\"");
}

$build = <<<BUILD
<?php 
/*
\| Compiled & Built on {$d} : Clean & Formatted
\| SlickInject v2
\| @Author: LegitSoulja
\| @License: MIT
\| @Source: https://github.com/LegitSoulja/SlickInject
*/
namespace {
  if (!extension_loaded('mysqlnd')) throw new Error("Failed to load nd_mysqli extension.");
  use SlickInject\Parser as Parser;
  use SlickInject\SQLObject as SQLObject;
  define("SI_VERSION", 102); // 1.0.2
  
  {$si}
}

namespace SlickInject {
  {$sqo}
  {$parser}
}
BUILD;

$pb = new PHP_Beautifier();
$pb->addFilter("ArrayNested");
$pb->addFilter('EqualsAlign');
$pb->addFilter('NewLines');
$pb->addFilter('IndentStyles');
$pb->setInputString($build);
unset($si, $sqo, $parser);
$pb->process();
$h= $pb->get();
//$h.="•••"; // cause an error, to test error handler
$h = str_replace($clean, "", $h);
try{
    eval($h);
    unset($h);
    if($status) die(header("Location: https://img.shields.io/badge/build-passing-brightgreen.svg"));
    $pb->show();
    die();
}catch(Error $ex){
    if($status) die(header("Location: https://img.shields.io/badge/build-failing-red.svg"));
    header_remove();
    header("Content-Type: text/html");
    $line = $ex->getLine() ;
    $stack = explode(PHP_EOL, $h)[$line - 1];
    die("Failed to parse : ".$ex->getMessage()."<br/><br/> : Line ".$line."<br/><br/>: Stack -> ".$stack);
}
exit;
