### SlickInject!



###### ::v2

You cannot depend on escaping strings/remove code. There will always be another way around. With v2, that problem will be eliminated, into just using, and combining the use of sending "safe/raw" sql code to the server first, before the actual data. (Prepare/Execute).



    Want to avoid risky SQL Injections? Tired of typing out SQL syntax? Bothered with long boring/duplicate code when managing your database?



SlickInject is the solution to your problems, in which will save you some time, with coding. That's if you build websites from scratch without using frameworks. SlickInject makes it easy to manage your database, protect again SQL injections, accomplish things faster, less code, less duplicate code (Using MySQLi). Let's make the life of a back-end dev easier.

#### Connect to database.

```php

$si = new SlickInject("host", "username", "password", "database_name");

```



### SELECT



> Using SELECT, you will automatically get returned the selected rows in an array format. Check examples for more detailed examples



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



// stay efficient : 3rd argument is false, which will return an SQLResponce

$response = $si->SELECT([],"table",[], false);



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

$email = "test@email.com"



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



### SQL (SQLObject)

Sometimes, SlickInject may lack certain things when managing your database. You can use SQLObject, as a below which is returned by SlickInject.

```php

$sql = $si->getSQLObject();

$sql->query("SELECT * FROM `table`", true); // return rows

```





### SQLObject



SQLObject can be used stand-alone if you don't like the quick and ease of use with SlickInject. Maybe, it's missing something. SQLObject Documentation..



##### Connecting

- Method 1

```php

$sql = new \SlickInject\SQLObject("localhost", "username", "password", "database");

```

- Method 2

```php

$sql = new \SlickInject\SQLObject();

$sql->connect("localhost", "username", "password", "database");

```



##### Sending Queries

```php

$sql->query("INSERT INTO table (username) VALUES ('LegitSoulja')"); // *SQLResponce

//

$sql->query("SELECT * FROM table", true); // Array : Get array of requested table rows

```



##### Ping

```php

$sql->ping(); // Boolean : Returns if database is still connected

```



##### Errors

```php

$sql->getConnectionError(); // String : Get connect errror, if present

//

$sql->getLastError(); // String : Get last error from last executed query

```



##### Close Datbase



```php

$sql->close(); 

```





#### Functions | Return <T> | Description

- connect(s,s,s,s) :: void : Connect to databse.

- getConnectionError() :: integer : Get database connection status error code

- getLastError() :: string : Get last database error

- escapeString(s) :: string :: **Deprecated**

- ping() :: bool : Return if connection is still live and not closed.

- query() :: void : Shouldn't be used unless you know what you're doing.



### SQLResponce



#### Functions | Return <T> | Description

> Last arguments for SlickInject must be false as of [this](https://github.com/LegitSoulja/SlickInject/blob/dev/README.md#obtain-mysqli_query-request), to get SQLResponce 

- hasRows() :: bool : If query returned any rows

- getResult() :: object : Returns mysqli_query responce

- num_rows() :: integer : Return number of rows

- getData() :: array : Return query table row(s)

- didAffect() :: bool : If any rows was affected during execution

- error() :: bool : If result doesn't exist or contain any errors



### Future Additions



- [ ] Create "Tables, Databases" with ease.

- [ ] Complex/Smart algorithm of building SQL queries w/ parser.

- [ ] Create a parser, in which validates your SQL queries, and validate queries before executed (Prevent SQL Injection).

- [ ] More in dept usage/mech/doc/additions of SlickInject (Plan, and make methods/functions understandable, easier to understand/learn/use).

- [ ] SlickInject Database TreeView (Displays maximum, but minimum detailed information about your database, tables, etc).

- [ ] Most of all, noob friendly, family safe, environment safe, global safe, familiarly recognizable and easily understandable. (TOo much?)



### contribute



> If you see a vulnerability, or recommend an extra security layer, or just want to help in any-way, you are allowed, and welcomed. This project may/may not be (updated/maintained), therefore, it is in your hands to maintain. 



However, SlickInject is also useful for those who are new to working with databases(SQL), or php even. This is a great start!. It has never been this easier, and safe to work with databases. I am now very happy to build sites more comfortable with the power of SlickInject. 

