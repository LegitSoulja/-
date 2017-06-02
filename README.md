### SlickInject

    Description..

#### Connect to database.
```php
$si = new SlickInject("host", "username", "password", "database_name");
```

###### ```SELECT * FROM `table` ```
```php
$si->SELECT([], "table");
```

###### ```SELECT * FROM `table` WHERE `id` = 1```
```php
$si->SELECT([], "table", array("id"=>1));
```

###### ```SELECT * FROM `table` WHERE `id`=1 AND `group_id`=1```
```php
$si->SELECT([], "table", array("id"=>1, "group_id"=>1));
// - or - 
$si->SELECT([], "table", array("id"=>1, "AND", "group_id"=>1));
```

###### ```SELECT `email` FROM `table` WHERE `group_id`=1 AND `id` > 1```
```php
$si->SELECT(["email"], "table", array("groud_id"=>1, "`id`>1"));
```

###### Obtain mysqli_query request
#### Obtain number of rows
```php
/* NOTE: A null [] array was placed, as WHERE. 
   4th argument must be false, in order to get the SQLResponce/Responce
*/

$si->SELECT([],"table",[], false)->num_rows();
// - or -
$si->SELECT([],"table",[], false)->getResponce()->num_rows; // get mysqli_query request
```

###### ```UPDATE `table` SET `username`="Guest" WHERE `id`=1```
```php
$username = "Guest";
$si->UPDATE('users', array("username"=>$username), array("id"=>1));
```

###### ```INSERT INTO `table` (`username`, `email`) VALUES ('Johnny', 'test@email.com')```
```php
$username = "Johnny";
$email = "test@email.com"

// very simple, and easy.
$si->INSERT('table', array("username"=>$username, "email"=>$email));
```

###### ```DELETE FROM `table` WHERE `id`=1```
```php
$si->DELETE("table", array("id"=>1));
```

###### ```TRUNCATE TABLE `table` ```
```php
$si->TRUNCATE("table");
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

#### Functions | Last arguments for SlickInject must be false, to get SQLResponce
- hasRows() :: Boolean : If query returned any rows
- getResponce() :: Returns mysqli_query responce
- num_rows() :: Int : Return number of rows
- getData() :: Array : Return query table row(s)

