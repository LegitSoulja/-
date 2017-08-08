<?
/* global $si; */

if(!isset($_POST["username"]) || !isset($_POST["password"])) {
  die("No information received.");
}

$username = $_POST["username"];
$password = hash('sha1', $_POST["password"]);

if($si->SELECT([], "users", array("username"=>$username, "password"=>$password), false)->num_rows() > 0) {
  // user exist, 
}else {
  // user does not exist
  
  // for this example, let's insert/register this data since the user doesn't exist
  $si->INSERT("users", array("username"=>$username, "password"=>$password));
}
