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

    $myChart    = new BJCBarChart();
    $conf       = $BL->conf;
    $symbol     = $conf['symbol'];
    $y          = date('Y');
    $status     = $BL->props->invoice_status[1];
    $y-=3;
    for ($i= 0; $i < 4; $i ++)
    {
        $y1        = $y + $i;
        $query1    = "SELECT SUM(`gross_amount`) as total FROM {$BL->props->tbl_invoices} WHERE `status`='$status' AND `due_date` LIKE '$y1-%'";
        $intot     = $BL->dbL->executeSELECT($query1);
        $into      = $intot[0]['total'];
        if ($into == '')
        {
            $intot1[$i]= "0";
        }
        else
        {
            $intot1[$i]= $into;
        }
    }
    #end of my bit to get invoice totals info
    // Set the properties
    $myChart->max               = "";
    $myChart->min               = "0";
    $myChart->barWidth          = "1000"; // As wide bars as possible
    $myChart->barPadding        = "5";
    $myChart->gridLines         = "5";
    $myChart->printTitle        = "Sales by Year";
    $myChart->printXTitle       = "";
    $myChart->printYTitle       = "";
    $myChart->printFooter       = "";
    $myChart->max               = 1;
    if($intot1[0]>$myChart->max)$myChart->max = $intot1[0]+1;
    if($intot1[1]>$myChart->max)$myChart->max = $intot1[1]+1;
    if($intot1[2]>$myChart->max)$myChart->max = $intot1[2]+1;
    if($intot1[3]>$myChart->max)$myChart->max = $intot1[3]+1;
    // Call the addBar method to add a new bar to the chart
    $myChart->addBar($y." (".$symbol.")", "0xFF0000", $intot1[0]);
    $myChart->addBar(($y+1)." (".$symbol.")", "0xCC3300", $intot1[1]);
    $myChart->addBar(($y+2)." (".$symbol.")", "0xFF0000", $intot1[2]);
    $myChart->addBar(($y+3)." (".$symbol.")", "0xCC3300", $intot1[3]);
    // Call the toXML method to output the XML data
    $myChart->toXML();
?>
