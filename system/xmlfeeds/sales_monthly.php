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

    $conf       = $BL->conf;
    $symbol     = $conf['symbol'];
    $myChart    = new BJCBarChart();
    $status     = $BL->props->invoice_status[1];
    $y          = date('Y');
    for ($i= 1; $i < 13; $i ++)
    {
        $j = $i;
        if ($i <= 9)
        {
            $j= "0".$i;
        }
        $query1    = "SELECT SUM(gross_amount) as total FROM {$BL->props->tbl_invoices} WHERE `status`='$status' AND `due_date` like '$y-$j-%'";
        $intot     = $BL->dbL->executeSELECT($query1);
        if ($intot[0]['total'] == '')
        {
            $intot1[$i]= "0";
        }
        else
        {
            $intot1[$i]= $intot[0]['total'];
        }
    }
    // Set the properties
    $myChart->max           = "";
    $myChart->min           = "0";
    $myChart->barWidth      = "1000"; // As wide bars as possible
    $myChart->barPadding    = "5";
    $myChart->gridLines     = "5";
    $myChart->printTitle    = "Invoices";
    $myChart->printXTitle   = "";
    $myChart->printYTitle   = "";
    $myChart->printFooter   = "";
    $myChart->max           = 1;

    if($intot1[1]>$myChart->max)$myChart->max   = $intot1[1]+1;
    if($intot1[2]>$myChart->max)$myChart->max   = $intot1[2]+1;
    if($intot1[3]>$myChart->max)$myChart->max   = $intot1[3]+1;
    if($intot1[4]>$myChart->max)$myChart->max   = $intot1[4]+1;
    if($intot1[5]>$myChart->max)$myChart->max   = $intot1[5]+1;
    if($intot1[6]>$myChart->max)$myChart->max   = $intot1[6]+1;
    if($intot1[7]>$myChart->max)$myChart->max   = $intot1[7]+1;
    if($intot1[8]>$myChart->max)$myChart->max   = $intot1[8]+1;
    if($intot1[9]>$myChart->max)$myChart->max   = $intot1[9]+1;
    if($intot1[10]>$myChart->max)$myChart->max  = $intot1[10]+1;
    if($intot1[11]>$myChart->max)$myChart->max  = $intot1[11]+1;
    if($intot1[12]>$myChart->max)$myChart->max  = $intot1[12]+1;
    // Call the addBar method to add a new bar to the chart
    $myChart->addBar("Jan (".$symbol.")", "0x0033FF", $intot1[1]);
    $myChart->addBar("Feb (".$symbol.")", "0x0099FF", $intot1[2]);
    $myChart->addBar("Mar (".$symbol.")", "0x0033FF", $intot1[3]);
    $myChart->addBar("Apr (".$symbol.")", "0x0099FF", $intot1[4]);
    $myChart->addBar("May (".$symbol.")", "0x0033FF", $intot1[5]);
    $myChart->addBar("Jun (".$symbol.")", "0x0099FF", $intot1[6]);
    $myChart->addBar("Jul (".$symbol.")", "0x0033FF", $intot1[7]);
    $myChart->addBar("Aug (".$symbol.")", "0x0099FF", $intot1[8]);
    $myChart->addBar("Sep (".$symbol.")", "0x0033FF", $intot1[9]);
    $myChart->addBar("Oct (".$symbol.")", "0x0099FF", $intot1[10]);
    $myChart->addBar("Nov (".$symbol.")", "0x0033FF", $intot1[11]);
    $myChart->addBar("Dec (".$symbol.")", "0x0099FF", $intot1[12]);
    // Call the toXML method to output the XML data
    $myChart->toXML();
?>
