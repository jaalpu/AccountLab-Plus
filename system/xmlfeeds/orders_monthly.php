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
    $y          = date('Y');
    for ($i= 1; $i < 13; $i++)
    {
        $j = $i;
        if ($i <= 9)
        {
            $j= "0" . $i;
        }
        $query         = "SELECT * FROM {$BL->props->tbl_orders} WHERE `sign_date` like '$y-$j-%'";
        $result        = $BL->dbL->executeSELECT($query);
        $num_rows[$i]  = count($result);
    }
    // Set the properties
    $myChart->max           = "1";
    $myChart->min           = "0";
    $myChart->barWidth      = "1000"; // As wide bars as possible
    $myChart->barPadding    = "5";
    $myChart->gridLines     = "5";
    $myChart->printTitle    = "Orders";
    $myChart->printXTitle   = "";
    $myChart->printYTitle   = "";
    $myChart->printFooter   = "";
    // Call the addBar method to add a new bar to the chart
    $myChart->addBar("Jan", "0x00CC00", $num_rows[1]);
    $myChart->addBar("Feb", "0x00FF00", $num_rows[2]);
    $myChart->addBar("Mar", "0x00CC00", $num_rows[3]);
    $myChart->addBar("Apr", "0x00FF00", $num_rows[4]);
    $myChart->addBar("May", "0x00CC00", $num_rows[5]);
    $myChart->addBar("Jun", "0x00FF00", $num_rows[6]);
    $myChart->addBar("Jul", "0x00CC00", $num_rows[7]);
    $myChart->addBar("Aug", "0x00FF00", $num_rows[8]);
    $myChart->addBar("Sep", "0x00CC00", $num_rows[9]);
    $myChart->addBar("Oct", "0x00FF00", $num_rows[10]);
    $myChart->addBar("Nov", "0x00CC00", $num_rows[11]);
    $myChart->addBar("Dec", "0x00FF00", $num_rows[12]);
    // Call the toXML method to output the XML data
    $myChart->toXML();
?>
