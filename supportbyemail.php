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

    require_once "init.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!-- DW6 -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $BL->props->lang['accountlabplus']; ?></title>
    </head>
    <body>
        <font face='sans-serif' color='black' size='2'>
            <?php
                if($BL->conf['en_ticket_by_email']){
                    $connection = $BL->conf['ticket_email_proto']."://".urlencode($BL->conf['ticket_email_user']).":".$BL->conf['ticket_email_pass']."@".$BL->conf['ticket_email_host'].":".$BL->conf['ticket_email_port']."/".$BL->conf['ticket_email_mbox'];
                    $msg        = new Mail_IMAPv2();
                    if (!$msg->connect($connection)) {
                        echo 'Error: Unable to build a connection.';
                    }else{
                        $msgcount = $msg->messageCount();
                        if ($msgcount > 0){
                            $dmids = array();
                            for ($mid = 1; $mid <= $msgcount; $mid++){
                                $msg->getHeaders($mid);
                                $msg->getParts($mid);
                                $xmid = $mid;
                                $xpid = $msg->msg[$mid]['pid'];
                                $from = $msg->header[$mid]['from'][0];
                                $subject = $msg->header[$mid]['subject'];
                                $body = $msg->getBody($xmid, $xpid);
                                $customer = $BL->customers->getByKey($from,'email');
                                $admin    = $BL->admin_users->getByKey($from,'email');
                                //reply
                                if(preg_match("/\[TICKET NO:/i",$subject)){
                                    $Reply_Array = array();
                                    $Reply_Array['ticket_id'] = trim(str_replace("]", "", str_replace("[TICKET NO:", "", strstr($subject, "[TICKET NO:"))));
                                    $Ticket_Data = $BL->support_tickets->getByKey($Reply_Array['ticket_id']);
                                    if(isset($customer['id']) && !empty($customer['id']) && isset($Ticket_Data['ticket_id']) && !empty($Ticket_Data['ticket_id'])){
                                        $Reply_Array['reply_by'] = $customer['email'];
                                        $Ticket_Data['ticket_status']=1;
                                    }elseif(isset($admin['id']) && !empty($admin['id']) && isset($Ticket_Data['ticket_id']) && !empty($Ticket_Data['ticket_id'])){
                                        $Reply_Array['reply_by'] = $admin['userame'];
                                        $Ticket_Data['ticket_status']=0;
                                    }
                                    $Reply_Array['reply_text'] = $body['message'];
                                    $Reply_Array['reply_date'] = date('Y-m-d H:i:s');
                                    $Reply_Array['reply_id'] = $BL->support_replies->insert($Reply_Array);
                                    $BL->support_tickets->update($Ticket_Data);
                                    $BL->mailTicket($Reply_Array['reply_id'],false);
                                    $dmids[] = $mid;
                                }else{
                                    //ticket
                                    if(isset($customer['id']) && !empty($customer['id'])){
                                        error_reporting(E_ALL);
                                        $Ticket_Array = array();
                                        foreach($BL->support_topics->find() as $topic){
                                            if(!empty($topic['topic_regexp']) && (preg_match('/'.$topic['topic_regexp'].'/',$body['message']) || preg_match('/'.$topic['topic_regexp'].'/',$subject))){
                                                $Ticket_Array['topic_id'] = $topic['topic_id'];
                                            }
                                        }
                                        if(!isset($Ticket_Array['topic_id'])){
                                            $topic = $BL->support_topics->hasAnyOne();
                                            $Ticket_Array['topic_id'] = $topic['topic_id'];
                                        }

                                        $Ticket_Array['cust_id'] = $customer['id'];
                                        $Ticket_Array['ticket_status'] = 1;
                                        $Ticket_Array['ticket_date']= date('Y-m-d H:i:s');
                                        $Ticket_Array['ticket_text']=$body['message'];
                                        $Ticket_Array['ticket_subject']=$subject;
                                        $Ticket_Array['ticket_id']  = $BL->support_tickets->insert($Ticket_Array);
                                        $BL->mailTicket($Ticket_Array['ticket_id']);
                                        $dmids[] = $mid;
                                    }
                                }
                            }
                            if(count($dmids)){
                                $msg->delete($dmids);
                                $msg->expunge();
                            }
                        }
                    }
                    $msg->close();
                }
            ?>
        </font>
    </body>
</html>
