<script language="JavaScript">
	function onClick(type){
		switch(type)
        {
			case 'cert':
				document.LoginForm.signature.disabled = true;
				document.LoginForm.certFile.disabled = false;
				
				break;
			case 'tokens':
				document.LoginForm.signature.disabled = false;
				document.LoginForm.certFile.disabled = true;
				
				break;
        }
	}
</script>

<?php
require_once 'lib/constants.inc.php';
?>

<html>
<head>

	<title>PayPal PHP SDK - API Credentials</title>
	<link href="pages/sdk.css" rel="stylesheet" type="text/css"/>

</head>
<body alink=#0000FF vlink=#0000FF>
<br>
<center>
<span id=normalBold>Use The Default Sandbox API Profile Or Enter Your Own Profile</span>
<br><br>
<span id=redBold>NOTE: Production code should NEVER expose API credentials in any way! They must be managed securely in your application.</span>
<br><br>
<span id=normal>To generate a Sandbox API Certificate, follow these steps: <a id="PayPalIntegrationCenterAPICertificateLink" href="https://www.paypal.com/IntegrationCenter/ic_certificate.html#step1" target="_blank">API Certificate</a></span>
<br><br>

<form action="WebPaymentPro.php" method="post" enctype="multipart/form-data" name="LoginForm">
<table width="700">
	<tr>
		<td align="right"><span id=normalBold>API Username:</span><br/><span id=smaller>(ex: my_account_api1.paypal.com)</span></td>
		<td>sdk-seller_api1.sdk.com</td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold><b>API Password:</b></span></td>
		<td>12345678</td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold>Encrypted API Certificate:</span><br><span id=smaller>cert_key.pem format</span></td>
		<td>sdk-seller_cert_key_pem.txt</td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold><b>Environment:</b></span></td>
		<td><?=ENVIRONMENT?></td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td align=left>
		   <input type="hidden" name="environment" value="<?=ENVIRONMENT?>">
			<input type="hidden" name="submitted" value="1">
			<input type="submit" value="Use default account" name="DefaultButton">
		</td>
	</tr>
	<tr>
		<td colspan=3 align=center><br><b>Or enter your own profile...</b></td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold><b>API Credentials:</b></span>
		<td>
			<input type="radio" name="api-type" value="cert" onclick="onClick('cert');">Client Side SSL Certificate<br>
			<input type="radio" name="api-type" value="tokens" checked onclick="onClick('tokens');">3 Tokens Authentication<br>
		</td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold><b>API Username:</span><br><span id=smaller>(ex: my_account_api1.paypal.com)</span></td>
		<td><input type="text" name="apiUsername" value=""><b> Not your PayPal Email Address!</b></td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold><b>API Password:</span></td>
		<td><input type="text" name="apiPassword" value=""></td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold>Signature:</span></td>
		<td><input type="text" name="signature" value=""></td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold>Encrypted API Certificate:</span><br><span id=smaller>cert_key.pem format</span></td>
		<td><input type="file" name="certFile" value="" disabled></td>
	</tr>
	<tr>
		<td align="right"><span id=normalBold><b>Environment:</span></td>
		<td><?=ENVIRONMENT?></td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td align=left>
			<input type="hidden" name="environment" value="<?=ENVIRONMENT?>">
			<input type="hidden" name="submitted" value="1">
			<input type="submit" value="Use my account" name="custom">
		</td>
	</tr>
</table>
</form>
</body>
</html>