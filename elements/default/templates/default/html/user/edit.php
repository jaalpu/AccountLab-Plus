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
</script>  
<!--tabs//-->
<div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['Edit_Profile']; ?></div>
<div class="tab_separator">&nbsp;</div>
<div>
<div id="tab1" name="tab1" class="tabContent" style="display:none">
		  <form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
		  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
              <tr> 
                <td height='22' colspan='2' class='accountlabPlanDataHTD'>
                &nbsp;&nbsp;<?php echo $BL->props->lang['Edit_Details']; ?>
                </td>
              </tr>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->lang['Email']; ?><font color="red"><b>*</b></font></td>
                <td class='accountlabAltDataTD'>
                <input name='email' type='text' class='accountlabInput' id='email' value='<?php echo $customer['email']; ?>' size='30' />
                </td>
              </tr>
              <tr> 
                <td height='22' class='accountlabDataTD'><?php echo $BL->props->lang['password']; ?><font color="red"><b>*</b></font></td>
                <td class='accountlabDataTD'>
                *******
                </td>
              </tr>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->lang['New_password']; ?></td>
                <td class='accountlabAltDataTD'>
                <input name='password1' type='password' class='accountlabInput' id='password1' size='10' />
                </td>
              </tr>
              <tr> 
                <td height='22' class='accountlabDataTD'><?php echo $BL->props->lang['Confirm_password']; ?></td>
                <td class='accountlabDataTD'>
                <input name='password2' type='password' class='accountlabInput' id='password2' size='10' />
                </td>
              </tr>
              
              
            <?php
            foreach($custom_fields as $cf){ 
                if($cf['field_name']!="country" && $cf['field_name']!="state" && $cf['field_name']!="vat_no"){
            ?>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?></td>
                <td class='accountlabAltDataTD'>
                  <?php if($cf['field_type']=="text"){ ?>
                     <input name='<?php echo $cf['field_name']; ?>' id='<?php echo $cf['field_name']; ?>' type='text' class='accountlabInput' size='25' value="<?php echo isset($customer[$cf['field_name']])?$customer[$cf['field_name']]:""; ?>"  />
                  <?php }else{ ?>
                    <select name='<?php echo $cf['field_name']; ?>' id='<?php echo $cf['field_name']; ?>' class='accountlabInput'>
                    <?php 
                    $values = $BL->utils->Get_Trimmed_Array(explode(",",$cf['field_value'])); 
                    $BL->utils->Remove_Empty_Elements($values);
                    foreach($values as $value){
                    ?>
                    <option value='<?php echo $value; ?>' <?php if(isset($customer[$cf['field_name']]) && $customer[$cf['field_name']]==$value)echo "selected"; ?>><?php echo $BL->props->parseLang($value); ?></option>
                    <?php
                    }
                    ?>
                    </select>
                  <?php } ?>
                </td>
              </tr>
              <?php }elseif($cf['field_name']=="country"){ ?>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?></td>
                <td class='accountlabAltDataTD'>
                  <select name='country' id='country' class='accountlabInput' onblur="javascript:updateStates(this.options[this.selectedIndex].value);">
                    <option><?php echo $BL->props->lang['select_country']; ?></option>
                    <?php foreach ($BL->props->country as $key => $value) { ?>
                     <option value='<?php echo $key; ?>' <?php if(isset($customer[$cf['field_name']]) && $customer[$cf['field_name']]==$key)echo "selected"; ?> ><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <?php }elseif($cf['field_name']=="state"){ ?>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?></td>
                <td class='accountlabAltDataTD'>
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
                  <select name='state' id='state' class='search'>
                    <option><?php echo $BL->props->lang['select_state']; ?></option>
                    <?php foreach ($BL->props->allstates[$country] as $key => $value) { ?>
                     <option value='<?php echo is_numeric($key)?$value:$key; ?>'<?php if(isset($customer[$cf['field_name']]) && $customer[$cf['field_name']]==$key) { echo " selected"; }?>><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
    			<?php
    			}
    			else
    			{
    			?>
                <input type='text' size='25' name='state' id='state' class='search' value="<?php ?>"/>
    			<?php
    			}
			?>
                </td>
              </tr>
              <?php }elseif($cf['field_name']=="vat_no"){ ?>        
                <?php if ($BL->conf['en_vat'] == 1) { ?>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->parseLang($cf['field_name']); ?><?php if(!$cf['field_optional'])echo "<font color='red'>*</font>"; ?></td>
                <td class='accountlabAltDataTD'>
                  <input name='vat_no' id='vat_no' class='accountlabInput' type='text'  size='25' value="<?php echo isset($customer['vat_no'])?$customer['vat_no']:""; ?>" /> 
                </td>
              </tr>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            
            
              <tr>
                <td height='22' class='accountlabDataTD'>&nbsp;</td>
                <td class='accountlabDataTD'>
                  <input name='id' id='id' type='hidden' value='<?php echo $customer['id']; ?>' />
                  <input name='cmd' id='cmd' type='hidden' value='<?php echo $cmd; ?>' />
                  <input name='submit' id='submit' type='submit' class='accountlabButton' value='<?php echo $BL->props->lang['submit']; ?>' />
                </td>
              </tr>
            </table>
            </form>
            </div>
            </div>
<script language="JavaScript" type="text/javascript">
  showTab('tab1', tabs, 't1', t);
</script>
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/footer.php"); ?>
