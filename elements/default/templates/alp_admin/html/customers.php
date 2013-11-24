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
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=viewcustomers" class="add_link"><?php echo $BL->props->lang['^customers']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
    <div id="display_list">
    <form name='form1' id='form1' method='POST' action="<?php echo $PHP_SELF; ?>">
    <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class="list_table">
        <tr> 
            <td colspan='2' class="tdheading">
                &nbsp;
            </td>
        </tr>
        <tr> 
            <td colspan='2' class="text_grey">
                <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
            </td>
        </tr>
        <?php if (isset($err) && !empty($err)) { ?>
        <tr> 
            <td colspan='2' class="text_grey" height="30">
                <font color="red"><b><?php echo $err; ?></b></font>
            </td>
        </tr>
        <tr> 
            <td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
            </td>
        </tr> 
        <?php } ?>
        <tr> 
          <td class='text_grey' valign='top' width='1%'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
           <?php echo $BL->props->lang['signup']; ?><font color='red'>*</font> 
          </div>
          <div id="form1_field">
           <?php echo $BL->utils->datePicker($date, $month, $year, "search"); ?>
          </div>
          </td>
        </tr>
        <tr> 
            <td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
            </td>
        </tr> 
        <tr> 
          <td class='text_grey' valign='top'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
            <?php echo $BL->props->lang['Email']; ?><font color='red'>*</font>         
          </div>
          <div id="form1_field">
              <input name='email' id='email' type='text' class='search' size='45' value="<?php echo isset($REQUEST['email'])?$REQUEST['email']:""; ?>" />   
          </div>
          </td>
        </tr>
        <tr> 
            <td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
            </td>
        </tr> 
        <tr> 
          <td class='text_grey' valign='top'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
          <?php echo $BL->props->lang['Password']; ?><font color='red'>*</font>       
          </div>
          <div id="form1_field">
              <input name='password1' id='password1' type='password' class='search' size='10' />
          </div>
          </td>
        </tr>
        <tr> 
            <td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
            </td>
        </tr> 
        <tr> 
          <td class='text_grey' valign='top'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'> 
          <div id="form1_label">
            <?php echo $BL->props->lang['password_confirm']; ?><font color='red'>*</font>
          </div>
          <div id="form1_field">
              <input name='password2' id='password2' type='password' class='search' size='10' />
          </div>
          </td>
        </tr>
        <tr> 
            <td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
            </td>
        </tr> 
        
<?php 
foreach($custom_fields as $cf){ 
    if($cf['field_name']!="country" && $cf['field_name']!="state" && $cf['field_name']!="vat_no"){
?>
        <tr> 
          <td class='text_grey' valign='top'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
            <?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?>
          </div>
          <div id="form1_field">
          <?php if($cf['field_type']=="text"){ ?>
             <input name='<?php echo $cf['field_name']; ?>' id='<?php echo $cf['field_name']; ?>' type='text' class='search' size='25' value="<?php echo isset($REQUEST[$cf['field_name']])?$REQUEST[$cf['field_name']]:""; ?>"  />
          <?php }else{ ?>
            <select name='<?php echo $cf['field_name']; ?>' id='<?php echo $cf['field_name']; ?>' class='search'>
            <?php 
            $values = $BL->utils->Get_Trimmed_Array(explode(",",$cf['field_value'])); 
            $BL->utils->Remove_Empty_Elements($values);
            foreach($values as $value){
            ?>
            <option value='<?php echo $value; ?>' <?php if(isset($REQUEST[$cf['field_name']]) && $REQUEST[$cf['field_name']]==$value)echo "selected"; ?>><?php echo $BL->props->parseLang($value); ?></option>
            <?php
            }
            ?>
            </select>
          <?php } ?>
          </div>
          </td>
        </tr>
    <?php }elseif($cf['field_name']=="country"){ ?>
        <tr> 
          <td class='text_grey' valign='top'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
            <?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?>
          </div>
          <div id="form1_field">
              <select name='country' id='country' class='search' onblur="javascript:updateStates(this.options[this.selectedIndex].value);">
                <option><?php echo $BL->props->lang['select_country']; ?></option>
                <?php foreach ($BL->props->country as $key => $value) { ?>
                 <option value='<?php echo $key; ?>' <?php if((isset($REQUEST[$cf['field_name']]) && $REQUEST[$cf['field_name']]===$key) || ($REQUEST["cmd"]=="addcustomer" && ($cf['field_value'] === $key || $cf['field_value'] === $value)))echo "selected"; ?> ><?php echo $value; ?></option>
                <?php } ?>
              </select>
          </div>
          </td>
        </tr>
    <?php }elseif($cf['field_name']=="state"){ ?>
        <tr> 
          <td class='text_grey' valign='top'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
            <?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?>
          </div>
          <div id="form1_field">            
			<?php
			if ($REQUEST["cmd"]=="addcustomer")
			{
			  /* If there is a predefined value in the country field, use it to populate the state/province/region field */
			  $country = '';
			  foreach($custom_fields as $cf2){
			    if($cf2['field_name']=="country")
			    {
			      $country = $cf2['field_value'];
			      break;
			    }
			  }
			}
			if (isset($REQUEST['country']))
			{
			  $country = $REQUEST['country'];
			}
			$find = array_search($country, $BL->props->country);
			$country = $find ? $find : $country;

			if (isset($REQUEST[$cf['field_name']]) || (!empty($country) && isset($BL->props->allstates[$country])))
			{ ?>
              <select name='state' id='state' class='search'>
                <option><?php echo $BL->props->lang['select_state']; ?></option>
                <?php foreach ($BL->props->allstates[$country] as $key => $value) { ?>
                 <option value='<?php echo is_numeric($key)?$value:$key; ?>'<?php if ((isset($REQUEST[$cf['field_name']]) && ($REQUEST[$cf['field_name']]===$key || $REQUEST[$cf['field_name']]===$value)) || ($REQUEST["cmd"]=="addcustomer" && ($cf['field_value']===$value || $cf['field_value']===$key))) { echo " selected"; }?>><?php echo $value; ?></option>
                <?php } ?>
              </select>
			<?php
			}
			else
			{
			?>
            <input type='text' size='25' name='state' id='state' class='search'/>
			<?php
			}
			?>
          </div>
          </td>
        </tr> 
    <?php }elseif($cf['field_name']=="vat_no"){ ?>        
        <?php if ($BL->conf['en_vat'] == 1) { ?>
        <tr> 
          <td class='text_grey' valign='top'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
           <?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?>
          </div>
          <div id="form1_field">
           <input name='vat_no' id='vat_no' class='search' type='text'  size='25' value="<?php echo isset($REQUEST['vat_no'])?$REQUEST['vat_no']:""; ?>" />
          </div>
          </td>
        </tr>
        <?php } ?>
    <?php } ?>
        <tr> 
          <td colspan='2' class='text_grey'>
            <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
          </td>
        </tr> 
<?php } ?>
        <tr> 
          <td class='text_grey' valign='top'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18' />
            </div>
          </td>
          <td valign='top' class='text_grey'>
          <div id="form1_label">
           <?php echo $BL->props->lang['trusted']; ?>
          </div>
          <div id="form1_field">
            <select name='trusted' id='trusted' class='search'>
            <option value='1' <?php if(isset($REQUEST['trusted']) && $REQUEST['trusted']==1)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['Yes']; ?></option>
            <option value='0' <?php if(isset($REQUEST['trusted']) && $REQUEST['trusted']==0)echo "selected=\"selected\""; ?>><?php echo  $BL->props->lang['No']; ?></option>
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
          <?php if($cmd=="editcustomers"){ ?>
          <input name='id' type='hidden' value='<?php echo $REQUEST['id']; ?>' />
          <?php } ?>
           <input name='cmd' type='hidden' value='<?php echo $cmd; ?>' />
          </div>
          <div id="form1_field">
           <input name='submit' type='submit' class='search1' value='<?php echo ($cmd=="editcustomers")?$BL->props->lang['Update']:$BL->props->lang['add']; ?>' />
          </div>
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
