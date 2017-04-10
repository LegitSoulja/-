# SlickInject

Tired of risky SQL Injects? Tired of typing out SQL syntax? Bothered with long boring code?

**SlickInject** is the solution to your problems, in which will hopefully save you some time, with coding. That's if you build websites from stratch without using frameworks.

#### How to use?

With the power and usage of MySQLi, SlickInject uses MySQLi to send, and recieve data from your databases. Other's will soon be supported.

###### Functions
- SELECT
```php
// let's select all the data from the table, with a specific criteria.
$email = "example@gmail.com"
SlickInject::SELECT(null,"users",array("email"=>$username)); // output: SELECT * FROM `users` WHERE email='example#@gmail.com'

// Get specific columns, instead of getting all (*)
SlickInject::SELECT("id,username,email","users",array("email"=>$username));

// null only makes this, if null, or undefined.
SlickInject::SELECT("*","users",array("email"=>$username));
```

- INSERT
```php 
// 'Johnny' Inserts his username into a database. Note his name is mispelled.
$username = "Johny";
SlickInject::INSERT("users",array("username"=>$username)); // output: INSERT INTO `users` (username) VALUES ('Johnny')
```

- UPDATE
```php
// 'Johnny' accidently mispelled his name, lets update to change it.
$username = "Johnny";
SlickInject::UPDATE("users", array("username"=>$username), array("username"=>"Johny")); // output: UPDATE `users` SET username='Johnny' WHERE username='Johny'
```

- DELETE
```php
$username = "Johnny";
SlickInject::DELETE("users", array("username"=>$username)); // output: DELETE FROM `users` WHERE username='Johnny'
```
