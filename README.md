###### Deprecated.
> SlickInject was a development project for a several projects, and has became outdated/out of sync with this github repo source, and our server source. Merging will be soon. Afterwards, this project is in hands of whoever wish to continue.

# SlickInject

Want to avoid risky SQL Injections? Tired of typing out SQL syntax? Bothered with long boring code?

**SlickInject** is the solution to your problems, in which will hopefully save you some time, with coding. That's if you build websites from stratch without using frameworks.

## How to use?

###### Functions
- SELECT
```php
// let's select all the data from the table, with a specific criteria.
$email = "example@gmail.com"
SlickInject::SELECT("users",[],array("email"=>$email)); // [] = null, and is required to be an array.
// output: SELECT * FROM `users` WHERE email='example@gmail.com'

// Get specific columns, instead of getting all (*)
SlickInject::SELECT("users",["id","username","email"],array("email"=>$email));
// output: SELECT id,username,email FROM `users` WHERE email='example@gmail.com'
```

- INSERT
```php 
// 'Johnny' Inserts his username into a database. Note his name is mispelled.
$username = "Johny";
SlickInject::INSERT("users",array("username"=>$username)); 
// output: INSERT INTO `users` (username) VALUES ('Johny')
```

- UPDATE
```php
// 'Johnny' accidently mispelled his name, lets update to change it.
$username = "Johnny";
SlickInject::UPDATE("users", array("username"=>$username), array("username"=>"Johny")); 
// output: UPDATE `users` SET username='Johnny' WHERE username='Johny'
```

- DELETE
```php
$username = "Johnny";
SlickInject::DELETE("users", array("username"=>$username)); 
// output: DELETE FROM `users` WHERE username='Johnny'
```

# SQLObject
SQLObject make thing's even more easier. You don't have to hassle with writing code to get data from the database, or retrieve. With one simple line of code will give you, 

1. A SQLResponce object

With the power and usage of MySQLi, SlickInject uses MySQLi to send, and recieve data from your databases. Other's will soon be supported.

```php
namespace tutorial;

include 'lib/SlickInject.php';

use SlickInject\SlickInject as SlickInject;

// To be safe with parsing data into your database, we recommend using SQLObject, or your mysqli object to string encape unsafe strings. You can simply connect using
$si = new SlickInject();
$si->connect("dbhost","dbuser","dbpass","dbname");

// Sample with SQLObject
$a = $si->SELECT("table",["*"]); // returns an object instance of SQLResponce (SlickInject\SQLObject)
$b = $si->SELECT("table",["*"])->returnRows(); // return an array of table rows
// Extra SQLResponce 

// Number of rows
$a->num_rows();

// Get request
$a->getRequest(); // Same responce you'll get from mysqli_query

// CHECK TEST.PHP FOR MORE INFORMATION

```

