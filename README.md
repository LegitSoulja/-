##### SlickInject

Tired of MySQLi, SQL, Duplicate Code, SQL Injection Risks and wasting time? SlickInject eliminates the use of even having to worry, most part waste time, secondly, must more faster, fun and easier to code.

SlickInject makes it very easy, to write code to manage your database, on top of that secure that no SQL Injections is possible. Meaning, you won't experience the unexperienced, in which you wouldn't even want to experience. 

### SlickInject Documentation

##### Connecting

Let's start off, learning how to connect. It's very simple.

```php
$si = new SlickInject("host","username","password", "database_name");

// or

$si = new SlickInject();
$si->connect("host","username","password", "database_name"))
```

##### Closing Database

```php
$si->close();
```

##### (SELECT) from a datbase

Select is very special, and can do almost anything, the same way you would write an ordinary SQL string.

### Params
- 1. ##### Columns
> Columns can be added when selecting. A null array, equals (*), wildcard. Ex,

```[]``` = *, however , ["id","username"] = id, username. In result ```SELECT *``` or ```SELECT user, username```

- 2. ##### Table Name

> Table Name. Second thing required by SELECT

A table name, (string).

- 3. ##### WHERE

> Using WHERE, a key(name), and value(value) is needed. As of example below ```WHERE `id`=1```. Adding another index key/value will automatically place ```AND``` in between if not assigned.

- 4. ##### Return Rows (Optional: Defaul = true)

> By default, when using SELECT, you will get your data responce back. You may want to count the rows, or get additional information from the responce. To get SQLResponce object, make this 4th option ```FALSE```



```php
// get data
$si->SELECT([], "table", array("id"=>1)); // Output: Array

// get responce
$si->SELECT([], "table", array("id"=>1), false); // Output: SQLResponce

// get number of rows
$si->SELECT([], "table", array("id"=>1), false)->num_rows();
/ - or -
$si->SELECT([], "table", array("id"=>1), false)->getResponce()->num_rows;

// get specific row columns
$si->SELECT(["id","username","email"], "table", array("id"=>1)); // Output: Array
```

##### (INSERT) into a datbase





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

