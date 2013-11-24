<?php
/*
 * Copyright notice goes here
 *
 * This file can be redistributed under the same terms as the rest of this program.
 */

$error_logging = 0;
$error_display = 0;

if ($error_logging || $error_display)
{
	// Handle runtime errors
	$old_error_handler = set_error_handler("runtime_error_handler");

	// Handle fatal errors (such as parse errors)
	register_shutdown_function('shutdown_function'); 
}

function shutdown_function()
{
	$error = error_get_last(); 
	if ($error['type'] == 1)
		ALP_error_handler($error);
}

function runtime_error_handler()
{
	$error = error_get_last(); 
	ALP_error_handler($error);
	die();
}

function ALP_error_handler($error)
{
	global $error_logging;
	global $error_display;

	$errlogfile = dirname(__FILE__) . "/../logs/error.log";
	// If error log is over 1M, move it to .old, deleting any existing .old
	if (@filesize($errlogfile) > 1048576)
		rename($errlogfile, $errlogfile.".old");

	$errors  = "\nTime of error: ".date("Y-m-d H:i:s")."\n\n";
	$errors .= "---------------------------------------------\n\n";
	$errors .= "\n\nError:\n".print_r($error, 1)."\n\n";
	$errors .= "---------------------------------------------\n\n";
	$errors .= "\n\nServer Info:\n".print_r($_SERVER, 1)."\n\n";
	$errors .= "---------------------------------------------\n\n";
	$errors .= "\n\nCOOKIE:\n".print_r($_COOKIE, 1)."\n\n";
	$errors .= "---------------------------------------------\n\n";
	$errors .= "\n\nPOST:\n".print_r($_POST, 1)."\n\n";
	$errors .= "---------------------------------------------\n\n";
	$errors .= "\n\nGET:\n".print_r($_GET, 1)."\n\n";
	$errors .= "---------------------------------------------\n\n";
	$e = new Exception();
	$errors .= "\n\nStack Trace:\n".$e->getTraceAsString()."\n\n";
	$errors .= "---------------------------------------------\n\n";
	
	// Write error to log file if necessary
	if ($error_logging)
	{
		$fp = fopen($errlogfile,"a");
		fputs($fp, $errors);
		fclose($fp);
	}
	
	// Print error details to display, if necessary
	if ($error_display)
	{
		print(str_replace("\n","<br />\n", $errors));
	}
}
?>