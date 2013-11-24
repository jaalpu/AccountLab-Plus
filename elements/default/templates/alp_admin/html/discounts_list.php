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
                      <td colspan="4" class="tdheading">
					  <b>&nbsp;<?php echo $BL->props->lang['~discounts']; ?></b>
					  </td>
                    </tr>
					<tr> 
                      <td colspan="4" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
            		<form name='form1' id='form1' action="<?php echo $PHP_SELF; ?>" method="POST">
            		<?php if (!count($allCustomers)) { ?>
            				<tr>
            					<td class="text_grey" colspan="4">
                                	<div align='center'>
                                	<?php echo $BL->props->lang['No_customers']; ?>
                                	</div>
            					</td>
            				</tr>
            		<?php } else { ?>														
                    <tr>
					<td class='text_grey' width='1%'></td>
					<td class='text_grey'><b><?php echo $BL->props->lang['Name']; ?></b></td>
					<td class='text_grey'><b><?php echo $BL->props->lang['discount']." (%)"; ?></b></td>
					<td class='text_grey'></td>
	  				</tr>
                    <?php foreach($allCustomers as $temp) { ?>
					<tr>
                      <td colspan='4' class='text_grey'>
					  <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1"></td>
                    </tr>					
					<tr>
					<td class='text_grey'></td>
					<td class='text_grey'><a href='<?php echo $PHP_SELF."?cmd=editcustomers&id=".$temp['id']; ?>'><?php echo $BL->getCustomerFieldValue("name",$temp['id']); ?></a></td>
					<td class='text_grey'><input type="text" name="discount[<?php echo $temp['id']; ?>]" class='search' value="<?php echo $temp['discount']; ?>" size="8" /></td>
					<td class='text_grey'>
							  <select name="disposable[<?php echo $temp['id']; ?>]" size="1" class='search'>
							    <option value="1" <?php if($temp['disposable'] == 1)echo "selected"; ?>><?php echo $BL->props->lang['next_order_only']; ?></option>
							    <option value="0" <?php if($temp['disposable'] == 0)echo "selected"; ?>><?php echo $BL->props->lang['until_removed']; ?></option>
							  </select>
							  <select name="cumulative[<?php echo $temp['id']; ?>]" size="1" class='search'>
							    <option value="1" <?php if($temp['cumulative'] == 1)echo "selected"; ?>><?php echo $BL->props->lang['cumulative']; ?></option>
							    <option value="0" <?php if($temp['cumulative'] == 0)echo "selected"; ?>><?php echo $BL->props->lang['not_cumulative']; ?></option>
							  </select> 
 					</td>
                    </tr>
					<tr>
                      <td colspan='4' class='text_grey' height="2">
					  <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
					  </td>
                    </tr>
                   <?php } } ?>
					<tr> 
                      <td colspan="4" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
					<tr> 
                      <td colspan="4" class="text_grey">
					  <div align="center">
							<input type='hidden' name='cmd' value='<?php echo $cmd; ?>'>
					        <input type='submit' class='search1' name='update' value='<?php echo $BL->props->lang['Update']; ?>' />					  
					  </div>
					  </td>
                    </tr>				
			        </form>
					<tr> 
                      <td colspan="4" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>			
                  </table>
	</div>
</div>
<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
