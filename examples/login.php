<?
/* global $si; */

/*
* DO NOT USE THIS AS A REAL EXAMPLE! - INSECURE (SlickInject Usage Only)
*/

if(!isset($_POST["username"]) || !isset($_POST["password"])) {
  die("No information received.");
}

$username = $_POST["username"];
$password = hash('sha1', $_POST["password"]);

if($si->SELECT([], "users", array("username"=>$username, "password"=>$password), false)->num_rows() > 0) {
  // user exist, 
}else {
  // user does not exist
}
