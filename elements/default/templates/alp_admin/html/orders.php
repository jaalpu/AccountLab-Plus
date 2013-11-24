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

<?php include_once $BL->props->get_page("templates/alp_admin/html/header.php");?>
<div id="content">
    <div id="display_list">
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=vieworders" class="add_link"><?php echo $BL->props->lang['^orders']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs" name='tt3' id='tt3' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=orphan_orders" class="add_link"><?php echo $BL->props->lang['~orphan_orders']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
    <div id="display_list">
    <?php include_once $BL->props->get_page("templates/alp_admin/html/_auto_create_order.php");?>
    <form name='form1' id='form1' method='POST' action="<?php echo $PHP_SELF; ?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
           <tr> 
               <td colspan='2' class="tdheading">
               <b>&nbsp;</b>
               </td>
           </tr>
           <tr> 
                <td class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Customer']; ?>
                </div>
                <div id="form1_field">
                <select name='customer_id' id='customer_id' class='search'>
                <?php foreach($Customers as $Customer){ ?>
                    <?php if ($cmd != "editorder" || $REQUEST['customer_id']==$Customer['id']){ ?>
                    <option value='<?php echo $Customer['id']; ?>' <?php echo ((isset($REQUEST['customer_id']) && $REQUEST['customer_id']==$Customer['id']) || (isset($REQUEST['id']) && $REQUEST['id']==$Customer['id']))?"selected":"";?>><?php echo $BL->getCustomerFieldValue("name",$Customer['id'])." {".$Customer['email']."}"; ?></option>
                    <?php } ?>
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
                <td class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['category']; ?>
                </div>
                <div id="form1_field">
                <select name='group_id' id='group_id' class='search' onchange="javascript:jumpMenu('1');">
                <option value='0'><?php if($show_tlds){echo $BL->props->lang['Register_a_domain_only'];}else{echo $BL->props->lang['select'];} ?></option>
                <?php 
					$BL->groups->setOrder("group_index");
					foreach($BL->groups->find() as $Groups){
				?>
                    <option value='<?php echo $Groups['group_id']; ?>' <?php echo (isset($REQUEST['group_id']) && $REQUEST['group_id']==$Groups['group_id'])?"selected":"";?>><?php echo $Groups['group_name']; ?></option>
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
           
           <tbody id="product_selector" name="product_selector" class='<?php echo (!isset($REQUEST['group_id']) || empty($REQUEST['group_id']))?"off":"on" ?>'>
           <tr> 
                <td class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['Plan']; ?>
                </div>
                <div id="form1_field">
                <select name='product_id' id='product_id' class='search' onchange="javascript:jumpMenu('2');">
                <option><?php echo $BL->props->lang['select']; ?></option>
                <?php if(isset($REQUEST['group_id']) && !empty($REQUEST['group_id'])){ ?>
                <?php foreach($Products as $P){ ?>
                <?php $Product = $BL->products->getByKey($P); ?>
                    <option value='<?php echo $Product['plan_price_id']; ?>' <?php echo (isset($REQUEST['product_id']) && $REQUEST['product_id']==$Product['plan_price_id'])?"selected":"";?>><?php echo $BL->getFriendlyName($Product['plan_price_id'])."@".$BL->toCurrency($Product['host_setup_fee'], null, 1); ?></option>
                <?php } ?>
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

            <?php if(isset($REQUEST['product_id']) && !empty($REQUEST['product_id'])){ ?>
            <tr> 
              <td class='text_grey'>
              <div align='center'>
              <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
              </div>
              </td>
              <td class='text_grey'>
              <div id="form1_label">
              <?php echo $BL->props->lang['server']; ?>
              </div>
              <div id="form1_field">
              <select name="server_id" id="server_id" class="search" onchange="javascript:jumpMenu('3');">
              <option value="0"><?php echo $BL->props->lang['Default_Server']; ?></option>
              <?php foreach($Servers as $Server){ ?>
              <option value="<?php echo $Server['server_id']; ?>" <?php echo (isset($REQUEST['server_id']) && $REQUEST['server_id']==$Server['server_id'])?"selected":"";?>><?php echo $Server['server_name']; ?></option>
              <?php } ?>
              </div>
              </td>
            </tr>



            <tr> 
              <td colspan='2' class='text_grey'>
              <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
              </td>
            </tr>
            <tr> 
              <td class='text_grey'>
              <div align='center'>
              <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
              </div>
              </td>
              <td class='text_grey'>
              <div id="form1_label">
              <?php echo $BL->props->lang['server_ip']; ?>
              </div>
              <div id="form1_field">
              <select name="ip_id" id="ip_id" class="search">
              <option value="0"><?php echo $BL->props->lang['Default_IP']; ?></option>
              <?php foreach($Ips as $Ip){ ?>
              <option value="<?php echo $Ip['ip_id']; ?>" <?php echo (isset($REQUEST['ip_id']) && $REQUEST['ip_id']==$Ip['ip_id'])?"selected":"";?>><?php echo $Ip['ip']; ?></option>
              <?php } ?>
              </div>
              </td>
            </tr>

            <tr> 
              <td colspan='2' class='text_grey'>
              <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
              </td>
            </tr>
           <tr> 
                <td class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $BL->props->lang['pay_cycle']; ?>
                </div>
                <div id="form1_field">
                <select name='bill_cycle' id='bill_cycle' class='search'>
                <option><?php echo $BL->props->lang['select']; ?></option>
                <?php foreach($Bill_Cycles as $Cycle_name=>$Bill_Cycle_Amount){ ?>
                    <option value='<?php echo $BL->billing_cycles->getCycleMonthFromCycleName($Cycle_name); ?>' <?php echo (isset($REQUEST['bill_cycle']) && $REQUEST['bill_cycle']==$BL->billing_cycles->getCycleMonthFromCycleName($Cycle_name))?"selected":"";?>><?php echo $BL->props->parseLang($Cycle_name)."@".$BL->toCurrency($Bill_Cycle_Amount, null, 1); ?></option>
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
            
           <?php foreach($Addons as $addon_id){ ?> 
           <?php
           $Addon['addon_id'] = $addon_id;
           $addon_data  = $BL->addons->getByKey($Addon['addon_id']);
           $addon_cycle = $BL->addons->getCycles($Addon['addon_id']);
           $date        = $BL->utils->getDateArray(isset($addon_activation_dates[$Addon['addon_id']])?$addon_activation_dates[$Addon['addon_id']]:date('Y-m-d'));
           ?>
           <tr> 
                <td class='text_grey'>
                <div align='center'>
                <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
                </div>
                </td>
                <td class='text_grey'>
                <div id="form1_label">
                <?php echo $addon_data['addon_name']; ?>
                </div>
                <div id="form1_field">
                <input type="checkbox" name='addon_ids[]' id='addon_<?php echo $addon_data['addon_id']; ?>' class='search' value='<?php echo $addon_data['addon_id']; ?>' <?php if(isset($addon_ids) && array_search($addon_data['addon_id'],$addon_ids)!==false)echo "checked"; ?> />
                <?php echo $BL->props->lang['active_from']; ?>
                <?php echo $BL->utils->datePicker($date['mday'], $date['mon'], $date['year'], "search", "_[".$addon_data['addon_id']."]"); ?>
                </select>
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
            </tbody>


           <tbody id="domain_selector" name="domain_selector" class='<?php echo ($show_owndomain || $show_subdomains || $show_tlds)?"on":"off"; ?>'>
           <tr> 
           <td class='text_grey' valign='top' width='1%'>
               <div align='center'>
               <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
               </div>
           </td>
           <td>
               <div id="form1_label">
               <?php echo $BL->props->lang['domain_type']; ?>
               </div>
               <div id="form1_field">
               <select name='dom_reg_type' id='dom_reg_type' class='search' onchange="javascript:toggleTbodyOff('whoisresult_div');toggleTbodyOff('dom_reg_type_0');toggleTbodyOff('dom_reg_type_1');toggleTbodyOff('dom_reg_type_2');if(this.selectedIndex!=0)toggleTbodyOn('dom_reg_type_'+this.options[this.selectedIndex].value);"> 
               <option><?php echo $BL->props->lang['select']; ?></option>
               <?php if($show_owndomain){ ?><option value='0' <?php if(isset($REQUEST['dom_reg_type']) && $REQUEST['dom_reg_type']==0)echo "selected"; ?>><?php echo $BL->props->lang['Owndomain']; ?></option><?php } ?>
               <?php if($show_tlds){ ?><option value='1' <?php if(isset($REQUEST['dom_reg_type']) && $REQUEST['dom_reg_type']==1)echo "selected"; ?>><?php echo $BL->props->lang['Newdomain']; ?></option><?php } ?>
               <?php if($show_subdomains){ ?><option value='2' <?php if(isset($REQUEST['dom_reg_type']) && $REQUEST['dom_reg_type']==2)echo "selected"; ?>><?php echo $BL->props->lang['Subdomain']; ?></option><?php } ?>
               </select>
               </div>
           </td>
           </tr>
           <tr> 
               <td colspan='2' class='text_grey'>
               <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
               </td>
           </tr>
           </tbody>
           <tbody id="dom_reg_type_0" name="dom_reg_type_0" class='<?php if(isset($REQUEST['dom_reg_type']) && $REQUEST['dom_reg_type']==0)echo "on";else echo "off"; ?>'>
           <tr> 
           <td class='text_grey' valign='top' width='1%'>
               <div align='center'>
               <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
               </div>
           </td>
           <td>
               <div id="form1_label">
               <?php echo $BL->props->lang['Owndomain']; ?>
               </div>
               <div id="form1_field">
               <input name='sld_0' id='sld_0' type='text' class='search'  size='30' value='<?php if(isset($domain_array[0]))echo $domain_array[0]; ?>' />
               .
               <input name='tld_0' id='tld_0' type='text' class='search'  size='5' value='<?php if(isset($domain_array[1]))echo $domain_array[1]; ?>' />               
               </div>
           </td>
           </tr>
           </tbody>
           <tbody id="dom_reg_type_1" name="dom_reg_type_1" class='<?php if(isset($REQUEST['dom_reg_type']) && $REQUEST['dom_reg_type']==1)echo "on";else  echo "off"; ?>'>
           <tr> 
           <td class='text_grey' valign='top' width='1%'>
               <div align='center'>
               <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
               </div>
           </td>
           <td>
               <div id="form1_label">
               <?php echo $BL->props->lang['Domain']; ?>
               </div>
               <div id="form1_field">
               <input name='sld_1' id='sld_1' type='text' class='search'  size='30'  value='<?php if(isset($domain_array[0]))echo $domain_array[0]; ?>' />
               .
               <select name='tld_1' id='tld_1' class='search'  size='1'>
               <?php foreach($BL->tlds->getAvailable() as $tld){ ?>
                    <option value='<?php echo $tld['dom_ext']; ?>' <?php if(isset($domain_array[1]) && $domain_array[1]==$tld['dom_ext'])echo "selected"; ?>><?php echo $tld['dom_ext']; ?></option>
               <?php } ?>
               </select>
               <select name='dom_reg_year' id='dom_reg_year' class='search'>
               <?php for($i=1;$i<11;$i++){ ?>
               <option value='<?php echo $i; ?>' <?php if(isset($REQUEST['dom_reg_year']) && $REQUEST['dom_reg_year']==$i)echo "selected"; ?>><?php echo $i." ".$BL->props->lang['year']; ?></option>
               <?php } ?>
               <option value='99' <?php if(isset($REQUEST['dom_reg_year']) && $REQUEST['dom_reg_year']==99)echo "selected"; ?> ><?php echo $BL->props->lang['one_time']; ?></option>
               </select>
               <input type="button" class='search1' name="Button1" id="Button1" value="<?php echo $BL->props->lang['check']; ?>" onclick="javascript:whoisQuery(getObj('sld_1','form1').value,getObj('tld_1','form1').options[getObj('tld_1','form1').selectedIndex].value,1);" />
               </div>
           </td>
           </tr>
           </tbody>
           <tbody id="dom_reg_type_2" name="dom_reg_type_2" class='<?php if(isset($REQUEST['dom_reg_type']) && $REQUEST['dom_reg_type']==2)echo "on";else echo "off"; ?>'>
           <tr> 
           <td class='text_grey' valign='top' width='1%'>
               <div align='center'>
               <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
               </div>
           </td>
           <td>
               <div id="form1_label">
               <?php echo $BL->props->lang['Subdomain']; ?>
               </div>
               <div id="form1_field">
               <input name='sld_2' id='sld_2' type='text' class='search'  size='30' value='<?php if(isset($domain_array[0]))echo $domain_array[0]; ?>' />
               .
               <select name='tld_2' id='tld_2' class='search'  size='1'>
               <?php foreach($BL->subdomains->getAvailable() as $subdomains){ ?>
                    <option value='<?php echo $subdomains['maindomain']; ?>' <?php if(isset($domain_array[1]) && $domain_array[1]==$subdomains['maindomain'])echo "selected"; ?>><?php echo $subdomains['maindomain']; ?></option>
               <?php } ?>
               </select>
               <input type="button" class='search1' name="Button2" id="Button2" value="<?php echo $BL->props->lang['check']; ?>" onclick="javascript:whoisQuery(getObj('sld_2','form1').value,getObj('tld_2','form1').options[getObj('tld_2','form1').selectedIndex].value,2);" />
               </div>
           </td>
           </tr>
           </tbody>
           
           <tbody id="whoisresult_div" name="whoisresult_div" class='off'>
           <tr> 
               <td class='text_grey'></td>
               <td class='text_grey'>
               <span id="whoisresult">&nbsp;</span>
               </td>
           </tr>
           </tbody>
           <tr> 
               <td colspan='2' class='text_grey'>
               <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
               </td>
           </tr>
           
           
        <tr> 
          <td class='text_grey' valign='top' width='1%'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
           <?php echo $BL->props->lang['username']; ?>
          </div>
          <div id="form1_field">
           <input name='dom_user' type='text' class='search' id='dom_user' size='20' value='<?php echo $REQUEST['dom_user']; ?>' />
          </div>
          </td>
        </tr>
           <tr> 
               <td colspan='2' class='text_grey'>
               <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
               </td>
           </tr>
          
        <tr> 
          <td class='text_grey' valign='top' width='1%'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
           <?php echo $BL->props->lang['password']; ?>
          </div>
          <div id="form1_field">
           <input name='dom_pass' type='text' class='search' id='dom_pass' size='20' value='<?php if($cmd=="editorder") echo $BL->utils->alpencrypt->decrypt($REQUEST['dom_pass'], $BL->props->encryptionKey);else echo $REQUEST['dom_pass']; ?>' />
          </div>
          </td>
        </tr>
           <tr> 
               <td colspan='2' class='text_grey'>
               <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
               </td>
           </tr>
           
           
           
          
        <tr> 
          <td class='text_grey' valign='top' width='1%'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
           <?php echo $BL->props->lang['Order_Status']; ?>
          </div>
          <div id="form1_field">
          <select name='cust_status' id='cust_status' class='search'>
          <?php foreach ($BL->props->order_status as $key => $value){ ?>
          <option value="<?php echo $value; ?>" <?php if($cmd=="editorder" && $REQUEST['cust_status']==$value) echo "selected"; ?>><?php echo $BL->props->lang[$value]; ?></option>
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
          <td class='text_grey' valign='top' width='1%'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
           <?php echo $BL->props->lang['signup']; ?>
          </div>
          <div id="form1_field">
           <?php $date=$BL->utils->getDateArray(isset($REQUEST['sign_date'])?$REQUEST['sign_date']:date('Y-m-d')); ?>
           <?php echo $BL->utils->datePicker($date['mday'], $date['mon'], $date['year'], "search"); ?>
          </div>
          </td>
        </tr>
           
        <?php if($cmd=="addorder"){ ?>
        <tr> 
          <td colspan='2' class='text_grey'>
          <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
          </td>
        </tr>
        <tr> 
          <td class='text_grey'>
          <div align='center'>
          <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
          </div>
          </td>
          <td class='text_grey'>
          <div id="form1_label">
          <?php echo $BL->props->lang['Create_intermediate_invoices']; ?>
          </div>
          <div id="form1_field">
          <select name="gen_intermediate" id="gen_intermediate" class="search">
          <option value="0"><?php echo $BL->props->lang['No']; ?></option>
          <option value="1"><?php echo $BL->props->lang['Yes']; ?></option>
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
          <td class='text_grey'>
          <div align='center'>
          <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
          </div>
          </td>
          <td class='text_grey'>
          <div id="form1_label">
          <?php echo $BL->props->lang['Mark_intermediate_invoice_as']; ?>
          </div>
          <div id="form1_field">
          <select name="mark_as" id="mark_as" class="search">
          <option value="<?php echo $BL->props->invoice_status[1]; ?>"><?php echo $BL->props->lang[$BL->props->invoice_status[1]]; ?></option>
          <option value="<?php echo $BL->props->invoice_status[0]; ?>"><?php echo $BL->props->lang[$BL->props->invoice_status[0]]; ?></option>
          <option value="<?php echo $BL->props->invoice_status[2]; ?>"><?php echo $BL->props->lang[$BL->props->invoice_status[2]]; ?></option>
          <option value="<?php echo $BL->props->invoice_status[3]; ?>"><?php echo $BL->props->lang[$BL->props->invoice_status[3]]; ?></option>
          </select>
          </div>
          </td>
        </tr>
        <?php } ?>
        <tr> 
          <td colspan='2' class='text_grey'>
          <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
          </td>
        </tr>
        <tr> 
          <td class='text_grey'>
          <div align='center'>
          <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
          </div>
          </td>
          <td class='text_grey'>
          <div id="form1_label">
          <?php echo $BL->props->lang['Payment_processor']; ?>
          </div>
          <div id="form1_field">
              <select name='pay_proc' id='pay_proc' class='search' >
                <?php
                  foreach ($BL->pg as $key => $value) {
                      if ($BL->pp_active[$value] == "Yes") {
                  ?>
                      <option value='<?php echo $value; ?>' <?php if(isset($REQUEST['pay_proc']) && $REQUEST['pay_proc']==$value)echo "selected"; ?>><?php echo $BL->pg_name[$value]; ?></option>
                <?php 
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
          <td valign='top' class='text_grey'></td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
          <?php if($cmd=="editorder"){ ?>
            <input name='sub_id' type='hidden' value='<?php echo $REQUEST['sub_id']; ?>' />
          <?php } ?>
           <input name='cmd' type='hidden' value='<?php echo $cmd; ?>' />
          </div>
          <div id="form1_field">
           <input name='submit' type='submit' class='search1' value='<?php echo ($cmd=="editorder")?$BL->props->lang['Update']:$BL->props->lang['add']; ?>' />
          </div>
          </td>
        </tr>
           
        </table>
        </form>
	</div>
</div>
<!--end content -->
<div id="navBar">
<?php if($cmd=="editorder"){ ?>
<table width="80%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan='2' class='text_grey'>
            <a href='<?php echo $PHP_SELF; ?>?cmd=<?php echo $cmd; ?>&action=welcomemail&sub_id=<?php echo $REQUEST['sub_id']; ?>'>
            <b><?php echo $BL->props->lang['Send_Welcome_Mail']; ?></b>
            </a>
		</td>
	</tr>
	<tr> 
		<td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen.jpg' width='180' height='2' />
		</td>
	</tr>
    <tr>
        <td colspan='2' class='text_grey'>
            <a href='<?php echo $PHP_SELF; ?>?cmd=<?php echo $cmd; ?>&action=activationmail&sub_id=<?php echo $REQUEST['sub_id']; ?>'>
            <b><?php echo $BL->props->lang['Send_Activation_Mail']; ?></b>
            </a>
        </td>
    </tr>
    <tr> 
        <td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen.jpg' width='180' height='2' />
        </td>
    </tr>	
    <tr>
        <td colspan='2' class='text_grey'>
            <a href='<?php echo $PHP_SELF; ?>?cmd=<?php echo $cmd; ?>&action=suspensionmail&sub_id=<?php echo $REQUEST['sub_id']; ?>'>
            <b><?php echo $BL->props->lang['Send_Suspension_Mail']; ?></b>
            </a>
        </td>
    </tr>
    <tr> 
        <td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen.jpg' width='180' height='2' />
        </td>
    </tr>
    </table>
<?php } ?>
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
