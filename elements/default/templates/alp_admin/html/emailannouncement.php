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
      <div class="tabs2" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=savedannounce" class="add_link"><?php echo $BL->props->lang['~savedannounce']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
        <form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>

			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr> 
                      <td colspan="2" class="tdheading">
					  <b>&nbsp;</b>
					  </td>
                    </tr>
					<tr> 
                      <td colspan="2" class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
                    
                      <tr> 
                        <td width='1%' class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['newsletter_to']; ?>
                        </div>
                        <div id="form1_field">                             
                          <select name="customer_1" id="customer_1" size="1" class='search' onchange="javascript:toggleTbodyOff('product_sec');toggleTbodyOff('tld_sec');toggleTbodyOff('sd_sec');toggleTbodyOff('total_sec');toggleTbodyOff('paid_sec');toggleTbodyOff('due_sec');toggleTbodyOff('country_sec');toggleTbodyOff('discount_sec');if(this.value==10)toggleTbodyOn('discount_sec');if(this.value==9)toggleTbodyOn('country_sec');if(this.value==8)toggleTbodyOn('due_sec');if(this.value==7)toggleTbodyOn('paid_sec');if(this.value==6)toggleTbodyOn('total_sec');if(this.value==5)toggleTbodyOn('product_sec');if(this.value==4)toggleTbodyOn('sd_sec');if(this.value==3)toggleTbodyOn('tld_sec');">
                            <option value="0" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['all_customer']; ?></option>
                            <option value="1" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['all_trusted_customer']; ?></option>
                            <option value="2" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='2')?"selected":""; ?>><?php echo $BL->props->lang['all_not_trusted_customer']; ?></option>
                            <option value="3" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='3')?"selected":""; ?>><?php echo $BL->props->lang['based_on_tlds']; ?></option>
                            <option value="4" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='4')?"selected":""; ?>><?php echo $BL->props->lang['based_on_subdomains']; ?></option>
                            <option value="5" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='5')?"selected":""; ?>><?php echo $BL->props->lang['based_on_products']; ?></option>
                            <option value="6" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='6')?"selected":""; ?>><?php echo $BL->props->lang['based_on_total']; ?></option>
                            <option value="7" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='7')?"selected":""; ?>><?php echo $BL->props->lang['based_on_paid']; ?></option>
                            <option value="8" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='8')?"selected":""; ?>><?php echo $BL->props->lang['based_on_due']; ?></option>
                            <option value="9" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='9')?"selected":""; ?>><?php echo $BL->props->lang['based_on_country']; ?></option>
                            <option value="10" <?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='10')?"selected":""; ?>><?php echo $BL->props->lang['based_on_discount']; ?></option>
                          </select>
                          </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>

                      <tbody name='tld_sec' id='tld_sec' class='<?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='3')?"on":"off"; ?>'>
                      <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">                             
                          <select name="tld_1" id="tld_1" size="1" class='search'>
                            <option value="1" <?php echo (isset($BL->REQUEST['tld_1']) && $BL->REQUEST['tld_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['having']; ?></option>
                            <option value="0" <?php echo (isset($BL->REQUEST['tld_1']) && $BL->REQUEST['tld_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['not_having']; ?></option>
                          </select>
                          <select name="tld_2" id="tld_2" size="1" class='search'>
                            <option value="0" <?php echo (isset($BL->REQUEST['tld_2']) && $BL->REQUEST['tld_2']=='0')?"selected":""; ?>><?php echo $BL->props->lang['any']; ?></option>
                            <?php foreach($tlds as $tld) { ?>
                            <option value="<?php echo $tld['dom_ext']; ?>" <?php echo (isset($BL->REQUEST['tld_2']) && $BL->REQUEST['tld_2']==$tld['dom_ext'])?"selected":""; ?>><?php echo $tld['dom_ext']; ?></option>
                            <?php } ?>
                          </select>
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>
                      </tbody>   
                      
                      
                      <tbody name='sd_sec' id='sd_sec' class='<?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='4')?"on":"off"; ?>'>
                      <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">                             
                          <select name="sd_1" id="sd_1" size="1" class='search'>
                            <option value="1" <?php echo (isset($BL->REQUEST['sd_1']) && $BL->REQUEST['sd_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['having']; ?></option>
                            <option value="0" <?php echo (isset($BL->REQUEST['sd_1']) && $BL->REQUEST['sd_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['not_having']; ?></option>
                          </select>
                          <select name="sd_2" id="sd_2" size="1" class='search'>
                            <option value="0" <?php echo (isset($BL->REQUEST['sd_2']) && $BL->REQUEST['sd_2']=='0')?"selected":""; ?>><?php echo $BL->props->lang['any']; ?></option>
                            <?php foreach($subdomains as $subdomain) { ?>
                            <option value="<?php echo $subdomain['maindomain']; ?>" <?php echo (isset($BL->REQUEST['sd_2']) && $BL->REQUEST['sd_2']==$subdomain['maindomain'])?"selected":""; ?>><?php echo $subdomain['maindomain']; ?></option>
                            <?php } ?>
                          </select>
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>
                      </tbody>   
                      
                      
                      <tbody name='product_sec' id='product_sec' class='<?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='5')?"on":"off"; ?>'>
                      <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">                             
                          <select name="product_1" id="product_1" size="1" class='search'>
                            <option value="1" <?php echo (isset($BL->REQUEST['product_1']) && $BL->REQUEST['product_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['having']; ?></option>
                            <option value="0" <?php echo (isset($BL->REQUEST['product_1']) && $BL->REQUEST['product_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['not_having']; ?></option>
                          </select>
                          <select name="product_2" id="product_2" size="1" class='search'>
                            <option value="0" <?php echo (isset($BL->REQUEST['product_2']) && $BL->REQUEST['product_2']=='0')?"selected":""; ?>><?php echo $BL->props->lang['any']; ?></option>
                            <?php foreach($products as $product) { ?>
                            <option value="<?php echo $product['plan_price_id']; ?>" <?php echo (isset($BL->REQUEST['product_1']) && $BL->REQUEST['product_1']==$product['plan_price_id'])?"selected":""; ?>><?php echo $BL->getFriendlyName($product['plan_price_id']); ?></option>
                            <?php } ?>
                          </select>
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>
                      </tbody>   
                      
                      
                      <tbody name='total_sec' id='total_sec' class='<?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='6')?"on":"off"; ?>'>
                      <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">                             
                          <select name="total_1" id="total_1" size="1" class='search'>
                            <option value="1" <?php echo (isset($BL->REQUEST['total_1']) && $BL->REQUEST['total_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['more_than']; ?></option>
                            <option value="0" <?php echo (isset($BL->REQUEST['total_1']) && $BL->REQUEST['total_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['less_than']; ?></option>
                          </select>
                          <input type="text" name="total_2" id="total_2" value="<?php echo isset($BL->REQUEST['total_2'])?$BL->REQUEST['total_1']:"0.00"; ?>" size="10" class="search" />
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>
                      </tbody>                         

                      <tbody name='paid_sec' id='paid_sec' class='<?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='7')?"on":"off"; ?>'>
                      <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">                             
                          <select name="paid_1" id="paid_1" size="1" class='search'>
                            <option value="1" <?php echo (isset($BL->REQUEST['paid_1']) && $BL->REQUEST['paid_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['more_than']; ?></option>
                            <option value="0" <?php echo (isset($BL->REQUEST['paid_1']) && $BL->REQUEST['paid_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['less_than']; ?></option>
                          </select>
                          <input type="text" name="paid_2" id="paid_2" value="<?php echo isset($BL->REQUEST['paid_2'])?$BL->REQUEST['paid_1']:"0.00"; ?>" size="10" class="search" />
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>
                      </tbody>
                      
                      <tbody name='due_sec' id='due_sec' class='<?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='8')?"on":"off"; ?>'>
                      <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">                             
                          <select name="due_1" id="due_1" size="1" class='search'>
                            <option value="1" <?php echo (isset($BL->REQUEST['due_1']) && $BL->REQUEST['due_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['more_than']; ?></option>
                            <option value="0" <?php echo (isset($BL->REQUEST['due_1']) && $BL->REQUEST['due_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['less_than']; ?></option>
                          </select>
                          <input type="text" name="due_2" id="due_2" value="<?php echo isset($BL->REQUEST['due_2'])?$BL->REQUEST['due_1']:"0.00"; ?>" size="10" class="search" />
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>
                      </tbody> 
                      
                      
                      <tbody name='country_sec' id='country_sec' class='<?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='9')?"on":"off"; ?>'>
                      <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">                             
                          <select name="country_1" id="country_1" size="1" class='search'>
                            <option value="1" <?php echo (isset($BL->REQUEST['country_1']) && $BL->REQUEST['country_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['residence_in']; ?></option>
                            <option value="0" <?php echo (isset($BL->REQUEST['country_1']) && $BL->REQUEST['country_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['residence_not_in']; ?></option>
                          </select>
                          <select name="country_2" id="country_2" size="1" class='search'  onblur="javascript:updateNewsletterStates(this.options[this.selectedIndex].value);">
                            <option value="0" <?php echo (isset($BL->REQUEST['country_2']) && $BL->REQUEST['country_2']=='0')?"selected":""; ?>><?php echo $BL->props->lang['any']; ?></option>
                            <?php foreach ($BL->props->country as $key => $value) { ?>
                             <option value='<?php echo $key; ?>' <?php echo (isset($BL->REQUEST['country_2']) && $BL->REQUEST['country_2']==$key)?"selected":""; ?> ><?php echo $value; ?></option>
                            <?php } ?>
                          </select>
                          <select name="country_3" id="country_3" size="1" class='search'>
                            <option value="0" <?php echo (isset($BL->REQUEST['country_3']) && $BL->REQUEST['country_3']=='0')?"selected":""; ?>><?php echo $BL->props->lang['any']; ?></option>
                          </select>
                          <?php if(isset($BL->REQUEST['country_3'])){ ?>
                          <script language="JavaScript" type="text/javascript">updateNewsletterStates('<?php echo $BL->REQUEST['country_3']; ?>');</script>
                          <?php } ?>
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>
                      </tbody>  
                      
                      
                      
                      <tbody name='discount_sec' id='discount_sec' class='<?php echo (isset($BL->REQUEST['customer_1']) && $BL->REQUEST['customer_1']=='10')?"on":"off"; ?>'>
                      <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">                             
                          <select name="discount_1" id="discount_1" size="1" class='search'>
                            <option value="2" <?php echo (isset($BL->REQUEST['discount_1']) && $BL->REQUEST['discount_1']=='2')?"selected":""; ?>><?php echo $BL->props->lang['having_more_than']; ?></option>
                            <option value="1" <?php echo (isset($BL->REQUEST['discount_1']) && $BL->REQUEST['discount_1']=='1')?"selected":""; ?>><?php echo $BL->props->lang['having_equal_to']; ?></option>
                            <option value="0" <?php echo (isset($BL->REQUEST['discount_1']) && $BL->REQUEST['discount_1']=='0')?"selected":""; ?>><?php echo $BL->props->lang['having_less_than']; ?></option>
                          </select>
                          <input type="text" name="discount_2" id="discount_2" value="<?php echo isset($BL->REQUEST['discount_2'])?$BL->REQUEST['discount_2']:"0.00"; ?>" size="10" class="search" />%
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>
                      </tbody> 

                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      
                      <tr> 
                         <td width='1%' class='text_grey'></td>
                         <td class='text_grey'>
                         <div id="form1_label"></div>
                         <div id="form1_field">
                         <?php echo $BL->props->lang['all_dates']; ?>
                         <input type='checkbox' name='all_dates' id='all_dates' <?php echo (isset($BL->REQUEST['all_dates']) && $BL->REQUEST['all_dates']=='1')?"checked":""; ?> value='1' class='search' onchange="javascript:if(this.checked==1)toggleTbodyOff('date_sec');else toggleTbodyOn('date_sec');" />
                         </div>
                         </td>
                      </tr>                      
                      <tr> 
                        <td colspan='2' height='5' class='text_grey'></td>
                      </tr>

                    <tbody name='date_sec' id='date_sec' class='<?php echo (isset($BL->REQUEST['all_dates']) && $BL->REQUEST['all_dates']=='1')?"off":"on"; ?>'>
                    <tr> 
                        <td width='1%' class='text_grey'></td>
                        <td class='text_grey'>
                        <div id="form1_label"></div>
                        <div id="form1_field">
                          <?php $f = $BL->utils->getDateArray((isset($BL->REQUEST['FromDate'])?$BL->REQUEST['FromDate']:'1970-1-1')); ?>
                          <?php $t = $BL->utils->getDateArray((isset($BL->REQUEST['ToDate'])?$BL->REQUEST['ToDate']:date('Y-m-d'))); ?>  
                          <?php echo $BL->props->lang['From']." : ".$BL->utils->datePicker($f['mday'], $f['mon'], $f['year'], "search", "fromD"); ?>
                          <?php echo $BL->props->lang['To']." : ".$BL->utils->datePicker($t['mday'], $t['mon'], $t['year'], "search", "toD"); ?>
                         </div>
                         </td>
                    </tr>
                    </tbody>
                      
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>

                      <tr> 
                        <td width='1%' class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['send_as_html']; ?>
                        </div>
                        <div id="form1_field"> 
                          <select name="send_as_html" id="send_as_html" size="1" class='search' onchange="javascript:if(this.value==1){toggleTbodyOff('body2');toggleTbodyOn('body1');}else{toggleTbodyOn('body2');toggleTbodyOff('body1');}">
                          <option value="0" <?php echo (isset($BL->REQUEST['send_as_html']) && empty($BL->REQUEST['send_as_html']))?"selected":""; ?>>Plain text</option>
                          <option value="1" <?php echo (isset($BL->REQUEST['send_as_html']) && !empty($BL->REQUEST['send_as_html']))?"selected":""; ?>>HTML</option>                            
                          </select>
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr> 

                      <tr> 
                        <td width='1%' class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['save_before_send']; ?>
                        </div>
                        <div id="form1_field"> 
                          <select name="save_before_send" id="save_before_send" size="1" class='search'>
                            <option value="1" <?php echo (isset($BL->REQUEST['newsletter_id']))?"selected":""; ?>><?php echo $BL->props->lang['Yes']; ?></option>
                            <option value="0" <?php echo (!isset($BL->REQUEST['newsletter_id']))?"selected":""; ?>><?php echo $BL->props->lang['No']; ?></option>
                          </select>
                        </div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr> 

                      <tr> 
                        <td width='1%' class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['subject']; ?>
						</div>
						<div id="form1_field"> 
                            <input name='newsletter_subject' id='newsletter_subject' type='text' value='<?php echo isset($BL->REQUEST['newsletter_subject'])?$BL->REQUEST['newsletter_subject']:""; ?>' size='48' class='search' />
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr> 
					  
					  <tbody id='body1' name='body1' class='<?php echo (isset($BL->REQUEST['send_as_html']) && !empty($BL->REQUEST['send_as_html']))?"on":"off"; ?>'>
                      <tr> 
                        <td class='text_grey' valign="top"><div align='center'>
						<img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey' valign="top">
						<div id="form1_label">
						<?php echo $BL->props->lang['message_body']; ?>
						</div>
						<div id="form1_field">
                            <textarea name='newsletter_body1' id='newsletter_body1' cols='55' rows='10'><?php echo isset($BL->REQUEST['newsletter_body'])?$BL->REQUEST['newsletter_body']:""; ?></textarea>
                          </div></td>
                      </tr>
                      </tbody>
                      <tbody id='body2' name='body2' class='<?php echo (!isset($BL->REQUEST['send_as_html']) || empty($BL->REQUEST['send_as_html']))?"on":"off"; ?>'>
                      <tr> 
                        <td class='text_grey' valign="top"><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' /></div></td>
                        <td class='text_grey' valign="top">
                        <div id="form1_label">
                        <?php echo $BL->props->lang['message_body']; ?>
                        </div>
                        <div id="form1_field">
                            <textarea name='newsletter_body2' id='newsletter_body2' class="search" cols='55' rows='10'><?php echo isset($BL->REQUEST['newsletter_body'])?$BL->REQUEST['newsletter_body']:""; ?></textarea>
                          </div></td>
                      </tr>
                      </tbody>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>		


                      <tr> 
                        <td class='text_grey'><div align='center'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						&nbsp;
						</div>
						<div id="form1_field">
                            <input type='hidden' name='newsletter_id' value='<?php echo isset($BL->REQUEST['newsletter_id'])?$BL->REQUEST['newsletter_id']:""; ?>' />
                            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php echo $BL->props->lang['send_announce']; ?>' />
                          </div></td>
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
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
