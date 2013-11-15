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

    <tr> 
        <td>    
            <fieldset class='accountlabFormTABLE'>
            <legend><b><?php echo $BL->props->lang['special_offer']." : ".$special['special_name']; ?></b></legend>
            <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
            <?php if (count($tld_array) && count($tld_array)){ ?>
                <tr> 
                    <td width='3%' height='1%' valign='top'> 
                    &#160;                
                    </td>
                    <td valign='top' width='20%'>
                        <?php echo $BL->props->lang['domain_name']; ?>
                    </td>
                    <td valign='top'>
                        <input name='sld2' id='sld2' type='text' class='accountlabInput' size='35' />
                        .
                        <select name='tld2' id='tld2' class='accountlabSelect'>
                        <?php 
                        if (array_key_exists('dom_ext',$tld_array[0])){
                            $type = 1;
                            $tld_array1 = array();
                            foreach ($tld_array as $tld) {
                                if(array_search($tld_array['dom_ext'],$tld_array1)===false) {
                                    $tld_array1[] = $t['dom_ext'];
                        ?>
                        <option value='<?php echo $tld['dom_ext']; ?>'><?php echo $tld['dom_ext']; ?></option>
                        <?php
                                } 
                            }
                        }elseif (array_key_exists('maindomain',$tld_array[0])){
                            $type = 2;
                            foreach ($tld_array as $subdomain){
                        ?>
                        <option value='<?php echo $subdomain['maindomain']; ?>'><?php echo $subdomain['maindomain']; ?></option>
                        <?php
                            }                     
                        }
                        ?>
                       </select>
                       <input type='button' class='accountlabButton' name='Button1' id='Button1' value='<?php echo $BL->props->lang['check']; ?>' onclick="javascript:xajax_step5_whois(<?php echo $type; ?>,xajax.$('sld2').value,xajax.$('tld2').value);" />
                    </td>
                </tr>
                <tr>
                    <td width='3%' height='1%' valign='top'> 
                    &#160;                
                    </td>
                    <td valign='top'>
                    &#160;
                    </td>
                    <td valign='top'>
                    <div name='special_whois_result' id='special_whois_result'>&#160;</div>
                    </td>
                </tr>
             <?php }else{ ?>
                <tr> 
                    <td width='3%' height='1%' valign='top'> 
                    &#160;                
                    </td>
                    <td valign='top'>
                        <?php echo $BL->props->lang['domain_name']; ?>
                    </td>
                    <td valign='top'>
                        <input name='sld2' id='sld2' type='text' class='accountlabInput' size='35' />
                        .
                        <input name='tld2' id='tld2' type='text' size='5' class='accountlabInput'>
                        <input type='button' class='accountlabButton' name='Button1' id='Button1' value='<?php echo $BL->props->lang['add']; ?>' onclick="javascript:xajax_step5_addDomain(3,xajax.$('sld2').value,xajax.$('tld2').value);" />
                    </td>
                </tr>
             <?php } ?>
                <tr> 
                    <td colspan='3' valign='top'> 
                    &#160;                
                    </td>
                </tr>
             <?php if(count($plan_array)){ ?>
                <tr>
                    <td width='3%' height='1%' valign='top'> 
                    &#160;                
                    </td>
                    <td valign='top'>
                    <?php echo $BL->props->lang['Plan']; ?>
                    </td>
                    <td valign='top'>
                    <select name='plan2' id='plan2' class='accountlabSelect' onchange="javascript:xajax_step5_addProduct(xajax.$('plan2').value);">
                    <option value='0'><?php echo $BL->props->lang['select']; ?></option>
                    <?php foreach ($plan_array as $plan){ ?>
                    <option value='<?php echo $plan['plan_price_id']; ?>'><?php echo $BL->getFriendlyName($plan['plan_price_id']); ?></option>
                    <?php } ?>
                    </select>
                    </td>
                </tr>   
             <?php }else{ ?>
                <input type='hidden' name='plan2' id='plan2' value='0' />
             <?php } ?>
                <tr> 
                    <td colspan='3' valign='top'> 
                    &#160;                
                    </td>
                </tr>
             <?php if(count($addon_array)){ ?>
                <tr>
                    <td width='3%' height='1%' valign='top'> 
                    &#160;                
                    </td>
                    <td valign='top'>
                    <?php echo $BL->props->lang['addons']; ?>
                    </td>
                    <td valign='top'>
                    <select name='addon2' id='addon2' class='accountlabSelect'  onchange="javascript:xajax_step5_addAddon(xajax.$('addon2').value);">
                    <option value='0'><?php echo $BL->props->lang['select']; ?></option>
                    <?php foreach ($addon_array as $addon){ ?>
                    <option value='<?php echo $addon['addon_id']; ?>'><?php echo $addon['addon_name']; ?></option>
                    <?php } ?>
                    </select>
                    </td>
                </tr>   
             <?php }else{ ?>
                <input type='hidden' name='addons2' id='addons2' value='0' />
             <?php } ?>
             </table>
         </td>
     </tr>
