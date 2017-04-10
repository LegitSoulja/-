###### HAS NOT YET BEEN RELEASED!.

# SlickInject

Tired of risky SQL Injects? Tired of typing out SQL syntax? Bothered with long boring code?

**SlickInject** is the solution to your problems, in which will hopefully save you some time, with coding. That's if you build websites from stratch without using frameworks.

#### How to use?

With the power and usage of MySQLi, SlickInject uses MySQLi to send, and recieve data from your databases. Other's will soon be supported.

```php
namespace tutorial;

include 'SlickInject.php';
use SlickInject\SlickInject as SlickInject;

// To be safe with parsing data into your database, we recommend using SQLObject, or your mysqli object to string encape unsafe strings. You can simply connect using

SlickInject::connect("dbhost","dbuser","dbpass","dbname");

// When you now run any functions below, you wont get the SQL, but the mysqli responce of the query itself. Read SQLObject below.
```

###### Functions
- SELECT
```php
// let's select all the data from the table, with a specific criteria.
$email = "example@gmail.com"
SlickInject::SELECT("users",null,array("email"=>$username)); 
// output: SELECT * FROM `users` WHERE email='example#@gmail.com'

// Get specific columns, instead of getting all (*)
SlickInject::SELECT("users",["id","username","email"],array("email"=>$username));
```

- INSERT
```php 
// 'Johnny' Inserts his username into a database. Note his name is mispelled.
$username = "Johny";
SlickInject::INSERT("users",array("username"=>$username)); 
// output: INSERT INTO `users` (username) VALUES ('Johnny')
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

1. Your responce
2. Your data (Rows), and other utils for information upon requests.

##### Coming soon....

