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
    $uptime     = @ exec('uptime');
    if ($uptime)
    {
        preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/", $uptime, $avgs);
        $uptime = explode(' up ', $uptime);
        $uptime = explode(',', $uptime[1]);
        $uptime = $uptime[0].', '.$uptime[1];
        $start  = mktime(0, 0, 0, 1, 1, date("Y"));
        $end    = mktime(0, 0, 0, date("m"), date("j"), date("y"));
        $diff   = $end - $start;
        $days   = $diff / 86400;
        #$percentage=($uptime/$days) * 100;
        $load   = $avgs[1].",".$avgs[2].",".$avgs[3]."";
        #echo 'Average Load: '.$load;
        #echo '<BR>Uptime: '.$uptime;
        #echo "<BR>$avgs[1]";
        #echo "<BR>$avgs[2]";
        #echo "<BR>$avgs[3]";

        // Set the properties
        $myChart->max           = "500";
        $myChart->min           = "0";
        $myChart->barWidth      = "1000"; // As wide bars as possible
        $myChart->barPadding    = "5";
        $myChart->gridLines     = "5";
        $myChart->printTitle    = "Server Uptime";
        $myChart->printXTitle   = "Poll Time";
        $myChart->printYTitle   = "Amount";
        $myChart->printFooter   = "Server Load Average";
        if ($avgs[1] == "")
        {
            $avgs[1] = 0;
        }
        if ($avgs[2] == "")
        {
            $avgs[2] = 0;
        }
        if ($avgs[3] == "")
        {
            $avgs[3] = 0;
        }
        $myChart->max = (1/5);
        if($avgs[1]>$myChart->max)$myChart->max = $avgs[1]+(1/5);
        if($avgs[2]>$myChart->max)$myChart->max = $avgs[2]+(1/5);
        if($avgs[3]>$myChart->max)$myChart->max = $avgs[3]+(1/5);
        // Call the addBar method to add a new bar to the chart
        $myChart->addBar("1 min", "0xFF0000", $avgs[1]);
        $myChart->addBar("5 min", "0x00FF00", $avgs[2]);
        $myChart->addBar("15 min", "0x0000FF", $avgs[3]);
        // Call the toXML method to output the XML data
        $myChart->toXML();
    }
?>
