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

    class model
    {
        var $REQUEST;
        var $dbL;
        var $props;
        var $utils;
        var $error;
        var $limit='';
        var $orderby='';
        var $indexname='index';
        var $keyname='id';

        function model(& $dbL, & $props, & $utils, &$REQUEST, & $errorHandler, & $BL)
        {
            $this->REQUEST          = & $REQUEST;
            $this->dbL              = & $dbL;
            $this->props            = & $props;
            $this->utils            = & $utils;
            $this->errorHandler     = & $errorHandler;
            $this->BL               = & $BL;
        }
        function setOrder($orderby=false, $asc_or_desc='', $tablename='')
        {
            if($orderby && in_array($orderby, $this->getFieldList()) && in_array(strtolower($asc_or_desc), array('', 'asc', 'desc')))
            {
                $this->orderby = " ORDER BY ".(isset($tablename)?"`$tablename`.":'')."$orderby $asc_or_desc";
            }
            else
            {
                throw new Exception('Invalid sort order.');
            }
        }
        function setLimit($limit=false)
        {
            // Sanity check and client min and max
            $min = isset($this->REQUEST['l1']) ? preg_replace('/\D/','',$this->REQUEST['l1']) : 0;
            $min = empty($min)?0:$min;
            $max = isset($this->REQUEST['l2']) ? preg_replace('/\D/','',$this->REQUEST['l2']) : 50;
            $max = empty($max)?50:$max;

            if($limit)
            {
                $this->limit = " LIMIT ".$min." , ".$max;
            }
            else
            {
                $this->limit = '';
            }
        }
        function getFieldList()
        {
            $fields = array();
            $table_info = $this->dbL->tableInfo($this->tableName);
            foreach($table_info as $field=>$obj)
            {
                $fields[] = $field;
            }
            return $fields;
        }
        function getPrimaryKey()
        {
            $table_info = $this->dbL->tableInfo($this->tableName);
            foreach($table_info as $field=>$obj)
            {
                if($obj->primary_key)return $field;
            }
            return null;
        }
        function query($sql)
        {
            if (stristr($sql, "SELECT"))
                return $this->dbL->executeSELECT($sql);
            if (stristr($sql, "INSERT"))
                return $this->dbL->executeINSERT($sql);
            if (stristr($sql, "UPDATE"))
                return $this->dbL->executeUPDATE($sql);
            if (stristr($sql, "DELETE"))
                return $this->dbL->executeDELETE($sql);
            if (stristr($sql, "CREATE"))
                return $this->dbL->executeCREATE($sql);
            if (stristr($sql, "DROP"))
                return $this->dbL->executeDROP($sql);
            if (stristr($sql, "ALTER"))
                return $this->dbL->executeALTER($sql);
        }
        function index($key='')
        {
            $key = empty($key)?$this->getPrimaryKey():$key;
            return $this->dbL->executeALTER("ALTER TABLE ".$this->tableName." ADD INDEX ( `".$key."`)");
        }
        function delete($condition=array())
        {
            return $this->dbL->deleteAllFromTable($this->tableName,$condition);
        }
        function find($condition=array())
        {
            return $this->dbL->findAllFromTable($this->tableName,$condition,$this->orderby,$this->limit);
        }
        function hasAnyOne($condition=array())
        {
            $return = $this->find($condition);
            if(count($return))
            {
                return $return[0];
            }
            return false;
        }
        function getByKey($id,$key='')
        {
            $key = empty($key)?$this->getPrimaryKey():$key;
            return $this->hasAnyOne(array("WHERE `".$key."`='".$this->utils->quoteSmart($id)."'"));
        }
        function insert($data)
        {
            $key  = $this->getPrimaryKey();
            $str1 = "";
            $str2 = "";
            $fields = $this->getFieldList();
            foreach($fields as $field)
            {
                if(isset($data[$field]) && ($key==null || ($key!=$field || !empty($data[$field]))))
                {
                    if(!empty($str1))
                    {
                        $str1 .= ", ";
                        $str2 .= ", ";
                    }
                    $str1 .= "`".$field."`";
                    $str2 .= "'".$this->utils->quoteSmart($data[$field])."'";
                }
            }
            $sql = "INSERT INTO ".$this->tableName." (".$str1.") VALUES (".$str2.")";
            return $this->dbL->executeINSERT($sql);
        }
        function update($data,$key='')
        {
            $str1 = "";
            $key  = empty($key)?$this->getPrimaryKey():$key;
            $fields = $this->getFieldList();
            foreach($fields as $field)
            {
                if(isset($data[$field]) && $key!=$field)
                {
                    if(!empty($str1))
                    {
                        $str1 .= ", ";
                    }
                    $str1 .= "`".$field."` = '".$this->utils->quoteSmart($data[$field])."'";
                }
            }
            $sql = "UPDATE ".$this->tableName." SET ".$str1;
            if($key && isset($data[$key]))
            {
                $sql .= "WHERE `".$key."`='".$this->utils->quoteSmart($data[$key])."'";
            }
            return $this->dbL->executeUPDATE($sql);
        }
        function save($data,$key='')
        {
            $key    = empty($key)?$this->getPrimaryKey():$key;
            $search = isset($data[$key])?array("WHERE `".$key."`='".$this->utils->quoteSmart($data[$key])."'"):array();
            if($this->hasAnyOne($search))
            {
                return $this->update($data,$key);
            }
            return $this->insert($data,$key);
        }
        function moveUp($id,$index)
        {
            $sql    = "UPDATE ".$this->tableName." SET `".$this->indexname."` = `".$this->indexname."`-1 WHERE `".$this->keyname."` = ".intval($id);
            $this->dbL->executeUPDATE($sql);
            $sql    = "UPDATE ".$this->tableName." SET `".$this->indexname."` = `".$this->indexname."`+1 WHERE `".$this->indexname."` = ".intval($index-1)." AND NOT `".$this->keyname."`= ".intval($id);
            $this->dbL->executeUPDATE($sql);
        }
        function moveDown($id,$index)
        {
            $sql    = "UPDATE ".$this->tableName." SET `".$this->indexname."` = `".$this->indexname."`+1 WHERE `".$this->keyname."` = ".intval($id);
            $this->dbL->executeUPDATE($sql);
            $sql    = "UPDATE ".$this->tableName." SET `".$this->indexname."` = `".$this->indexname."`-1 WHERE `".$this->indexname."` = ".intval($index+1)." AND NOT `".$this->keyname."`= ".intval($id);
            $this->dbL->executeUPDATE($sql);
        }
    }
?>
