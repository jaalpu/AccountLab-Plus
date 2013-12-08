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

    class customers extends model
    {
        var $tableName = "customers";
        function del($id)
        {
            return $this->update(array("cust_deleted"=>1,"id"=>$id));
        }
        function edit($fields=array())
        {
            if(isset($this->REQUEST['password1']) && !empty($this->REQUEST['password1']) && $this->REQUEST['password1']==$this->REQUEST['password2'])
            {
                $this->REQUEST['password'] = md5($this->REQUEST['password2']);
            }
            $this->REQUEST['creation_date'] = isset($this->REQUEST['creation_date'])?$this->REQUEST['creation_date']:date('Y-m-d');
            $result = $this->update($this->REQUEST,'id');
            foreach($fields as $field)
            {
                if(isset($this->REQUEST[$field['field_name']]))
                {
                    if(count($this->dbL->executeSELECT("SELECT * FROM `customers_customfields` WHERE `customer_id`=".intval($this->REQUEST['id'])." AND `field_id`=".intval($field['field_id']))))
                    {
                        $sql    = "UPDATE `customers_customfields` SET `field_value`='".$this->utils->quoteSmart($this->REQUEST[$field['field_name']])."' WHERE `customer_id`=".intval($this->REQUEST['id'])." AND `field_id`=".intval($field['field_id']);
                        $result = $this->dbL->executeUPDATE($sql);
                    }
                    else
                    {
                        $sql = "INSERT INTO `customers_customfields` VALUES (".intval($this->REQUEST['id']).",".intval($field['field_id']).",'".$this->utils->quoteSmart($this->REQUEST[$field['field_name']])."')";
                        $this->dbL->executeINSERT($sql);
                    }
                }
            }
            return ($result)?$this->REQUEST['id']:0;
        }
        function add($fields=array())
        {
            $this->REQUEST['password']      = md5($this->REQUEST['password1']);
            $this->REQUEST['creation_date'] = isset($this->REQUEST['creation_date'])?$this->REQUEST['creation_date']:date('Y-m-d');
            $insert_id = $this->insert($this->REQUEST,'id');
            if($insert_id)
            {
                foreach($fields as $field)
                {
                    if(isset($this->REQUEST[$field['field_name']]))
                    {
                        $sql = "INSERT INTO `customers_customfields` VALUES (".intval($insert_id).",".intval($field['field_id']).",'".$this->utils->quoteSmart($this->REQUEST[$field['field_name']])."')";
                        $this->dbL->executeINSERT($sql);
                    }
                }
            }
            return $insert_id;
        }
        function get($condition="")
        {
            $sql = $condition;
            return $this->find(array($sql));
        }
        function validate($data, $fields=array(), $edit_mode = false)
        {
            if (isset($data['member']) && $data['member'] == '1' && !$edit_mode)
            {
                if (!$this->utils->chkEmailFormat($data['existing_email']))
                {
                    return $this->props->lang['err_email'];
                }
                elseif (!count($this->find(array("WHERE `cust_deleted`='0' AND `email`='".$this->utils->quoteSmart($data['existing_email'])."' AND `password`='".md5($data['existing_password'])."'"))))
                {
                    return $this->props->lang['err_user_pass'];
                }
            }
            elseif(!$edit_mode)
            {
                if (!$this->utils->chkEmailFormat($data['email']))
                {
                    return $this->props->lang['err_email'];
                }
                elseif ($data['password1'] != $data['password2'])
                {
                    return $this->props->lang['err_pass'];
                }
                elseif (count($this->find(array("WHERE `cust_deleted`='0' AND `email`='".$this->utils->quoteSmart($data['email'])."'"))))
                {
                    return $this->props->lang['err_email_exists'];
                }
                else
                {
                    foreach($fields as $field)
                    {
                        $f = $field['field_name'];
                        if (empty($data[$f]) && !$field['field_optional'])
                        {
                            return $this->props->lang['err_improper_field']." => ".$this->props->parseLang(ucfirst($f));
                        }
                    }
                }
            }
            else
            {
                if (!$this->utils->chkEmailFormat($data['email']))
                {
                    return $this->props->lang['err_email'];
                }
                elseif (!empty($data['password1']) && $data['password1'] != $data['password2'])
                {
                    return $this->props->lang['err_pass'];
                }
                else
                {
                    foreach($fields as $field)
                    {
                        $f = $field['field_name'];
                        if (empty($data[$f]) && !$field['field_optional'])
                        {
                            return $this->props->lang['err_improper_field']." => ".$this->props->parseLang(ucfirst($f));
                        }
                    }
                }
            }
            return;
        }
        function getFieldValue($field_id,$customer_id)
        {
            $sql = "SELECT `field_value` FROM `customers_customfields` WHERE `customer_id`=".intval($customer_id)." AND `field_id`=".intval($field_id);
            $temp= $this->dbL->executeSELECT($sql);
            return isset($temp[0]['field_value'])?$temp[0]['field_value']:null;
        }
    }
?>
