##### SlickInject

    Description..

```php
/* COMPLETE GUIDE */

// connect to a database
$si = new SlickInject("host", "username", "password", "database_name");

/*
    Understanding SELECT.
    
    (1st argument)
    [] = Columns, in which is used in SQL, for example SELECT id, username, email FROM `table`.
    [] = *
    and ["id","username","email"] = id, username, password
    
    (2nd argument) 
    Table Name
    
    (3rd argument) WHERE -> (Search)
     Key(Column)/Value(Data). Used to select rows from a table with a criteria, of a specific column name, and value.
     
     Behind the engine, array("id"=>1) turns into (WHERE `id`=1).
     
*/

// SELECT DATA
$arr = $si->SELECT([], "table", array("id"=>1));

$arr = $si->SELECT([], "table", array("id"=>1, "username"=>"Johnny"));

/*
    Wait, now there's key/values in that array. What does that do?
    
    Behind the engine, if 2 key/values are together in an array, "AND" is placed in-between those 2 if non is specified. Therefor, the result of the sql below is "SELECT * FROM `table` WHERE `id=1 AND `username`='Johnny'";
*/

// This also works, either way

$arr = $si->SELECT([], "table", array("id"=>1, "AND", "username"=>"Johnny"));

// Other

$arr = $si->SELECT([], "table", array("`id` > 1"));

/*
    Yes, strings work as normal when used. "SELECT * FROM `table` WHERE id > 1"
*/







```


### SQLObject

SQLObject can be used stand-alone if you don't like the quick and ease of SlickInject. Maybe, it's missing something. SQLObject Documentation..

##### Connecting
- Method 1
```php
$sql = new \SlickInject\SQLObject();
$sql->connect("localhost", "username", "password", "database");
```
- Method 2
```php
$sql = new \SlickInject\SQLObject("localhost", "username", "password", "database");
```

##### Sending Queries
```php
$sql = new \SlickInject\SQLObject("localhost", "username", "password", "database");
//
$sql->query("INSERT INTO table (username) VALUES ('LegitSoulja')"); // *SQLResponce
//
$sql->query("SELECT * FROM table", true); // Array : Get array of requested table rows
```

##### Ping
```php
$sql = new \SlickInject\SQLObject("localhost", "username", "password", "database");
//
$sql->ping(); // Boolean : Returns if database is still connected
```

##### Errors
```php
$sql = new \SlickInject\SQLObject("localhost", "username", "password", "database");
//
$sql->getConnectionError(); // String : Get connect errror, if present
//
$sql->getLastError(); // String : Get last error from last executed query
```

##### Close Datbase

```php
$sql = new \SlickInject\SQLObject("localhost", "username", "password", "database");
//
$sql->close(); 
```

### SQLResponce

#### Functions
- hasRows() :: Boolean : If query returned any rows
- getResponce() :: Returns mysqli_query responce
- num_rows() :: Int : Return number of rows
- getData() :: Array : Return query table row(s)

