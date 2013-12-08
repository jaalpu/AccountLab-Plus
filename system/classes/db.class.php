<?php

    /*
    * Copyright © 2005-2009 Cosmopoly Europe EOOD (http://netenberg.com).
    * All Rights Reserved.
    *
    * This Cosmopoly Europe EOOD work (including software, documents, or
    * other related items) is being provided by the copyright holder under
    * the following license. By obtaining, using and/or copying this work,
    * you (the licensee) agree that you have read, understood, and will
    * comply with the following terms and conditions:
    *
    * Permission to use, copy, modify, and distribute this software and its
    * documentation, with or without modification, for any purpose and
    * without fee or royalty is hereby granted, provided that you include
    * the following on ALL copies of the software and documentation or
    * portions thereof, including modifications, that you make:
    *
    * 1. The full text of this NOTICE in a location viewable to users of the
    * redistributed or derivative work.
    *
    * 2. A short notice of the following form (hypertext is preferred, text
    * is permitted) should be used within the body of any redistributed or
    * derivative code: "Copyright © 2005-2009 Cosmopoly Europe EOOD
    * (http://netenberg.com). All Rights Reserved."
    *
    * 3. Notice of any changes or modifications to the W3C files, including
    * the date changes were made. (We recommend you provide URIs to the
    * location from which the code is derived.)
    *
    * THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
    * HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
    * INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR FITNESS
    * FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE OR
    * DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS, COPYRIGHTS,
    * TRADEMARKS OR OTHER RIGHTS.
    * COPYRIGHT HOLDERS WILL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL
    * OR CONSEQUENTIAL DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR
    * DOCUMENTATION.
    *
    * The name and trademarks of copyright holders may NOT be used in
    * advertising or publicity pertaining to the software without specific,
    * written prior permission. Title to copyright in this software and any
    * associated documentation will at all times remain with copyright
    * holders.
    */

    /*
    * A class to do all database handling
    * db Version 2.0
    */
    class db
    {
        function db($server, $username, $password, $database, & $errorHandler, $new_link= false)
        {
            $this->errorHandler = & $errorHandler;
            $this->dbConnect($server, $username, $password, $database, $new_link);
        }
        function dbConnect($server, $username, $password, $database, $new_link)
        {
            $this->dbConnection = @mysql_connect($server, $username, $password, $new_link);
            if (!$this->dbConnection)
            {
                $this->errorHandler->setErrorMsg("DATABASE","Could not connect to database server : ". $server . "");
                $this->errorHandler->setError(true);
            }
            elseif(!@mysql_select_db($database,$this->dbConnection))
            {
                $this->errorHandler->setErrorMsg("DATABASE","Could not connect to database : " . $database . "\n MYSQL ERROR: ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection)."\n");
                $this->errorHandler->setError(true);
            }
        }
        function dbDisconnect()
        {
            if (isset ($this->dbConnection))
            {
                @mysql_close($this->dbConnection);
            }
            else
            {
                $this->errorHandler->setErrorMsg("DATABASE","MYSQL ERROR: ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection)."\n");
                $this->errorHandler->setError(true);
            }
        }
        function deleteAllFromTable($table, $condition1=array())
        {
            $condition2 = '';
            if(count($condition1))
            {
                foreach($condition1 as $c)
                {
                    $condition2 .= ' '.$c;
                }
            }
            return $this->executeDELETE("DELETE FROM ".$table.$condition2);
        }
        function findAllFromTable($table, $condition1=array(), $orderby='', $limit='')
        {
            $condition2 = '';
            if(count($condition1))
            {
                foreach($condition1 as $c)
                {
                    $condition2 .= ' '.$c;
                }
            }
            return $this->executeSELECT("SELECT * FROM ".$table.$condition2.$orderby.$limit);
        }
        function executeDROP($DROP_SQL,$return_error=false)
        {
            $queryresult= @mysql_query($DROP_SQL, $this->dbConnection);
            if ($queryresult == false)
            {
                $error = "MYSQL ERROR : ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection);
                $this->errorHandler->setErrorMsg("DATABASE","Could not execute SQL : " . $DROP_SQL . "\n ".$error."\n");
                $this->errorHandler->setError(true);
                return ($return_error)?$error:true;
            }
            return $queryresult?$queryresult:1;
        }
        function executeALTER($ALTER_SQL,$return_error=false)
        {
            $queryresult= @mysql_query($ALTER_SQL, $this->dbConnection);
            if ($queryresult == false)
            {
                $error = "MYSQL ERROR : ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection);
                $this->errorHandler->setErrorMsg("DATABASE","Could not execute SQL : " . $ALTER_SQL . "\n ".$error."\n");
                $this->errorHandler->setError(true);
                return ($return_error)?$error:false;
            }
            return $queryresult?$queryresult:true;
        }
        function executeCREATE($CREATE_SQL,$return_error=false)
        {
            $queryresult= @mysql_query($CREATE_SQL, $this->dbConnection);
            if ($queryresult == false)
            {
                $error = "MYSQL ERROR : ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection);
                $this->errorHandler->setErrorMsg("DATABASE","Could not execute SQL : " . $CREATE_SQL . "\n ".$error."\n");
                $this->errorHandler->setError(true);
                return ($return_error)?$error:false;
            }
            return $queryresult?$queryresult:true;
        }
        function executeDELETE($DELETE_SQL,$return_error=false)
        {
            $queryresult= @mysql_query($DELETE_SQL, $this->dbConnection);
            if ($queryresult == false)
            {
                $error = "MYSQL ERROR : ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection);
                $this->errorHandler->setErrorMsg("DATABASE","Could not execute SQL : " . $DELETE_SQL . "\n ".$error."\n");
                $this->errorHandler->setError(true);
                return ($return_error)?$error:false;
            }
            return @mysql_affected_rows($this->dbConnection);
        }
        function executeINSERT($INSERT_SQL,$return_error=false)
        {
            $queryresult = @mysql_query($INSERT_SQL, $this->dbConnection);
            $insert_id   = @mysql_insert_id($this->dbConnection);
            if ($queryresult == false)
            {
                $error = "MYSQL ERROR : ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection);
                $this->errorHandler->setErrorMsg("DATABASE","Could not execute SQL : " . $INSERT_SQL . "\n ".$error."\n");
                $this->errorHandler->setError(true);
                return ($return_error)?$error:false;
            }
            return ($insert_id)?$insert_id:true;
        }
        function executeUPDATE($UPDATE_SQL,$return_error=false)
        {
            $queryresult= @mysql_query($UPDATE_SQL, $this->dbConnection);
            if ($queryresult == false)
            {
                $error = "MYSQL ERROR : ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection);
                $this->errorHandler->setErrorMsg("DATABASE","Could not execute SQL : " . $UPDATE_SQL . "\n ".$error."\n");
                $this->errorHandler->setError(true);
                return ($return_error)?$error:false;
            }
            return @mysql_affected_rows($this->dbConnection);
        }
        function executeSELECT($SELECT_SQL,$return_error=false)
        {
            $queryresults = @mysql_query($SELECT_SQL, $this->dbConnection);
            if ($queryresults == false)
            {
                $error = "MYSQL ERROR : ".@mysql_errno($this->dbConnection) . ": " . @mysql_error($this->dbConnection);
                $this->errorHandler->setErrorMsg("DATABASE","Could not execute SQL : " . $SELECT_SQL . "\n ".$error."\n");
                $this->errorHandler->setError(true);
                return ($return_error)?$error:0;
            }
            else
            {
                $Return_Array  = array();
                while ($row = @mysql_fetch_array($queryresults, MYSQL_ASSOC))
                {
                    $Return_Array[] = $row;
                }
                return $Return_Array;
            }
            @mysql_free_result($queryresults);
            return array();
        }
        function tableInfo($table)
        {
            $result = array();
            $sql    = "SELECT * FROM ".$table;
            $result = @mysql_query($sql);
            $i      = 0;
            $metas  = array();
            while ($i < @mysql_num_fields($result))
            {
                $meta = @mysql_fetch_field($result, $i);
                if ($meta)
                {
                    $metas[$meta->name] = $meta;
                }
                $i++;
            }
            return $metas;
        }
        function listTables($database)
        {
            $sql      = "SHOW TABLES FROM ".$database;
            $array    = $this->executeSELECT($sql);
            $result   = array ();
            foreach ($array as $v)
            {
                foreach ($v as $val)
                {
                    $result[]= $val;
                }
            }
            return $result;
        }
        function executeMixedSQLArray($SQLarray, $values= array (), $return_error = false)
        {
            $result = array ();
            foreach ($SQLarray as $key => $sql)
            {
                if (count($values) > 1)
                {
                    $temp= $sql;
                    foreach ($values as $k => $v)
                    {
                        $pattern= "~" . $k;
                        $temp= preg_replace("|$pattern|", $v, $temp);
                    }
                    $sql= $temp;
                }
                if (stristr($sql, "SELECT"))
                    $result[$key]= $this->executeSELECT($sql,$return_error);
                elseif (stristr($sql, "INSERT"))
                    $result[$key]= $this->executeINSERT($sql,$return_error);
                elseif (stristr($sql, "UPDATE"))
                    $result[$key]= $this->executeUPDATE($sql,$return_error);
                elseif (stristr($sql, "DELETE"))
                    $result[$key]= $this->executeDELETE($sql,$return_error);
                elseif (stristr($sql, "CREATE"))
                    $result[$key]= $this->executeCREATE($sql,$return_error);
                elseif (stristr($sql, "ALTER"))
                    $result[$key]= $this->executeALTER($sql,$return_error);
                elseif (stristr($sql, "DROP"))
                    $result[$key]= $this->executeDROP($sql,$return_error);
            }
            return $result;
        }
    }
?>
