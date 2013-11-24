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
    <form name='form1' id='form1' method='POST' action="<?php echo $PHP_SELF; ?>">
            <?php if ((empty ($REQUEST['submit']) && empty($REQUEST['clientexec_host'])) || $REQUEST['assign_fields']=="true"){ ?>

			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list_table">
					<tr>
                      <td colspan="2" class="tdheading">
					  <b>&nbsp;<?php echo $BL->props->lang['~import_clientexec']; ?></b>
					  </td>
                    </tr>
					<tr>
                      <td colspan="2" class="text_grey">
                      <img src="elements/default/templates/alp_admin/images/spacer.gif" alt="" width="100%" height="1" /></td>
                    </tr>
				    <tr>
                        <td class='text_grey' width='1%'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['clientexec_host']; ?>
                        </div>
                        <div id="form1_field">
                            <input name='clientexec_host' type='text' class='search' id='clientexec_host' size='20' value='<?php echo isset($REQUEST['clientexec_host'])?$REQUEST['clientexec_host']:""; ?>' />
                        </div>
                        </td>
				     </tr>
                      <tr>
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <tr>
                        <td class='text_grey' width='1%'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['clientexec_db']; ?>
                        </div>
                        <div id="form1_field">
                            <input name='clientexec_db' type='text' class='search' id='clientexec_db' size='20' value='<?php echo isset($REQUEST['clientexec_db'])?$REQUEST['clientexec_db']:""; ?>' />
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <tr>
                        <td class='text_grey' width='1%'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['clientexec_user']; ?>
                        </div>
                        <div id="form1_field">
                            <input name='clientexec_user' type='text' class='search' id='clientexec_user' size='20' value='<?php echo isset($REQUEST['clientexec_user'])?$REQUEST['clientexec_user']:""; ?>' />
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <tr>
                        <td class='text_grey' width='1%'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['clientexec_pass']; ?>
                        </div>
                        <div id="form1_field">
                            <input name='clientexec_pass' type='text' class='search' id='clientexec_pass' size='20' value='<?php echo isset($REQUEST['clientexec_pass'])?$REQUEST['clientexec_pass']:""; ?>' />
                        </div>
                        </td>
                     </tr>
                      <tr>
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>

                      <?php if(isset($REQUEST['assign_fields']) && $REQUEST['assign_fields']=="true"){ ?>
                      <tr>
                        <td class='text_grey' width='1%' valign='top'>
                        <div align='center'>
                        <img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'>
                        </div>
                        </td>
                        <td class='text_grey' valign='top'>
                        <div id="form1_label">
                        <?php echo $BL->props->lang['assign_fields']; ?>
                        </div>
                        <div id="form1_field">
                            <?php
                            $clientexecHandler->connectDB();
                            $fields = $clientexecHandler->getCustomFields();
                            ?>
                            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                            <tr>
                            <td width='1%'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></td>
                            <td>Address</td>
                            <td> => </td>
                            <td>
                              <select name="f_address" id="f_address" size="1" class='search'>
                              <?php foreach($fields as $k=>$v){ ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                              <?php } ?>
                              </select>
                              </td>
                            <tr>
                            <tr>
                            <td width='1%'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></td>
                            <td>City</td>
                            <td> => </td>
                            <td>
                              <select name="f_city" id="f_city" size="1" class='search'>
                              <?php foreach($fields as $k=>$v){ ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                              <?php } ?>
                              </select>
                              </td>
                            <tr>
                            <tr>
                            <td width='1%'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></td>
                            <td>State</td>
                            <td> => </td>
                            <td>
                              <select name="f_state" id="f_state" size="1" class='search'>
                              <?php foreach($fields as $k=>$v){ ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                              <?php } ?>
                              </select>
                              </td>
                            <tr>
                            <tr>
                            <td width='1%'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></td>
                            <td>Zip</td>
                            <td> => </td>
                            <td>
                              <select name="f_zip" id="f_zip" size="1" class='search'>
                              <?php foreach($fields as $k=>$v){ ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                              <?php } ?>
                              </select>
                              </td>
                            <tr>
                            <tr>
                            <td width='1%'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></td>
                            <td>Country</td>
                            <td> => </td>
                            <td>
                              <select name="f_country" id="f_country" size="1" class='search'>
                              <?php foreach($fields as $k=>$v){ ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                              <?php } ?>
                              </select>
                              </td>
                            <tr>
                            <tr>
                            <td width='1%'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></td>
                            <td>Telephone</td>
                            <td> => </td>
                            <td>
                              <select name="f_telephone" id="f_telephone" size="1" class='search'>
                              <?php foreach($fields as $k=>$v){ ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                              <?php } ?>
                              </select>
                              </td>
                            <tr>
                            <tr>
                            <td width='1%'><img src='elements/default/templates/alp_admin/images/menu_icon_dot.gif' width='32' height='18'></td>
                            <td>Default Password</td>
                            <td> => </td>
                            <td>
                              <input type='text' name='password' id='password' class='search' />
                              </td>
                            <tr>
                            </table>
                        </div>
                        </td>
                     </tr>
                      <tr>
                        <td colspan='2' class='text_grey'>
                        <img src='elements/default/templates/alp_admin/images/menu_line_lightgreen-long.jpg' width='100%' height='1' />
                        </td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td class='text_grey'><div align='center'></div></td>
                        <td class='text_grey'>
                        <div id="form1_label">
                        &nbsp;
                        </div>
                        <div id="form1_field">
                            <input type='hidden' name='cmd' value='<?php echo $cmd; ?>' />
                            <input type='hidden' name='assign_fields' value='<?php if(empty($REQUEST['assign_fields']))echo "true"; else echo "false"; ?>' />
                            <input name='submit' type='submit' class='search1' value='<?php echo $BL->props->lang['import']; ?>' />
                          </div></td>
                      </tr>
                  </table>
                  </form>
                  <?php }else{ ?>
                        <?php
                        if (ob_get_level() == 0) ob_start();
                        echo '<div class="percents"><font color="red"><b>---------'.$BL->props->lang['import_started_at'].' '.date('H:i:s d-M-Y').'.---------</b></font></div>';
                        flush();
                        ob_flush();
                        sleep(1);
                        echo '<div class="percents"><b>'.$BL->props->lang['connnecting_mysql_server'].'</b></div>';
                        flush();
                        ob_flush();
                        sleep(1);
                        $clientexecHandler->connectDB();
                        echo '<div class="percents">'.$BL->props->lang['Done'].'.<br /><b>'.$BL->props->lang['importing_tlds'].'</b></div>';
                        flush();
                        ob_flush();
                        sleep(1);
                        $clientexecHandler->importTlds($BL);
                        echo '<div class="percents">'.$BL->props->lang['Done'].'.<br /><b>'.$BL->props->lang['importing_products'].'</b></div>';
                        flush();
                        ob_flush();
                        sleep(1);
                        $clientexecHandler->importProducts($BL);
                        echo '<div class="percents">'.$BL->props->lang['Done'].'.<br /><b>'.$BL->props->lang['importing_customers'].'</b></div>';
                        flush();
                        ob_flush();
                        sleep(1);
                        $clientexecHandler->importCustomers($BL);
                        echo '<div class="percents">'.$BL->props->lang['Done'].'.<br /><b>'.$BL->props->lang['importing_orders'].'</b></div>';
                        flush();
                        ob_flush();
                        sleep(1);
                        $e_orders = $clientexecHandler->importOrders($BL);
                        echo '<div class="percents">'.$BL->props->lang['Done'].'.<br /><b>'.$BL->props->lang['importing_invoices'].'</b></div>';
                        flush();
                        ob_flush();
                        sleep(1);
                        $clientexecHandler->importInvoices($BL,$e_orders);
                        echo '<div class="percents">'.$BL->props->lang['Done'].'</div>';
                        flush();
                        ob_flush();
                        sleep(1);

                        ob_end_flush();
                        ?>
                        <div class="percents" style="z-index:12"><font color='red'><b>---------<?php echo $BL->props->lang['import_completed_at']." ".date('H:i:s d-M-Y'); ?>.---------</b></font></div>
               <?php } ?>
	</div>
</div>

<!--end content -->
<div id="navBar">
<?php include_once $BL->props->get_page("templates/alp_admin/html/_sidepanel.php"); ?>
</div>
<!--end navbar -->
<?php include_once $BL->props->get_page("templates/alp_admin/html/footer.php"); ?>
