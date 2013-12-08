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
    * Class to give access to a page
    * ALPmail Version 2.0
    */
    class ALPmail extends PHPMailer
    {
        /*
        * Set PHPMailer Properties
        */
        function setProps($conf, & $props)
        {
            $this->props = $props;
            /**
            * Email priority (1 = High, 3 = Normal, 5 = low).
            * @var int
            */
            if($conf['email_priority'])
                $this->Priority = $conf['email_priority'];

            /**
            * Sets the CharSet of the message.
            * @var string
            */
            $this->CharSet = $props->lang['charset'];
            if($conf['email_charset'])
                $this->CharSet = $conf['email_charset'];

            /**
            * Sets the Content-type of the message.
            * @var string
            */
            if($conf['email_content_type'])
                $this->ContentType = $conf['email_content_type'];

            /**
            * Sets the Encoding of the message. Options for this are "8bit",
            * "7bit", "binary", "base64", and "quoted-printable".
            * @var string
            */
            if($conf['email_encoding'])
                $this->Encoding = $conf['email_encoding'];

            /**
            * Sets the From email address for the message.
            * @var string
            */
            $this->From = $conf['comp_email'];

            /**
            * Sets the From name of the message.
            * @var string
            */
            $this->FromName = $conf['company_name'];

            /**
            * Sets the Sender email (Return-Path) of the message.  If not empty,
            * will be sent via -f to sendmail or as 'MAIL FROM' in smtp mode.
            * @var string
            */
            $this->Sender = $conf['email_sender'];

            /**
            * Sets word wrapping on the body of the message to a given number of
            * characters.
            * @var int
            */
            if($conf['email_wordwrap'])
                $this->WordWrap = $conf['email_wordwrap'];

            /**
            * Method to send mail: ("mail", "sendmail", or "smtp").
            * @var string
            */
            if($conf['emailer'])
                $this->Mailer = $conf['emailer'];

            /**
            * Sets the path of the sendmail program.
            * @var string
            */
            if($conf['sendmail_path'])
                $this->Sendmail = $conf['sendmail_path'];

            /**
            * Sets the email address that a reading confirmation will be sent.
            * @var string
            */
            if($conf['reading_confirm'])
                $this->ConfirmReadingTo  = $conf['reading_confirm'];


            /////////////////////////////////////////////////
            // SMTP VARIABLES
            /////////////////////////////////////////////////

            /**
            *  Sets the SMTP hosts.  All hosts must be separated by a
            *  semicolon.  You can also specify a different port
            *  for each host by using this format: [hostname:port]
            *  (e.g. "smtp1.example.com:25;smtp2.example.com").
            *  Hosts will be tried in order.
            *  @var string
            */
            if($conf['smtp_host'])
                $this->Host = $conf['smtp_host'];

            /**
            *  Sets the default SMTP server port.
            *  @var int
            */
            if($conf['smtp_port'])
                $this->Port = $conf['smtp_port'];

            /**
            *  Sets SMTP authentication. Utilizes the Username and Password variables.
            *  @var bool
            */
            if($conf['smtp_auth'])
                $this->SMTPAuth = true;

            /**
            *  Sets SMTP username.
            *  @var string
            */
            if($conf['smtp_user'])
                $this->Username = $conf['smtp_user'];

            /**
            *  Sets SMTP password.
            *  @var string
            */
            if($conf['smtp_pass'])
                $this->Password = $conf['smtp_pass'];

        }
        /*
        * Send email
        */
        function sendMail()
        {
            $r = false;
            if(!$this->props->alp_demo_mode && $this->Send())$r = true;
            $this->ClearAllRecipients();
            $this->ClearAttachments();
            return $r;
        }
    }
?>
