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
<div id="content">
	<div id="display_list">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
		<tr> 
            <td class="tdheading" colspan="4">
                <b>&nbsp;<?php echo $BL->props->lang["~".$cmd]; ?></b>
            </td>
        </tr>
		<tr> 
            <td class="text_grey" colspan="4">
                <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
            </td>
        </tr>
		<tr> 
	        <td class="text_grey" colspan="4" align="center">
                <?php if(isset($report_image_data)){ ?><img src='info.php?cmd=REPORT_IMAGE&<?php echo $report_image_data; ?>' border='1'><?php } ?>
	        </td>
        </tr>		
        <tr> 
            <td class="text_grey" colspan="4" align="center">
                <?php if(isset($report_image_data_2)){ ?><img src='info.php?cmd=REPORT_IMAGE&<?php echo $report_image_data_2; ?>' border='1'><?php } ?>
            </td>
        </tr>
		<tr> 
            <td class="text_grey" colspan="4">
		      <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
            </td>
        </tr>
    </table>
    <br />	
	</div>
</div>
<!--end content -->
<div id="navBar">
<form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
<table width="80%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td class='text_grey' colspan='2'>
			<select name='r_type' class='search'>
			    <?php if($cmd=="assets"){ ?>
		  		<optgroup label="<?php echo $BL->props->lang['select_basic_report']; ?>">
				<option value='income_all'     <?php if(isset($REQUEST['r_type']) && $REQUEST['r_type']=="income_all")    echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['income_all']; ?></option>
				<option value='income_country' <?php if(isset($REQUEST['r_type']) && $REQUEST['r_type']=="income_country")echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['income_country']; ?></option>
				<option value='income_yearly'  <?php if(isset($REQUEST['r_type']) && $REQUEST['r_type']=="income_yearly") echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['income_yearly']; ?></option>
				<option value='income_monthly' <?php if(isset($REQUEST['r_type']) && $REQUEST['r_type']=="income_monthly")echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['income_monthly']; ?></option>
				<option value='sales_product'  <?php if(isset($REQUEST['r_type']) && $REQUEST['r_type']=="sales_product") echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['sales_product']; ?></option>
				<option value='ord_domain'     <?php if(isset($REQUEST['r_type']) && $REQUEST['r_type']=="ord_domain")    echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['ord_domain']; ?></option>
	            <?php }else{ ?>
				<optgroup label="<?php echo $BL->props->lang['Calculate_growth']; ?>">
				<option value='2_years'   <?php if(isset($REQUEST['r_type']) && $REQUEST['r_type']=="2_years")  echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Based_on_last_2_years']; ?></option>
				<option value='12_months' <?php if(isset($REQUEST['r_type']) && $REQUEST['r_type']=="12_months")echo "selected=\"selected\""; ?>><?php echo $BL->props->lang['Based_on_last_12_months']; ?></option>
	            <?php } ?>
				</select>
				<br />
				<br />
			    <input type='hidden' name='cmd' value='<?php echo $cmd; ?>'>
		  </td>
        </tr>
		<?php if(isset($REQUEST['cmd']) && $REQUEST['cmd']!="growth"){ ?>
        <tr> 
          <td colspan='2' class='text_grey'>
		  <b><?php echo $BL->props->lang['all_dates']; ?></b>
		  <input type='checkbox' name='all_dates' <?php if((isset($REQUEST['all_dates']) && $REQUEST['all_dates']==true) || !isset($REQUEST['year_fieldfromD']) || empty($REQUEST['year_fieldfromD']))echo "checked=\"checked\""; ?> value='true' class='search' onchange="javascript:if(this.checked==true)toggleTbodyOff('date_sec');else toggleTbodyOn('date_sec');">
		  <br />
	      <br />
		  </td>
        </tr>
		<tbody id='date_sec'>
        <tr> 
          <td colspan='2' class='text_grey'>
	      <?php $f = $BL->utils->getDateArray($BL->report->rFromDate); ?>
		  <?php echo "<b>".$BL->props->lang['From']."</b><br />".$BL->utils->datePicker($f['mday'], $f['mon'], $f['year'], "search", "fromD"); ?>
          <br />
          <br />
	      <?php $t=$BL->utils->getDateArray($BL->report->rToDate); ?>		
		  <?php echo  "<b>".$BL->props->lang['To']."</b><br />".$BL->utils->datePicker($t['mday'], $t['mon'], $t['year'], "search", "toD"); ?>
          <br />
          <br />
		  </td>
        </tr>
		</tbody>
	    <?php } ?>
        <tr> 
          <td colspan='2' class='text_grey'>
          <input type='submit' name='submit' value='<?php echo $BL->props->lang['View']; ?>' class='search1'> 
		  </td>
        </tr>
		<script language="JavaScript" type="text/javascript">
    	<?php if((isset($REQUEST['all_dates']) && $REQUEST['all_dates']==true) || !isset($REQUEST['year_fieldfromD']) || empty($REQUEST['year_fieldfromD'])){ ?>
		toggleTbodyOff('date_sec');
		<?php } if(!isset($REQUEST['r_type']) || empty($REQUEST['r_type'])){ ?>
		toggleTbodyOff('btn_sec');
		<?php } ?>
		</script>
</table>
</form>
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
