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

    /*
    * Some usefull tools
    * utils.php Version 2.0
    */
    class utils extends Date_Calc
    {
        var $PDF;
        var $alert_text;
        var $alert_now;
        /*
        * Constructor of the class
        */
        function utils()
        {
            $this->alpencrypt = new alpencrypt();
        }
        function extractIps($str1) {
            $return_array = array ();
            $num = "(25[0-5]|2[0-4]\d|[01]?\d\d|\d)";
            preg_match_all("/$num\\.$num\\.$num\\.$num\-$num/", $str1, $match0);
            preg_match_all("/$num\\.$num\\.$num\\.$num/", $str1, $match1);
            if(count($match0[0]))
            {
                foreach($match0[0] as $k=>$v)
                {
                    for($i=$match0[4][$k];$i<=$match0[5][$k];$i++)
                    {
                        $match1[0][] = $match0[1][$k].'.'.$match0[2][$k].'.'.$match0[3][$k].'.'.$i;
                    }
                }
            }
            $return_array = $this->Get_Trimmed_Array($match1[0]);
            return $return_array;
        }
        /*
        * Parse Google currency
        */
        function parse_google_currency($to, $from)
        {
            $output   = "";
            $output1  = "";
            $regex    = "<b\b[^>]*>(.*?)</b>";
            $return   = file('http://www.google.com/search?hl=en&lr=&q=1+' . $from . '+in+' . $to . '&btnG=Search');
            while (list (, $line)= each($return))
            {
                /*
                * preg_match('/[A-Za-z.].*[ ][=][ ][0-9]+[.][0-9]{0,2}/', $line, $output);
                */
                preg_match('/[A-Za-z0-9.\s]+[ ][=][ ][0-9]+[.][0-9]+/', $line, $output);
                if (!empty ($output[0]))
                {
                    preg_match('/[0-9]+[.][0-9]{0,2}/', $output[0], $output1);
                    if (!empty ($output1[0]))
                        return $output1[0];
                }
            }
            return 0;
        }
        /*
        * Monitor Server
        */
        function checkit($link, $port)
        {
            $errno    = "";
            $errstr   = "";
            $packs    = 5;
            $nError   = 0;
            $rturn    = "online";
            $l        = $this->removetrailingslash($link);
            for ($a = 0; $a <= $packs; $a++)
            {
                $url  = @ fsockopen($l, $port, $errno, $errstr, 5);
                if (!$url)
                {
                    $rturn  = "offline";
                    break;
                }
                @ fclose($url);
            }
            return $rturn;
        }
        /*
        * Remove trailing slash
        */
        function removetrailingslash($link)
        {
            if(substr($link,-1)=="/")
            {
                $link = substr($link, 0, strlen($link)-1);
            }
            return $link;
        }
        /*
        * Generate random no image
        */
        function rndImage($number= "")
        {
            $img_number   = imagecreate(150, 30);
            $white        = imagecolorallocate($img_number, 255, 255, 255);
            $black        = imagecolorallocate($img_number, 0, 0, 0);
            $grey_shade1  = imagecolorallocate($img_number, 254, 254, 254);
            $grey_shade2  = imagecolorallocate($img_number, 224, 224, 224);
            $font         = 5;
            //margin
            imagefill($img_number, 0, 0, $grey_shade1);
            //horizontal lines
            $j = 0;
            for ($i = 0; $i < 6; $i++)
            {
                $j = $j +5;
                imageline($img_number, 0, $j, 150, $j, $grey_shade2);
            }
            //vertical lines
            $j = 0;
            for ($i = 0; $i < 30; $i++)
            {
                $j = $j +5;
                imageline($img_number, $j, 0, $j, 30, $grey_shade2);
            }
            imagerectangle($img_number, 0, 0, 149, 29, $black);
            //generate number
            $st_pos = 0;
            if ($number == "")
            {
                $number = $this->random_password(8);
            }
            for ($i= 0; $i < 8; $i++)
            {
                $st_pos  = $st_pos +16;
                $c       = rand(1, 3);
                if ($c == 1)
                {
                    $rnd_color = imagecolorallocate($img_number, rand(200, 255), 0, 0);
                }
                elseif ($c == 2)
                {
                    $rnd_color = imagecolorallocate($img_number, 0, rand(150, 200), 0);
                }
                elseif ($c == 3)
                {
                    $rnd_color = imagecolorallocate($img_number, 0, 0, rand(200, 255));
                }
                imagestring($img_number, $font, $st_pos, rand(0, 5), $number { $i }, $rnd_color);
                //imagettftext($img_number, 20, rand(-45,45), $st_pos, rand(23, 26), $rnd_color, "arial.ttf",$number { $i });
            }
            header("Content-type: image/jpeg");
            imagejpeg($img_number);
            return $number;
        }
        /*
        * split ips to array
        */
        function splitIParray($ip)
        {
            $new_ip     = array();
            $temp       = $this->Get_Trimmed_Array(explode("-",$ip,2));
            $new_ip[0]  = 0;
            $new_ip[1]  = 0;
            $new_ip[2]  = 0;
            $new_ip[3]  = 0;
            $new_ip[4]  = 0;
            if(count($temp)>1)
            {
                $new_ip[4]=trim($temp[1]);
            }
            $temp1      = $this->Get_Trimmed_Array(explode(".",$temp[0]),4);
            $new_ip[0]  = $temp1[0];
            $new_ip[1]  = $temp1[1];
            $new_ip[2]  = $temp1[2];
            $new_ip[3]  = $temp1[3];
            return $new_ip;
        }
        /*
        * clean tag
        */
        function clnTag($tag, $replace, $str)
        {
            $search  = array ("@<" . $tag . "[^>]*?>.*?</" . $tag . ">@si");
            $replace = array ($replace);
            $return  = preg_replace($search, $replace, $str);
            return str_replace('</'.$tag, '',$return);
        }
        /*
        * get the string inside a tag
        */
        function strInTag($tag, $str, $id=0)
        {
            if(empty($id))
            {
                $s1 = stristr($str, "<".$tag.">");
                $s2 = stristr($str, "</".$tag.">");
                $l  = strlen($s1) - strlen($s2);
                return substr($s1, strlen("<".$tag.">"), $l);
            }
            $match1 = array();
            $match2 = array();
            $match3 = array();
            preg_match_all("/\<".$tag."\>(.*?)\<\/".$tag."\>/", $str, $match1);
            foreach($match1 as $i=>$t)
            {
                foreach($match1[$i] as $m)
                {
                    $m          = strip_tags($m);
                    $m          = trim($m);
                    $match3[]   = $m;
                }
            }
            $match4 = $this->Get_Uniques_Array($match3);
            $this->Remove_Empty_Elements($match4);
            return (is_numeric($id))?$match4[$id]:$match4;
        }
        function matheval($equation)
        {
            $equation = $this->htmlspecialchars_decode($equation);
            $equation = preg_replace("/[^0-9+\-.*\/()%]/","",$equation);
            $equation = preg_replace("/([+-])([0-9]+)(%)/","*(1\$1.\$2)",$equation);
            $equation = preg_replace("/([0-9]+)(%)/",".\$1",$equation);
            if ($equation == "")
            {
                $return = 0;
            } else
            {
                eval("\$return=" . $equation . ";");
            }
            return $return;
        }
        function eval_html($string)
        {
            $string = preg_replace_callback("/(<\?=)(.*?)\?>/si"         , "eval_print_buffer"   ,$string);
            $return = preg_replace_callback("/(<\?php|<\?)(.*?)\?>/si"   , "eval_buffer"         ,$string);
            eval("\$return=" . $return . ";");
            return $return;
        }
        /*
        * Replace urls with links
        */
        function url2link($text)
        {
            return preg_replace("|[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]|", "<a href=\"\\0\">\\0</a>", $text);
        }
        /*
        * Alert
        */
        function alert($str, $simple= false, $nl2br= true, $PDF=false)
        {
            $this->PDF = $PDF;
            if ($simple == true)
            {
                echo "<script language=\"javascript\">alert('" . $str . "');</script>";
            }
            else
            {
                if ($nl2br)
                {
                    $this->alert_text = nl2br($str);
                }
                else
                {
                    $this->alert_text = $str;
                }
                $this->alert_now= true;
            }
        }
        /*
        * Function print date picker
        */
        function datePicker($d, $m, $y, $class, $postfix= "")
        {
            $date = "<select name=\"date_field" . $postfix . "\" class=\"" . $class . "\">";
            for ($i= 1; $i < 32; $i++)
            {
                if ($i == $d)
                    $date .= "<option value=\"" . $i . "\" selected=\"selected\">" . $i . "</option>";
                else
                    $date .= "<option value=\"" . $i . "\">" . $i . "</option>";
            }
            $date .= "</select>";
            $month= "<select name=\"month_field" . $postfix . "\" class=\"" . $class . "\">";
            for ($i= 1; $i < 13; $i++)
            {
                if ($i == $m)
                    $month .= "<option value=\"" . $i . "\" selected=\"selected\">" . $i . "</option>";
                else
                    $month .= "<option value=\"" . $i . "\">" . $i . "</option>";
            }
            $month .= "</select>";
            $month .= "</select>";
            $year= "<select name=\"year_field" . $postfix . "\" class=\"" . $class . "\">";
            for ($i= 1970; $i < date('Y') + 30; $i++)
            {
                if ($i == $y)
                {
                    $year .= "<option value=\"" . $i . "\" selected=\"selected\">" . $i . "</option>";
                }
                else
                {
                    $year .= "<option value=\"" . $i . "\">" . $i . "</option>";
                }
            }
            $year .= "</select>";
            return $date . "-" . $month . "-" . $year;
        }
        function Get_Uniques_Array($Old_Array)
        {
            $New_Array= Array ();
            foreach ($Old_Array As $Element)
            {
                if (!in_array($Element, $New_Array))
                {
                    $New_Array[]= $Element;
                }
            }
            return $New_Array;
        }
        function Get_Trimmed_Array($Array)
        {
            foreach ($Array As $Key => $Value)
            {
                $Key= trim($Key);
                if (!is_array($Value))
                {
                    $Value= trim($Value);
                }
                $Array[$Key]= $Value;
            }
            return $Array;
        }
        function Remove_Empty_Elements(& $array)
        {
            $t = array();
            foreach($this->Get_Trimmed_Array($array) as $k=>$v)
            {
                if($v!='' || $v!=null)
                {
                    $t[$k] = $v;
                }
            }
            $array = array();
            $array = $t;
        }
        /*
        * Array To Str
        */
        function arrayToString($array)
        {
            $str = "";
            foreach ($array as $k => $v)
            {
                if (!is_array($v))
                {
                    $str .= $k . "=" . $v . "<br>";
                }
                else
                {
                    $str .= $this->arrayToString($v);
                }
            }
            return $str;
        }
        /*
        * Returns only the string from a html code
        */
        function onlyStr($str)
        {
            $text = preg_replace("|<br>|i", "||", $str);
            $text = preg_replace('|(<[^>]+>([^<]+<\/[^>]+>)?)|', ' ', $text);
            $text = str_replace(";", "", $text);
            $text = str_replace("\r", "", $text);
            $text = str_replace("||", "\n", $text);
            return $this->quoteSmart($text);
        }
        /*
        * Random password generator
        */
        function random_password($length= "8")
        {
            srand((double) microtime() * 1000000);
            $vowels= array (
                "a",
                "e",
                "u",
                "2",
                "3",
                "4",
                "6",
                "7",
                "8",
                "9"
            );
            $cons= array (
                "B",
                "C",
                "D",
                "G",
                "H",
                "J",
                "K",
                "M",
                "N",
                "P",
                "R",
                "T",
                "U",
                "V",
                "W",
                "TR",
                "CR",
                "BR",
                "FR",
                "TH",
                "DR",
                "CH",
                "PH",
                "WR",
                "PT",
                "TP",
                "FW",
                "PR",
                "PL",
                "CL",
                "b",
                "c",
                "d",
                "g",
                "h",
                "j",
                "k",
                "m",
                "n",
                "p",
                "r",
                "p",
                "t",
                "u",
                "v",
                "w",
                "tr",
                "cr",
                "br",
                "fr",
                "th",
                "dr",
                "ch",
                "ph",
                "wr",
                "jt",
                "yp",
                "aw",
                "pr"
            );
            $num_vowels   = count($vowels);
            $num_cons     = count($cons);
            $passwd       = "";
            for ($i= 0; $i < $length; $i++)
            {
                $passwd .= $cons[rand(0, $num_cons -1)] . $vowels[rand(0, $num_vowels -1)];
            }
            return substr($passwd, 0, $length);
        }
        /*
        * Get the directory listing
        */
        function dirlist($path, $type= "", $ext= "")
        {
            $path       = realpath($path);
            if ($handle = opendir($path))
            {
                $i = 0;
                $f = array ();
                $e = array ();
                while (false !== ($file= readdir($handle)))
                {
                    if (strlen($file) > 2)
                    {
                        $temp = explode('.', $file);
                        if (empty ($ext) or $temp[count($temp)-1] == $ext)
                        {
                            $f[$i] = !empty ($temp[0])
                            ?str_replace(".".$ext,"",$file)
                            :"";
                            $e[$i] = !empty ($temp[count($temp)-1])
                            ?$temp[count($temp)-1]
                            :"";
                        }
                    }
                    $i++;
                }
                closedir($handle);
                $files['name'] = $f;
                $files['ext']  = $e;
                if ($type != "")
                {
                    return $files[$type];
                }
                return $files;
            }
            return null;
        }
        /*
        * Check date format
        */
        function checkDateFormat($dt)
        {
            if (strtotime($dt))
            {
                return true;
            }
            return false;
        }
        /*
        * Check for a valid subdomain name
        */
        function chksubDomainFormat($domain)
        {
            if (preg_match("/^[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+\.[a-zA-Z0-9.]{2,10}$/i", $domain))
            {
                return true;
            }
            return false;
        }
        /*
        * Check for a valid domain name
        */
        function chkDomainFormat($domain)
        {
            if (preg_match("/^[a-zA-Z0-9-]+\.[a-zA-Z0-9.]{2,10}$/i", $domain))
            {
                return true;
            }
            return false;
        }
        /*
        * Check for a valid user name password
        */
        function chkUserFormat($str)
        {
            if (preg_match("/^[a-zA-Z0-9~!@#$%^&*()_+-=]{0,255}$/i", $str))
            {
                return true;
            }
            return false;
        }
        /*
        * Check for a valid email address
        */
        function chkEmailFormat($email)
        {
            if (preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,10})$/i", $email))
            {
                return true;
            }
            return false;
        }
        /*
        * Function to escape SQL strings
        */
        function quoteSmart($str, $html= true)
        {
            if ($html= true)
            {
                $str= get_magic_quotes_gpc()?stripslashes(trim($str)):trim($str);
                $str= $this->htmlspecialchars_decode($str);
            }
            else
            {
                $str= get_magic_quotes_gpc()?stripslashes(trim($str)):trim($str);
                $str= HTMLSpecialChars($str);
            }
            if (version_compare(phpversion(), "4.3.0") == "-1")
            {
                return mysql_escape_string(trim($str));
            }
            else
            {
                return mysql_real_escape_string(trim($str));
            }
        }
        function htmlspecialchars_decode($str)
        {
            if (!function_exists('htmlspecialchars_decode'))
            {
                return strtr($str, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
            }
            else
            {
                return htmlspecialchars_decode($str);
            }
        }
        function entity_decode($html)
        {
            //supports the most used entity codes
            $html = str_replace("&nbsp;"," ",$html);
            $html = str_replace("&amp;","&",$html);
            $html = str_replace("&lt;","<",$html);
            $html = str_replace("&gt;",">",$html);
            $html = str_replace("&laquo;","?",$html);
            $html = str_replace("&raquo;","?",$html);
            $html = str_replace("&para;","?",$html);
            $html = str_replace("&euro;","?",$html);
            $html = str_replace("&trade;","?",$html);
            $html = str_replace("&copy;","?",$html);
            $html = str_replace("&reg;","?",$html);
            $html = str_replace("&plusmn;","?",$html);
            $html = str_replace("&tilde;","~",$html);
            $html = str_replace("&circ;","^",$html);
            $html = str_replace("&quot;",'"',$html);
            $html = str_replace("&permil;","?",$html);
            $html = str_replace("&Dagger;","?",$html);
            $html = str_replace("&dagger;","?",$html);
            return $html;
        }
        /*
        * Date
        */
        function toDate($d, $format= 'Y-m-d')
        {
            if (strtotime($d) === false || strtotime($d) === -1)
                return $d;
            return date($format, strtotime($d));
        }
        /*
        * Floating
        */
        function toFloat($number)
        {
            if(is_float($number))return $number;
            return sprintf("%f", floatval($number));
        }
        /*
        * Integer
        */
        function toInteger($number)
        {
            return intval(sprintf("%d", intval($number)));
        }
        /*
        * Currency format
        */
        function toCurrency($number, $curr= array (), $with_symbol= 1)
        {
            if (!isset ($curr['symbol_prefixed']))
                $curr['symbol_prefixed']= 1;
            if (!isset ($curr['symbol']))
                $curr['symbol']= '$';
            if (!isset ($curr['decimals']))
                $curr['decimals']= 2;
            if (!isset ($curr['str1']))
                $curr['str1']= '.';
            if (!isset ($curr['str2']))
                $curr['str2']= ',';
            if (empty ($with_symbol))
                return number_format($number, $curr['decimals'], $curr['str1'], $curr['str2']);
            elseif (!empty ($curr['symbol_prefixed'])) return $curr['symbol'] . " " . number_format($number, $curr['decimals'], $curr['str1'], $curr['str2']);
            else
                return number_format($number, $curr['decimals'], $curr['str1'], $curr['str2']) . " " . $curr['symbol'];
        }
        /*
        * Returns the real IP address of the user
        */
        function realip()
        {
            $ip= FALSE;
            if (!empty ($_SERVER["HTTP_CLIENT_IP"]))
            {
                $ip= $_SERVER["HTTP_CLIENT_IP"];
            }
            if (!empty ($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $ips= explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
                if ($ip)
                {
                    array_unshift($ips, $ip);
                    $ip= FALSE;
                }
                for ($i= 0; $i < count($ips); $i++)
                {
                    if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i]))
                    {
                        if (version_compare(phpversion(), "5.0.0", ">="))
                        {
                            if (ip2long($ips[$i]) != false)
                            {
                                $ip= $ips[$i];
                                break;
                            }
                        }
                        else
                        {
                            if (ip2long($ips[$i]) != -1)
                            {
                                $ip= $ips[$i];
                                break;
                            }
                        }
                    }
                }
            }
            // Return with the found IP or the remote address
            return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
        }
        /*
        * Returns whole-month-count between two dates
        */
        function count_months($start_date, $end_date)
        {
            $start_date_unixtimestamp= strtotime($start_date);
            $start_date_month= date("m", $start_date_unixtimestamp);
            $end_date_unixtimestamp= strtotime($end_date);
            $end_date_month= date("m", $end_date_unixtimestamp);
            $calculated_date_unixtimestamp= $start_date_unixtimestamp;
            $counter= 0;
            while ($calculated_date_unixtimestamp < $end_date_unixtimestamp)
            {
                $counter++;
                $calculated_date_unixtimestamp= strtotime($start_date . " +{$counter} months");
            }
            return $counter;
        }
        /*
        * Get date after x days
        */
        function getXdayAfter($sbd, $today)
        {
            if (!$sbd)
                return $today;
            $v_today= $today;
            $total_days= cal_days_in_month(CAL_GREGORIAN, $today['mon'], $today['year']);
            //if $sbd is less than remaning days of the month
            if ($sbd <= $total_days - $today['mday'])
            {
                $v_today['mday']= $today['mday'] + $sbd;
            }
            else
            {
                $do= true;
                $v_sbd= $sbd;
                for ($i= 1; $i < ($v_sbd +1); $i++)
                {
                    $v_today['mday']= $v_today['mday'] + 1;
                    $total_days= cal_days_in_month(CAL_GREGORIAN, $v_today['mon'], $v_today['year']);
                    if ($v_today['mday'] > $total_days)
                    {
                        $v_today['mday']= 1;
                        $v_today['mon']= $v_today['mon'] + 1;
                    }
                    if ($v_today['mon'] > 12)
                    {
                        $v_today['mon']= 1;
                        $v_today['year']= $v_today['year'] + 1;
                    }
                }
            }
            return $v_today;
        }
        /*
        * Get date after x months
        */
        function getXmonthsAfter($m, $today)
        {
            $floating_date= $today;
            for ($i= 1; $i <= $m; $i++)
            {
                if ($floating_date['mon'] < 12)
                {
                    $floating_date['mon']= $floating_date['mon'] + 1;
                }
                else
                {
                    $floating_date['mon']= 1;
                    $floating_date['year']= $floating_date['year'] + 1;
                }
            }
            $total_days= cal_days_in_month(CAL_GREGORIAN, $floating_date['mon'], $floating_date['year']);
            if ($total_days < $floating_date['mday'])
                $floating_date['mday']= $total_days;
            return $floating_date;
        }
        /*
        * Get date array
        */
        function getDateArray($date)
        {
            return getdate(strtotime($date));
        }
    }
?>
