<?php
namespace test;
function _load_all($a)
{
    foreach (glob($a) as $b) {
        if (is_dir($b)) {
            _load_all($b . "/*"); // recursive include.
            continue;
        } else {
            if (basename($b, ".php") == basename(__FILE__, ".php"))
                continue;

            if (pathinfo($b)['extension'] == "php") 
                include $b;
        }
    }
}
_load_all("lib/*");

use SlickInject\SlickInject as SlickInject;

// // connect to the database / create instance
$_slickinject = new SlickInject("localhost", "username", "password", "database_name");

// - or -

/*
    $_slickinject = new SlickInject();
    $_slickinject->connect("localhost", "username", "password", "database_name");
*/

/* DO WORK */

// get rows from database as an array
$data = $_slickinject->SELECT([], "table", array("id"=>1)); // @Array : Returns array
// Hidden SQL: "SELECT * FROM `table` WHERE `id`=1"

// insert
$_slickinject->INSERT('table', array("id"=>5,"username"=>"bob")); // @SQLResponce :: Returns responce, since no data is being given.
// Hidden SQL: "INSERT INTO `table` (id, username) VALUES (5, 'bob')"

// update
$_slickinject->UPDATE('table', array("username"=>"bobo"), array("id"=>5)); // @SQLResponce
// Hidden SQL: "UPDATE `table` SET `username`='bobo' WHERE `id`=5"

// close database connection
$_slickinject->close();

/*
    You do not need to create a new instance of SlickInject. Creating a new instance allows you more ease with not having to worry about
    dealing with mysql, and handling queries, and errors yourself. 
    
    You can use SlickInject as static, but only the SQL string will be returned on EVERY function for SQL.
    Enabling DEBUG will return the same results.
*/

// Example of outputting JUST the string of the SQL.
SlickInject::SELECT([], "table", array("id"=>1)); 
// Output: SELECT * FROM `table` WHERE `id`=1


// Check examples for more
