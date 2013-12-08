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

    $admin_cmds = array(
        "^customers",
        "~viewcustomers",
        "~addcustomer",
        "+editcustomers",
        "+delcustomers",
        "-",
        "^orders",
        "~vieworders",
        "~addorder",
        "+editorder",
        "+delorder",
        "~orphan_orders",
        "-",
        "^invoices",
        "~viewinvoice",
        "+addinvoice",
        "+editinvoice",
        "+delinvoice",
        "~manual_payments",
        "-",
        "^products",
        "~groups",
        "+add_group",
        "+edit_group",
        "+del_group",
        "~plans",
        "+addplan",
        "+editplan",
        "+delplan",
        "~subdomains",
        "+add_maindomain",
        "+editmaindomain",
        "+delmaindomain",
        "+act_subdomain",
        "~addons",
        "+add_addon",
        "+edit_addon",
        "+del_addon",
        "-",
        "^extras",
        "~specials",
        "+add_special",
        "+edit_special",
        "+del_special",
        "~coupons",
        "+add_coupon",
        "+edit_coupon",
        "+del_coupon",
        "+act_coupon",
        "~disc_tokens",
        "+add_disc_token",
        "+edit_disc_token",
        "+del_disc_token",
        "+send_disc_token",
        "+act_disc_token",
        "~credits",
        "~discounts",
        "-",
        "^tickets",
        "~topics",
        "+add_topic",
        "+edit_topic",
        "+del_topic",
        "+act_support",
        "~ticket",
        "-",
        "^newsletters",
        "~emailannounce",
        "~savedannounce",
        "+delsavedannounce",
        "-",
        "^reports",
        "~assets",
        "~growth",
        "-",
        "^settings",
        "~conf",
        "~custompages",
        "+add_custompage",
        "+edit_custompage",
        "+del_custompage",
        "~custom_scripts",
        "~customfields",
        "+add_customfield",
        "+edit_customfield",
        "+del_customfield",
        "~billing_cycles",
        "+add_cycle",
        "+edit_cycle",
        "+del_cycle",
        "~currency",
        "+addcurrency",
        "+editcurrency",
        "+delcurrency",
        "~geoip",
        "~ips",
        "+add_ip",
        "+edit_ip",
        "+del_ip",
        "~users",
        "+add_user",
        "+edit_user",
        "+del_user",
        "~servers",
        "+addservers",
        "+editserver",
        "+delserver",
        "~payment",
        "~registrar",
        "~tld",
        "+addtld",
        "+edittld",
        "+deltld",
        "~tax",
        "+addtax",
        "+edittax",
        "+deltax",
        "~e_templates",
        "~announce",
        "+addannounce",
        "+editannounce",
        "+delannounce",
        "~faq",
        "+addfaq",
        "+editfaq",
        "+delfaq",
        "+faqgroup",
        "+addfaqgroup",
        "+editfaqgroup",
        "+delfaqgroup",
        "-",
        "^utililies",
        "~import_packages",
        "~import_clientexec",
        "~reset_alp",
        "~systemtest",
        "-",
        //General commands allowed for all
        "-main",
        "-passwd",
        "-openTicket",
        "-viewTicket",
        "-closeTicket",
        ""
    );
?>
