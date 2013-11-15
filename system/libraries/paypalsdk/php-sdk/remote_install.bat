:: install.bat
:: Windows remote install files, uses a scripted FTP upload.
::
@ECHO OFF

:: Give ourselves a local environment with !VAR! support.
SETLOCAL ENABLEDELAYEDEXPANSION

:: Confirm overwriting files.
ECHO This installer will overwrite any existing files in the target directory. To cancel, press Control-C and then Y.
PAUSE

:: Prompt user for connection information.
SET /P HOSTNAME="Enter the FTP server to install on: "
SET /P USERNAME="Username for FTP: "
SET /P PASSWORD="Password for FTP: "
SET /P INSTALLDIR="Please enter the path (relative to your FTP root) for the paypal-php-sdk directory: "
SET /P SAMPLEDIR="Please enter the path (relative to your FTP root) for the paypal-sdk-samples directory: "

:: Create the include_path file.
ECHO.^<?php > ppsdk_include_path.inc
ECHO./******************************************* >> ppsdk_include_path.inc
ECHO. AUTO-GENERATED include for PayPal PHP SDK >> ppsdk_include_path.inc
ECHO. Created by install.php on: >> ppsdk_include_path.inc
DATE /T >> ppsdk_include_path.inc
ECHO.*******************************************/ >> ppsdk_include_path.inc
ECHO.set_include_path('%INSTALLDIR%' . DIRECTORY_SEPARATOR . 'paypal-php-sdk' . DIRECTORY_SEPARATOR . 'lib' . PATH_SEPARATOR . get_include_path()); >> ppsdk_include_path.inc

:: Read the template file.
FOR /F "delims=" %%L IN (docs\FTPManifest.txt) DO (
  :: Replace our known tokens.
  SET LINE=%%L
  SET LINE=!LINE:{hostname}=%HOSTNAME%!
  SET LINE=!LINE:{username}=%USERNAME%!
  SET LINE=!LINE:{password}=%PASSWORD%!
  SET LINE=!LINE:{installdir}=%INSTALLDIR%!
  SET LINE=!LINE:{sampledir}=%SAMPLEDIR%!
  ECHO.!LINE!>> ftpinstall.scr
)

:: Add the include_path file
ECHO.put ppsdk_include_path.inc>> ftpinstall.scr

:: Signoff
ECHO.QUIT>> ftpinstall.scr

START /W FTP -s:ftpinstall.scr

:: Clean up
TYPE NUL > ftpinstall.scr
TYPE NUL > ppsdk_include_path.inc
DEL ftpinstall.scr
DEL ppsdk_include_path.inc
