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

<?php include_once $BL->props->get_page("templates/".THEMEDIR."/html/cart/top.php"); ?>
<!--Main table. Contains two rows:
1. top picture, logo and menu
2. page body with texts etc.
-->
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top" width='125'>&nbsp</td>
                    <td valign="top">
			<table width="756" height="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top">
					
						<table width="756" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
							<tr>
								<td id="header">
								
								  <center>
								  <table width="710">
										<tr>
											<td width="50"><img alt="logo" src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/logo.png"); ?>" width="73" height="71" /></td>
											<td align="left"><p class="slogan">Company Slogan</p><p class="company">HOSTING COMPANY</p></td>
											<td align="right"><p class="support">Live Sales and Support</p>
											<p class="support-number">1-800-123-4567</p></td>
										</tr>
									</table>
								   </center>
									
								</td>
							</tr>
							<tr>
								<td id="menu" height="22">
			
									<center>
									<table class="hmains">
										<tr>
											<td class="hmains"><a href="" class="hmains"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/arrow.gif"); ?>" alt="" width="8" height="9" />Welcome</a></td>
											<td class="hmains"><a href="" class="hmains"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/arrow.gif"); ?>" alt="" width="8" height="9" />Hosting</a></td>
											<td class="hmains"><a href="" class="hmains"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/arrow.gif"); ?>" alt="" width="8" height="9" />Domainnames</a></td>
											<td class="hmains"><a href="" class="hmains"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/arrow.gif"); ?>" alt="" width="8" height="9" />Products</a></td>
											<td class="hmains"><a href="" class="hmains"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/arrow.gif"); ?>" alt="" width="8" height="9" />Support</a></td>
											<td class="hmains"><a href="" class="hmains"><img src="<?php echo $BL->props->get_page("templates/".THEMEDIR."/images/arrow.gif"); ?>" alt="" width="8" height="9" />About us</a></td>
										</tr>
									</table>
									</center>
									
								</td>
							</tr>
							<tr>
								<td id="submenu" height="22">
			
									<center>
									<table class="hsubs">
										<tr>
											<td class="hsubs"><a href="" class="hsubs">Subpage1</a></td>
											<td class="hsubs"><a href="" class="hsubs">Subpage2</a></td>
											<td class="hsubs"><a href="" class="hsubs">Subpage3</a></td>
											<td class="hsubs"><a href="" class="hsubs">Subpage4</a></td>
											<td class="hsubs"><a href="" class="hsubs">Subpage5</a></td>
											<td class="hsubs"><a href="" class="hsubs">Subpage6</a></td>
										</tr>
									</table>
									</center>
								
								</td>
							</tr>
                            <tr>
								<td id="content" valign="top">
			
									<table style="margin: 40px 40px;" width="676">
										<tr>
										  <td valign="top">
										  <!--Your content here-->
