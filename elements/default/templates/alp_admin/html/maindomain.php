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
      <div class="tabs" name='tt1' id='tt1' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs';" ><a href="admin.php?cmd=subdomains" class="add_link"><?php echo $BL->props->lang['~subdomains']; ?></a></div>
      <div class="tab_separator">&nbsp;</div>
      <div class="tabs2" name='tt2' id='tt2' onmouseover="javascript:this.className='tabs1';" onmouseout="javascript:this.className='tabs2';" ><?php echo $title; ?></div>
      <div class="tab_separator">&nbsp;</div>
    </div>
	<div id="display_list">
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
					<td class="text_grey" colspan="2">
					<form name='form1' id='form1' method='post' action='<?php echo $PHP_SELF; ?>'>
				    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                      <tr> 
                        <td width='1%' class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['Domain']; ?>
						</div>
						<div id="form1_field"> 
                            <input name='maindomain' type='text' class='search' id='maindomain' size='20' value='<?php if($cmd=="editmaindomain")echo $maindomain['maindomain']; ?>' />
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                    <?php foreach($BL->props->cycles as $ck=>$cv){ ?>
                      <tr> 
                        <td class='text_grey'><div align='center'>
						<img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang[$cv]." (".$conf['symbol'].")"; ?>
						</div>
						<div id="form1_field">
                            <input name='<?php echo $cv; ?>' type='text' class='search' size='10' value='<?php if($cmd=="editmaindomain")echo $maindomain_cycles[$cv]; ?>' />
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'>
						<img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>
                      <?php } ?>

                      <tr> 
                        <td class='text_grey'><div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						<?php echo $BL->props->lang['reserved_names']; ?>
						</div>
						<div id="form1_field">
                            <input name='reserved_names' type='text' class='search' id='reserved_names' size='20' value='<?php if($cmd=="editmaindomain")echo $maindomain['reserved_names']; ?>'>
                          </div></td>
                      </tr>
                      <tr> 
                        <td colspan='2' class='text_grey'><img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' /></td>
                      </tr>



                      <tr> 
                        <td class='text_grey'><div align='center'></div></td>
                        <td class='text_grey'>
						<div id="form1_label">
						&nbsp;
						</div>
						<div id="form1_field">
                            <?php if($cmd=="editmaindomain"){ ?>
                        	<input type='hidden' name='main_id' value='<?php echo $maindomain['main_id']; ?>' />
                            <?php } ?>
                            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php if($cmd=="editmaindomain")echo $BL->props->lang['Update'];else echo $BL->props->lang['add']; ?>' />
                          </div></td>
                      </tr>
                    </table>
				  </form>
					</td>
				</tr>		
                  </table>
	</div>
</div>

<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
