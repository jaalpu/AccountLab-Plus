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
<!--tabs//-->

<?php
	foreach($BL->props->order_status as $status)
	{
		$allorders[$status] = $BL->orders->get("WHERE `customers`.id=".intval($_SESSION['user_id'])." AND `orders`.order_deleted != '1' AND `cust_status`='".$status."'");
	}

	$t=1;
	$orders = $BL->orders->get("WHERE `customers`.id=".intval($_SESSION['user_id'])." AND `orders`.order_deleted != '1'");
?>
<div class="tabs" name='t<?php echo $t ?>' id='t<?php echo $t ?>' onclick="javascript:showTab('tab<?php echo $t ?>', tabs, 't<?php echo $t ?>', t);" onmouseover="javascript:overTab('t<?php echo $t ?>', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['Orders']; ?></div>
<div class="tab_separator">&nbsp;</div>
<?php
	foreach($allorders as $k=>$v) {
		if (!empty($v)) {
			$t+=1;
?>
<div class="tabs" name='t<?php echo $t ?>' id='t<?php echo $t ?>' onclick="javascript:showTab('tab<?php echo $t ?>', tabs, 't<?php echo $t ?>', t);" onmouseover="javascript:overTab('t<?php echo $t ?>', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang[$k]; ?></div>
<div class="tab_separator">&nbsp;</div>
<?php
		}
	}
?>
<!-- pages -->
<?php $t=1; ?>
<div>
<div id="tab<?php echo $t ?>" name="tab<?php echo $t ?>" class="tabContent" style="display:none">
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/orders.php"); ?>
</div>
<?php
	foreach($allorders as $k=>$v) {
		if (!empty($v)) {
			$t+=1;
			$orders = $v;
?>
<div id="tab<?php echo $t ?>" name="tab<?php echo $t ?>" class="tabContent" style="display:none">
<?php include $BL->props->get_page("templates/".THEMEDIR."/html/user/orders.php"); ?>
</div>
<?php
		}
	}
?>



</div>
<script language="JavaScript" type="text/javascript">
  var tabs = ["tab1"<?php for($i=2; $i<=$t; $i++) { echo ", \"tab$i\""; } ?>];
  var t    = ["t1"<?php for($i=2; $i<=$t; $i++) { echo ", \"t$i\""; } ?>];
  showTab('tab1', tabs, 't1', t);
</script>
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/footer.php"); ?>
