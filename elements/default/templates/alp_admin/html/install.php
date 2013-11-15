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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $BL->props->parseLang('charset'); ?>" />
<title><?php echo $BL->props->parseLang('accountlabplus'); ?></title>
<link rel="stylesheet" href="<?php echo $BL->props->getElement("/templates/alp_admin/css/default_horizontal_menu.css",1); ?>" type="text/css" />
</head>
<body>
<br />
<table width='486' border='0' align='center' cellpadding='0' cellspacing='0' class="list_table">
  <tr>
    <td class='tdheading'>
            <?php echo $BL->props->parseLang('title_installer'); ?>
    </td>
  </tr>
  <tr>
    <td valign='top' class='text_grey'>
    <table width='486' border='0' cellspacing='0' cellpadding='0'>
        <tr>
          <td width='20'>&nbsp;</td>
          <td width='466' height='430' valign='top' class='text_grey'>
<?php
########################################Step 1#################################################            
if ($step == 1)
{
?>
    <table width='457' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td width='163'>&nbsp;</td>
            <td width='294'>&nbsp;</td>
        </tr>
        <tr>
            <td class='text_grey'>
                <b><?php echo $BL->props->parseLang('install')." >> ".$BL->props->parseLang('step_1'); ?></b><br /><br />
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='2' class='text_grey'>
                <?php echo empty($err)?"<i>".$BL->props->parseLang('enter_detail')."</i>":"<font color='red'>".$err."</font>"; ?>
            </td>
        </tr>
        <?php if(!empty($err1)){ ?>
        <tr>
            <td colspan='2' class='text_grey'>
                <?php echo "<br><font color='red'>".$err1."</font>"; ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php if(empty($err)){ ?>
        <tr>
            <td colspan='2'>
                <form name='startform' id='startform' method='post' action='<?php echo $PHP_SELF; ?>'>
                    <table width='447' border='0' cellspacing='0' cellpadding='0'>
                      <tr>
                        <td width='112'>&nbsp;</td>
                        <td width='335'>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class='text_grey'>
                            <?php echo $BL->props->parseLang('hostname'); ?>
                        </td>
                        <td>
                            <input name='hostname' type='text' class='search' size='20' value="<?php echo $BL->props->db_host; ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td height='22' class='text_grey'>
                            <?php echo $BL->props->parseLang('database'); ?>
                        </td>
                        <td><input name='dbname' type='text' class='search' size='20' value="<?php echo $BL->props->db_name; ?>" /></td>
                      </tr>
                      <tr>
                        <td height='22' class='text_grey'>
                            <?php echo $BL->props->parseLang('username'); ?>
                        </td>
                        <td>
                            <input name='user' type='text' class='search' size='20' value="<?php echo $BL->props->db_user; ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td class='text_grey'>
                            <?php echo $BL->props->parseLang('password'); ?>
                        </td>
                        <td>
                            <input name='pass' type='password' class='search' size='20' value="<?php echo $BL->props->db_pass; ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><br />

                            <input name='step' type='hidden' value='2' />
                            <input name='cmd' type='hidden' value='install' />
                            <input name='create' type='submit' class='search1' value='<?php echo $BL->props->parseLang('submit'); ?>' />
                        </td>
                      </tr>
                    </table>
                  </form>
                  </td>
              </tr>
              <?php } ?>
            </table>
        </td>
        </tr>
      </table>
<?php
}
########################################Step 1################################################# 
########################################Step 2#################################################            
if ($step == 2)
{
?>
<form name='confirmform' id='confirmform' method='post' action='<?php echo $PHP_SELF; ?>'>
    <table width='457' border='0' cellspacing='0' cellpadding='0'>
       <tr>
          <td width='457'>&nbsp;</td>
       </tr>
        <tr>
            <td class='text_grey'>
                <b><?php echo $BL->props->parseLang('install')." >> ".$BL->props->parseLang('step_2'); ?></b><br><br>
            </td>
            <td>&nbsp;</td>
        </tr>
       <tr>
          <td class='text_grey'>
            <?php echo "<i>".$BL->props->parseLang('install_or_upgrade')."</i>"; ?>
          </td>
       </tr>
       <tr>
          <td width='457'>&nbsp;</td>
       </tr>
       <tr>
          <td>
                <input name='step' type='hidden' value='3' />
                <input name='hostname' type='hidden' value='<?php echo $REQUEST['hostname']; ?>' />
                <input name='user' type='hidden' value='<?php echo $REQUEST['user']; ?>' />
                <input name='pass' type='hidden' value='<?php echo $REQUEST['pass']; ?>' />
                <input name='dbname' type='hidden' value='<?php echo $REQUEST['dbname']; ?>' />
                <input name='cmd' type='hidden' value='install' />
                <input name='Drop_Tables' type='hidden' value='Drop_Tables' />
                <input name='submit' type='submit' class='search1' value='<?php echo $BL->props->parseLang('install'); ?>' />
                <input name='upgrade' type='button' class='search1' value='<?php echo $BL->props->parseLang('upgrade'); ?>' onClick="location.href='<?php echo $PHP_SELF; ?>?cmd=upgrade'; return false;" />
          </td>
       </tr>
     </table>
</form>
<?php
}
########################################Step 2################################################# 
########################################Step 3#################################################            
if ($step == 3)
{
?>
     <table width='457' border='0' cellspacing='0' cellpadding='0'>
       <tr>
          <td width='163'>&nbsp;</td>
          <td width='294'>&nbsp;</td>
       </tr>
        <tr>
            <td class='text_grey'>
                <b><?php echo $BL->props->parseLang('install')." >> ".$BL->props->parseLang('step_3'); ?></b><br><br>
            </td>
            <td>&nbsp;</td>
        </tr>
       <tr>
           <td colspan='2' class='text_grey'>
                <?php echo $BL->props->parseLang('enter_admin_detail'); ?>
           </td>
       </tr>
       <tr>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
       </tr>
       <tr>
           <td colspan='2'>
             <form name='secondform' id='secondform' method='post' action='<?php echo $PHP_SELF; ?>'>
             <table width='447' border='0' cellspacing='0' cellpadding='0'>
                 <tr>
                     <td width='112'>&nbsp;</td>
                     <td width='335'>&nbsp;</td>
                 </tr>
                 <tr>
                     <td class='text_grey'><?php echo $BL->props->parseLang('admin_pass'); ?></td>
                     <td>
                        <input name='admin_pass' type='text' class='search' id='admin_pass' size='35' />
                     </td>
                 </tr>
                 <tr>
                     <td height='22' class='text_grey'>
                        <?php echo $BL->props->parseLang('install_path'); ?>
                     </td>
                     <td>
                        <input name='ins_path' type='text' class='search' id='ins_path' size='35' value='<?php echo $BL->utils->removetrailingslash(INSTALL_PATH); ?>' />
                     </td>
                 </tr>
                 <tr>
                    <td height='22' class='text_grey'>
                        <?php echo $BL->props->parseLang('install_url'); ?>
                    </td>
                    <td>
                        <input name='ins_url' type='text' class='search' id='ins_url' size='35' value='<?php echo $BL->utils->removetrailingslash(INSTALL_URL); ?>' />
                    </td>
                 </tr>
                 <tr>
                    <td class='text_grey'>
                        <?php echo $BL->props->parseLang('admin_email'); ?>
                    </td>
                    <td>
                        <input name='admin_email' type='text' class='search' id='admin_email' size='35' />
                    </td>
                 </tr>
                 <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input name='step' type='hidden' value='4' />
                        <input name='cmd' type='hidden' value='install' />
                        <input name='hostname' type='hidden' value='<?php echo $REQUEST['hostname']; ?>' />
                        <input name='user' type='hidden' value='<?php echo $REQUEST['user']; ?>' />
                        <input name='pass' type='hidden' value='<?php $REQUEST['pass']; ?>' />
                        <input name='dbname' type='hidden' value='<?php echo $REQUEST['dbname']; ?>' /><br />

                        <input name='submit' type='submit' class='search1' value='<?php echo $BL->props->parseLang('complete'); ?>' />
                    </td>
                 </tr>
                </table>
             </form>
            </td>
        </tr>
     </table>
<?php

}
########################################Step 3################################################# 
########################################Step 4#################################################            
if ($step == 4)
{   
?>
    <table width='457' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td width='163'>&nbsp;</td>
            <td width='294'>&nbsp;</td>
        </tr>
        <tr>
            <td class='text_grey'>
                <b><?php echo $BL->props->parseLang('install')." >> ".$BL->props->parseLang('step_4'); ?></b><br><br>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class='text_grey' colspan='2'><?php echo $BL->props->parseLang('install_complete'); ?></td>
        </tr>
        <tr>
            <td colspan='2' class='text_grey'>
                  <ul>
                  <?php if(isset($warning)){ ?>
                  <li><?php echo $warning; ?><?php echo $BL->props->parseLang('install_path')."=<b>".INSTALL_PATH."</b><br>"; ?><?php echo $BL->props->parseLang('install_url')."=<b>".INSTALL_URL."</b><br><br>"; ?></li>
                  <?php } ?>
                    <li><?php echo $BL->props->parseLang('remove_install'); ?></li>
                    <li><?php echo $BL->props->parseLang('chmod_db.php'); ?></li>
                  </ul>
                  <p><?php echo $BL->props->parseLang('login_to'); ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <form name='form1' id='form1' action="admin.php" method="post" enctype="text/plain"><br />

                <input type="submit" name="name" value="<?php echo $BL->props->parseLang('login'); ?>" class='search1' />
                </form>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
            </td>
        </tr>
    </table>
<?php
}
########################################Step 4#################################################            
########################################Upgrade#################################################            
if ($step == "upgrade")
{
?>
    <table width='457' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td width='163'>&nbsp;</td>
            <td width='294'>&nbsp;</td>
        </tr>
        <tr>
            <td class='text_grey'>
                <b><?php echo $BL->props->parseLang('install')." >> ".$BL->props->parseLang('upgrade'); ?></b><br><br>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class='text_grey' colspan='2'><?php echo $BL->props->parseLang('upgrade_complete'); ?></td>
        </tr>
        <tr>
            <td colspan='2' class='text_grey'>
                  <ul>
                  <?php if($warning!=""){ ?>
                  <li><?php echo $warning; ?><?php echo $BL->props->parseLang('install_path')."=<b>".INSTALL_PATH."</b><br>"; ?><?php echo $BL->props->parseLang('install_url')."=<b>".INSTALL_URL."</b><br><br>"; ?></li>
                  <?php } ?>
                    <li><?php echo $BL->props->parseLang('remove_install'); ?></li>
                    <li><?php echo $BL->props->parseLang('chmod_db.php'); ?></li>
                  </ul>
                  <p><?php echo $BL->props->parseLang('login_to'); ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <form name='form1' id='form1' action="admin.php" method="post" enctype="text/plain"><br />
                <input type="submit" name="name" value="<?php echo $BL->props->parseLang('login'); ?>" class='search1' />
                </form>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
            </td>
        </tr>
    </table>
<?php

}
########################################Upgrade#################################################
if($step == "error"){    
?>
    <table width='457' border='0' cellspacing='0' cellpadding='0'>
        <tr>
            <td width='163'>&nbsp;</td>
            <td width='294'>&nbsp;</td>
        </tr>
        <tr>
            <td class='text_grey'>
                <b><?php echo $BL->props->parseLang('install')." >> ".$BL->props->parseLang('error'); ?></b><br><br>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='2' class='text_grey'>
            <p><?php echo $err; ?></p>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
            </td>
        </tr>
    </table>
<?php
}
?>
</td>
  </tr>
  <tr>
    <td height='16' class='text_white'>&nbsp;</td>
  </tr>
</table>

</body>
</html>
