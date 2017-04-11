<?php
namespace SlickInject\SQLObject;
class SQLResponce
{
    private static $request;
    private static $rows = array();
    private static $row = array();
    private static $rowsIstablished = false;
    function __construct($request)
    {
        self::$request = $request;
    }
    function returnRows()
    {
        if ($this->num_rows() == 0 || !self::$rowsIstablished)
            return array();
        if ($this->num_rows() > 1)
            return self::$rows;
        return self::$row;
    }
    function rowsIstablished()
    {
        return self::$rowsIstablished;
    }
    function getRequest()
    {
        return self::$request;
    }
    function num_rows()
    {
        return self::$request->num_rows;
    }
    function setup($request)
    {
        if ($request->num_rows < 1)
            return false;
        $return = array();
        $index  = 0;
        while ($row = mysqli_fetch_array($request)) {
            print_r($row);
            $return[$index] = $row;
            $index++;
        }
        self::$rowsIstablished = true;
        if (count($return) > 1) {
            self::$rows = $return;
        } else {
            self::$row = $return;
        }
        return true;
    }
}
class SQLObject
{
    private static $sql;
    private static $connected = false;
    public function connect($dbhost, $dbuser, $dbpass, $dbname)
    {
        $a = $this->pcon($dbhost, $dbuser, $dbpass, $dbname);
        if (gettype($a) == "string")
            die($a);
        if ($this->getConnectionError() != 0)
            return false;
        return true;
    }
    private function pcon($dbhost, $dbuser, $dbpass, $dbname)
    {
        self::$sql = @mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (!self::$sql)
            return "Could not connect to database -> " . $this->getConnectionError();
        return true;
    }
    public function getConnectionError()
    {
        return mysqli_connect_error();
    }
    public function returnLastError()
    {
        return mysqli_error(self::$sql);
    }
    public function isConnected()
    {
        return self::$connected;
    }
    public function close()
    {
        mysqli_close(self::$sql);
    }
    public function escapeString($string)
    {
        return self::$sql->real_escape_string($string);
    }
    public function query($q, $returnRows = true)
    {
        if ($r = mysqli_query(self::$sql, $q)) {
            $responce = new SQLResponce($r);
            if (!$returnRows)
                return $responce;
            if ($responce->setup($r)) {
                return $responce;
            } else {
                return $responce;
            }
            throw new \Exception("Err");
            return false;
        }
        throw new \Exception($this->returnLastError());
        return false;
    }
}
