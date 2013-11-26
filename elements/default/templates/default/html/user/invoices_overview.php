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

<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/header.php"); ?>
<script language="JavaScript" type="text/javascript">
var tabs = ["tab1","tab2","tab3"<?php if($conf['u_invoice_date']){ ?>,"tab4"<?php } ?>];
var t    = ["t1","t2","t3"<?php if($conf['u_invoice_date']){ ?>,"t4"<?php } ?>];
</script>  
<!--tabs//-->
<div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang[$BL->props->invoice_status[0]]." ".$BL->props->lang['^invoices']; ?></div>
<div class="tab_separator">&nbsp;</div>
<div class="tabs" name='t2' id='t2' onclick="javascript:showTab('tab2', tabs, 't2', t);" onmouseover="javascript:overTab('t2', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang[$BL->props->invoice_status[1]]." ".$BL->props->lang['^invoices']; ?></div>
<div class="tab_separator">&nbsp;</div>
<div class="tabs" name='t3' id='t3' onclick="javascript:showTab('tab3', tabs, 't3', t);" onmouseover="javascript:overTab('t3', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang[$BL->props->invoice_status[2]]." ".$BL->props->lang['^invoices']; ?></div>
<div class="tab_separator">&nbsp;</div>
<?php if($conf['u_invoice_date']){ ?>
<div class="tabs" name='t4' id='t4' onclick="javascript:showTab('tab4', tabs, 't4', t);" onmouseover="javascript:overTab('t4', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang[$BL->props->invoice_status[5]]." ".$BL->props->lang['^invoices']; ?></div>
<div class="tab_separator">&nbsp;</div>
<?php } ?>
<div>
<div id="tab1" name="tab1" class="tabContent" style="display:none">
<?php $invoices = $BL->invoices->get("WHERE `customers_orders`.customer_id=".intval($_SESSION['user_id'])." AND `invoices`.status='".$BL->utils->quoteSmart($BL->props->invoice_status[0])."'"); include $BL->props->get_page("templates/".THEMEDIR."/html/user/invoices.php"); ?>
</div>
<div id="tab2" name="tab2" class="tabContent" style="display:none">
<?php $invoices = $BL->invoices->get("WHERE `customers_orders`.customer_id=".intval($_SESSION['user_id'])." AND (`invoices`.status='".$BL->utils->quoteSmart($BL->props->invoice_status[1])."' OR `invoices`.status='".$BL->utils->quoteSmart($BL->props->invoice_status[6])."')"); include $BL->props->get_page("templates/".THEMEDIR."/html/user/invoices.php"); ?>
</div>
<div id="tab3" name="tab3" class="tabContent" style="display:none">
<?php $invoices = $BL->invoices->get("WHERE `customers_orders`.customer_id=".intval($_SESSION['user_id'])." AND `invoices`.status='".$BL->utils->quoteSmart($BL->props->invoice_status[2])."'"); include $BL->props->get_page("templates/".THEMEDIR."/html/user/invoices.php"); ?>
</div>
<?php if($conf['u_invoice_date']){ ?>
<div id="tab4" name="tab4" class="tabContent" style="display:none">
<?php $invoices = $BL->invoices->get("WHERE `customers_orders`.customer_id=".intval($_SESSION['user_id'])." AND `invoices`.status='".$BL->utils->quoteSmart($BL->props->invoice_status[5])."'"); include $BL->props->get_page("templates/".THEMEDIR."/html/user/invoices.php"); ?>
</div>
<?php } ?>
</div>
<script language="JavaScript" type="text/javascript">
  showTab('tab1', tabs, 't1', t);
</script>
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/footer.php"); ?>
