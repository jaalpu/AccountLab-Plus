<?php

require_once 'PayPal/Type/GetExpressCheckoutDetailsResponseDetailsType.php';
require_once 'PayPal/Type/GetExpressCheckoutDetailsResponseType.php';

$resp_details = $response->getGetExpressCheckoutDetailsResponseDetails();
$logger->_log('GetExpressCheckoutDetails: '.print_r($resp_details, true));

$payer_info = $resp_details->getPayerInfo();
$payer_id = $payer_info->getPayerID();

$address = $payer_info->getAddress();
$street1 = $address->getStreet1();
$street2 = $address->getStreet2();
$city_name = $address->getCityName();
$state_province = $address->getStateOrProvince();
$postal_code = $address->getPostalCode();
$country_code = $address->getCountryName();

$order_total = $currencyCodeType.' '.$paymentAmount;

$final_url = 'ECReceipt.php?token='.$token.'&payerID='.$payer_id.'&paymentAmount='.$paymentAmount.'&currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>PayPal PHP SDK - ExpressCheckout API</title>
    <link href="pages/sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>

<center>
<table width=400>

<tr>
   <td><b>Order Total:</b></td>
   <td><?=$order_total?></td>
</tr>

<tr>
   <td colspan="2"><b>Shipping Address:</b></td>
</tr>

<tr>
   <td>Street 1:</td>
   <td><?=$street1?></td>
</tr>

<tr>
   <td>Street 2:</td>
   <td><?=$street2?></td>
</tr>

<tr>
   <td>City:</td>
   <td><?=$city_name?></td>
</tr>

<tr>
   <td>State:</td>
   <td><?=$state_province?></td>
</tr>

<tr>
   <td>Postal code:</td>
   <td><?=$postal_code?></td>
</tr>

<tr>
   <td>Country:</td>
   <td><?=$country_code?></td>
</tr>

</table>

<!-- Link to ECReceipt.php -->
<a id="ECReceiptLink" href="<?=$final_url?>">Pay</a>

</center>

<br>
<b><a id="CallsLink" href="Calls.html">Home</a></b>

</body>
</html>