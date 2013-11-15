<?php

include 'ppsdk_include_path.inc';

require_once 'PayPal.php';
require_once 'PayPal/Profile/Handler/Array.php';
require_once 'PayPal/Profile/API.php';
require_once 'PayPal/Type/AbstractResponseType.php';
require_once 'PayPal/Type/ErrorType.php';
require_once 'PayPal/Type/RefundTransactionResponseType.php';
require_once 'PayPal/Type/TransactionSearchResponseType.php';
require_once 'PayPal/Type/GetTransactionDetailsResponseType.php';
require_once 'PayPal/Type/DoDirectPaymentResponseType.php';
require_once 'PayPal/Type/SetExpressCheckoutResponseType.php';
require_once 'PayPal/Type/GetExpressCheckoutDetailsResponseDetailsType.php';
require_once 'PayPal/Type/GetExpressCheckoutDetailsResponseType.php';
require_once 'PayPal/Type/DoExpressCheckoutPaymentResponseType.php';
require_once 'PayPal/Type/DoCaptureResponseDetailsType.php';
require_once 'PayPal/Type/DoCaptureResponseType.php';
require_once 'PayPal/Type/MassPayResponseType.php';
require_once 'PayPal/Type/DoReauthorizationResponseType.php';
require_once 'PayPal/Type/DoVoidResponseType.php';

require_once 'SampleLogger.php';


session_start();

$logger = new SampleLogger('ApiError.php', PEAR_LOG_DEBUG);

$response = $_SESSION['response'];
$logger->_log('SOAP response: '. print_r($response, true));

// Require AbstractResponseType.php
$ack           = $response->getAck();
$correlationID = $response->getCorrelationID();
$version       = $response->getVersion();
// Require ErrorType.php
$errorList     = $response->getErrors();

// Remove the response at this point
unset($_SESSION['response']);

?>

<html>
<head>
<title>PayPal PHP API Error</title>
<link href="pages/sdk.css" rel="stylesheet" type="text/css"/>
</head>

<body alink=#0000FF vlink=#0000FF>

<center>
<br>
<span id=apiheader>PayPal API Error</span>
<br><br>
<span id=smaller>A PayPal API has returned an error!</span><br><br>
<table width="700">

	<tr>
		<td>Ack:</td>
		<td><?= $ack ?></td>
	</tr>
	<tr>
		<td>Correlation ID:</td>
		<td><?= $correlationID ?></td>
	</tr>
	<tr>
		<td>Version:</td>
		<td><?= $version ?></td>
	</tr>
<?php
   if(! is_array($errorList)) {
      $errorCode    = $errorList->getErrorCode();
      $shortMessage = $errorList->getShortMessage();
      $longMessage  = $errorList->getLongMessage();
?>
	<tr>
		<td>Error Number:</td>
		<td><?= $errorCode ?></td>
	</tr>
	<tr>
		<td>Short Message:</td>
		<td><?= $shortMessage ?></td>
	</tr>
	<tr>
		<td>Long Message:</td>
		<td><?= $longMessage ?></td>
	</tr>

<?php
   } else {
      for($n = 0; $n < sizeof($errorList); $n++) {
         $oneError = $errorList[$n];
         $errorCode    = $oneError->getErrorCode();
         $shortMessage = $oneError->getShortMessage();
         $longMessage  = $oneError->getLongMessage();
?>

	<tr>
		<td>Error Number:</td>
		<td><?= $errorCode ?></td>
	</tr>
	<tr>
		<td>Short Message:</td>
		<td><?= $shortMessage ?></td>
	</tr>
	<tr>
		<td>Long Message:</td>
		<td><?= $longMessage ?></td>
	</tr>

<?php
      } // for
   }  // if
?>

</table>
</center>
<a id="CallsLink" href="Calls.html">Home</a>
</body>
</html>