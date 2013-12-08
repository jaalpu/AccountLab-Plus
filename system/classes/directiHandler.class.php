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

    require_once (LIBRARIES."directi".PATH_SEP."config.php");
    require_once (LIBRARIES."directi".PATH_SEP."customer.class.php");
    require_once (LIBRARIES."directi".PATH_SEP."response.class.php");
    require_once (LIBRARIES."directi".PATH_SEP."domcontact.class.php");
    require_once (LIBRARIES."directi".PATH_SEP."domorder.class.php");
    if(!isset($_POST['pp']) || $_POST['pp']!='paypalwpp')//tweak for paypal class redeclared in php-sdk from paypal
        require_once (LIBRARIES."directi".PATH_SEP."nusoap.php");
    /*
    * A class to do all directi handling
    * directiHandler Version 1.0
    */
    class directiHandler
    {
        /*
        * Constructor
        */
        function directiHandler()
        {
            $this->iserror= false;
            $this->error_str="";
        }
        /*
        * check contants
        */
        function chkCon()
        {
            if (empty ($this->USERNAME))
            {
                $this->error_str =  "User Name is Required!";
                $this->iserror= true;
            }
            if (empty ($this->PASSWORD))
            {
                $this->error_str = "Password is Required!";
                $this->iserror= true;
            }
            if (empty ($this->ROLE))
            {
                $this->error_str = "Role is Required!";
                $this->iserror= true;
            }
            if (empty ($this->LANGPREF))
            {
                $this->error_str = "Language Preference is Required!";
                $this->iserror= true;
            }
            if (empty ($this->PARENTID))
            {
                $this->error_str = "Parent id is Required!";
                $this->iserror= true;
            }
            elseif (!is_numeric($this->PARENTID))
            {
                $this->error_str = "Parent id is not Numeric!";
                $this->iserror= true;
            }
            if($this->MODE=="test_http")
                $this->SERVICE_URL = "http://demo.myorderbox.com/anacreon/servlet/rpcrouter"; // HTTP DEMO SERVICE URL
            elseif($this->MODE=="test_https")
                $this->SERVICE_URL = "https://demo.myorderbox.com/anacreon/servlet/rpcrouter"; // HTTPS DEMO SERVICE URL
            elseif($this->MODE=="live_http")
                $this->SERVICE_URL = "http://www.myorderbox.com/anacreon/servlet/rpcrouter"; // HTTP LIVE SERVICE URL
            else
                $this->SERVICE_URL = "https://www.foundationapi.com/anacreon/servlet/rpcrouter"; // HTTPS LIVE SERVICE URL

            //PUT in to global variables
            $_GET['SERVICE_URL'] = $this->SERVICE_URL;
            return;
        }
        /*
        * Create customer
        */
        function createCustomer()
        {
            $Customer = new Customer(LIBRARIES."directi".PATH_SEP."wsdl".PATH_SEP."customer.wsdl");
            $return   = $Customer->addCustomer($this->USERNAME, $this->PASSWORD, $this->ROLE, $this->LANGPREF, $this->PARENTID, $this->data['email'], $this->data['dom_pass'], $this->data['name'], $this->data['domain'], $this->data['address'], "", "", $this->data['city'], $this->data['state'], $this->data['country'], $this->data['zip'], $this->data['country_code'], $this->data['telephone'], "", "", "", "", $this->LANGPREF);
            $response = new Response($return);
            $response->errorAnalyse();
            if ($response->isError())
            {
                $this->error_str = $response->errorMsg;
                $this->iserror   = true;
                if($response->errorCode == "com.logicboxes.foundation.sfnb.user.CustomerExistsException")
                {
                    $return = $Customer->getCustomerId($this->USERNAME,$this->PASSWORD,$this->ROLE,$this->LANGPREF,$this->PARENTID,$this->data['email']);
                    $this->account= $return;
                    $response  = new Response($return);
                    $response->errorAnalyse();
                    if ($response->isError())
                    {
                        $this->error_str = $response->errorMsg;
                        $this->iserror   = true;
                        return;
                    }
                    else
                    {
                        $this->error_str = "";
                        $this->iserror   = false;
                        return;
                    }
                }
                return;
            }
            else
            {
                $this->account= $response->getResult();
            }
            if(empty($this->account))
            {
                $this->error_str = "An unknown error occurred while creating customer!";
                $this->iserror   = true;
            }
            return;
        }
        /*
        * Add Domain contact
        */
        function addDomContact()
        {
            $this->error_str = "";
            $this->iserror   = false;
            $DomContact= new DomContact(LIBRARIES."directi".PATH_SEP."wsdl".PATH_SEP."domaincontact.wsdl");
            $return    = $DomContact->addDefaultContact($this->USERNAME, $this->PASSWORD, $this->ROLE, $this->LANGPREF, $this->PARENTID, $this->account);
            $response  = new Response($return);
            $response->errorAnalyse();
            if ($response->isError())
            {
                $this->error_str = $response->errorMsg;
                $this->iserror   = true;
                return;
            }
            else
            {
                $this->contact= $response->getResult();
            }
            if(empty($this->contact))
            {
                $this->error_str = "An unknown error occurred while adding domain contact!";
                $this->iserror   = true;
            }
            return;
        }
        /*
        * Register Domain
        */
        function regDomain()
        {
            $this->error_str = "";
            $this->iserror   = false;
            $dom = $this->data['domain'];
            if (!empty($this->data['dom_period']))
            {
                $period= $this->data['dom_period'];
                $domain= array ($dom => "{$period}");
            }
            else
            {
                $domain= array ($dom => "1");
            }
            $ns = array ("ns1.logicboxes.com", "ns2.logicboxes.com");
            if (($this->MODE == "live_http" || $this->MODE == "live_https") && !empty($this->data['ns1']) && !empty($this->data['ns1']))
                $ns = array ($this->data['ns1'], $this->data['ns2']);

            $DomOrder = new DomOrder(LIBRARIES."directi".PATH_SEP."wsdl".PATH_SEP."domain.wsdl");
            $return   = $DomOrder->registerDomain($this->USERNAME, $this->PASSWORD, $this->ROLE, $this->LANGPREF, $this->PARENTID, $domain, $ns, $this->contact, $this->contact, $this->contact, $this->contact, $this->account, "NoInvoice");
            $response = new Response($return);
            $domaindata= $response->getResult();
            $data_array= $domaindata[$dom];
            if ($data_array['status']=="error")
            {
                $this->error_str = $data_array['error'];
                $this->iserror   = true;
                return;
            }
            else
            {
                $this->entityid = $data_array['entityid'];
            }
            $this->data_array = $data_array;
            if(empty($this->entityid))
            {
                $this->error_str = "An unknown error occurred while registering domain!";
                $this->iserror   = true;
            }
            return;
        }
    }
?>
