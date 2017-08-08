### SlickInject!
###### ::v2

#### Supports PHP (v5.6 - v7.1)
- [x] MySQLi (100% fully supported)

> ###### [![g](http://legitsoulja.info/build/SlickInject?status)](#) [![GitHub issues](https://img.shields.io/github/issues/LegitSoulja/SlickInject.svg)](https://github.com/LegitSoulja/SlickInject/issues) [![GitHub forks](https://img.shields.io/github/forks/LegitSoulja/SlickInject.svg)](https://github.com/LegitSoulja/SlickInject/network) [![GitHub stars](https://img.shields.io/github/stars/LegitSoulja/SlickInject.svg)](https://github.com/LegitSoulja/SlickInject/stargazers)

SlickInject is a ```PHP``` library in which allows you to write fast back-end sites using MySQLi with style. Not only SlickInject increase workflow, but also manages your queries, and make sure you stay secure. SlickInject writes your queries automatically, and protects your database from any leaks & injections.

> I would've never made this if I knew a project as of [Medoo](https://medoo.in/) existed. This project was something I had thought of on my own originally due to the time I waste in working backend. I never intended to make a project similar, and or better. This is something I use for my personal use. It's small, fast, and lightweight. It wouldn't be public, but decided why not share an have an extra repository. If you like this project, please show appreciation.

#### Installation
**Library**

- Lib\SlickInject (SlickInject/Parser)
- Lib\SQLObject (SQLObject)

**Single Build**: [Download/Generate a new build](http://legitsoulja.info/build/SlickInject)

> This single build is SlickInject combined into one single file. The link above will generate you a new updated build that hasn't been yet updated. Rely on this link, or the file in the build folder.

---
#### Connect to database.

```php
$si = new SlickInject("host", "username", "password", "database_name");
```
---
### SELECT

> Using SELECT, you will automatically get returned the selected rows in an array format. Check examples for more detailed information. 

##### Notes about ```SELECT```

- **The 1st argument ```must``` be an array. ```[]``` = ```*```**
- **The 3rd argument ```must``` be an array, and or ```NULL```**
- **The 4th argument is ```true``` by default. Setting it ```false``` will return ```SlickInject\SQLResponce``` (see below).**


The example query correlates to the code example of the way you should think when writing.

###### ```SELECT * FROM `table` ```

```php
$si->SELECT([], "table", []); // [] = *, 1st argument (All rows)
```


###### ```SELECT * FROM `table` WHERE `id` = 1```

#### Notes about ```WHERE```
- **The 3rd argument as spoke, is WHERE in this case. **

```php

// @param array []       |  Columns you're receiving
// @param string "table" |  The table name
// @param array array()  |  WHERE cause

$si->SELECT([], "table", array("id"=>1));
```

###### ```SELECT * FROM `table` WHERE `id`=1 AND `group_id`=1```

```php
$si->SELECT([], "table", array("id"=>1, "group_id"=>1));

// - or - 

$si->SELECT([], "table", array("id"=>1, "AND", "group_id"=>1));
```

###### ```SELECT `email` FROM `table` ORDER BY id```

```php
$si->SELECT(["email"], "table", array("ORDER BY", "id"))
```

###### ```SELECT `email` FROM `table` WHERE id = 1 ORDER BY id```

```php
$si->SELECT(["email"], "table", array("id"=>1, "ORDER BY", "id"))
```



###### ```SELECT `email` FROM `table` WHERE `group_id`=1 AND `id` > 1```

```php
$si->SELECT(["email"], "table", array("groud_id"=>1, "`id`>1"));
```

##### Change database

```php
$si->select_db("otherdatabase")->SELECT([], "table"); 
```

###### SQLResponce | SELECT (Example)

Except for the ```SELECT``` method, the others will return you ```SQLResponce```, however by default, you are given the rows of the selected data as an array, which can be toggled false as the 4th argument when using ```SELECT```

###### Obtain number of rows

```php
$response = $si->SELECT([], "table", [], false);

print_r($response ->num_rows()); // int
```



### UPDATE

###### ```UPDATE `table` SET `username`="Guest" WHERE `id`=1```

```php

$username = "Guest";

$si->UPDATE('users', array("username"=>$username), array("id"=>1));
```



### INSERT



###### ```INSERT INTO `table` (`username`, `email`) VALUES ('Johnny', 'test@email.com')```

```php

$username = "Johnny";

$email = "example@example.com"

// very simple, and easy.

$si->INSERT('table', array("username"=>$username, "email"=>$email));

```



### DELETE

###### ```DELETE FROM `table` WHERE `id`=1```

```php

$si->DELETE("table", array("id"=>1));

```



### TRUNCATE



###### ```TRUNCATE TABLE `table` ```

```php

$si->TRUNCATE("table");

```



### Closing Database

When using SlickInject, it does not handle rather or not the connection should be open or closed. Using the statement below, you can close your databse when you're done using it.

```php

$si->close();

```

### SQLObject

#### Functions | Return <T> | Description

- connect(string, string, string, string) :: void : Connect to databse.

- getConnectionError() :: integer : Get database connection status error code

- getLastError() :: string : Get last database error

- ping() :: bool : Return if connection is still live and not closed.

- query(string, array||null, bool) :: void : Shouldn't be used unless you know what you're doing.




### SQLResponce

#### Functions | Return <T> | Description

> Last arguments for SlickInject must be false as of [this](https://github.com/LegitSoulja/SlickInject/blob/dev/README.md#obtain-mysqli_query-request), to get SQLResponce 

- hasRows() :: bool : If query returned any rows

- getResult() :: object : Returns mysqli_query responce

- num_rows() :: integer : Return number of rows

- getData() :: array : Return query table row(s)

- didAffect() :: bool : If any rows was affected during execution

- error() :: bool : If result doesn't exist or contain any errors




