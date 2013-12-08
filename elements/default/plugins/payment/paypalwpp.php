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

    $name           = "PayPal Website Payments Pro";
    $paypalwpp      = array (
        array ("API Username"   , "paypalwpp_apiUsername"),
        array ("API Password"   , "paypalwpp_apiPassword"),
        array ("API Credentials", "paypalwpp_api-type", "cert", "tokens"),
        array ("Signature"      , "paypalwpp_signature"),
        array ("Encrypted API Certificate" , "paypalwpp_certFile"),
        array ("Active"         , "active", "No", "Yes"),
        array ("Title"          , "title"),
        array ("Submit label"   , "submit_label")
    );
    //Extra fields for order form and customer backend
    $ext_fields     = array (
        // 0=$lang ,1=var, 2=store 3=encrypt, 4=type, 5=size, 6=required, 7=show in [, options]
        array("Card_First_Name"     ,"paypalwpp_firstName"       ,1,0,"text"     ,35 ,1,2),
        array("Card_Last_Name"      ,"paypalwpp_lastName"        ,1,0,"text"     ,35 ,1,2),
        array("Card_Type"           ,"paypalwpp_creditCardType"  ,1,0,"select"   ,1  ,1,2 , "Visa","MasterCard","Discover","Amex"),
        array("Card_Number"         ,"paypalwpp_creditCardNumber",1,0,"text"     ,35 ,1,2),
        array("Exp_Month"           ,"paypalwpp_expDateMonth"    ,1,0,"select"   ,1  ,1,2 , "01","02","03","04","05","06","07","08","09","10","11","12"),
        array("Exp_Year"            ,"paypalwpp_expDateYear"     ,1,0,"select"   ,1  ,1,2),
        array("CVV2_Code"           ,"paypalwpp_cvv2Number"      ,1,0,"text"     ,4  ,1,2),
        array("Address"             ,"paypalwpp_address1"        ,1,0,"text"     ,35 ,1,2),
        array("City"                ,"paypalwpp_city"            ,1,0,"text"     ,35 ,1,2),
        array("State"               ,"paypalwpp_state"           ,1,0,"select"   ,1  ,1,2 , "AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY", "AA", "AE", "AP", "AS", "FM", "GU", "MH", "MP", "PR", "PW", "VI"),
        array("Zip"                 ,"paypalwpp_zip"             ,1,0,"text"     ,35 ,1,2),
    );

    $validate = "
    function validatepayment(btn) {
    if (btn.form.paypalwpp_creditCardNumber.value.length < 5) {
    alert('Please enter your credit card number.');
    return false;
    }

    if (!luhnCheck(btn.form.paypalwpp_creditCardNumber.value)) {
    alert('This credit card number is not valid.');
    return false;
    }

    if (!isNumeric(btn.form.paypalwpp_creditCardNumber.value)) {
    alert('Credit card number can\'t contain spaces or non-numbers.');
    return false;
    }

    if (btn.form.paypalwpp_creditCardNumber.value.length < 5) {
    alert('Please enter your credit card number.');
    return false;
    }

    if (btn.form.paypalwpp_firstName.value.length < 1) {
    alert('Please enter the credit card first name.');
    return false;
    }

    if (btn.form.paypalwpp_lastName.value.length < 1) {
    alert('Please enter the credit card last name.');
    return false;
    }

    if (!isNumeric(btn.form.paypalwpp_expDateMonth.value) || (btn.form.paypalwpp_expDateMonth.value < 1) || (btn.form.paypalwpp_expDateMonth.value > 12)) {
    alert('Please enter the credit card expiration month.');
    return false;
    }

    if (!isNumeric(btn.form.paypalwpp_expDateYear.value) || (btn.form.paypalwpp_expDateYear.value < 1) || (btn.form.paypalwpp_expDateYear.value > 99)) {
    alert('Please enter the credit card expiration year.');
    return false;
    }

    if ((btn.form.paypalwpp_cvv2Number.value.length < 3) || !isNumeric(btn.form.paypalwpp_cvv2Number.value)) {
    alert('Please enter the CVV2 (card verification code) from the back of your card.');
    return false;
    }

    if (btn.form.paypalwpp_address1.value.length < 1) {
    alert('Please enter the credit card address.');
    return false;
    }

    if (btn.form.paypalwpp_city.value.length < 1) {
    alert('Please enter the credit card city.');
    return false;
    }

    if (btn.form.paypalwpp_state.value.length < 1) {
    alert('Please enter the credit card state.');
    return false;
    }

    if (btn.form.paypalwpp_zip.value.length < 1) {
    alert('Please enter the credit card ZIP or postal code.');
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

    for($i=date('Y');$i<(date('Y')+20);$i++)
    {
        $ext_fields[5][]=$i;
    }

    $send_method = "POST";
    $pay         = new paypalwpp($demo_mode);
    /*
    * Class to do all paypalwpp
    * paypalwpp Version 1.0
    */
    class paypalwpp
    {
        /*
        * Constructor
        */
        function paypalwpp($demo_mode= 0)
        {
            $this->demo_mode = $demo_mode;
            $this->pay_url   = 'ipn.php';
            $this->ipn_type  = 2;
        }
        /*
        * Function to send variables
        */
        function sendVariables($path_url, $pp_vals)
        {
            $this->pay_url  = $path_url.'/ipn.php';

            $this->_POST1   = $_POST;
            $this->_POST1['item_number'] = time().rand(0, 1000);
            if (isset ($_POST['force_inv_no']))
            {
                $this->_POST1['item_number'] = $_POST['force_inv_no'];
            }
            $this->_POST1['ipn_type'] = 2;
            $this->_POST1['pp']       = 'paypalwpp';
            $this->_POST1['item_name']= $_POST['friendly_desc'];
            if(empty($this->_POST1['item_name']))
            {
                $this->_POST1['item_name'] = $_POST['desc'];
            }

            $this->_POST1['firstName']        = $_POST['paypalwpp_firstName'];
            $this->_POST1['lastName']         = $_POST['paypalwpp_lastName'];
            $this->_POST1['creditCardType']   = $_POST['paypalwpp_creditCardType'];
            $this->_POST1['creditCardNumber'] = $_POST['paypalwpp_creditCardNumber'];
            $this->_POST1['expDateMonth']     = $_POST['paypalwpp_expDateMonth'];
            $this->_POST1['expDateYear']      = $_POST['paypalwpp_expDateYear'];
            $this->_POST1['cvv2Number']       = $_POST['paypalwpp_cvv2Number'];
            $this->_POST1['address1']         = $_POST['paypalwpp_address1'];
            $this->_POST1['city']             = $_POST['paypalwpp_city'];
            $this->_POST1['state']            = $_POST['paypalwpp_state'];
            $this->_POST1['zip']              = $_POST['paypalwpp_zip'];
            $this->_POST1['amount']           = number_format($_POST['gross_amount'],2);
        }
        /*
        * IPN=Internet Payment Notifier
        */
        function ipn(& $BL)
        {
            if($_POST['pp'] == "paypalwpp")
            {
                $this->item_number    = $_POST['item_number'];
                $this->transaction_id = 0;
                $this->payment_status = '';

                $pp_vals = $BL->pp_vals->getByKey("paypalwpp");
                $temp    = $BL->orphan_orders->hasAnyOne(array("WHERE `item_number`=".intval($this->item_number)));
                $O_order = array();
                foreach($BL->orphan_order_datas->find(array("WHERE `orphan_order_id`=".intval($temp['orphanorder_id']))) as $data)
                {
                    $O_order[$data['orphan_order_field']] = $data['orphan_order_value'];
                }
                if(count($O_order))
                {
                    $amount = number_format($O_order['gross_amount'], 2);
                }
                else
                {
                    $invoice = $BL->invoices->get("WHERE `invoice_no`=".intval($this->item_number));
                    $amount  = number_format($invoice[0]['gross_amount'], 2);
                }

                require_once 'PayPal.php';
                require_once 'PayPal/Profile/API.php';
                require_once 'PayPal/Profile/Handler.php';
                require_once 'PayPal/Profile/Handler/Array.php';
                require_once 'PayPal/Type/DoDirectPaymentRequestType.php';
                require_once 'PayPal/Type/DoDirectPaymentRequestDetailsType.php';
                require_once 'PayPal/Type/DoDirectPaymentResponseType.php';
                // Add all of the types
                require_once 'PayPal/Type/BasicAmountType.php';
                require_once 'PayPal/Type/PaymentDetailsType.php';
                require_once 'PayPal/Type/AddressType.php';
                require_once 'PayPal/Type/CreditCardDetailsType.php';
                require_once 'PayPal/Type/PayerInfoType.php';
                require_once 'PayPal/Type/PersonNameType.php';

                // Ack related constants
                define('ACK_SUCCESS', 'Success');
                define('ACK_SUCCESS_WITH_WARNING', 'SuccessWithWarning');

                // Refund related constants
                define('REFUND_PARTIAL', 'Partial');
                define('REFUND_FULL', 'Full');

                // Profile
                if($this->demo_mode)
                    define('ENVIRONMENT', 'sandbox');
                else
                    define('ENVIRONMENT', 'live');

                define('UNITED_STATES', 'US');


                $dummy        = @new APIProfile();
                $environments = $dummy->getValidEnvironments();
                $handler      = & ProfileHandler_Array::getInstance(array(
                    'username'        => $pp_vals['paypalwpp_apiUsername'],
                    'certificateFile' => null,
                    'subject'         => null,
                    'environment'     => ENVIRONMENT ));
                $pid          = ProfileHandler::generateID();
                $profile      = new APIProfile($pid, $handler);

                $profile->setAPIUsername($pp_vals['paypalwpp_apiUsername']);
                $profile->setAPIPassword($pp_vals['paypalwpp_apiPassword']);
                if(is_file($pp_vals['paypalwpp_certFile']))
                    $profile->setCertificateFile($pp_vals['paypalwpp_certFile']);
                $profile->setSignature($pp_vals['paypalwpp_signature']);
                $profile->setEnvironment(ENVIRONMENT);

                $caller       = & PayPal::getCallerServices($profile);

                $_SESSION['APIProfile'] = $profile;
                $_SESSION['caller']     = $caller;

                $dp_request   = & PayPal::getType('DoDirectPaymentRequestType');
                /**
                * Get posted request values
                */
                $paymentType            = 'Sale';
                $firstName              = $_POST['paypalwpp_firstName'];
                $lastName               = $_POST['paypalwpp_lastName'];
                $creditCardType         = $_POST['paypalwpp_creditCardType'];
                $creditCardNumber       = $_POST['paypalwpp_creditCardNumber'];
                $expDateMonth           = $_POST['paypalwpp_expDateMonth'];
                $padDateMonth           = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
                $expDateYear            = $_POST['paypalwpp_expDateYear'];
                $cvv2Number             = $_POST['paypalwpp_cvv2Number'];
                $address1               = $_POST['paypalwpp_address1'];
                $address2               = $_POST['paypalwpp_address2'];
                $city                   = $_POST['paypalwpp_city'];
                $state                  = $_POST['paypalwpp_state'];
                $zip                    = $_POST['paypalwpp_zip'];
                $amount                 = $amount;

                // Populate SOAP request information
                // Payment details
                $OrderTotal             = & PayPal::getType('BasicAmountType');
                $OrderTotal->setattr('currencyID', 'USD');
                $OrderTotal->setval($amount, 'iso-8859-1');
                $PaymentDetails         = & PayPal::getType('PaymentDetailsType');
                $PaymentDetails->setOrderTotal($OrderTotal);
                $shipTo                 = & PayPal::getType('AddressType');
                $shipTo->setName($firstName.' '.$lastName);
                $shipTo->setStreet1($address1);
                $shipTo->setStreet2($address2);
                $shipTo->setCityName($city);
                $shipTo->setStateOrProvince($state);
                $shipTo->setCountry(UNITED_STATES);
                $shipTo->setPostalCode($zip);
                $PaymentDetails->setShipToAddress($shipTo);

                $dp_details             = & PayPal::getType('DoDirectPaymentRequestDetailsType');
                $dp_details->setPaymentDetails($PaymentDetails);

                // Credit Card info
                $card_details           = & PayPal::getType('CreditCardDetailsType');
                $card_details->setCreditCardType($creditCardType);
                $card_details->setCreditCardNumber($creditCardNumber);
                $card_details->setExpMonth($padDateMonth);
                $card_details->setExpYear($expDateYear);
                $card_details->setCVV2($cvv2Number);

                $payer                  = & PayPal::getType('PayerInfoType');
                $person_name            = & PayPal::getType('PersonNameType');
                $person_name->setFirstName($firstName);
                $person_name->setLastName($lastName);
                $payer->setPayerName($person_name);

                $payer->setPayerCountry(UNITED_STATES);
                $payer->setAddress($shipTo);

                $card_details->setCardOwner($payer);

                $dp_details->setCreditCard($card_details);
                $dp_details->setIPAddress($_SERVER['SERVER_ADDR']);
                $dp_details->setPaymentAction($paymentType);

                $dp_request->setDoDirectPaymentRequestDetails($dp_details);

                $caller     = & PayPal::getCallerServices($profile);
                $response   = $caller->DoDirectPayment($dp_request);
                $ack        = $response->getAck();

                $this->payment_status = $ack;
                $this->transaction_id = $response->TransactionID;

                if (!empty ($this->item_number) && !empty ($this->transaction_id) && ($this->payment_status == ACK_SUCCESS || $this->payment_status == ACK_SUCCESS_WITH_WARNING))
                {
                    $BL->invoices->processTransaction($this->item_number, $this->transaction_id);
                    return true;
                }
            }
            return false;
        }
    }
?>
