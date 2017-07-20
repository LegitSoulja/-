<?php
namespace test;
function _load_all($a)
{
    foreach (glob($a) as $b) {
        if (is_dir($b)) {
            _load_all($b . "/*"); // recursive include.
            continue;
        } else {
            if ($b == __FILE__) continue;
            if (pathinfo($b)['extension'] == "php") : include $b; endif;
        }
    }
}
_load_all("lib/*");


// // connect to the database / create instance
$si = new SlickInject("localhost", "username", "password", "database_name");
// $si->connect() is usable aswell, instead of passing the args via the constructor

// get rows from database as an array
$data = $_slickinject->SELECT([], "table", array("id"=>1)); // @Array : Returns array

// INSERT
$si->INSERT('table', array("id"=>5,"username"=>"bob")); // @SQLResponce

// UPDATE
$si->UPDATE('table', array("username"=>"bobo"), array("id"=>5)); // @SQLResponce

// CLOSE
$si->close();

