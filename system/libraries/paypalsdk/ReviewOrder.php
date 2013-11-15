<?php
include 'ppsdk_include_path.inc';

require_once 'PayPal.php';
require_once 'PayPal/Profile/Handler/Array.php';
require_once 'PayPal/Profile/API.php';
require_once 'PayPal/Type/BasicAmountType.php';
require_once 'PayPal/Type/SetExpressCheckoutRequestType.php';
require_once 'PayPal/Type/SetExpressCheckoutRequestDetailsType.php';
require_once 'PayPal/Type/SetExpressCheckoutResponseType.php';

require_once 'PayPal/Type/GetExpressCheckoutDetailsRequestType.php';
require_once 'PayPal/Type/GetExpressCheckoutDetailsResponseDetailsType.php';
require_once 'PayPal/Type/GetExpressCheckoutDetailsResponseType.php';

require_once 'lib/constants.inc.php';
require_once 'SampleLogger.php';

define('PAYPAL_URL', 'https://www.' . ENVIRONMENT . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=');

session_start();

$profile = $_SESSION['APIProfile'];

$logger = new SampleLogger('ReviewOrder.php', PEAR_LOG_DEBUG);

// Verify that user is logged in
if(! isset($profile)) {
   // Not logged in -- Back to the login page
   
   $logger->_log('You are not logged in;  return to index.php'); 
   $location = 'index.php';
   header("Location: $location"); 
} else {
   $logger->_log('caller: '. print_r($caller, true));   
}

$token = $_REQUEST['token'];
if(! isset($token)) {

   // SetExpressCheckout handling
   $serverName = $_SERVER['SERVER_NAME'];
   // Use this to test with NAT
   // $serverName = '192.168.1.10';
   $serverPort = $_SERVER['SERVER_PORT'];
   
   // $pathInfo = '/php-sdk/samples/php';
   $path_parts = pathinfo($_SERVER['SCRIPT_NAME']);
   $path_info = $path_parts['dirname'];
   $url='http://'.$serverName.':'.$serverPort.$path_info;
   
   $paymentAmount=$_REQUEST['paymentAmount'];
   $currencyCodeType=$_REQUEST['currencyCodeType'];
   // paymentType is ActionCodeType in ASP SDK
   $paymentType=$_REQUEST['paymentType'];
   
   $returnURL = $url.'/ReviewOrder.php?paymentAmount='.$paymentAmount.'&currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType;
   $cancelURL = str_replace('ReviewOrder', 'ExpressCheckout', $returnURL);
   
   $ec_request =& PayPal::getType('SetExpressCheckoutRequestType');
   
   $ec_details =& PayPal::getType('SetExpressCheckoutRequestDetailsType');
   $ec_details->setReturnURL($returnURL);
   $ec_details->setCancelURL($cancelURL);
   $ec_details->setPaymentAction($paymentType);
    
   $amt_type =& PayPal::getType('BasicAmountType');
   $amt_type->setattr('currencyID', $currencyCodeType);
   $amt_type->setval($paymentAmount, 'iso-8859-1');  
   $ec_details->setOrderTotal($amt_type);
   
   $ec_request->setSetExpressCheckoutRequestDetails($ec_details);
   
   
   $caller =& PayPal::getCallerServices($profile);

   // Execute SOAP request
   $response = $caller->SetExpressCheckout($ec_request);
   // $display = print_r($response, true);
   $logger->_log('SetExpressCheckout response: '. print_r($response,true));
   
   $ack = $response->getAck();
   
   $logger->_log('Ack='.$ack);
   
   switch($ack) {
      case ACK_SUCCESS:
      case ACK_SUCCESS_WITH_WARNING:
         // Good to break out;
         
         // Redirect to paypal.com here
         $token = $response->getToken();
         $payPalURL = PAYPAL_URL.$token;
         // $display=$payPalURL;
         $logger->_log('Redirect to PayPal for payment: '. $payPalURL);
         header("Location: ".$payPalURL);
         exit;
      
      default:
         $_SESSION['response'] =& $response;   
         $logger->_log('SetExpressCheckout failed: ' . print_r($response, true));
         $location = "ApiError.php";
         header("Location: $location");  
   }
   
} else {
   
   // We have a TOKEN from paypal
   // GetExpressCheckoutDetails handling here
   $paymentType=$_REQUEST['paymentType'];
   $token = $_REQUEST['token'];
   $paymentAmount=$_REQUEST['paymentAmount'];
   $currencyCodeType=$_REQUEST['currencyCodeType'];
   
   $ec_request =& PayPal::getType('GetExpressCheckoutDetailsRequestType');
   $ec_request->setToken($token);
   
   $caller =& PayPal::getCallerServices($profile);

   // Execute SOAP request
   $response = $caller->GetExpressCheckoutDetails($ec_request);
   // $display = print_r($response, true);
   $logger->_log('GetExpressCheckoutDetails response: '. print_r($response,true));
   
   $ack = $response->getAck();
   
   $logger->_log('Ack='.$ack);
   
   switch($ack) {
      case ACK_SUCCESS:
      case ACK_SUCCESS_WITH_WARNING:
         // Continue on based on the require below...
         break;
      
      default:
         $_SESSION['response'] =& $response;   
         $logger->_log('SetExpressCheckout failed: ' . print_r($response, true));
         $location = "ApiError.php";
         header("Location: $location");  
   }
   
   require_once 'pages/GetExpressCheckoutDetails.html.php'; 
}

?>
