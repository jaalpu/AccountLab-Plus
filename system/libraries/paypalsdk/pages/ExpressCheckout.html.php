<?php
	$paymentType = $_GET['paymentType'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>PayPal PHP SDK - ExpressCheckout API</title>
    <link href="pages/sdk.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <center>
	<form action="ReviewOrder.php" method="post" name="ExpressCheckoutForm">
	<input type=hidden name=paymentType value=<?=$paymentType?>>
	<span id=apiheader>SetExpressCheckout</span>
    <table class="api">
         <tr>
            <td colspan="2">
                <br />
                <center>
                You must be logged into <a href="https://developer.paypal.com" id="PayPalDeveloperCentralLink" target="_blank">Developer
                    Central</a><br />
                <br />
                </center>
            </td>
        </tr>
        <tr>
            <td class="header">
                Amount:</td>
            <td>
                <input type="text" name="paymentAmount" size="5" maxlength="7" value="1.00" />
                <select name="currencyCodeType">
                <option value="USD">USD</option>
                <option value="GBP">GBP</option>
                <option value="EUR">EUR</option>
                <option value="JPY">JPY</option>
                <option value="CAD">CAD</option>
                <option value="AUD">AUD</option>
                </select>
                (Required)</td>
        </tr>
        <tr>
            <td>
                <br />
                <br />
                <input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" />
            </td>
            <td>
                <br />
                <br />
                Save time. Pay securely without sharing your financial information.
            </td>
        </tr>
    </table>
	</form>
    </center>
    <br />
    <a id="CallsLink" class="home" href="Calls.html">Home</a>
</body>
</html>
