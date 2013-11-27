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
<div class="tabs" name='t1' id='t1' onclick="javascript:showTab('tab1', tabs, 't1', t);" onmouseover="javascript:overTab('t1', t);" onmouseout="javascript:outTab(t);" ><?php echo $BL->props->lang['Orders']; ?></div>
<div class="tab_separator">&nbsp;</div>
<div>
<div id="tab1" name="tab1" class="tabContent" style="display:none">
	   <table width='100%' border='0' cellspacing='0' cellpadding='0'>
              <tr> 
                <td height='22' colspan='2' class='accountlabPlanDataHTD'>&nbsp;&nbsp;<?php echo $BL->props->lang['Order_Details']; ?></td>
              </tr>
              <tr> 
                <td width='25%'  height='22' class='accountlabDataTD'><?php echo $BL->props->lang['Order_Date']; ?></td>
                <td  height='22' class='accountlabDataTD'><?php echo $BL->fDate($order[0]['sign_date']); ?></td>
              </tr>
              <tr> 
                <td  height='22' class='accountlabAltDataTD'><?php echo $BL->props->lang['Domain']; ?></td>
                <td  height='22' class='accountlabAltDataTD'><?php echo $order[0]['domain_name']; ?></td>
              </tr>
              <tr> 
                <td  height='22' class='accountlabDataTD'><?php echo $BL->props->lang['dom_reg']; ?></td>
                <td  height='22' class='accountlabDataTD'><?php if($order[0]['dom_reg_type']==1)echo $BL->props->lang['Yes']; else echo $BL->props->lang['No']; ?></td>
              </tr>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->lang['Plan']; ?></td>
                <td class='accountlabAltDataTD'><?php echo $BL->getFriendlyName($order[0]['product_id']); ?></td>
              </tr>
             
              <tr> 
                <td  height='22' class='accountlabDataTD'><?php echo $BL->props->lang['Status']; ?></td>
                <td  height='22' class='accountlabDataTD'><?php echo $BL->props->lang[$order[0]['cust_status']]; ?></td>
              </tr>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->lang['server']; ?></td>
                <td class='accountlabAltDataTD'><?php echo $server['server_name']; ?></td>
              </tr>
              <tr> 
                <td  height='22' class='accountlabDataTD'><?php echo $BL->props->lang['IP']; ?></td>
                <td  height='22' class='accountlabDataTD'><?php echo $ip['ip']; ?></td>
              </tr>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><?php echo $BL->props->lang['ns']; ?></td>
                <td class='accountlabAltDataTD'><?php echo $server['name_server_1']; ?><br><?php echo $server['name_server_2']; ?></td>
              </tr>
              <tr> 
                <td  height='22' class='accountlabDataTD'><?php echo $BL->props->lang['username']; ?></td>
                <td  height='22' class='accountlabDataTD'><?php echo $order[0]['dom_user']; ?></td>
              </tr>
            <?php if (count($addon_ids)){ ?>     
              <tr> 
                <td height='22' class='accountlabDataTD'></td>
                <td class='accountlabDataTD'></td>
              </tr>
              <tr> 
                <td height='22' class='accountlabAltDataTD'><b><?php echo $BL->props->lang['addons']; ?></b></td>
                <td class='accountlabAltDataTD'></td>
              </tr>
            <?php
            $count = 0;
            $td    = "";
            foreach ($addon_ids as $addon_data)
            {
            	$count = 1;
                if ($td == "accountlabDataTD")
                    $td = "accountlabAltDataTD";
            	else
            		$td = "accountlabDataTD";
                $addon = $BL->addons->getByKey($addon_data['addon_id']);
            ?>
              <tr> 
                <td height='22' class='accountlabDataTD'><?php echo $addon['addon_name']; ?></td>
                <td class='accountlabDataTD'><?php echo $BL->props->lang['active_from']." ".$BL->fDate($addon_data['activation_date']); ?></td>
              </tr>
            <?php } } ?>
            </table>
</div>
</div>
<script language="JavaScript" type="text/javascript">
  showTab('tab1', tabs, 't1', t);
</script>
<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/user/footer.php"); ?>
