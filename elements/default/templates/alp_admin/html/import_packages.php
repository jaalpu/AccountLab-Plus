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
    <form name='form1' id='form1' method='post' action="<?php echo $PHP_SELF; ?>">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
		<tr> 
            <td colspan="4" class="tdheading">
		    <b><?php echo $BL->props->lang['~import_packages']; ?></b>
		    </td>
        </tr>
		<tr> 
            <td colspan="4" class="text_grey">
            <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
            </td>
        </tr>
        <tr>
            <td class='text_grey' width='1%'>
            <div align='center'>
            <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
            </div>
            </td>
            <td class='text_grey' colspan="3">
              <div id="form1_label">
              <b><?php echo $BL->props->lang['import_from']; ?>:</b>
              </div>
              <div id="form1_field">
              <select name='server_id' id='server_id' class='search'>
              <?php foreach ($Servers as $Server){ ?>
                <?php if($Server['server_type']!="plesk"){ ?>
                <option value="<?php echo $Server['server_id']; ?>" <?php if(isset($REQUEST['server_id']) && $REQUEST['server_id']==$Server['server_id'])echo "selected"; ?>><?php echo $Server['server_name']; ?></option>
                <?php } ?>
              <?php } ?>
              </select>
            </div>
            </td>
        </tr>
        <tr> 
          <td colspan='4' class='text_grey'>
          <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
          </td>
        </tr> 
        <tr>
          <td class='text_grey' width='1%'><div align='center'></div></td>
          <td class='text_grey' colspan="3">
          <div id="form1_label">
          </div>
          <div id="form1_field">
          <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
          <input name='submit' type='submit' value='<?php echo $BL->props->lang['import']; ?>' class='search1' />
          </div>
          </td>
         </tr>
        <tr> 
            <td colspan="4" class="text_grey">
            <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
            </td>
        </tr>
        </table>
        <br />
        <?php if(count($Packages)){ ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
        
 		<tr> 
            <td colspan="4" class="tdheading">
		    <b>&nbsp;<?php echo $BL->props->lang['Imported_packages']; ?></b>
		    </td>
        </tr>
		<tr> 
            <td colspan="4" class="text_grey">
            <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
            </td>
        </tr>
    	<tr>
    		<td class="text_grey"><img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
    		<td class="text_grey"><b><?php echo $BL->props->lang['package']; ?></b></td>
    		<td class="text_grey"><b><?php echo $BL->props->lang['asso_plan']; ?></b></td>
    		<td class="text_grey"></td>
    	</tr>	
		<tr>
            <td colspan='4' class='text_grey'>
		    <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1" />
            </td>
        </tr>	
	<?php foreach($Packages as $Package) { ?>	
	<tr>
		<td class="text_grey">
        <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
        </td>
		<td class="text_grey"><?php echo $Package; ?></td>
		<td class="text_grey"><?php echo $Package; ?></td>
		<td class="text_grey"><?php echo $Linked_Package[$Package]; ?></td>
	</tr>
    <tr>
        <td colspan='4' class='text_grey'>
        <img src="elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg" width="100%" height="1" />
        </td>
    </tr>
	<?php } ?>
	<tr>
		<td class="text_grey" colspan="4">
        <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" />
        </td>
	</tr>   
	
    </table>
    <?php } ?>
    </form>
	</div>
</div>

<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
