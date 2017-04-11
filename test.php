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

// usage before class initialization
echo "<br/><br/>- <b>SQL (String)</b><br/>";
print_r(SlickInject::SELECT("table",["*"]));

// connect to database, and get row data

$si = new SlickInject();
$si->connect("localhost", "username", "password", "database");

echo "<br/><br/>- <b>Table data (Array)</b><br/>";
print_r($si->SELECT("table", ["*"], array(
    "id" => 1 // WHERE id=1
))->returnRows()); // returns array
                      
// OR
$SQLResponce = $si->SELECT("table", ["*"], array(
    "id" => 1 // WHERE id=1, instanceof SQLResponce
)); // returns object

echo "<br/><br/>- <b>SQL Responce (Object)</b><br/>";
print_r($SQLResponce);   

echo "<br/><br/><b>Get Number of rows SQLResponce</b><br/>";
print_r($SQLResponce->num_rows());

echo "<br/><br/><b>Get rows (Array) from SQLResponce</b><br/>";
print_r($rows_as_array = $SQLResponce->returnRows());
