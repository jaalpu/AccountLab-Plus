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

    $name           = "Credit Card";
    //Fields for admin backend
    $creditcard     = array (
        array ("Instructions message"       , "disp_msg"),
        array ("Show additional currencies" , "add_curr", "No", "Yes"),
        array ("Status after payment submission" , "submitted_status", "Pending", "Submitted"),
        array ("Active"                     , "active", "No", "Yes"),
        array ("Title"                      , "title"),
        array ("Submit label"               , "submit_label")
    );
    //Extra fields for order form and customer backend
    $ext_fields     = array (
        // 0=$lang ,1=var, 2=store 3=encrypt, 4=type, 5=size, 6=required, 7=show in [, options]
        array("Cardholder_Name"     ,"card_holder"      ,1,0,"text"     ,35 ,1,2),
        array("Card_Number"         ,"card_no"          ,1,1,"text"     ,35 ,1,2),
        array("Card_Type"           ,"card_type"        ,1,0,"select"   ,1  ,1,2 , "Visa","Mast","Amex","Disc"),
        array("Exp_Date"            ,"exp_date"         ,1,0,"text"     ,7  ,1,2),
        array("CVV2_Code"           ,"CVV2"             ,1,1,"text"     ,4  ,1,2)
    );
    $send_method    = "DIRECT";
    $validate       = "
    function validatepayment(btn) {
    if (btn.form.card_no.value.length < 5) {
    alert('Please enter your credit card number.');
    return false;
    }

    if (!luhnCheck(btn.form.card_no.value)) {
    alert('This credit card number is not valid.');
    return false;
    }

    if (!isNumeric(btn.form.card_no.value)) {
    alert('Credit card number can\'t contain spaces or non-numbers.');
    return false;
    }

    if (btn.form.card_no.value.length < 5) {
    alert('Please enter your credit card number.');
    return false;
    }

    if (btn.form.card_holder.value.length < 1) {
    alert('Please enter the credit card name.');
    return false;
    }

    if ((btn.form.exp_date.value.length != 4) || !isNumeric(btn.form.exp_date.value)) {
    alert('Please enter the credit card expiration date in the form MMYY.');
    return false;
    }

    if ((btn.form.CVV2.value.length < 3) || !isNumeric(btn.form.CVV2.value)) {
    alert('Please enter the CVV2 (card verification code) from the back of your card.');
    return false;
    }

    return true;
    }

    function isNumeric(sText) {
    var ValidChars = '0123456789';
    for (i = 0; i < sText.length && isNumeric == true; i++)
    if (ValidChars.indexOf(sText.charAt(i)) == -1)
    return false;
    return true;

    }

    function luhnCheck(CardNumber) {
    if (!isNumeric(CardNumber))
    return false;

    var no_digit = CardNumber.length;
    var oddoeven = no_digit & 1;
    var sum = 0;

    for (var count = 0; count < no_digit; count++) {
    var digit = parseInt(CardNumber.charAt(count));
    if (!((count & 1) ^ oddoeven)) {
    digit *= 2;
    if (digit > 9)
    digit -= 9;
    }
    sum += digit;
    }
    if (sum % 10 == 0)
    return true;
    else
    return false;
    }
    ";
    $pay            = new creditcard();
    /*
    * Class to do all offline
    * creditcard Version 1.0
    */
    class creditcard
    {
        /*
        * Constructor
        */
        function creditcard()
        {
            $this->pay_url   = 'ipn.php';
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->_POST1               = array ();
            $this->_POST1['item_number']= time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            $res = $BL->pp_vals->find(array("WHERE `pp_name`='".get_class()."'"));
            $status_after_submit = $res[0]['submitted_status'];

            if ($status_after_submit == 'Submitted')
            {
                $BL->invoices->update(array("invoice_no"=>intval($BL->REQUEST['item_number']), "status"=>$BL->props->invoice_status[6]));
            }
            return true;
        }
    }
?>
