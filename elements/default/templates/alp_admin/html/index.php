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

<?php include_once $BL->props->get_page("templates/alp_admin/html/header.php"); ?>
<script language="JavaScript" type="text/javascript">
var tabs = [<?php echo $str1; ?>];
var t    = [<?php echo $str2; ?>];
</script>  
<div id="content">
    <div id="display_list">
      <div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['General']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <?php if($BL->getCmd("viewinvoice") && count($sInvoices)){ ?>
      <div class="tabs" name='t2' id='t2' onclick="javascript:showTab('tab2', tabs, 't2', t);" onmouseover="javascript:overTab('t2', t);" onmouseout="javascript:outTab(t);" ><?php echo count($sInvoices)." ".$BL->props->lang['Submitted_Invoices']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <?php } ?>
      <?php if($BL->getCmd("manual_payments") && count($mInvoices)){ ?>
      <div class="tabs" name='t3' id='t3' onclick="javascript:showTab('tab3', tabs, 't3', t);" onmouseover="javascript:overTab('t3', t);" onmouseout="javascript:outTab(t);" ><?php echo count($mInvoices)." ".$BL->props->lang['~manual_payments']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <?php } ?>
      <?php if($BL->getCmd("viewinvoice") && count($pInvoices)){ ?>
      <div class="tabs" name='t4' id='t4' onclick="javascript:showTab('tab3', tabs, 't4', t);" onmouseover="javascript:overTab('t4', t);" onmouseout="javascript:outTab(t);" ><?php echo count($pInvoices)." ".$BL->props->lang['Pending_Invoices']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <?php } ?>
      <?php if($BL->getCmd("orphan_orders") && count($oOrders)){ ?>
      <div class="tabs" name='t5' id='t5' onclick="javascript:showTab('tab4', tabs, 't5', t);" onmouseover="javascript:overTab('t5', t);" onmouseout="javascript:outTab(t);" ><?php echo count($oOrders)." ".$BL->props->lang['Orphan_Order(s)']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <?php } ?>
      <?php if($BL->getCmd("vieworders") && count($pOrders)){ ?>
      <div class="tabs" name='t6' id='t6' onclick="javascript:showTab('tab6', tabs, 't6', t);" onmouseover="javascript:overTab('t6', t);" onmouseout="javascript:outTab(t);" ><?php echo count($pOrders)." ".$BL->props->lang['Pending_Orders']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <?php } ?>
      <?php if($BL->getCmd("viewTicket") && $open_ticket_count){ ?>
      <div class="tabs" name='t7' id='t7' onclick="javascript:showTab('tab7', tabs, 't7', t);" onmouseover="javascript:overTab('t7', t);" onmouseout="javascript:outTab(t);" ><?php echo $open_ticket_count." ".$BL->props->lang['open_tickets']; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <?php } ?>      
    </div>
	<div id="display_list">    
    <div id="tab1" name="tab1" class="tabContent" style="display:none">
    <?php include_once $BL->props->get_page("templates/alp_admin/html/_server_status.php"); ?>
    </div>
    
    <?php if($BL->getCmd("viewinvoice")){ $Invoices = $sInvoices;?>
    <div id="tab2" name="tab2" class="tabContent" style="display:none">	
    <?php include $BL->props->get_page("templates/alp_admin/html/_invoices.php"); ?>
    </div>
	<?php } ?>	 
     
    <?php if($BL->getCmd("manual_payments")){ $Invoices = $mInvoices;?>
    <div id="tab3" name="tab3" class="tabContent" style="display:none">	
    <?php include $BL->props->get_page("templates/alp_admin/html/_invoices.php"); ?>
    </div>
	<?php } ?>	 
     
    <?php if($BL->getCmd("viewinvoice")){ $Invoices = $pInvoices;?>
    <div id="tab4" name="tab4" class="tabContent" style="display:none">
    <?php include $BL->props->get_page("templates/alp_admin/html/_invoices.php"); ?>
    </div>     
    <?php } ?>
     
	<?php if($BL->getCmd("orphan_orders")){ ?>   
    <div id="tab5" name="tab5" class="tabContent" style="display:none">     
    <?php include_once $BL->props->get_page("templates/alp_admin/html/_orphan_orders.php"); ?>            
    </div>    
	<?php } ?>     
     
    <?php if($BL->getCmd("vieworders")){ $Orders = $pOrders; ?>
    <div id="tab6" name="tab6" class="tabContent" style="display:none">
    <?php include_once $BL->props->get_page("templates/alp_admin/html/_orders.php"); ?>
    </div>
    <?php } ?>  
     
	<?php if($BL->getCmd("viewTicket")){ ?>
    <div id="tab7" name="tab7" class="tabContent" style="display:none">        
    <?php include_once $BL->props->get_page("templates/alp_admin/html/_tickets.php"); ?>
    </div>    
	<?php } ?>
     
    <div style="float:left;">
    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="list_table">				
    <tr> 
        <td class="text_grey" align="center">
        <div style="vertical-align:middle">
        <img src='elements/default/templates/alp_admin/images/pdf.gif' alt='<?php echo $BL->props->lang['PDF']; ?>' border='0' /> <?php echo $BL->props->lang['PDF']; ?>
        &nbsp;
        <img src='elements/default/templates/alp_admin/images/edit_all.gif' border="0" /> <?php echo $BL->props->lang['Edit']; ?>
        &nbsp;
        <img src='elements/default/templates/alp_admin/images/add_order.gif' border="0" /> <?php echo $BL->props->lang['Make_regular']; ?>
        &nbsp;
        <img src='elements/default/templates/alp_admin/images/delete.gif' border="0" /> <?php echo $BL->props->lang['Delete']; ?>
        </div>
        </td>
    </tr>
    </table>
    </div>	 
  </div>
</div>
<script language="JavaScript" type="text/javascript">
  showTab('tab1', tabs, 't1', t);
</script>
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel_flash.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
