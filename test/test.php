<?php
/*
\* Example usages of SlickInject to it's full potential.
*/

global $si; // SlickInject

// select all from table order by id
$si->SELECT([], "table", array("ORDER BY id"));
$si->SELECT([], "table", array("ORDER BY", "id")); // another way

// select all from table where id < 50 order by id
$si->SELECT([], "table", array("WHERE", "id < 50" ,"ORDER BY id"));

// select all from table where id == 1 and group == 1
$si->SELECT([], "table", array("id"=>1, "group"=>1));

// select id, group, contacts from table where group == 1 or group == 3
$si->SELECT(["id", "group", "contacts"], "table", array("group"=>1, "OR", "group"=>3));

// select id from table where id != 10
$si->SELECT([], "table", array("WHERE", "id", "!=", 10));
$si->SELECT([], "table", array("WHERE id != 10")); // another way
$si->SELECT([], "table", array("WHERE", "id != ", 10)); // another way

/*
* The only-time you add WHERE first is when you don't need to check if something matches. "id"=>2 "id = 2
*/

// update table set username = Guest where id = 1
$si->UPDATE("table", array("username"=>"Guest"), array("id"=>1));

// update table set username = Guest where id > 10
$si->UPDATE("table", array("username"=>"Guest"), array("WHERE", "id > 10")); 
$si->UPDATE("table", array("username"=>"Guest"), array("WHERE", "id > ", 10)); // another way

// insert into table (with this data)
$si->INSERT("table", array("username"=>"Hello World", "group"=>1));

// delete from table where (this data exist)
$si->DELETE("table", array("username"=>"Guest", "id"=>1));

// delete from table where id > 0. No need to add WHERE if your dont need to check if something matches.
$si->DELETE("table", array("id > 1"));

// ALWAYS CLOSE YOUR DATABASE TO RESERVE RESOURCES
$si->close();
