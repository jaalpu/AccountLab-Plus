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

<tbody name='new_user_sec' id='new_user_sec' class='off'>
<tr> 
    <td>
    <fieldset class='accountlabFormTABLE'>
    <legend><b><?php echo $BL->props->lang['new_customers_sign_up']; ?></b></legend>
	<table width='100%' border='0' cellspacing='0' cellpadding='2' align='center'>
        <tr> 
          <td valign='top' class='accountlabPlanDataTD' width='40%'>
			<?php echo $BL->props->lang['Email']; ?><font color='red'>*</font><br />
		    <span class="smaller"><?php echo $BL->props->lang['this_billing_login']; ?></span>
		  </td>
          <td valign='top' class='accountlabPlanDataTD'>
              <input name='email' id='email' type='text' class='accountlabInput' size='45' />
          </td>
        </tr>
        <tr> 
          <td valign='top' class='accountlabPlanDataTD'>
		  <?php echo $BL->props->lang['Password']; ?><font color='red'>*</font><br />
		  <span class="smaller"><?php echo $BL->props->lang['this_billing_pass']; ?></span>
		  </td>
          <td valign='top' class='accountlabPlanDataTD'>
              <input name='password1' id='password1' type='password' class='accountlabInput' size='10' />
          </td>
        </tr>
        <tr> 
          <td valign='top' class='accountlabPlanDataTD'> 
			<?php echo $BL->props->lang['password_confirm']; ?><font color='red'>*</font>
          </td>
          <td valign='top' class='accountlabPlanDataTD'>
              <input name='password2' id='password2' type='password' class='accountlabInput' size='10' />
          </td>
        </tr>
        <tr> 
          <td valign='top' class='accountlabPlanDataTD'></td>
          <td valign='top' class='accountlabPlanDataTD'></td>
        </tr>
        
<?php 
foreach($custom_fields as $cf){ 
    if($cf['field_name']!="country" && $cf['field_name']!="state" && $cf['field_name']!="vat_no"){
?>
        <tr> 
          <td height='21' valign='top' class='accountlabPlanDataTD'>
			<?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?>
          </td>
          <td valign='top' class='accountlabPlanDataTD'>
          <?php if($cf['field_type']=="text"){ ?>
             <input name='<?php echo $cf['field_name']; ?>' id='<?php echo $cf['field_name']; ?>' type='text' class='accountlabInput' size='25' value="<?php echo $cf['field_value']?>" />
          <?php }else{ ?>
            <select name='<?php echo $cf['field_name']; ?>' id='<?php echo $cf['field_name']; ?>' class='accountlabInput'>
            <?php 
            $values = $BL->utils->Get_Trimmed_Array(explode(",",$cf['field_value'])); 
            $BL->utils->Remove_Empty_Elements($values);
            foreach($values as $value){
            ?>
            <option value='<?php echo $value; ?>'><?php echo $BL->props->parseLang($value); ?></option>
            <?php
            }
            ?>
            </select>
          <?php } ?>
		  </td>
        </tr>
    <?php }elseif($cf['field_name']=="country"){ ?>
        <tr> 
          <td valign='top' class='accountlabPlanDataTD'>
            <?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?>
          </td>
          <td valign='top' class='accountlabPlanDataTD'>
              <select name='country' id='country' class='accountlabInput' onblur="javascript:xajax_step3_listStates(xajax.$('country').value,'');">
                <option><?php echo $BL->props->lang['select_country']; ?></option>
                <?php foreach ($BL->props->country as $key => $value) { ?>
                 <option value='<?php echo $key; ?>'<?php if (($cf['field_value']==$value) || ($cf['field_value']==$key)) { echo " selected"; }?>><?php echo $value; ?></option>
                <?php } ?>
              </select>
           </td>
        </tr>
    <?php }elseif($cf['field_name']=="state"){ ?>
        <tr> 
          <td valign='top' class='accountlabPlanDataTD'>
            <?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?>
          </td>
          <td valign='top' class='accountlabPlanDataTD'>
            <div id='state_selection' name='state_selection'>
			<?php
			/* If there is a predefined value in the country field, use it to populate the state/province/region field */
			$country = '';
			foreach($custom_fields as $cf2){
			  if($cf2['field_name']=="country")
			  {
			    $country = $cf2['field_value'];
			    break;
			  }
			}
			$find = array_search($country, $BL->props->country);
			$country = $find ? $find : $country;

			if (!empty($country) && isset($BL->props->allstates[$country]))
			{ ?>
              <select name='state' id='state' class='accountlabInput'>
                <option><?php echo $BL->props->lang['select_state']; ?></option>
                <?php foreach ($BL->props->allstates[$country] as $key => $value) { ?>
                 <option value='<?php echo $key; ?>'<?php if (($cf['field_value']===$value) || ($cf['field_value']===$key)) { echo " selected"; }?>><?php echo $value; ?></option>
                <?php } ?>
              </select>
			<?php
			}
			else
			{
			?>
            <input type='text' size='25' name='state' id='state' class='accountlabInput' />
			<?php
			}
			?>
            </div>
          </td>
        </tr> 
    <?php }elseif($cf['field_name']=="vat_no"){ ?>
        <?php if ($conf['en_vat'] == 1) { ?>
        <tr> 
          <td valign='top' class='accountlabPlanDataTD'>
           <?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?>
          </td>
          <td valign='top' class='accountlabPlanDataTD'>
           <input name='vat_no' id='vat_no' class='accountlabInput' type='text'  size='25' />
          </td>
        </tr>
        <?php } ?>
<?php
    }
} 
?>
		</table>
        </fieldset>
	</td>
</tr>
</tbody>
