<?php
/**
 * Program: install.php
 *
 * Installer for PayPal PHP SDK
 *
 * This version assumes that the distribution (.zip, .tar, .tar.gz) has already
 * been expanded since this script is included in the distribution.
 *
 * Author:  D. Harvey
 * Date:  2/21/2006
 *
 * Notes:
 * - Handle entered directories with/without trailing slash
 * - The install.php resides at the top of the PHP tree so there is no install required
 *   for the PHP libs.
 */

/**
 * Required PHP extension list.
 */
$reqd_ext = array(
    'curl',
    'openssl',
);

/**
 * Checks.
 */
if (!inSdkDir()) {
    $sdk_dir = dirname(__FILE__);
    error_message("Please cd to the $sdk_dir and run install.php");
    exit(1);
}
if ($err = validate_php_env($reqd_ext)) {
    error_message('One or more required PHP extensions is missing: ' . $err);
    exit(1);
}

/**
 * Confirm overwriting.
 */
echo "This installer will overwrite any existing files in the target directory.\nContinue (y or n)? ";
$confirm = strtolower(substr(trim(fgets(STDIN)), 0, 1));
if ($confirm != 'y') {
    exit(1);
}

/**
 * Proceed with installation.
 */
echo "Installing the PayPal PHP SDK ...\n";

/**
 * Local or remote.
 */
echo "Do you want to install the SDK on a remote FTP server (y or n)? ";
$remote = strtolower(substr(trim(fgets(STDIN)), 0, 1));
if ($remote == 'y') {
    install_remote();
} else {
    /**
     * Install web files.
     */
    echo "Where would you like the PayPal web samples installed? ";
    $php_web_dir = strip_slash(trim(fgets(STDIN)));
    if (!is_dir($php_web_dir)) {
        // Create if it does not exist.
        echo "Creating $php_web_dir...\n";
        mkdir($php_web_dir, 0755);
    }
    echo "Installing web samples to $php_web_dir\n";
    install_web($php_web_dir);
}

echo "\n\nInstallation Complete!\n\n";
exit(0);

/**
 * Utility functions below
 */
function error_message($msg)
{
    echo "INSTALLATION ERROR:\n$msg\n";
}

function strip_slash($path)
{
    if (strrpos($path, '/') === strlen($path) - 1) {
        $path = substr($path, 0, strlen($path) - 1);
    }
    return $path;
}

function inSdkDir()
{
    $sdk_dir = dirname(__FILE__);
    if (strpos($sdk_dir, 'php-sdk') === strlen($sdk_dir) - strlen('php-sdk')) {
        return true;
    } else {
        return false;
    }
}

function validate_php_env($required_extensions)
{
    // Exit-code style - empty string == succeeded.
    $result = '';

    $php_ext = get_loaded_extensions();
    foreach ($required_extensions as $ext) {
        if (!in_array($ext, $php_ext)) {
            $result .= " $ext";
        }
    }

    return trim($result);
}

function generate_ini_set($sdk_dir, $phpfile, $libdir = 'lib')
{
    $include_path = get_include_path();
    if (!stristr($sdk_dir, $include_path)) {
        if (!($fp = fopen($phpfile, 'w'))) {
            error_message("Unable to generate $phpfile");
            return false;
        }

        $stamp = date('m/d/Y H:i:s');
        $code = "<?php\n" .
            "//*******************************************\n" .
            "// AUTO-GENERATED include for PayPal PHP SDK\n" .
            "// Created by install.php on $stamp\n" .
            "//*******************************************\n\n" .
            "set_include_path('$sdk_dir' . DIRECTORY_SEPARATOR . '" . $libdir . "' . PATH_SEPARATOR . get_include_path());\n";

        fwrite($fp, $code);
        fclose($fp);
    }
    return true;
}

function install_web($to_dir)
{
    $to_dir .= '/paypal_php_samples';
    copydir_r('./samples/php', $to_dir, 0755);
    generate_ini_set(dirname(__FILE__), $to_dir . '/ppsdk_include_path.inc');
}

/**
 * Copies everything from directory $fromDir to directory $toDir and
 * sets up files mode $chmod
 */
function copydir_r($fromDir, $toDir, $chmod = 0757)
{
    // Check for some errors
    $errors = array();
    $messages = array();
    if (!is_dir($toDir)) {
        mkdir($toDir, $chmod);
    }
    if (!is_dir($fromDir)) {
        $errors[] = 'source ' . $fromDir . ' is not a directory';
    }
    if (!empty($errors)) {
        return false;
    }

    // Processing.
    $exceptions = array('.', '..', '.svn');
    $handle = opendir($fromDir);
    while (false !== ($item = readdir($handle)))
        if (!in_array($item, $exceptions)) {
            // Cleanup for trailing slashes in directories
            // destinations.
            $from = str_replace('//', '/', $fromDir . '/' . $item);
            $to = str_replace('//', '/', $toDir . '/' . $item);

            if (is_file($from)) {
                if (@copy($from, $to)) {
                    chmod($to, $chmod);
                    touch($to,filemtime($from)); // to track last modified time
                    $messages[] = 'File copied from '.$from.' to '.$to;
                } else
                    $errors[] = 'cannot copy file from ' . $from.' to '.$to;
            }
            if (is_dir($from)) {
                if (@mkdir($to)) {
                    chmod($to, $chmod);
                    $messages[] = 'Directory created: '.$to;
                } else
                    $errors[] = 'cannot create directory '.$to;
                copydir_r($from, $to, $chmod);
            }
        }

    closedir($handle);
    return true;
}

/**
 * Do the install to a remote FTP server.
 */
function install_remote()
{
    echo "\nProceeding with remote installation.\n\n";

    // validate_php_env returns a string on error, empty string on
    // success, so be careful with logic.
    if (validate_php_env(array('ftp')) &&
        validate_php_env(array('sockets'))) {
        error_message('You must have either FTP or Sockets support in PHP to use the remote installer.');
        exit(1);
    }

    echo "Enter the FTP server to install on: ";
    $host = trim(fgets(STDIN));
    echo "Username for FTP: ";
    $user = trim(fgets(STDIN));
    echo "Password for FTP: ";
    $pass = trim(fgets(STDIN));
    echo "Please enter the path (relative to your FTP root) for the paypal-php-sdk directory: ";
    $installdir = trim(fgets(STDIN));
    echo "Please enter the path (relative to your FTP root) for the paypal-sdk-samples directory: ";
    $sampledir = trim(fgets(STDIN));

    $ftp = ftp_connect($host);
    if (!is_resource($ftp)) {
        error_message('Unable to connect to FTP server: ' . $host);
        exit(1);
    }

    if (!ftp_login($ftp, $user, $pass)) {
        error_message('Unable to authenticate to FTP server as ' . $user);
        exit(1);
    }

    // Install the libraries.
    echo "\nInstalling SDK libraries...\n";
    if (!@ftp_chdir($ftp, $installdir)) {
        if (!ftp_mkdir($ftp, $installdir)) {
            error_message('Libraries install directory does not exist and I can\'t create it.');
            exit(1);
        }
        ftp_chdir($ftp, $installdir);
    }
    if (!@ftp_chdir($ftp, 'paypal-php-sdk')) {
        if (!ftp_mkdir($ftp, 'paypal-php-sdk')) {
            error_message('Unable to create libraries directory.');
            exit(1);
        }
        ftp_chdir($ftp, 'paypal-php-sdk');
    }
    ftp_r($ftp, '.');
    ftp_cdup($ftp);

    // Install the samples.
    echo "Installing SDK samples...\n";
    if (!@ftp_chdir($ftp, $sampledir)) {
        if (!ftp_mkdir($ftp, $sampledir)) {
            error_message('Samples install directory does not exist and I can\'t create it.');
            exit(1);
        }
        ftp_chdir($ftp, $sampledir);
    }
    if (!@ftp_chdir($ftp, 'paypal-sdk-samples')) {
        if (!ftp_mkdir($ftp, 'paypal-sdk-samples')) {
            error_message('Unable to create samples directory.');
            exit(1);
        }
        ftp_chdir($ftp, 'paypal-sdk-samples');
    }
    ftp_r($ftp, 'samples/php');

    // Generate and upload the ppsdk_include_path file.
    generate_ini_set($installdir, './ppsdk_include_path.inc', "paypal-php-sdk' . DIRECTORY_SEPARATOR . 'lib");
    ftp_put($ftp, 'ppsdk_include_path.inc', './ppsdk_include_path.inc', FTP_ASCII);
    unlink('./ppsdk_include_path.inc');

    ftp_close($ftp);
}

/**
 * Recursively upload a directory via FTP.
 *
 * @param resource &$ftp The FTP resource to use.
 * @param string $dir The directory to upload.
 */
function ftp_r(&$ftp, $dir)
{
    // Processing.
    $exceptions = array('.', '..', '.svn');
    $handle = opendir($dir);
    while (false !== ($item = readdir($handle))) {
        if (!in_array($item, $exceptions)) {
            // Cleanup for trailing slashes in directories
            // destinations.
            $full = str_replace('//', '/', $dir . '/' . $item);
            if (is_file($full)) {
                ftp_put($ftp, $item, $full, FTP_ASCII);
            } elseif (is_dir($full)) {
                if (!@ftp_chdir($ftp, $item)) {
                    ftp_mkdir($ftp, $item);
                    ftp_chdir($ftp, $item);
                }
                ftp_r($ftp, $full);
                ftp_cdup($ftp);
            }
        }
    }

    closedir($handle);
}

// Socket
if (!function_exists('ftp_connect')) {
/**
 * Net_FTP socket implementation of FTP functions.
 *
 * The functions in this file emulate the ext/FTP functions through
 * ext/Socket.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Networking
 * @package    FTP
 * @author     Tobias Schlitt <toby@php.net>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id: Socket.php,v 1.4 2005/02/23 12:12:23 toby Exp $
 * @link       http://pear.php.net/package/Net_FTP
 * @since      File available since Release 0.0.1
 */

/**
* Default FTP extension constants
*/
define('FTP_ASCII', 0);
define('FTP_TEXT', 0);
define('FTP_BINARY', 1);
define('FTP_IMAGE', 1);
define('FTP_TIMEOUT_SEC', 0);

/**
* &resource ftp_connect ( string host [, int port [, int timeout ] ] );
*
* Opens an FTP connection and return resource or false on failure.
*
* TODO:
*       The FTP extension has ftp_get_option() function which returns the
* timeout variable. This function needs to be created and contain it as
* static variable.
*
* TODO:
*       The FTP extension has ftp_set_option() function which sets the
*       timeout variable. This function needs to be created and called here.
*
* FTP Success respons code: 220
*
* @param    string  $host   ( Host to connect to )
* @param    int     $port   ( Optional, port to connect to )
* @param    int     $timeout( Optional, seconds until function timeouts )
* @return   &resource
*/
function &ftp_connect($host, $port = 21, $timeout = 90)
{
    $false = false; // We are going to return refrence (E_STRICT)

    if (!is_string($host) || !is_integer($port) || !is_integer($timeout)) {
        return $false;
    }

    $control = @fsockopen($host, $port, $iError, $sError, $timeout);
    $GLOBALS['_NET_FTP']['timeout'] = $timeout;

    if (!is_resource($control)) {
        return $false;
    }

    stream_set_blocking($control, TRUE);
    stream_set_timeout($control, $timeout);

    do {
        $content[] = fgets($control, 8129);
        $array = socket_get_status($control);
    }
    while ($array['unread_bytes'] > 0);

    if (substr($content[count($content)-1], 0, 3) == 220) {
        return $control;
    }

    return $false;
}

/**
* boolean ftp_login ( resource stream, string username, string password );
*
* Logs in to an given FTP connection stream.
* Returns TRUE on success or FALSE on failure.
*
* NOTE:
*       Username and password are *not* optional. Function will *not*
*       assume "anonymous" if username and/or password is empty
*
* FTP Success respons code: 230
*
* @param    resource    $stream   ( FTP resource to login to )
* @param    string      $username ( FTP Username to be used )
* @param    string      $password ( FTP Password to be used )
* @return   boolean
*/
function ftp_login(&$control, $username, $password)
{
    if (!is_resource($control) || is_null($username)) {
        return false;
    }

    fputs($control, 'USER '.$username."\r\n");
    $contents = array();
    do {
        $contents[] = fgets($control, 8192);
        $array = socket_get_status($control);
    } while ($array['unread_bytes'] > 0);

    if (substr($contents[count($contents)-1], 0, 3) != 331) {
        return false;
    }

    fputs($control, 'PASS '.$password."\r\n");
    $contents = array();
    do {
        $contents[] = fgets($control, 8192);
        $array = socket_get_status($control);
    } while ($array['unread_bytes']);

    if (substr($contents[count($contents)-1], 0, 3) == 230) {
        return true;
    }

    trigger_error('ftp_login() [<a
            href="function.ftp-login">function.ftp-login</a>]: '
.$contents[count($contents)-1], E_USER_WARNING);

    return false;
}

/**
* boolean ftp_close ( resource stream );
*
* Closes FTP connection.
* Returns TRUE or FALSE on error.
*
* NOTE:
*       resource is set to NULL since unset() can't unset the variable.
*
* @param    integer     $stream   ( FTP resource )
* @return   boolean
*/
function ftp_close(&$control)
{
    if (!is_resource($control)) {
        return false;
    }

    fputs($control, 'QUIT'."\r\n");
    fclose($control);
    $control = NULL;
    return TRUE;
}

/**
* boolean ftp_chdir ( resource stream, string directory );
*
* Changes the current directory to the specified directory.
* Returns TRUE on success or FALSE on failure.
*
* FTP success respons code: 250
* Needs data connection: NO
*
* @param    integer     $stream     ( FTP stream )
* @param    string      $pwd        ( Directory name )
* @return   boolean
*/
function ftp_chdir(&$control, $pwd)
{
    if (!is_resource($control) || !is_string($pwd)) {
        return false;
    }

    fputs($control, 'CWD '.$pwd."\r\n");
    $content = array();
    do {
        $content[] = fgets($control, 8192);
        $array = socket_get_status($control);
    } while ($array['unread_bytes'] > 0);

    if (substr($content[count($content)-1], 0, 3) == 250) {
        return true;
    }

    trigger_error ('ftp_chdir() [<a
            href="function.ftp-chdir">function.ftp-chdir</a>]:
                ' .$content[count($content)-1], E_USER_WARNING);

    return false;
}

/**
* boolean ftp_mkdir ( resource stream, string directory );
*
* Changes the current directory to the specified directory.
* Returns TRUE on success or FALSE on failure.
*
* FTP success respons code: 250
* Needs data connection: NO
*
* @param    integer     $stream     ( FTP stream )
* @param    string      $dir        ( Directory name )
* @return   boolean
*/
function ftp_mkdir(&$control, $dir)
{
    if (!is_resource($control) || !is_string($dir)) {
        return false;
    }

    fputs($control, 'MKD '.$dir."\r\n");
    $content = array();
    do {
        $content[] = fgets($control, 8192);
        $array = socket_get_status($control);
    } while ($array['unread_bytes'] > 0);

    $result_code = substr($content[count($content)-1], 0, 3);
    if ($result_code >= 200 && $result_code < 300) {
        return true;
    }

    trigger_error ('ftp_mkdir() [<a
            href="function.ftp-mkdir">function.ftp-mkdir</a>]:
                ' .$content[count($content)-1], E_USER_WARNING);

    return false;
}

/**
* boolean ftp_pasv ( resource stream, boolean passive );
*
* Toggles passive mode ON/OFF.
* Returns TRUE on success or FALSE on failure.
*
* Comment:
*       Althou my lack of C knowlage I checked how the PHP FTP extension
*       do things here. Seems like they create the data connection and store
*       it in object for other functions to use.
*       This is now done here.
*
* FTP success respons code: 227
*
* @param   stream  $control  ( FTP stream )
* @return  boolean
*/
$_NET_FTP = array();
$_NET_FTP['USE_PASSIVE'] = false;
$_NET_FTP['DATA'] = null;

function ftp_pasv(&$control, $pasv)
{
    if (!is_resource($control) || !is_bool($pasv)) {
        return false;
    }

    // If data connection exists, destroy it
    if (isset($GLOBALS['_NET_FTP']['DATA'])) {
        fclose($GLOBALS['_NET_FTP']['DATA']);
        $GLOBALS['_NET_FTP']['DATA'] = null;

        do {
            fgets($control, 16);
            $array = socket_get_status($control);
        } while ($array['unread_bytes'] > 0);
    }

    // Are we suppost to create active or passive connection?
    if (!$pasv) {
        $GLOBALS['_NET_FTP']['USE_PASSIVE'] = false;
        # Pick random "low bit"
        $low = rand(39, 250);
        # Pick random "high bit"
        $high = rand(39, 250);
        # Lowest  possible port would be; 10023
        # Highest possible port would be; 64246

        $port = ($low<<8)+$high;
        $ip = str_replace('.', ',', $_SERVER['SERVER_ADDR']);
        $s = $ip.','.$low.','.$high;

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (is_resource($socket)) {
            if (socket_bind($socket, '0.0.0.0', $port)) {
                if (socket_listen($socket)) {
                    $GLOBALS['_NET_FTP']['DATA'] = &$socket;
                    fputs($control, 'PORT '.$s."\r\n");
                    $line = fgets($control, 512);
                    if (substr($line, 0, 3) == 200) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    # Since we are here, we are suppost to create passive data connection.
    $i = fputs($control, 'PASV' ."\r\n");

    $content = array();
    do {
        $content[] = fgets($control, 128);
        $array = socket_get_status($control);
    } while ($array['unread_bytes']);

    if (substr($cont=$content[count($content)-1], 0, 3) != 227) {
        return false;
    }

    $pos    = strpos($cont, '(')+1;
    $pos2   = strrpos($cont, ')')-$pos;
    $string = substr($cont, $pos, $pos2);

    $array = split(',', $string);
    # IP we are connecting to
    $ip = $array[0]. '.' .$array[1]. '.' .$array[2]. '.' .$array[3];
    # Port ( 256*lowbit + highbit
    $port = ($array[4] << 8)+$array[5];

    # Our data connection
    $data = fsockopen($ip, $port, $iError, $sError,
        $GLOBALS['_NET_FTP']['timeout']);

    if (is_resource($data)) {
        $GLOBALS['_NET_FTP']['USE_PASSIVE'] = true;
        $GLOBALS['_NET_FTP']['DATA'] = &$data;
        stream_set_blocking($data, true);
        stream_set_timeout($data, $GLOBALS['_NET_FTP']['timeout']);

        return true;
    }

    return false;
}

/**
* bool ftp_put ( resource stream, string remote_file, string local_file,
*               int mode [, int startpos ] );
*
* Uploads a file to the FTP server
* Returns TRUE on success or FALSE on failure.
*
* NOTE:
*       The transfer mode specified must be either FTP_ASCII or FTP_BINARY.
*
* @param    resource    $stream     ( FTP stream )
* @param    string      $remote     ( Remote file to write )
* @param    string      $local      ( Local file to upload )
* @param    integer     $mode       ( Upload mode, FTP_ASCI || FTP_BINARY )
* @param    integer     $pos        ( Optional, start upload at position )
* @return   boolean
*/
function ftp_put(&$control, $remote, $local, $mode, $pos = 0) {
    if (!is_resource($control) || !is_readable($local) ||
            !is_integer($mode) || !is_integer($pos)) {
        return false;
    }

    $types = array (
        0 => 'A',
        1 => 'I'
    );
    $windows = array (
        0 => 't',
        1 => 'b'
    );

    /**
    * TYPE values:
    *       A ( ASCII  )
    *       I ( BINARY )
    *       E ( EBCDIC )
    *       L ( BYTE   )
    */

    if (!isset($GLOBALS['_NET_FTP']['DATA']) ||
            !is_resource($GLOBALS['_NET_FTP']['DATA'])) {
        ftp_pasv($control, $GLOBALS['_NET_FTP']['USE_PASSIVE']);

    }
    // Establish data connection variable
    $data = &$GLOBALS['_NET_FTP']['DATA'];

    // Decide TYPE to use
    fputs($control, 'TYPE '.$types[$mode]."\r\n");
    $line = fgets($control, 256); // "Type set to TYPE"
    if (substr($line, 0, 3) != 200) {
        return false;
    }

    fputs($control, 'STOR '.$remote."\r\n");
    sleep(1);
    $line = fgets($control, 256); // "Opening TYPE mode data connect."

    if (substr($line, 0, 3) != 150) {
        return false;
    }

    // Creating resource to $local file
    $fp = fopen($local, 'r'. $windows[$mode]);
    if (!is_resource($fp)) {
        $fp = NULL;
        return false;
    }

    // Loop throu that file and echo it to the data socket
    $i = 0;
    switch ($GLOBALS['_NET_FTP']['USE_PASSIVE']) {
        case false:
            $data = &socket_accept($data);
            while (!feof($fp)) {
                $i += socket_write($data, fread($fp, 10240), 10240);
            }
            socket_close($data);
            break;

        case true:
            while (!feof($fp)) {
                $i += fputs($data, fread($fp, 10240), 10240);
            }

            fclose($data);
        break;
    }

    $data = NULL;
    do {
        $line = fgets($control, 256);
    } while (substr($line, 0, 4) != "226 ");
    return true;
}
}
