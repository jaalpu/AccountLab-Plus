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

    require_once "init.php";
    //GET STATES OF COUNTRY
    if(isset($REQUEST['cc']))
    {
        $STATES= isset($BL->props->allstates[$REQUEST['cc']])?$BL->props->allstates[$REQUEST['cc']]:array();
        $count = 0;
        $str   = "<data><states>";
        foreach($STATES as $k=>$v)
        {
            $state = trim($v);
            if(!empty($state))
            {
                if (is_numeric($k))
                    $str .= "<state>$state</state>";
                else
                    $str .= "<state abbr=\"$k\">$state</state>";
                $count++;
            }
        }
        $str .= "</states>";
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" standalone="yes"?>';
        echo $str;
        echo '<count>'.$count.'</count></data>';
        $BL->Disconnect();
    }
    //GET LICENSED DOMAIN
    if($cmd=="L_DOMAIN")
    {
        echo INSTALL_DOMAIN;
        $BL->Disconnect();
    }
    //GET SERVER STATUS
    if(isset($REQUEST['server_ip']) && isset($REQUEST['port']) && isset($REQUEST['ss']) && $REQUEST['ss']==true)
    {
        echo $BL->utils->checkit($REQUEST['server_ip'],$REQUEST['port']);
    }
    //GET WHOIS ONLINE
    if(isset($REQUEST['whoisonline']) && $REQUEST['whoisonline']=true)
    {
        $Sec = isset($REQUEST['secs'])?$REQUEST['secs']:600;
        $Whoisonline = $BL->whoisonline($Sec);
        if(!count($Whoisonline))
        {
            echo 0;
        }
        else
        {
            echo "|";
            foreach($whoisonline as $v)
            {
                echo "~";
                foreach($v as $key=>$val)
                {
                    echo (empty($val)) ?"N/A"."~":$val."~";
                }
                echo "|";
            }
        }
        $BL->Disconnect();
    }
    //GET LOCATION
    if((isset($REQUEST['country']) && $REQUEST['country']==true) || (isset($REQUEST['state']) && $REQUEST['state']==true) || (isset($REQUEST['ip']) && $REQUEST['ip']==true))
    {
        $remote_ip            = $BL->utils->realip();
        $temp2                = $BL->geoip->getRemoteCountry($remote_ip);
        $remote_country_code  = $temp2[0]['COUNTRY_CODE2'];
        $remote_city          = $temp2[1]['CITY'];
        if($REQUEST['country']==true)
        {
            echo $remote_country_code;
        }
        elseif($REQUEST['state']==true)
        {
            echo $remote_city;
        }
        else
        {
            echo $remote_ip;
        }
        $BL->Disconnect();
    }
    //WHOIS
    if ((isset($REQUEST['whois']) && $REQUEST['whois']==true) && isset ($REQUEST['tld']) && isset ($REQUEST['sld']))
    {
        if (!$BL->utils->chkDomainFormat($REQUEST['sld'].".".$REQUEST['tld']))
        {
            $whois_result = $BL->props->lang['err_domain'];
            if(isset($REQUEST['bool']) && $REQUEST['bool']==1)
            {
                $whois_result = "-1";
            }
            echo $whois_result;
            $BL->Disconnect();
        }
        $wr           = $BL->whois->checkDomain($REQUEST['sld'], $REQUEST['tld']);
        $whois_result = "<b>".$REQUEST['sld'].".".$REQUEST['tld']." ".$BL->props->lang['not_available']."</b>";
        if (!is_numeric($wr))
        {
            $wr = $whois_result;
            if(isset($REQUEST['bool']) && $REQUEST['bool']==1)
            {
                $wr = "-1";
            }
            echo $wr;
            $BL->Disconnect();
        }
        elseif (!$wr)
        {
            $whois_result = "<b>".$REQUEST['sld'].".".$REQUEST['tld']." ".$BL->props->lang['is_available']."</b>";
            if(isset($REQUEST['bool']) && $REQUEST['bool']==1)
            {
                $whois_result  = "1";
            }
            echo $whois_result;
            $BL->Disconnect();
        }
        if(isset($REQUEST['bool']) && $REQUEST['bool']==1)
        {
            $whois_result = "0";
        }
        echo $whois_result;
        $BL->Disconnect();
    }
    //SUBDOMAINS
    if ((isset($REQUEST['subdomain']) && $REQUEST['subdomain']=true) && isset($REQUEST['tld']) && isset ($REQUEST['sld']))
    {
        if (!$BL->utils->chksubDomainFormat($REQUEST['sld'].".".$REQUEST['tld']))
        {
            $whois_result1 = $BL->props->lang['err_subdomain'];
            if(isset($REQUEST['bool']) && $REQUEST['bool']==1)
            {
                $whois_result1 = "-1";
            }
            echo $whois_result1;
            $BL->Disconnect();
        }
        $wr            = $BL->subdomains->isAvailable($REQUEST['sld'], $REQUEST['tld']);
        $whois_result1 = "<b>".$REQUEST['sld'].".".$REQUEST['tld']." ".$BL->props->lang['not_available']."</b>";
        if ($wr)
        {
            $whois_result1 = "<b>".$REQUEST['sld'].".".$REQUEST['tld']." ".$BL->props->lang['is_available']."</b>";
            if(isset($REQUEST['bool']) && $REQUEST['bool']==1)
            {
                $whois_result1 = "1";
            }
            echo $whois_result1;
            $BL->Disconnect();
        }
        if(isset($REQUEST['bool']) && $REQUEST['bool']==1)
        {
            $whois_result1 = "0";
        }
        echo $whois_result1;
        $BL->Disconnect();
    }
    //GET PRINT INVOICE
    if(isset($REQUEST['cmd']) && $REQUEST['cmd']=='PRINT')
    {
        $temp    = $BL->invoices->get("WHERE `invoice_no`=".intval($REQUEST['invoice_no']));
        $invoice = $temp[0];
        if ($REQUEST['invoice_no']>0 && (
            (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $invoice['customer_id'] && $BL->auth->IsSESSION("user"))
            || $BL->auth->IsSESSION("admin")
            || (isset($_SESSION['quickpay']) && $_SESSION['quickpay'] == $REQUEST['invoice_no'] )))
        {
            $html_buffer = $BL->invoices->mailInvoice($REQUEST['invoice_no'],true);
        ?>
        <html>
            <body onload="javascript:window.print();" onfocus="window.close()">
                <?php
                    echo $html_buffer;
                ?>
            </body>
        </html>
        <?php
        }
        else
        {
            echo "OOPS! Your session can not be verified, Please try again.";
        }
        $BL->Disconnect();
    }
    //GET PDF INVOICE
    if(isset($REQUEST['cmd']) && ($REQUEST['cmd']=='PDF' || $REQUEST['cmd']=='VPDF'))
    {
        if(isset($REQUEST['invoice_no']))
        {
            $Invoice  = $BL->invoices->get("WHERE `invoice_no` =".intval($REQUEST['invoice_no']));
            if (isset($Invoice[0]['customer_id']) && (
                (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $Invoice[0]['customer_id'] && $BL->auth->IsSESSION("user"))
                || $BL->auth->IsSESSION("admin")
                || (isset($_SESSION['quickpay']) && $_SESSION['quickpay'] == $REQUEST['invoice_no'])))
            {
                $html_buffer = $BL->invoices->mailInvoice($REQUEST['invoice_no'],true);
                $file_name   = $BL->conf['invoice_prefix'] . $REQUEST['invoice_no'] . $BL->conf['invoice_suffix'].".pdf";
                require_once  LIBRARIES  . "tcpdf_min".PATH_SEP."tcpdf.php";
                $pdf         = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // remove default header/footer
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                $pdf->AddPage();

                // output the HTML content
                $pdf->writeHTML($html_buffer, true, false, true, false, '');

                if ($REQUEST['cmd']=='VPDF')
                {
                    header("Content-type: application/pdf");
                    $pdf->Output($file_name,'I');
                }
                else
                {
                    $pdf->Output($file_name,'D');
                }
            }
        }
        elseif(isset($REQUEST['html']) && $BL->auth->IsSESSION("admin"))
        {
            $html_buffer = urldecode($REQUEST['html']);
            $file_name   = date('H:i_d-M-Y').".pdf";
            require_once  LIBRARIES  . "tcpdf_min".PATH_SEP."tcpdf.php";
            $pdf         = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            $pdf->AddPage();

            // output the HTML content
            $pdf->writeHTML($html_buffer, true, false, true, false, '');

            $pdf->Output($file_name,'D');
        }
        else
        {
            echo "OOPS! Your session can not be verified, Please try again.";
        }
        $BL->Disconnect();
    }
    if(isset($REQUEST['cmd']) && $REQUEST['cmd']=='IV')
    {
        $verify_code = $BL->utils->random_password();
        $BL->utils->rndImage($verify_code);
        $_SESSION['captcha_key'] = md5($verify_code);
        $BL->Disconnect();
    }
    if(isset($REQUEST['cmd']) && $REQUEST['cmd']=='REPORT_IMAGE')
    {
        $width  = 600;
        $height = 400;
        error_reporting(0);
        header("Content-type: image/png");
        require_once  LIBRARIES  . "libchart".PATH_SEP."libchart.php";
        if($REQUEST['type']=="pie")
        {
            $chart = new PieChart($width, $height);
        }
        elseif($REQUEST['type']=="hbar")
        {
            $chart = new HorizontalChart($width, $height);
        }
        elseif($REQUEST['type']=="vbar")
        {
            $chart = new VerticalChart($width, $height);
            $chart->setLabelMarginBottom(100);
        }
        else
        {
            $chart = new LineChart($width, $height);
            $chart->setLabelMarginBottom(150);
        }
        foreach($REQUEST['datas'] as $data)
        {
            $chart->addPoint(new Point($data[0], $data[1]));
        }
        $chart->setLogo("");
        $chart->setTitle($REQUEST['title']);
        $chart->render();
        $BL->Disconnect();
    }
    //GET INVOICE/SALES/SERVERLOAD REPORT
    if ($cmd == "load")
        include_once XMLFEEDS."uptime.php";
    if ($cmd == "cbm")
        include_once XMLFEEDS."orders_monthly.php";
    if ($cmd == "inv")
        include_once XMLFEEDS."invoices_all.php";
    if ($cmd == "sbm")
        include_once XMLFEEDS."sales_monthly.php";
    if ($cmd == "sby")
        include_once XMLFEEDS."sales_yearly.php";
    $BL->Disconnect();
?>
