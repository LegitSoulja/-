<?php
/*
\| Compiled & Built on Monday 14th of August 2017 03:57:58 AM : Clean & Formatted
\| SlickInject v2
\| @Author: LegitSoulja
\| @Status: Discontinued
\| @License: MIT
\| @Source: https://github.com/LegitSoulja/SlickInject
*/
namespace {
    if (!extension_loaded('mysqlnd')) throw new Error("Failed to load nd_mysqli extension.");
    use SlickInject\SQLObject as SQLObject;
    class SlickInject extends SlickInject\Parser {
        private static $ip;
        /**
         * SlickInject constructor | Can accept database credentials.
         * @return void
         */
        function __construct() {
            $zaa = func_get_args();
            if (count($zaa) === 4) return $this->gzvnect($zaa[0], $zaa[1], $zaa[2], $zaa[3]);
        }
        /**
         * Connect to database
         * @param string $jjp          Database host
         * @param string $el          Database username
         * @param string $tna          Database password
         * @param string $ms          Database name
         * @return void
         */
        public function connect($jjp, $el, $tna, $ms) {
            if ($this->isConnected()) return;
            self::$ip = new SQLObject($jjp, $el, $tna, $ms);
        }
        private function isConnected() {
            return ((self::$ip instanceof SQLObject)) ? true : false;
        }
        /**
         * Returns SQLObject
         * @return \SlickInject\SQLObject
         */
        public function getSQLObject() {
            return self::$ip;
        }
        public function select_db($cos) {
            self::$ip->select_db($cos);
            return $this;
        }
        /*
         * Output logged data, w/ an option to close the database behind for even quicker clean code
         * @param bool $ts_      State of message, used for some type of error reporting to alert rather or not the output was good.
         * @param string\array     The message in which you are sending.
         * @param bool             False by default, True to close the database before executing
         * @return extermination
        */
        private function output($ts_, $cxo = "", $me   = false) {
            if ($me) $this->me();
            die(json_encode(array("state" => $ts_, "message" => $cxo)));
        }
        /**
         * Close database connection
         * @return void
         */
        public function close() {
            return self::$ip->close();
        }
        /**
         * Update database with data
         * @param string $dsv          Name of table in which you're updating.
         * @param array $etq          List of key/values of the data you're updating
         * @param array $lxbo           List of key/values of the where exist
         * @return \SlickInject\SQLResponce
         */
        public function UPDATE($dsv, $etq, $lxbo) {
            if (!$this->isConnected() || !isset($dsv) || !isset($etq) || !isset($lxbo)) return;
            $bk = parent::_UPDATE($dsv, $etq, $lxbo);
            return self::$ip->query($bk[0], (isset($bk[1])) ? $bk[1] : NULL);
        }
        /**
         * Select data from a database
         * @param array $qk              List of specific columns that is being obtained. * = [];
         * @param string $dsv               Name of table in which you're updating.
         * @param array $lxbo                List of key/values of the where exist
         * @param bool $ft                    Return rows, false returns \SlickInject\SQLResponce
         * @return array
         */
        public function SELECT($qk, $dsv, $lxbo  = NULL, $ft     = true) {
            if (!$this->isConnected() || !isset($qk) || !isset($dsv)) return;
            $db = parent::_SELECT($qk, $dsv, $lxbo);
            return self::$ip->query($db[0], (isset($db[1])) ? $db[1] : NULL, $ft);
        }
        /**
         * Insert data into a database
         * @param string $dsv               Name of table in which you're updating.
         * @param array $etq                List of key/values of the data you're inserting
         * @return \SlickInject\SQLResponce
         */
        public function INSERT($dsv, $etq) {
            if (!$this->isConnected() || !isset($dsv) || !isset($etq)) return;
            $foy = parent::_INSERT($dsv, $etq);
            return self::$ip->query($foy[0], $foy[1]);
        }
        /**
         * Truncate/Delete table
         * @param string $dsv               Name of table in which you're updating.
         * @return \SlickInject\SQLResponce
         */
        public function TRUNCATE($dsv) {
            if (!$this->isConnected() || !isset($dsv)) return;
            $jrb = parent::_TRUNCATE($dsv);
            return self::$ip->query($jrb[0]);
        }
        /**
         * Delete a row in a table
         * @param string $dsv               Name of table in which you're updating.
         * @param array $lxbo                List of key/values that directs which/where table is being deleted
         * @return \SlickInject\SQLResponce
         */
        public function DELETE($dsv, $lxbo  = NULL) {
            if (!$this->isConnected() || !isset($dsv) || !isset($lxbo)) return;
            $isd = parent::_DELETE($dsv, $lxbo);
            return self::$ip->query($isd[0], (isset($isd[1])) ? $isd[1] : NULL);
        }
    }
}
namespace SlickInject {
    class SQLResponce {
        private $ihb;
        private $uwl = array();
        private $xr;
        /**
         * SQLResponce constructor
         * @return void
         */
        function __construct($xr, $uwl         = array()) {
            $this->ihb = $xr->get_result();
            $this->xr   = $xr;
            if ($this->ihb->num_rows < 1) return;
            while ($p_        = $this->ihb->fetch_assoc()) {
                array_push($uwl, $p_);
            }
            $this->uwl = $uwl;
        }
        /**
         * Return mysqli_result object
         * @return object
         */
        public function getResult() {
            return $this->ihb;
        }
        /**
         * Check if any rows was affected during execution
         * @return bool
         */
        public function didAffect() {
            return ($this->xr->affected_rows > 0) ? true : false;
        }
        /**
         * Check if result hasn't failed
         * @return bool
         */
        public function error() {
            return ($this->ihb) ? true : false;
        }
        /**
         * Check if results contain rows
         * @return bool
         */
        public function hasRows() {
            return (!empty($this->uwl)) ? true : false;
        }
        /**
         * Return number of rows
         * @return int
         */
        public function num_rows() {
            return (int)$this->ihb->num_rows;
        }
        /**
         * Return rows from results
         * @return array
         */
        public function getData() {
            return $this->uwl;
        }
    }
    class SQLObject {
        private static $gzv;
        private $bw; // default database name
        private $djy = true;
        /**
         * SQLObject constructor | Can accept database  credentials
         * @return void
         */
        function __construct($cfi, $lxif, $rm, $ys) {
            return $this->gzvnect($cfi, $lxif, $rm, $ys);
        }
        /**
         * Close database connected
         * @return void
         */
        public function close() {
            @\mysqli_close(self::$gzv);
        }
        /**
         * Connect to database
         * @param string $jjp          Database host
         * @param string $el          Database username
         * @param string $tna          Database password
         * @param string $ms          Database name
         * @return void
         */
        public function connect($jjp, $el, $tna, $ms) {
            if ($this->isConnected()) return;
            $this->bw = $ms;
            self::$gzv             = new \mysqli($jjp, $el, $tna, $ms);
        }
        /**
         * [Private] Checks if the database connection was ever established.
         * @return bool
         */
        private function isConnected() {
            return (isset(self::$gzv) && $this->ping()) ? true : false;
        }
        public function select_db($cos) {
            $this->djy = false;
            return mysqli_select_db(self::$gzv, $cos);
        }
        /**
         * Get connect error status
         * @return int
         */
        public function getConnectionError() {
            return @\mysqli_connect_error();
        }
        /**
         * Get last error from a failed prepare, and or execute.
         * @return string
         */
        public function getLastError() {
            return @\mysqli_error(self::$gzv);
        }
        /** Deprecated [Useless]
         * Escape string using mysqli
         * @return string
         */
        private function escapeString(&$yz) {
            return self::$gzv->real_escape_string($yz);
        }
        /**
         * Check if connection still live
         * @return bool
         */
        public function ping() {
            return (@self::$gzv->ping()) ? true : false;
        }
        private function set_default_db() {
            $this->djy = true;
            return mysqli_select_db(self::$gzv, $this->bw);
        }
        /**
         * Send query, in which is processed specially.
         * @param stting $rb                  The query that will be prepared
         * @param array $d_y                  Types, and params to be binded before execute
         * @param bool $ft                     Return rows (Array), or returns SQLObject (Object).
         * @return boolean
         */
        public function query($rb, $d_y, $ft   = false) {
            try {
                if ($l_u = self::$gzv->prepare($rb)) {
                    if (isset($d_y) && $d_y != NULL) {
                        $ss  = array($d_y[0]);
                        foreach ($d_y as $_c  => $os) {
                            if ($_c != 0) {
                                $ss[$_c]      = & $d_y[$_c];
                            }
                        }
                        call_user_func_array(array($l_u, "bind_param"), $ss);
                    }
                    if ($l_u->execute()) {
                        $ihb = new SQLResponce($l_u);
                        if (!$this->djy) $this->set_default_db(); // reset default database
                        if ($ft) return ($ihb->hasRows()) ? $ihb->getData() : array();
                        return $ihb;
                    }
                }
                throw new \Exception($this->getLastError());
            }
            catch(\Exception $rv_) {
                if (!$this->djy) $this->set_default_db(); // reset default database
                die("Error " . $rv_->getMessage());
            }
        }
    }
    class Parser {
        /**
         * Reserved keywords to prevent future errors
         */
        private static $rz = array("ADD", "KEYS", "EXTERNAL", "PROCEDURE", "ALL", "FETCH", "PUBLIC", "ALTER", "FILE", "RAISERROR", "AND", "FILLFACTOR", "READ", "ANY", "FOR", "READTEXT", "AS", "FOREIGN", "RECONFIGURE", "ASC", "FREETEXT", "REFERENCES", "AUTHORIZATION", "FREETEXTTABLE", "REPLICATION", "BACKUP", "FROM", "RESTORE", "BEGIN", "FULL", "RESTRICT", "BETWEEN", "FUNCTION", "RETURN", "BREAK", "GOTO", "REVERT", "BROWSE", "GRANT", "REVOKE", "BULK", "GROUP", "RIGHT", "BY", "HAVING", "ROLLBACK", "CASCADE", "HOLDLOCK", "ROWCOUNT", "CASE", "IDENTITY", "ROWGUIDCOL", "CHECK", "IDENTITY_INSERT", "RULE", "CHECKPOINT", "IDENTITYCOL", "SAVE", "CLOSE", "IF", "SCHEMA", "CLUSTERED", "IN", "SECURITYAUDIT", "COALESCE", "INDEX", "SELECT", "COLLATE", "INNER", "SEMANTICKEYPHRASETABLE", "COLUMN", "INSERT", "SEMANTICSIMILARITYDETAILSTABLE", "COMMIT", "INTERSECT", "SEMANTICSIMILARITYTABLE", "COMPUTE", "INTO", "SESSION_USER", "CONSTRAINT", "IS", "SET", "CONTAINS", "JOIN", "SETUSER", "CONTAINSTABLE", "KEY", "SHUTDOWN", "CONTINUE", "KILL", "SOME", "CONVERT", "LEFT", "STATISTICS", "CREATE", "LIKE", "SYSTEM_USER", "CROSS", "LINENO", "TABLE", "CURRENT", "LOAD", "TABLESAMPLE", "CURRENT_DATE", "MERGE", "TEXTSIZE", "CURRENT_TIME", "NATIONAL", "THEN", "CURRENT_TIMESTAMP", "NOCHECK", "TO", "CURRENT_USER", "NONCLUSTERED", "TOP", "CURSOR", "NOT", "TRAN", "DATABASE", "NULL", "TRANSACTION", "DBCC", "NULLIF", "TRIGGER", "DEALLOCATE", "OF", "TRUNCATE", "DECLARE", "OFF", "TRY_CONVERT", "DEFAULT", "OFFSETS", "TSEQUAL", "DELETE", "ON", "UNION", "DENY", "OPEN", "UNIQUE", "DESC", "OPENDATASOURCE", "UNPIVOT", "DISK", "OPENQUERY", "UPDATE", "DISTINCT", "OPENROWSET", "UPDATETEXT", "DISTRIBUTED", "OPENXML", "USE", "DOUBLE", "OPTION", "USER", "DROP", "OR", "VALUES", "DUMP", "ORDER", "VARYING", "ELSE", "OUTER", "VIEW", "END", "OVER", "WAITFOR", "ERRLVL", "PERCENT", "WHEN", "ESCAPE", "PIVOT", "WHERE", "EXCEPT", "PLAN", "WHILE", "EXEC", "PRECISION", "WITH", "EXECUTE", "PRIMARY", "WITHIN", "GROUP", "EXISTS", "PRINT", "WRITETEXT", "EXIT", "PROC");
        private static function WHERE($zxx, $jla          = false) {
            $cu            = $oss            = array();
            $hy              = 0;
            foreach ($zxx as $lxi => $lx) {
                if (!is_numeric($lxi) && !empty($lx)) {
                    if (in_array(strtoupper($lxi), self::$rz)):
                        array_push($cu, "`" . $lxi . "`=?");
                    else:
                        array_push($cu, "" . $lxi . "=?");
                    endif;
                    array_push($cu, 'AND');
                    array_push($oss, $lx);
                    $hy = 1;
                }
                else {
                    if ($hy === 0 && $jla === TRUE) throw new \Exception("An error has occured");
                    if ($hy === 1) array_pop($cu);
                    array_push($cu, $lx);
                    $hy = 2;
                }
            }
            if ($hy === 1) {
                array_pop($cu);
            }
            $hrq = "";
            foreach ($oss as $lx) {
                $hrq.= self::getType($lx);
            }
            if (!empty($hrq)) array_unshift($oss, $hrq);
            return array($cu, $oss);
        }
        /**
         * Get initial of type in which is needed to bind the proper types when executing to the database
         * @param string $ih               <T>
         * @return char
         */
        private static function getType($ih) {
            switch (gettype($ih)) {
                case "string":
                    return "s";
                case "boolean": // bool is recognized as an integer
                    
                case "integer":
                    return "i";
                case "double":
                    return "d";
                default:
                    throw new \Error("Unable to bind params");
            }
        }
        public static function _SELECT($qk, $dsv, $lxbo, $rv_plain = false) {
            $qk = (count($qk) > 0) ? $qk : array("*");
            foreach ($qk as $lxi       => $lx) {
                if (in_array(strtoupper($lx), self::$rz)) $qk[$lxi]         = "`" . $lx . "`";
            }
            $lxbo   = (count($lxbo) > 0) ? self::WHERE($lxbo) : NULL;
            $rb     = (($rv_plain) ? "EXPLAIN " : "");
            if (in_array(strtoupper($dsv), self::$rz)) {
                $dsv   = "`" . $dsv . "`";
            }
            // $rb .= "SELECT [" . join(", ", $qk) . "] FROM " . $dsv;
            $rb.= "SELECT " . join(", ", $qk) . " FROM " . $dsv;
            if ($lxbo != NULL && count($lxbo[1]) > 1 && isset($lxbo[0])) {
                $rb.= " WHERE " . join(" ", $lxbo[0]);
            }
            elseif (isset($lxbo[0])) {
                $rb.= " " . join(" ", $lxbo[0]);
            }
            return array($rb, (isset($lxbo[1])) ? $lxbo[1] : NULL);
        }
        public static function _INSERT($dsv, $etq) {
            if (in_array(strtoupper($dsv), self::$rz)) {
                $dsv   = "`" . $dsv . "`";
            }
            $rb     = "INSERT INTO " . $dsv;
            $coss   = array();
            $ru = array();
            $oss  = array();
            foreach ($etq as $lxi => $lx) {
                if (isset($lxi) && isset($lx)) {
                    if (is_numeric($lxi)) continue;
                    array_push($coss, "`" . $lxi . "`");
                    array_push($ru, "?");
                    array_push($oss, $lx);
                }
            }
            $rb.= " (" . join(", ", $coss) . ") VALUES ";
            $rb.= " (" . join(", ", $ru) . ")";
            $hrq = "";
            foreach ($oss as $lx) {
                $hrq.= self::getType($lx);
            }
            array_unshift($oss, $hrq);
            return array($rb, $oss);
        }
        public static function _UPDATE($dsv, $etq, $lxbo) {
            if (in_array(strtoupper($dsv), self::$rz)) {
                $dsv  = "`" . $dsv . "`";
            }
            $foy = array();
            $oss = array();
            $lxbo  = (count($lxbo) > 0) ? self::WHERE($lxbo, TRUE) : NULL;
            $rb    = "UPDATE " . $dsv . " SET";
            foreach ($etq as $lxi => $lx) {
                if (isset($lxi) && isset($lx)) {
                    if (is_numeric($lxi)) continue;
                    if (in_array(strtoupper($lxi), self::$rz)):
                        array_push($foy, "`" . $lxi . "`=?");
                    else:
                        array_push($foy, "" . $lxi . "=?");
                    endif;
                    array_push($oss, $lx);
                }
            }
            $rb.= " " . join(", ", $foy);
            if ($lxbo != NULL) {
                $rb.= " WHERE " . join(" ", $lxbo[0]);
            }
            $hrq = "";
            foreach ($oss as $lx) {
                $hrq.= self::getType($lx);
            }
            if ($lxbo != NULL) {
                $hrq.= $lxbo[1][0];
                array_shift($lxbo[1]);
            }
            $ty = count($oss);
            foreach ($lxbo[1] as $lxi  => $lx) {
                $oss[$ty]    = $lx;
                $ty++;
            }
            array_unshift($oss, $hrq);
            return array($rb, $oss);
        }
        public static function _TRUNCATE($dsv) {
            $rb = "TRUNCATE TABLE `" . $dsv . "`";
            return array($rb);
        }
        public static function _DELETE($dsv, $lxbo) {
            $rb   = "DELETE FROM `" . $dsv . "`";
            if (count($lxbo) > 0) {
                $lxbo = self::WHERE($lxbo);
                $rb.= " WHERE " . join(" ", $lxbo[0]);
            }
            return array($rb, $lxbo[1]);
        }
    }
}
