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
<?php
	// Get default currency formatting options, and force a few settings for compatibility
	$curr_array = $BL->curr_conf;
	$curr_array['str1'] = '.';//force decimal as period
	$curr_array['str2'] = '';//remove the thousand separator
?>
<script><!--
function updateTotal() {
	var total=0;
	total += parseFloat(document.getElementById('tld_fee').value);
	total += parseFloat(document.getElementById('setup_fee').value);
	total += parseFloat(document.getElementById('cycle_fee').value);

	<?php foreach($Addons as $Addon_Name=>$Addon_Fee){ ?>
	total += parseFloat(document.getElementById('addon_setups[<?php echo $Addon_Name; ?>]').value);
	total += parseFloat(document.getElementById('addon_cycles[<?php echo $Addon_Name; ?>]').value);
	<?php } ?>

	if (document.getElementsByName('debit_credit')[0].value == "debit") {
		total += parseFloat(document.getElementById('debit_credit_amount').value);
	}
	if (document.getElementsByName('debit_credit')[0].value == "credit") {
		total -= parseFloat(document.getElementById('debit_credit_amount').value);
	}
	total -= parseFloat(document.getElementById('other_amount').value);

	document.getElementById('net_amount').value=total.toFixed(<?php echo $curr_array['decimals'] ?>);

	var totaltax = 0;
	for(var i=0; i < document.getElementsByName('tax1[]').length;i++) {
		// We .toFixed early, because hidden decimals make the math look dishonest
		var thistax = (total * parseFloat(document.getElementsByName('tax0[]')[i].value)/100).toFixed(<?php echo $curr_array['decimals']; ?>);
		document.getElementsByName('tax1[]')[i].value = thistax;
		if (document.getElementsByName('tax3[]')[i].value == '+') {
			totaltax += parseFloat(thistax);
		}
		if (document.getElementsByName('tax3[]')[i].value == '-') {
			totaltax -= parseFloat(thistax);
		}
	}
	document.getElementById('tax_amount').value=totaltax.toFixed(<?php echo $curr_array['decimals'] ?>);
	total += totaltax;
	document.getElementById('gross_amount').value=total.toFixed(<?php echo $curr_array['decimals'] ?>);
}
//--></script>
<div id="content">
    <div id="display_list">
        <form name='form1' id='form1' method='POST' action='<?php echo $PHP_SELF; ?>'>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
        <tr> 
            <td colspan="2" class="tdheading">
            <b>&nbsp;<?php echo $BL->props->lang['Create_Invoice_for']." ".$BL->getCustomerFieldValue("name",isset($Invoice[0]['id'])?$Invoice[0]['id']:$Order[0]['id']); ?></b>
            </td>
        </tr>
        <tr> 
            <td colspan="2" class="text_grey">
            <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
            </td>
        </tr>
        <?php if($cmd=="editinvoice" && isset($Extra_Fields) && count($Extra_Fields)){ ?>
        <tr> 
            <td colspan="2" class="text_grey">                      
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <?php foreach($Extra_Fields as $Extra_Field){ ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label"><?php echo $BL->props->lang[$Extra_Field[0]]; ?></div>
                <div id="form1_field"><?php echo $Extra_Field_Values[$Extra_Field[1]]; ?></div>
                </td>
            </tr>
            <?php } ?>
            </table>
            </td>
        </tr> 
        <tr> 
            <td colspan="2" class="text_grey">
            <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td class="text_grey" colspan="2">
            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr> 
                <td width="1%" class='text_grey'>
	            <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Description']; ?>
                </div>
                <div id="form1_field">
                <?php if($cmd=="editinvoice") { echo $BL->getFriendlyDesc($Invoice[0]['desc'],$Invoice[0]['order_id']); }else { echo $BL->getFriendlyDesc($Order[0]['sub_id']."-".$Order[0]['product_id']."-".$Order[0]['domain_name']."-".date('Y-m-d'),$Order[0]['sub_id']); } ?>
                <input name='desc' id='desc' type='hidden' value="<?php if($cmd=="editinvoice") echo $Invoice[0]['desc']; else echo $Order[0]['sub_id']."-".$Order[0]['product_id']."-".$Order[0]['domain_name']."-".date('Y-m-d'); ?>" />                    
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Due_Date']; ?>
                </div>
                <div id="form1_field">
                <?php $date=$BL->utils->getDateArray(isset($Invoice[0]['due_date'])?$Invoice[0]['due_date']:date('Y-m-d')); ?>
                <?php echo $BL->utils->datePicker($date['mday'], $date['mon'], $date['year'], "search"); ?>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" valign="top" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey' valign="top">
                <div id="form1_label">
                <?php echo $BL->props->lang['detail']; ?>
                </div>
                <div id="form1_field">
                <textarea name="pay_text" rows="10" cols="65"><?php if($cmd=="editinvoice"){echo $Invoice[0]['pay_text'];} ?></textarea>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php if($cmd=="editinvoice"){ ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Domain']; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">
                <input name='tld_fee' type='text' class='search' id='tld_fee' size='20' value='<?php echo $BL->toCurrency($Invoice[0]['tld_fee'],$BL->curr_conf,1,0); ?>' onblur='updateTotal();'/>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['setup_fee']; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">
                <input name='setup_fee' type='text' class='search' id='setup_fee' size='20' value='<?php echo $BL->toCurrency($Invoice[0]['setup_fee'],$curr_array,1,0); ?>' onblur='updateTotal();' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['cycle_amount']; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">
                <input name='cycle_fee' type='text' class='search' id='cycle_fee' size='20' value='<?php echo $BL->toCurrency($Invoice[0]['cycle_fee'],$curr_array,1,0); ?>' onblur='updateTotal();' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php foreach($Addons as $Addon_Name=>$Addon_Fee){ ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $Addon_Name; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">
                <?php echo $BL->props->lang['setup_fee']; ?>&nbsp;<input name='addon_setups[<?php echo $Addon_Name; ?>]' type='text' class='search' id='addon_setups[<?php echo $Addon_Name; ?>]' size='8' value='<?php echo $BL->toCurrency($Addon_Fee['SETUP'],$curr_array,1,0); ?>' onblur='updateTotal();' />
                <?php echo $BL->props->lang['Recurring']; ?>&nbsp;<input name='addon_cycles[<?php echo $Addon_Name; ?>]' type='text' class='search' id='addon_cycles[<?php echo $Addon_Name; ?>]' size='8' value='<?php echo $BL->toCurrency($Addon_Fee['CYCLE'],$curr_array,1,0); ?>' onblur='updateTotal();' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php } ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <b><?php echo $BL->props->lang['special_disount']; ?></b>
                </div>
                <div id="form1_field">
                &nbsp;
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>&nbsp;</div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['tld_discount']; ?> (%)
                </div>
                <div id="form1_field">
                <input name='inv_tld_disc' type='text' class='search' id='inv_tld_disc' size='20' value='<?php echo rtrim(rtrim($Invoice[0]['inv_tld_disc'],'0'),'.'); ?>' onblur='updateTotal();' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>&nbsp;</div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['plan_discount']; ?> (%)
                </div>
                <div id="form1_field">
                <input name='inv_plan_disc' type='text' class='search' id='inv_plan_disc' size='20' value='<?php echo rtrim(rtrim($Invoice[0]['inv_plan_disc'],'0'),'.'); ?>' onblur='updateTotal();' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>&nbsp;</div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['addon_discount']; ?> (%)
                </div>
                <div id="form1_field">
                <input name='inv_addon_disc' type='text' class='search' id='inv_addon_disc' size='20' value='<?php echo rtrim(rtrim($Invoice[0]['inv_addon_disc'],'0'),'.'); ?>' onblur='updateTotal();' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php } ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Credit_Debit']; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">
                <input name='debit_credit_amount' type='text' class='search' id='debit_credit_amount' size='20' value='<?php if($cmd=="editinvoice"){echo $BL->toCurrency($Invoice[0]['debit_credit_amount'],$curr_array,1,0);}else echo "0.00"; ?>' onblur='updateTotal();' />
                	  <select name="debit_credit" size="1" class='search' onblur='updateTotal();' onchange='updateTotal();'>
                	  <option></option>
                	    <option value="credit" <?php if($cmd=="editinvoice" && $Invoice[0]['debit_credit'] == "credit")echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['credit']; ?></option>
                	    <option value="debit" <?php if($cmd=="editinvoice" && $Invoice[0]['debit_credit'] == "debit")echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['debit']; ?></option>
                	  </select>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Credit_Debit']." ".$BL->props->lang['reason']; ?>
                </div>
                <div id="form1_field">
                <input name='debit_credit_reason' type='text' class='search' id='debit_credit_reason' size='20' value='<?php if($cmd=="editinvoice")echo $Invoice[0]['debit_credit_reason']; ?>' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php if(($cmd=="editinvoice" && $Invoice[0]['prorate_amount']>0) || ($cmd!="editinvoice" && $BL->conf['en_prorate'])){ ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['prorate_desc']; ?>
                </div>
                <div id="form1_field">                      
                <input name='prorate_desc' type='text' class='search' id='prorate_desc' size='20' value='<?php if($cmd=="editinvoice"){echo $Invoice[0]['prorate_desc'];} ?>' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['prorate_amount']; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">
                <input name='prorate_amount' type='text' class='search' id='prorate_amount' size='20' value='<?php if($cmd=="editinvoice"){echo $BL->toCurrency($Invoice[0]['prorate_amount'],$curr_array,1,0);}else echo "0.00"; ?>' onblur='updateTotal();'/>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php } ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['discount']; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">                      
                <input name='other_amount' type='text' class='search' id='other_amount' size='20' value='<?php if($cmd=="editinvoice"){echo $BL->toCurrency($Invoice[0]['other_amount'],$curr_array,1,0);}else echo "0.00"; ?>' onblur='updateTotal();' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Net_Amount']; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">
                <input name='net_amount' type='text' class='search' id='net_amount' size='20' value='<?php if($cmd=="editinvoice"){echo $BL->toCurrency($Invoice[0]['net_amount'],$curr_array,1,0);}else echo "0.00"; ?>' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php if($cmd=="editinvoice"){?>
            <?php foreach($Taxes as $Tax) { ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                <td class='text_grey'>
                <div id="form1_label">
                <input name='tax2[]' type='text' value='<?php echo $Tax[2]; ?>' class='search' id='tax2'>
                </div>
                <div id="form1_field">
                <select name='tax3[]' id='tax3' class='search' onblur='updateTotal();' onchange='updateTotal();'>
                <option value='+' <?php if($Tax[3]=="+")echo "selected=\"selected\""; ?>>+</option>
                <option value='-' <?php if($Tax[3]=="-")echo "selected=\"selected\""; ?>>-</option>
                </select>
                %<input name='tax0[]' type='text' value='<?php echo number_format($Tax[0],2); ?>' class='search' id='tax0' size='5' onblur='updateTotal();' />
                =
                <?php echo $BL->conf['symbol']; ?>
                <input name='tax1[]' type='text' value='<?php echo $BL->toCurrency($Tax[1],$curr_array,1,0); ?>' class='search' id='tax1' size='10' onblur='updateTotal();' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['total_tax']." (".$BL->conf['symbol'].")"; ?> 
                </div>
                <div id="form1_field">
                <input name='tax_amount' type='text' value='<?php if($cmd=="editinvoice"){echo $BL->toCurrency($Invoice[0]['tax_amount'],$curr_array,1,0);}else echo "0"; ?>' class='search' id='tax_amount' size='20' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Gross_Amount']; ?> (<?php echo $BL->conf['symbol']; ?>)
                </div>
                <div id="form1_field">
                <input name='gross_amount' type='text' class='search' id='gross_amount' size='20' value='<?php if($cmd=="editinvoice"){echo $BL->toCurrency($Invoice[0]['gross_amount'],$curr_array,1,0);} ?>' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <?php 
            if(isset($Invoice[0]['pay_curr_factor']) && $Invoice[0]['pay_curr_factor']!=1 && $Invoice[0]['pay_curr_factor']!=0){
                $curr_conf                    = array();
                $curr_conf['symbol_prefixed'] = $Invoice[0]['pay_curr_symbol_prefixed'];
                $curr_conf['symbol']          = $Invoice[0]['pay_curr_symbol'];
                $curr_conf['decimals']        = $Invoice[0]['pay_curr_decimal_number'];
                $curr_conf['str1']            = $Invoice[0]['pay_curr_decimal_str'];
                $curr_conf['str2']            = $Invoice[0]['pay_curr_thousand_str']; 
            ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['currency']; ?>
                </div>
                <div id="form1_field">
                <input name='pay_curr_name' type='text' class='search' id='pay_curr_name' size='20' value='<?php if($cmd=="editinvoice"){echo $Invoice[0]['pay_curr_name'];} ?>' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['symbol']; ?>
                </div>
                <div id="form1_field">
                <input name='pay_curr_symbol' type='text' class='search' id='pay_curr_symbol' size='20' value='<?php if($cmd=="editinvoice"){echo $Invoice[0]['pay_curr_symbol'];} ?>' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['currency_rate']; ?>
                </div>
                <div id="form1_field">
                <input name='pay_curr_factor' type='text' class='search' id='pay_curr_factor' size='20' value='<?php if($cmd=="editinvoice"){echo $Invoice[0]['pay_curr_factor'];} ?>' />
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['curr_symbol_position']; ?>
                </div>
                <div id="form1_field"> 
                    <select name='pay_curr_symbol_prefixed' id='pay_curr_symbol_prefixed' class="search">
                    <option value="1" <?php  if($cmd=="editinvoice" && $Invoice[0]['pay_curr_symbol_prefixed']==1)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Prefixed']; ?></option>
                    <option value="0" <?php  if($cmd=="editinvoice" && $Invoice[0]['pay_curr_symbol_prefixed']==0)echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Suffixed']; ?></option>
                    </select>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['decimal_number']; ?>
                </div>
                <div id="form1_field"> 
                  <select name="pay_curr_decimal_number" id="pay_curr_decimal_number" size="1">
                  <?php for($i=0;$i<=6;$i++){ ?>
                    <option value="<?php echo $i; ?>" <?php if($cmd=="editinvoice" && $i==$Invoice[0]['pay_curr_decimal_number'])echo "selected=\"selected\""; ?>><?php echo $i; ?></option>
                  <?php } ?>
                  </select>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['decimal_str']; ?>
                </div>
                <div id="form1_field">
                  <select name="pay_curr_decimal_str" id="pay_curr_decimal_str" size="1">
                    <option value="," <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_decimal_str']==',')echo "selected=\"selected\""; ?>>,</option>
                    <option value="." <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_decimal_str']=='.')echo "selected=\"selected\""; ?>>.</option>
                    <option value="'" <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_decimal_str']=='\'')echo "selected=\"selected\""; ?>>'</option>
                    <option value="’" <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_decimal_str']=='’')echo "selected=\"selected\""; ?>>’</option>
                    <option value=" " <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_decimal_str']==' ')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['blank']; ?>]</option>
                    <option value="" <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_decimal_str']=='')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['none']; ?>]</option>
                  </select>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['thousand_str']; ?>
                </div>
                <div id="form1_field"> 
                  <select name="pay_curr_thousand_str" id="pay_curr_thousand_str" size="1">
                    <option value="," <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_thousand_str']==',')echo "selected=\"selected\""; ?>>,</option>
                    <option value="." <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_thousand_str']=='.')echo "selected=\"selected\""; ?>>.</option>
                    <option value="'" <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_thousand_str']=='\'')echo "selected=\"selected\""; ?>>'</option>
                    <option value="’" <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_thousand_str']=='’')echo "selected=\"selected\""; ?>>’</option>
                    <option value=" " <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_thousand_str']==' ')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['blank']; ?>]</option>
                    <option value="" <?php if($cmd=="editinvoice" && $Invoice[0]['pay_curr_thousand_str']=='')echo "selected=\"selected\""; ?>>[<?php echo $BL->props->lang['none']; ?>]</option>
                  </select>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Total_amount_in'].$Invoice[0]['pay_curr_name']."(".$Invoice[0]['pay_curr_symbol'].")"; ?>
                </div>
                <div id="form1_field">
                <b><?php echo $BL->toCurrency($Invoice[0]['pay_curr_factor']*$Invoice[0]['gross_amount'],$curr_conf,1); ?></b>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>                  
            <?php } ?>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Payment_processor']; ?>
                </div>
                <div id="form1_field">
                <select name='payment_method' class='search' id='payment_method'>
                <?php foreach ($BL->pg as $key => $value) {
                        if ($BL->pp_active[$value] == "Yes") {
                            if ($cmd == "editinvoice" && $Invoice[0]['payment_method'] == $value) {
                ?>
                <option value='<?php echo $value; ?>' selected="selected"><?php echo $BL->pg_name[$value]; ?></option>
                <?php }else{ ?>
                <option value='<?php echo $value; ?>'><?php echo $BL->pg_name[$value]; ?></option>
                <?php  } } } ?>
                </select>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label"><?php echo $BL->props->lang['Status']; ?></div>
                <div id="form1_field">
                <select name='status' class='search'>
                <?php foreach ($BL->props->invoice_status as $k => $v) {
                	if ($cmd == "editinvoice" && $Invoice[0]['status'] == $v)
                    {
                		echo "<option value=\"".$v."\" selected=\"selected\">".$BL->props->lang[$v]."</option>";
                    }
                	else
                    {
                		echo "<option value=\"".$v."\">".$BL->props->lang[$v]."</option>";
                    }
                }
                ?>
                </select>
                </div>
                </td>
            </tr>
            <tr> 
                <td colspan='2' class='text_grey'>
                <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                </td>
            </tr>
            <tr> 
                <td width="1%" class='text_grey'>
                <div align='center'>&nbsp;</div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                &nbsp;
                </div>
                <div id="form1_field">
                <?php if ($cmd == "editinvoice") { ?>
                <input type='hidden' name='invoice_no' value='<?php echo $REQUEST['invoice_no']; ?>' />
                <?php }else{ ?>
                <input type='hidden' name='sub_id' value='<?php echo $REQUEST['sub_id']; ?>' />
                <?php } ?>
                <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                <input name='submit' type='submit' class='search1' value='<?php if($cmd=="editinvoice")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
                </div>
                </td>
            </tr>
            </table>
            </td>
        </tr>
        </table>
        </form>
	</div>
</div>
<!--end content -->
<div id="navBar">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td class='text_grey'>
            <a href='info.php?cmd=PRINT&invoice_no=<?php echo $REQUEST['invoice_no']; ?>' target='_blank'><b><?php echo $BL->props->lang['Print']; ?></b></a>
        </td>
    </tr>
    <tr> 
        <td class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen.jpg' width='100%' height='2' />
        </td>
    </tr>
    <tr>
        <td class='text_grey'>
            <a href='info.php?cmd=VPDF&invoice_no=<?php echo $REQUEST['invoice_no']; ?>' target='_blank'><b><?php echo $BL->props->lang['PDF']; ?></b></a>
        </td>
    </tr>
    <tr>
        <td class='text_grey'>
            <a href='info.php?cmd=PDF&invoice_no=<?php echo $REQUEST['invoice_no']; ?>' target='_blank'><b><?php echo $BL->props->lang['Download_PDF']; ?></b></a>
        </td>
    </tr>
    <tr> 
        <td class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen.jpg' width='100%' height='2' />
        </td>
    </tr>
    <tr>
        <td class='text_grey'>
            <a href='<?php echo $PHP_SELF; ?>?cmd=editinvoice&action=sendinvoice&invoice_no=<?php echo $REQUEST['invoice_no']; ?>'><b><?php echo $BL->props->lang['Send_Invoice']; ?></b></a>
        </td>
    </tr>
    <tr> 
        <td class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen.jpg' width='100%' height='2' />
        </td>
    </tr>
    <tr>
        <td class='text_grey'>
            <a href='<?php echo $PHP_SELF; ?>?cmd=editinvoice&action=sendpaymentnotice&invoice_no=<?php echo $REQUEST['invoice_no']; ?>'><b><?php echo $BL->props->lang['Send_Payment_Reciept']; ?></b></a>
        </td>
    </tr>
    <tr> 
        <td class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen.jpg' width='100%' height='2' />
        </td>
    </tr>
</table>
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
