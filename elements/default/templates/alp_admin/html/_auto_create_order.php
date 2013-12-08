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

<?php if ($cmd == "editorder"){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
<tr>
  <td class="tdheading">
  <b>&nbsp;</b>
  </td>
</tr>
<tr>
  <td class="text_grey">
<table width="100%" border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td class='text_grey' width="2%">&nbsp;</td>
    <td class='text_grey' width="20%"><?php echo $BL->props->lang['Name']; ?></td>
    <td class='text_grey' colspan='4'><?php echo $BL->getCustomerFieldValue("name",$REQUEST['customer_id'])." {".$REQUEST['email']."}"; ?></td>
  </tr>
  <tr>
    <td class='text_grey'>&nbsp;</td>
    <td class='text_grey'><?php echo $BL->props->lang['remote_ip']; ?></td>
    <td class='text_grey' colspan='4'><?php echo $REQUEST['remote_ip']; ?></td>
  </tr>
  <tr>
    <td class='text_grey'>&nbsp;</td>
    <td class='text_grey'><?php echo $BL->props->lang['remote_country']; ?></td>
    <td class='text_grey' colspan='4'><?php echo isset($BL->props->country[$REQUEST['remote_country_code']])?$BL->props->country[$REQUEST['remote_country_code']]:$BL->props->lang['na']; ?></td>
  </tr>
  <tr>
    <td class='text_grey'>&nbsp;</td>
    <td class='text_grey'><?php echo $BL->props->lang['remote_city']; ?></td>
    <td class='text_grey' colspan='4'><?php echo $REQUEST['remote_city']; ?></td>
  </tr>
  <form name='form6' id='form6' method='post' action='<?php echo $PHP_SELF; ?>'>
  <tr>
    <td class='text_grey'>&nbsp;</td>
    <td class='text_grey'><?php echo $BL->props->lang['next_bill_date']; ?></td>
    <td class='text_grey'><b><?php echo $BL->fDate($REQUEST['rec_next_date']); ?></b></td>
    <td class='text_grey'><?php echo $BL->props->lang['change_next_bill_date']; ?></td>
    <td class='text_grey'>
    <?php $date=$BL->utils->getDateArray($REQUEST['rec_next_date']); ?>
    <?php echo $BL->utils->datePicker($date['mday'], $date['mon'], $date['year'], "search"); ?>
    </td>
    <td class='text_grey'>
    <input type="hidden" name='action' value="change_next_bill_date" />
    <input type="hidden" name="cmd" value="<?php echo $cmd; ?>" />
    <input type="hidden" name="sub_id" value="<?php echo $REQUEST['sub_id']; ?>" />
    <input type="submit" name="submit1" value="<?php echo $BL->props->lang['Update']; ?>" class="search1" />
    </td>
  </tr>
  </form>
  <?php if($REQUEST['dom_reg_comp'] == 1) {  ?>
  <tr>
    <td class='text_grey'>&nbsp;</td>
    <td class='text_grey'><?php echo $BL->props->lang['Domain_Reg_Id']; ?></td>
    <td class='text_grey' colspan='4'><?php echo "<font color='skyblue'><b>".$REQUEST['dom_reg_result']."</b></font> (".ucfirst($REQUEST['dom_registrar']).")"; ?></td>
  </tr>
  <?php }elseif($REQUEST['dom_reg_type'] == 1){ ?>
  <form name='form3' id='form3' method='post' action='<?php echo $PHP_SELF; ?>'>
  <tr>
    <td class='text_grey'>&nbsp;</td>
    <td class='text_grey'><?php echo $BL->props->lang['Domain']." ".$BL->props->lang['Status']; ?></td>
    <td class='text_grey'><font color='red'><b><?php  echo $BL->props->lang['not_registered']; ?></b></font></td>
    <td class='text_grey'><?php echo $BL->props->lang['register_with']; ?></td>
    <td class='text_grey'>
    <?php $REQUEST['registrar'] = $BL->registerDomain($REQUEST['domain_name'], $REQUEST['sub_id'], "true"); ?>
    <select name='registrar' class='search'>
    <option value='manual'><?php echo $BL->props->lang['manual']; ?></option>
    <?php
    foreach($BL->dr as $registrar){
        if($BL->dr_vals[$registrar]['active']=="yes"){
    ?>
    <option value='<?php echo $registrar; ?>' <?php if($REQUEST['registrar']==$registrar) echo "selected"; ?>><?php echo ucfirst($registrar); ?></option>
    <?php } } ?>
    </select>
    </td>
    <td class='text_grey'>
    <input type="hidden" name='action' value="register_domain" />
    <input type="hidden" name="cmd" value="<?php echo $cmd; ?>" />
    <input type="hidden" name="domain_name" value="<?php echo $REQUEST['domain_name']; ?>" />
    <input type="hidden" name="sub_id" value="<?php echo $REQUEST['sub_id']; ?>" />
    <input type="submit" name="submit1" value="<?php echo $BL->props->lang['Update']; ?>" class="search1" />
    </td>
  </tr>
  </form>
  <?php } ?>
  <?php if(!empty($REQUEST['product_id']) && !empty($order_product['acc_method'])){ ?>
  <form name='form2' id='form2' method='post' action='<?php echo $PHP_SELF; ?>'>
  <tr>
    <td class='text_grey'>&nbsp;</td>
    <td class='text_grey'><?php echo $BL->props->lang['Account_Status']; ?></td>
    <td class='text_grey'>
    <font color='<?php echo $txt_color; ?>'>    <b><?php  echo empty($REQUEST['acct_status'])?'':$BL->props->lang[$BL->props->order_status[$REQUEST['acct_status']]]; ?></b></font>
    </td>
    <td class='text_grey'>
    <?php echo $BL->props->lang['Change_status_to']; ?>
    </td>
    <td class='text_grey'>
     <select name='status_action' id='status_action' class='search'>
     <option value="<?php echo $action; ?>" "selected"><?php echo $action_txt; ?></option>
     <option value="_<?php echo $action; ?>"><?php echo $BL->props->lang['Mark']." ".$action_txt; ?></option>
     <option value="kill"><?php echo $BL->props->lang['Kill_Account']; ?></option>
     </select>
     </td>
    <td class='text_grey'>
    <input type="hidden" name='action' value="change_status" />
    <input type="hidden" name="cmd" value="<?php echo $cmd; ?>" />
    <input type="hidden" name="sub_id" value="<?php echo $REQUEST['sub_id']; ?>" />
    <input type="submit" name="submit1" value="<?php echo $BL->props->lang['Update']; ?>" class="search1" />
    </td>
  </tr>
  </form>
  <?php } ?>
    <tr>
      <td colspan="6" class="text_grey">
      <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
      </td>
    </tr>
</table>
</td>
</tr>
</table>
<br />
<?php } ?>
