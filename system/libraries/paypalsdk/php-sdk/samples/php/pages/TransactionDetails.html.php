<?php

   $ptd = $response->getPaymentTransactionDetails();
   $payer_info = $ptd->getPayerInfo();
   $payment_info = $ptd->getPaymentInfo();
   
   // Payer fields
   $payer = $payer_info->getPayer();
   $payer_id = $payer_info->getPayerID();
   $payer_name = $payer_info->getPayerName();
   $payer_fname = $payer_name->getFirstName();
   $payer_lname = $payer_name->getLastName();
   
   // Payment fields
   $tran_ID = $payment_info->getTransactionID();
   $tran_ID_parent = $payment_info->getParentTransactionID();
   if(! isset($tran_ID_parent)){
      $tran_ID_parent = "Not Available";
   }
   $gross_amt_obj = $payment_info->getGrossAmount();
   $gross_amt = $gross_amt_obj->_value;
   $currency_cd = $gross_amt_obj->_attributeValues['currencyID'];
   // $currency_cd = 'USD';
   $status = $payment_info->getPaymentStatus();
   
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Transaction details</title>
    <link href="pages/sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>

    <center>
    <span id=apiheader>Transaction Details</span>
    <br><br>
    <table>
    
        <tr>
            <td>
                Payer:
            </td>
            <td><?=$payer?></td>
        </tr>
        <tr>
            <td>
                Payer ID:
            </td>
            <td><?=$payer_id?></td>
        </tr>
        <tr>
            <td>
                First Name:
            </td>
            <td><?=$payer_fname?></td>
        </tr>
        <tr>
            <td>
                Last Name:
            </td>
            <td><?=$payer_lname?></td>
        </tr>
        <tr>
            <td>
                Transaction ID:
            </td>
            <td><?=$tran_ID?></td>
        </tr>
        <tr>
            <td>
                Parent Transaction ID (if any):
            </td>
            <td><?=$tran_ID_parent?></td>
        </tr>
        <tr>
            <td>
                Gross Amount:
            </td>
            <?php
            $display_amt = $currency_cd.' '.$gross_amt;
            ?>
            <td><?=$display_amt?></td>
        </tr>
        <tr>
            <td>
                Payment Status:
            </td>
            <td><?=$status?></td>
        </tr>
      
    </table>
    </center>
    
    <?php
      // Build links
      $do_void_link = 'DoVoid.php?authorization_id='.$tran_ID;
      $do_capture_link = 'DoCapture.php?authorization_id='.$tran_ID.'&currency='.$currency_cd.'&amount='.$gross_amt;
      $do_refund_link = 'RefundTransaction.php?transaction_id='.$tran_ID.'&currency='.$currency_cd.'&amount='.$gross_amt;
    ?>
    
    <br><br>
    <a id="DoVoidLink" href="<?=$do_void_link?>">Void</a>
    <a id="DoCaptureLink" href="<?=$do_capture_link?>">Capture</a>
    <a id="RefundTransactionLink" href="<?=$do_refund_link?>">Refund</a>
    <a id="BackLink" href="javascript:history.back()">Back</a>
    <br />
    <a id="CallsLink" class="home" href="Calls.html">Home</a>
</body>
</html>
