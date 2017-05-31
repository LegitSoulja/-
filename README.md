##### SlickInject | In Development

### SlickInject
> Coming Soon

### SQLObject

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

