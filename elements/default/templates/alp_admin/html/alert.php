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

?>

<?php
if (!method_exists($BL, 'busLogic')) die("");
?>
<script language="JavaScript" type="text/javascript">
<!--
isIE=document.all;
isNN=!document.all&&document.getElementById;
isN4=document.layers;

function hideMe(){
  alertdiv=isIE ? document.all.theLayer : document.getElementById("theLayer");
  if (isIE||isNN) alertdiv.style.visibility="hidden";
  else if (isN4) document.theLayer.visibility="hide";
}

function showMe(){
  alertdiv=isIE ? document.all.theLayer : document.getElementById("theLayer");
  if (isIE||isNN) alertdiv.style.visibility="visible";
  else if (isN4) document.theLayer.visibility="show";
}

-->
</script>
<!-- BEGIN FLOATING LAYER CODE //-->
<div id="theLayer" align='center' style="position:absolute;visibility:<?php if($BL->utils->alert_now)echo "visible"; else echo "hidden"; ?>">
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align='center'>
<table border="0" width="50%" class="alert_table" cellspacing="0" cellpadding="5">
    <tr>
        <td width="100%" valign='top'>
          <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                  <td class="alert_tdhead">
                  <div align='right'>
                  <?php if($BL->utils->PDF){ ?>
                  <a href="info.php?cmd=VPDF&html=<?php echo urlencode($BL->utils->alert_text); ?>" target='_blank'"><b>[<?php echo $BL->props->lang['PDF']; ?>]</b></a>
                  &nbsp;&nbsp;
                  <a href="info.php?cmd=PDF&html=<?php echo urlencode($BL->utils->alert_text); ?>" target='_blank'"><b>[<?php echo $BL->props->lang['Download_PDF']; ?>]</b></a>
                  &nbsp;&nbsp;
                  <?php } ?>
                  <a href="#" onClick="hideMe();return false"><b>[<?php echo $BL->props->lang['Close']; ?>]</b></a>
                  </div>
                  </td>
              </tr>
              <tr>
                  <td width="100%" bgcolor="#FFFFFF" class="alert_text" align='center'>
                            <!-- PLACE YOUR CONTENT HERE //-->  
                            <?php echo $BL->utils->alert_text; ?>
                            <!-- END OF CONTENT AREA //-->
                  </td>
              </tr>
          </table> 
        </td>
    </tr>
</table>
    </td>
   </tr>
</table>
</div>
<!-- END FLOATING LAYER CODE //-->
