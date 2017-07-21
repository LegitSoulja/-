<?php

/*
\| @Author: LegitSoulja
\| @License: MIT
\| @Source: https://github.com/LegitSoulja/SlickInject
*/

use SlickInject\Parser as Parser;
use SlickInject\SQLObject as SQLObject;

define("SI_VERSION", 102); // 1.0.2

class SlickInject
{
    
    private static $SQLObject;
    
    /**
     * SlickInject constructor | Can accept database credentials.
     * @return void
     */
    function __construct()
    {
        $args = func_get_args();
        if (count($args) === 4)
            return $this->connect($args[0], $args[1], $args[2], $args[3]);
    }
    
    /**
     * Connect to database
     * @param string $db_host          Database host
     * @param string $db_user          Database username
     * @param string $db_pass          Database password
     * @param string $db_name          Database name
     * @return void
     */
    public function connect($db_host, $db_user, $db_pass, $db_name)
    {
        if ($this->isConnected()) return;
        self::$SQLObject = new SQLObject($db_host, $db_user, $db_pass, $db_name);
    }
    
    /**
     * Check if a connect was ever established
     * @return bool
     */
    public function isConnected()
    { return ((self::$SQLObject instanceof SQLObject)) ? true : false; }
    
    /**
     * Returns SQLObject
     * @return object
     */
    public function getSQLObject()
    { return self::$SQLObject; }
    
    /**
     *Close database connection
     * @return void
     */
    public function close()
    { return self::$SQLObject->close(); }
    
    /**
     * Update database with data
     * @param string $table          Name of table in which you're updating.
     * @param array $object          List of key/values of the data you're updating
     * @param array $where           List of key/values of the where exist
     * @return bool
     */
    public function UPDATE($table, $object, $where)
    {
        if (!$this->isConnected() || !isset($table) || !isset($object) || !isset($where)) return;
        $update = Parser::UPDATE($table, $object, $where);
        return self::$SQLObject->query($update[0], (isset($update[1])) ? $update[1] : NULL);
    }
    
    /**
     * Select data from a database
     * @param array $columns              List of specific columns that is being obtained. * = [];
     * @param string $table               Name of table in which you're updating.
     * @param array $where                List of key/values of the where exist
     * @return bool
     */
    public function SELECT($columns, $table, $where = NULL, $rr = true)
    {
        if (!$this->isConnected() || !isset($columns) || !isset($table)) return;
        $select = Parser::SELECT($columns, $table, $where);
        return self::$SQLObject->query($select[0], (isset($select[1])) ? $select[1] : NULL, $rr);
    }
    
    /**
     * Insert data into a database
     * @param string $table               Name of table in which you're updating.
     * @param array $object                List of key/values of the data you're inserting
     * @return bool
     */
    public function INSERT($table, $object)
    {
        if (!$this->isConnected() || !isset($table) || !isset($object)) return;
        $insert = Parser::INSERT($table, $object);
        return self::$SQLObject->query($insert[0], $insert[1]);
    }
    
    /**
     * Insert data into a database
     * @param string $table               Name of table in which you're updating.
     * @param array $object                List of key/values of the data you're inserting
     * @return bool
     */
    public function TRUNCATE($table)
    {
        if (!$this->isConnected() || !isset($table)) return;
        $truncate = Parser::TRUNCATE($table);
        return self::$SQLObject->query($truncate[0]);
    }
    
    /**
     * Delete a row in a table
     * @param string $table               Name of table in which you're updating.
     * @param array $where                List of key/values that directs which/where table is being deleted
     * @return bool
     */
    public function DELETE($table, $where = NULL)
    {
        if (!$this->isConnected() || !isset($table) || !isset($object)) return;
        $delete = Parser::DELETE($table, $where);
        return self::$SQLObject->query($delete[0], (isset($delete[1])) ? $delete[1] : NULL);
    }
}
