<?
namespace test;
function _load_all($a)
{
    global $ignore;
    foreach (glob($a) as $b) {
        if (is_dir($b)) {
            _load_all($b . "/*");
            continue;
        } else {
            if (basename($b, ".php") == basename(__FILE__, ".php") || in_array(basename($b, ".php"), $ignore))
                continue;
            if (pathinfo($b)['extension'] == "php")
                include $b;
        }
    }
}
_load_all("/lib/*");

use SlickInject as SlickInject;

echo SlickInject::SELECT("table", ["*"], array(
    "id" => 1 // WHERE id=1
)); // returns SQL string

// connect to database, and get row data
$si = new SlickInject();
$si->connect("localhost", "username", "password", "database");
$si->SELECT("table", ["*", array(
    "id" => 1 // WHERE id=1
)); // returns object
