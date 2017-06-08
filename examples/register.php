<?
/* global $si; */

/*
* DO NOT USE THIS AS A REAL EXAMPLE! - INSECURE (SlickInject Usage Only)
*/

if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"])){

  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];
  
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) die("Invalid Email");
  if(strlen($username) < 3 || strlen($username) > 25) die("Username to short, or too long.");
  if(strlen($password) < 5 || strlen($password) > 25) die("Password to short, or too long.");
  
  // encrypt password
  $password = hash('sha1', $password);
  
  $userData = array(
    "username" => $username, 
    "password" => $password, 
    "email" => $email
  );
  
  // insert into database
  $si->INSERT('users', $userData);
  die("Registered :)");
  
}

die("Failed to register. Username,Password,Email is invalid.");
