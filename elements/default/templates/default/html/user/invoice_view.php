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
var tabs = ["tab1"];
var t    = ["t1"];
<?php echo (isset($payment_method)&&isset($BL->pg_validate[$payment_method]))?$BL->pg_validate[$payment_method]:''; ?>
</script>
<!--tabs//-->
<div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['Invoice']; ?></div>
<div class="tab_separator">&nbsp;</div>
<div class="tabs" name='t2' id='t2'><a href='info.php?cmd=VPDF&invoice_no=<?php echo $invoice['invoice_no']; ?>' target='_blank'><?php echo $BL->props->lang['PDF']; ?></a></div>
<div class="tab_separator">&nbsp;</div>
<div class="tabs" name='t2' id='t2'><a href='info.php?cmd=PDF&invoice_no=<?php echo $invoice['invoice_no']; ?>' target='_blank'><?php echo $BL->props->lang['Download_PDF']; ?></a></div>
<div class="tab_separator">&nbsp;</div>
<div class="tabs" name='t4' id='t4'><a href='info.php?cmd=PRINT&invoice_no=<?php echo $invoice['invoice_no']; ?>' target='_blank'><?php echo $BL->props->lang['Print']; ?></a></div>
<div class="tab_separator">&nbsp;</div>
<div>
<div id="tab1" name="tab1" class="tabContent" style="display:none">
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<tr>
 <td colspan='2'>
 <?php echo $html_buffer; ?>
 </td>
</tr>
<tr>
   <td colspan='2' >
   <?php echo $BL->props->lang['the_invoice_is']." ".($invoice['status']); ?>. <?php echo $BL->props->lang['If_u_have']; ?><a href='mailto:<?php echo $conf['comp_email']; ?>' class='accountlabPlanLink'><?php echo $BL->props->lang['contactus']; ?>.</a>
   </td>
</tr>
<tr>
   <td colspan='2' ><hr></td>
</tr>
</table>
<!--pay invoice section //-->
<?php if(($invoice['status']==$BL->props->invoice_status[0]) || ($invoice['status']==$BL->props->invoice_status[5])){ ?>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
<form action="<?php echo $PHP_SELF; ?>" method="post" name='pay_form1' id='pay_form1'>
<tr>
    <td colspan='2' >
    <b><?php echo $BL->props->lang['payment_options']; ?></b>
    </td>
</tr>
<tr>
    <td height='18' colspan='2' >&nbsp;</td>
</tr>
<tr>
    <td colspan='2' >
    <select name='pp' id='pp' class='accountlabInput' onchange="javascript:this.form.submit();">
    <?php foreach($BL->pg as $k=>$v){ ?>
    <?php if($BL->pp_active[$v]=="Yes"){ ?>
    <option value='<?php echo $v; ?>' <?php if($v==$invoice['payment_method'])echo "selected=\"selected\""; ?>><?php echo $BL->pg_name[$v]; ?></option>
    <?php } ?>
    <?php } ?>
    </select>
    </td>
</tr>
<input type="hidden" name="cmd" id="cmd" value="pay" />
<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $REQUEST['invoice_no']; ?>" />
</form>
<form action="<?php echo $post_url; ?>" method="<?php echo ($send_method=="DIRECT")?"POST":$send_method; ?>" name='pay_form2' id='pay_form2'>
<tr>
<tr>
    <td height='18' colspan='2' >&nbsp;</td>
</tr>
<?php if($show_add_curr=="Yes"){ ?>
<tr>
    <td  colspan='2'>
        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td colspan='4'>
            <b><?php echo $BL->props->lang['you_can_pay_by_add_cur']; ?></b>
            </td>
        </tr>
        <tr><td colspan='4'>&nbsp;</td></tr>
        <tr>
            <td width="2%">
            <input type='radio' name='pay_curr_id' id='pay_curr_id' value='0' <?php if(empty($invoice['pay_curr_name']) || $conf['curr_name']==$invoice['pay_curr_name'])echo "checked=\"checked\""; ?> class='accountlabinput' />
            </td>
            <td>
            <?php echo $BL->props->lang['Total_amount_in'].$conf['curr_name']; ?>
            </td>
            <td align='right'>
            <?php echo $BL->toCurrency($REQUEST['gross_amount'],null,1); ?>
            </td>
            <td>&nbsp;</td>
         </tr>
         <?php
         if(count($add_cur)){ foreach($add_cur as $ac){
                $curr_conf                    = array();
                $curr_conf['symbol_prefixed'] = $ac['curr_symbol_prefixed'];
                $curr_conf['symbol']          = $ac['curr_symbol'];
                $curr_conf['decimals']        = $ac['curr_decimal_number'];
                $curr_conf['str1']            = $ac['curr_decimal_str'];
                $curr_conf['str2']            = $ac['curr_thousand_str'];
         ?>
         <tr>
            <td width="2%">
            <input type='radio' name='pay_curr_id' id='pay_curr_id' value='<?php echo $ac['curr_id'] ?>' <?php if($ac['curr_name']==$invoice['pay_curr_name'])echo "checked=\"checked\""; ?> class='accountlabinput' />
            </td>
            <td>
            <?php echo $BL->props->lang['Total_amount_in'].$ac['curr_name']; ?>
            </td>
            <td align='right'>
            <?php echo $BL->toCurrency($REQUEST['gross_amount']*$ac['curr_factor'],$curr_conf,1); ?>
            </td>
            <td>&nbsp;</td>
          </tr>
          <?php } } ?>
          <tr><td colspan='4'>&nbsp;</td></tr>
          </table>
    </td>
</tr>
<?php } ?>
<tr>
    <td colspan='2' >
          <table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
             <td colspan='4'><?php echo $disp_msg; ?></td>
          </tr>
          <?php if(count($add_fields)>0){ ?>
          <tr><td colspan='4'>&nbsp;</td></tr>
          <?php foreach($add_fields as $field){ ?>
          <tr>
              <td>
                 <?php echo $BL->props->lang[$field[0]]; ?><?php if($field[6]==1){?><font color="red">*</font><?php } ?>
              </td>
              <td>
                 <?php if($field[4]=="text"){ ?>
                 <input name="<?php echo $field[1]; ?>" type="text" id="<?php echo $field[1]; ?>" <?php if ($field[3]==0) {?>value="<?php echo $ext_fields[$field[1]]; ?>"<?php } ?> size="<?php echo $field[5]; ?>" class='accountlabInput' />
                 <?php }elseif($field[4]=="select"){ ?>
                 <select name="<?php echo $field[1]; ?>" id="<?php echo $field[1]; ?>" class='accountlabInput' size="<?php echo $field[5]; ?>">
                 <?php for($i=8;$i<count($field);$i++){ ?>
                    <option value='<?php echo $field[$i]; ?>' <?php if($ext_fields[$field[1]]==$field[$i] && $field[3]==0)echo "selected=\"selected\""; ?>><?php echo $field[$i]; ?></option>
                 <?php } ?>
                 <?php $_SESSION[$field[1]]=$field[8];?>
                 </select>
                 <?php } ?>
              </td>
           </tr>
           <?php } ?>
           <tr><td colspan='4'>&nbsp;</td></tr>
           <?php } ?>
           </table>
    </td>
</tr>
<tr>
    <td colspan='2' >
    <?php if($post_url==INSTALL_URL."customer.php"){ ?>
    <input type="hidden" name="cmd" id="cmd" value="pay" />
    <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $REQUEST['invoice_no']; ?>" />
    <input type="hidden" name="payment_method" id="payment_method" value="<?php echo $payment_method; ?>" />
    <?php } ?>
    <?php echo $post_vars; ?>
    <?php if(!empty($BL->pg_name[$payment_method])) { ?>
    <input type="submit" class='accountlabInput' name="alp_pay_now" id='alp_pay_now' value="<?php echo $BL->pg_submitlabel[$payment_method]; ?>" onclick="return validatepayment(this);"/>
    <?php } ?>
    </td>
</tr>
<tr>
    <td height='18' colspan='2' >&nbsp;</td>
</tr>
</form>
<?php } ?>
</table>
</div>
</div>
<script language="JavaScript" type="text/javascript">
  showTab('tab1', tabs, 't1', t);
</script>
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/footer.php"); ?>
