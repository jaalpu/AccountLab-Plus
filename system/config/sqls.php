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


    //sql to upgrade from 2.9.0 to 2.9.1
    $Queries['2_9_1'][] = "ALTER TABLE `groups` ADD `group_index` INT( 11 ) NOT NULL DEFAULT '0'";
    $Queries['2_9_1'][] = "SELECT @i:=0;";
    $Queries['2_9_1'][] = "UPDATE `groups` SET `group_index`=@i:=@i+1;";
    $Queries['2_9_1'][] = "ALTER TABLE `addons` ADD `addon_index` INT( 11 ) NOT NULL DEFAULT '0'";
    $Queries['2_9_1'][] = "SELECT @i:=0;";
    $Queries['2_9_1'][] = "UPDATE `addons` SET `addon_index`=@i:=@i+1;";
    $Queries['2_9_1'][] = "ALTER TABLE `customfields` ADD `customfields_index` INT( 11 ) NOT NULL DEFAULT '0'";
    $Queries['2_9_1'][] = "SELECT @i:=0;";
    $Queries['2_9_1'][] = "UPDATE `customfields` SET `customfields_index`=@i:=@i+1;";

    //sql to upgrade from 2.8 r12 to 2.9.0
    $Queries['2_9_0'][] = "ALTER TABLE `order_conf` ADD `en_quickpay`           ENUM( '0', '1' )      NOT NULL DEFAULT '0'";


    //sqls to upgrade from 2.8 r10 to 2.8 r12 (build no 14)
    $Queries['2_8r12'][] = "
    CREATE TABLE `registrars` (
    `id`        INT( 11 )       NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `name`      VARCHAR( 255 )  NOT NULL ,
    `field`     VARCHAR( 255 )  NOT NULL ,
    `value`     VARCHAR( 255 )  NOT NULL
    ) TYPE = MYISAM
    ";

    //sqls to upgrade from 2.8 r3 to 2.8 r10 (build no 13)
    $Queries['2_8r10'][] = "ALTER TABLE `support_topics` ADD `topic_regexp` VARCHAR( 255 ) NOT NULL";

    $Queries['2_8r10'][] = "ALTER TABLE `support_tickets` ADD `ticket_subject` VARCHAR( 255 ) NOT NULL ";

    $Queries['2_8r10'][] = "ALTER TABLE `order_conf` ADD `ticket_email`         VARCHAR( 255 )      NOT NULL ";
    $Queries['2_8r10'][] = "ALTER TABLE `order_conf` ADD `ticket_email_proto`   ENUM( 'imap', 'pop3', 'nntp', 'pop3s' ) NOT NULL DEFAULT 'imap'";
    $Queries['2_8r10'][] = "ALTER TABLE `order_conf` ADD `ticket_email_host`    VARCHAR( 255 )      NOT NULL ";
    $Queries['2_8r10'][] = "ALTER TABLE `order_conf` ADD `ticket_email_port`    INT( 11 )           NOT NULL DEFAULT '143'";
    $Queries['2_8r10'][] = "ALTER TABLE `order_conf` ADD `ticket_email_mbox`    VARCHAR( 255 )      NOT NULL DEFAULT 'INBOX#novalidate-cert'";
    $Queries['2_8r10'][] = "ALTER TABLE `order_conf` ADD `ticket_email_user`    VARCHAR( 255 )      NOT NULL ";
    $Queries['2_8r10'][] = "ALTER TABLE `order_conf` ADD `ticket_email_pass`    VARCHAR( 255 )      NOT NULL ";
    $Queries['2_8r10'][] = "ALTER TABLE `order_conf` ADD `en_ticket_by_email`   ENUM( '0', '1' )    NOT NULL ";

    $Queries['2_8r10'][] = "UPDATE `registerfly` SET `registerfly_active` = 'no'";

    $Queries['2_8r10'][] = "
    CREATE TABLE `custompages` (
    `id`            INT( 11 )       NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `title`         VARCHAR( 255 )  NOT NULL ,
    `metatags`      TEXT            NOT NULL ,
    `content`       TEXT            NOT NULL
    ) TYPE = MYISAM
    ";
    $Queries['2_8r10'][] = "ALTER TABLE `custompages` ADD `require_customer_login` ENUM( '0', '1' ) NOT NULL ";
    $Queries['2_8r10'][] = "ALTER TABLE `custompages` ADD `display_side_links` ENUM( '0', '1' ) NOT NULL ";

    //sqls to upgrade from 2.8 r3 to 2.8 r4 (build no 12)
    $Queries['2_8r4'][] = "
    CREATE TABLE `newsletters` (
    `newsletter_id`         INT( 11 )       NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `newsletter_subject`    VARCHAR( 255 )  NOT NULL ,
    `newsletter_body`       TEXT            NOT NULL
    ) TYPE = MYISAM
    ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `customer_1`   INT( 11 )           NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `FromDate`     DATE                NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `ToDate`       DATE                NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `tld_1`        ENUM( '0', '1' )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `tld_2`        VARCHAR( 25 )       NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `sd_1`         ENUM( '0', '1' )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `sd_2`         VARCHAR( 25 )       NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `product_1`    ENUM( '0', '1' )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `product_2`    INT( 11 )           NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `total_1`      ENUM( '0', '1' )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `total_2`      DECIMAL( 16, 6 )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `paid_1`       ENUM( '0', '1' )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `paid_2`       DECIMAL( 16, 6 )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `due_1`        ENUM( '0', '1' )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `due_2`        DECIMAL( 16, 6 )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `country_1`    ENUM( '0', '1' )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `country_2`    VARCHAR( 255 )      NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `country_3`    VARCHAR( 255)       NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `discount_1`   ENUM('0','1','2')   NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `discount_2`   DECIMAL( 16, 6 )    NOT NULL ";
    $Queries['2_8r4'][] = "ALTER TABLE `newsletters` ADD `send_as_html` ENUM( '0', '1' )    NOT NULL ";

    //sqls to upgrade from 2.8 to 2.8 r3 (build no 11)
    $Queries['2_8r3_1'][] = "DROP TABLE `messages` ";
    $Queries['2_8r3_1'][] = "ALTER TABLE `support_reply`    RENAME `support_replies`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `disc_token`       RENAME `disc_tokens`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `disc_token_code`  RENAME `disc_token_codes`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `hosting_price`    RENAME `products`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `domain_price`     RENAME `tlds`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `coupon`           RENAME `coupons`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `users_online`     RENAME `online_users`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `order_server_ip`  RENAME `orders_servers_ips`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `package_server`   RENAME `products_servers`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `ord_inv_rec`      RENAME `ord_inv_recs`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `payment_log`      RENAME `payment_logs`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `dom_reg_log`      RENAME `dom_reg_logs`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `tax`              RENAME `taxes`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `currency`         RENAME `currencies`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `announce`         RENAME `announcements`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `faq`              RENAME `faqs`";
    $Queries['2_8r3_1'][] = "ALTER TABLE `sub_order`        RENAME `orders`";

    $Queries['2_8r3_1'][] = "
    CREATE TABLE `orphan_orders` (
    `orphanorder_id`    INT( 11 )       NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `item_number`       VARCHAR( 255 )  NOT NULL ,
    `payment_method`    VARCHAR( 255 )  NOT NULL ,
    `order_date`        DATETIME        NOT NULL ,
    UNIQUE (`item_number`)
    ) TYPE = MYISAM
    ";

    $Queries['2_8r3_1'][] = "
    CREATE TABLE `orphan_order_datas` (
    `orphan_order_id`       INT( 11 )       NOT NULL ,
    `orphan_order_field`    VARCHAR( 255 )  NOT NULL ,
    `orphan_order_value`    VARCHAR( 255 )  NOT NULL
    ) TYPE = MYISAM
    ";

    $Queries['2_8r3_1'][] = "
    CREATE TABLE `faqgroups` (
    `faqgroup_id`   INT( 11 )       NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `faqgroup_name` VARCHAR( 255 )  NOT NULL ,
    `faqgroup_desc` TEXT            NOT NULL
    ) TYPE = MYISAM
    ";
    $Queries['2_8r3_1'][] = "
    CREATE TABLE `orders_addons` (
    `sub_id`            INT( 11 ) NOT NULL DEFAULT '0',
    `addon_id`          INT( 11 ) NOT NULL DEFAULT '0',
    `activation_date`   DATE      NOT NULL DEFAULT '0000-00-00'
    ) TYPE = MYISAM ";
    $Queries['2_8r3_1'][] ="
    CREATE TABLE `groups_products` (
    `group_id`      INT( 11 ) NOT NULL DEFAULT '0',
    `product_id`    INT( 11 ) NOT NULL DEFAULT '0'
    ) TYPE = MYISAM ";
    $Queries['2_8r3_1'][] ="
    CREATE TABLE `products_addons` (
    `product_id`      INT( 11 ) NOT NULL DEFAULT '0',
    `addon_id`        INT( 11 ) NOT NULL DEFAULT '0'
    ) TYPE = MYISAM ";
    $Queries['2_8r3_1'][] ="
    CREATE TABLE `customfields` (
    `field_id`          INT( 11 )                               NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `field_name`        VARCHAR( 255 )                          NOT NULL ,
    `field_type`        ENUM( 'text', 'select' )                NOT NULL ,
    `field_value`       VARCHAR( 255 )                          NOT NULL ,
    `field_optional`    ENUM( '0', '1' )                        NOT NULL ,
    `field_active`      ENUM( '1', '0' )                        NOT NULL
    ) TYPE = MYISAM ";

    $Queries['2_8r3_1'][] ="
    CREATE TABLE `customers_customfields` (
    `customer_id`   INT( 11 )       NOT NULL ,
    `field_id`      INT( 11 )       NOT NULL ,
    `field_value`   VARCHAR( 255 )  NOT NULL
    ) TYPE = MYISAM ";

    $Queries['2_8r3_1'][] ="
    CREATE TABLE `customers_orders` (
    `customer_id`   INT( 11 ) NOT NULL ,
    `order_id`      INT( 11 ) NOT NULL
    ) TYPE = MYISAM ";

    $Queries['2_8r3_1'][] ="
    CREATE TABLE `orders_invoices` (
    `order_id`   INT( 11 ) NOT NULL ,
    `invoice_id` INT( 11 ) NOT NULL
    ) TYPE = MYISAM ";

    $Queries['2_8r3_1'][] = "ALTER TABLE `customers` CHANGE `cust_deleted` `cust_deleted` ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "UPDATE `customers` SET `cust_deleted`='0' WHERE `cust_deleted`!='1'";

    $Queries['2_8r3_1'][] = "ALTER TABLE `customfields` ADD UNIQUE (`field_name`)";
    $Queries['2_8r3_1'][] = "INSERT INTO `customfields` VALUES ( '1' , 'name',      'text', '', '0', '1')";
    $Queries['2_8r3_1'][] = "INSERT INTO `customfields` VALUES ( '2' , 'address',   'text', '', '0', '1')";
    $Queries['2_8r3_1'][] = "INSERT INTO `customfields` VALUES ( '3' , 'city',      'text', '', '0', '1')";
    $Queries['2_8r3_1'][] = "INSERT INTO `customfields` VALUES ( '4' , 'zip',       'text', '', '0', '1')";
    $Queries['2_8r3_1'][] = "INSERT INTO `customfields` VALUES ( '5' , 'country',   'text', '', '0', '1')";
    $Queries['2_8r3_1'][] = "INSERT INTO `customfields` VALUES ( '6' , 'state',     'text', '', '0', '1')";
    $Queries['2_8r3_1'][] = "INSERT INTO `customfields` VALUES ( '7' , 'telephone', 'text', '', '0', '1')";
    $Queries['2_8r3_1'][] = "INSERT INTO `customfields` VALUES ( '8' , 'vat_no',    'text', '', '1', '1')";

    $Queries['2_8r3_2'][] = "ALTER TABLE `orders` CHANGE `cat_id`       `group_id`      INT( 11 )           NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `orders` CHANGE `plan`         `product_id`    INT( 11 )           NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `orders` CHANGE `dom_reg`      `dom_reg_type`  ENUM( '0', '1', '2') NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `orders` CHANGE `bill_cycle`   `bill_cycle`    INT( 3 )            NOT NULL DEFAULT '12'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `orders` CHANGE `pay_proc`     `pay_proc`      VARCHAR( 255 )      NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `orders` CHANGE `dom_reg_comp` `dom_reg_comp`  ENUM( '1', '0' )    NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `orders` CHANGE `remote_ip`    `remote_ip`     VARCHAR( 255 )      NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `orders` DROP                  `addon_ids` ";

    $Queries['2_8r3_2'][] = "ALTER TABLE `invoices` CHANGE `invoice_no`             `invoice_no`            INT( 11 )       NOT NULL AUTO_INCREMENT ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `invoices` CHANGE `payment_method`         `payment_method`        VARCHAR( 255 )  NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `invoices` CHANGE `pay_curr_name`          `pay_curr_name`         VARCHAR( 255 )  NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `invoices` CHANGE `pay_curr_symbol`        `pay_curr_symbol`       VARCHAR( 255 )  NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `invoices` CHANGE `pay_curr_decimal_str`   `pay_curr_decimal_str`  VARCHAR( 255 )  NOT NULL DEFAULT '.'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `invoices` CHANGE `pay_curr_thousand_str`  `pay_curr_thousand_str` VARCHAR( 255 )  NOT NULL DEFAULT ','";

    $Queries['2_8r3_2'][] = "ALTER TABLE `groups`   DROP   `products` ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `products` DROP   `addons` ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `products` ADD `domain` ENUM( '1', '0' ) NOT NULL DEFAULT '1' AFTER `subdomain` ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `products` CHANGE `default_cycle` `default_cycle` INT( 3 ) NOT NULL DEFAULT '13'";
    $Queries['2_8r3_2'][] = "UPDATE `products` SET `force_domain_subdomain` = '0' WHERE `force_domain_subdomain` !='1'";
    $Queries['2_8r3_2'][] = "UPDATE `products` SET `default_cycle` = '13' WHERE `default_cycle`=''";

    $Queries['2_8r3_2'][] = "ALTER TABLE    `billings_products` CHANGE  `product_table` `product_table` ENUM( 'addons', 'products', 'subdomains' ) NOT NULL DEFAULT 'products'";
    $Queries['2_8r3_2'][] = "UPDATE         `billings_products` SET     `product_table`='products'      WHERE `product_table`!='addons' AND `product_table`!='subdomains'";

    $Queries['2_8r3_2'][] = "UPDATE `order_conf` SET `disp_whois`='1' WHERE `disp_whois`='yes'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `maor_id`       `id`            INT( 11 )        NOT NULL AUTO_INCREMENT ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `disp_whois`    `en_whois`      ENUM( '1', '0' ) NOT NULL DEFAULT '1'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `order_para1`   `order_para`    LONGTEXT         NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `vat`           `en_vat`        ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `en_sub`        `en_subdomain`  ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `en_iv`         `en_iv`         ENUM( '0', '1' ) NOT NULL DEFAULT '1'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `en_cc`         `en_cc`         ENUM( '0', '1' ) NOT NULL DEFAULT '1'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `auto_email`    `en_automail`   ENUM( '0', '1' ) NOT NULL DEFAULT '1'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `en_support`    `en_support`    ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` CHANGE `order_page_title` `order_para_title` TEXT NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` ADD    `en_owndomain`   ENUM( '1', '0' ) NOT NULL DEFAULT '1'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` ADD    `lang_selector`  ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` ADD    `theme_selector` ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
    $Queries['2_8r3_2'][] = "ALTER TABLE `order_conf` DROP   `show_wizard` ";
    $Queries['2_8r3_2'][] = "UPDATE `order_conf` SET `en_whois`='0' WHERE `en_whois`=''";

    $Queries['2_8r3_2'][] = "ALTER TABLE `pp_vals` CHANGE `disp_msg` `disp_msg` TEXT NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `pp_vals` CHANGE `pp_name` `pp_name` VARCHAR( 255 ) NOT NULL ";
    $Queries['2_8r3_2'][] = "ALTER TABLE `pp_vals` ADD PRIMARY KEY ( `pp_name` ) ";

    $Queries['2_8r3_2'][] = "ALTER TABLE `geoip` ADD `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ";

    $Queries['2_8r3_2'][] = "ALTER TABLE `disc_token_codes` ADD PRIMARY KEY ( `disc_token_code` )";

    $Queries['2_8r3_2'][] = "ALTER TABLE `faqs` ADD `faqgroup_id` INT( 11 ) NOT NULL AFTER `faq_id` ";

    $Queries['2_8r3_2'][] = "DROP TABLE `temp` ";

    //sqls to upgrade from 2.7 r9 to 2.8 (build no 10)
    $Queries['2_8'][] = "
    CREATE TABLE `custom_scripts` (
    `id`                INT( 11 )                                            NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `file_name`         VARCHAR( 255 )                                       NOT NULL ,
    `post_variables`    TEXT                                                 NOT NULL ,
    `run_schedule`      ENUM( 'A_AC', 'A_PP', 'W_B', 'A_B', 'W_L', 'MANUAL', 'INACTIVE' ) NOT NULL DEFAULT 'INACTIVE'
    )
    TYPE = MYISAM
    ";
    $Queries['2_8'][] = "
    CREATE TABLE `billing_cycles` (
    `id`            INT( 11 )       NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `cycle_month`   INT( 3 )        NOT NULL ,
    `cycle_name`    VARCHAR( 255 )  NOT NULL
    )
    TYPE = MYISAM
    ";
    $Queries['2_8'][] = "
    CREATE TABLE `billings_products` (
    `billing_id`    INT NOT NULL ,
    `product_id`    INT NOT NULL ,
    `product_table` ENUM( 'addons', 'hosting_price', 'subdomains' ) NOT NULL ,
    `amount`        DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'
    )
    TYPE = MYISAM
    ";
    $Queries['2_8'][] = "
    CREATE TABLE `access_ips` (
    `id`            INT( 11 )       NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `ip_address`    VARCHAR( 25 )   NOT NULL ,
    `admin_id`      INT( 11 )       NOT NULL
    )
    TYPE = MYISAM
    ";
    $Queries['2_8'][] = "ALTER TABLE `order_conf` ADD `show_price`                  ENUM( '0', '1' )        NOT NULL DEFAULT '1'";
    $Queries['2_8'][] = "ALTER TABLE `order_conf` ADD `security_degree`             ENUM( '0', '1', '2' )   NOT NULL DEFAULT '0'";
    $Queries['2_8'][] = "ALTER TABLE `order_conf` ADD `image_verification_customer` ENUM( '0', '1' )        NOT NULL DEFAULT '0'";
    $Queries['2_8'][] = "ALTER TABLE `order_conf` ADD `image_verification_admin`    ENUM( '0', '1' )        NOT NULL DEFAULT '0'";

    $Queries['2_8'][] = "ALTER TABLE `specials` ADD `auto_desc` ENUM( '0', '1' ) NOT NULL DEFAULT '1'";

    $Queries['2_8'][] = "ALTER TABLE `hosting_price` ADD `force_domain_subdomain` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `subdomain`" ;
    $Queries['2_8'][] = "ALTER TABLE `hosting_price` ADD `plan_index`             INT( 11 )        NOT NULL DEFAULT '1'";

    $Queries['2_8'][] = "ALTER TABLE `servers` CHANGE `username_regexp` `username_min_length` INT( 2 ) NOT NULL DEFAULT '5'";
    $Queries['2_8'][] = "ALTER TABLE `servers` CHANGE `username_prefix` `username_max_length` INT( 2 ) NOT NULL DEFAULT '8'";

    $Queries['2_8'][] = "ALTER TABLE `billing_cycles` ADD UNIQUE ( `cycle_month` ,`cycle_name`)";

    $Queries['2_8_INSERTS'][] = "INSERT INTO `billing_cycles` ( `id` , `cycle_month` , `cycle_name` ) VALUES ('1' , '1',  'monthly')";
    $Queries['2_8_INSERTS'][] = "INSERT INTO `billing_cycles` ( `id` , `cycle_month` , `cycle_name` ) VALUES ('2' , '3',  'quarterly')";
    $Queries['2_8_INSERTS'][] = "INSERT INTO `billing_cycles` ( `id` , `cycle_month` , `cycle_name` ) VALUES ('3' , '6',  'half_yearly')";
    $Queries['2_8_INSERTS'][] = "INSERT INTO `billing_cycles` ( `id` , `cycle_month` , `cycle_name` ) VALUES ('4' , '12', 'yearly')";

    //sqls to upgrade from 2.7 r8 to 2.7 r9 (build no 9)
    $Queries['2_7r9'][] = "ALTER TABLE `order_conf` ADD `send_pending_invoice_everyday` ENUM( '0', '1' ) NOT NULL DEFAULT '0' ";

    //sqls to upgrade from 2.7 r5 to 2.7 r8 (build no 7)
    $Queries['2_7r8'][] = "ALTER TABLE `addons` CHANGE `addon_setup` `addon_setup` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `addons` CHANGE `monthly`     `monthly`     DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `addons` CHANGE `quarterly`   `quarterly`   DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `addons` CHANGE `half_yearly` `half_yearly` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `addons` CHANGE `yearly`      `yearly`      DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";

    $Queries['2_7r8'][] = "ALTER TABLE `currency` CHANGE `curr_factor`  `curr_factor`   DECIMAL( 16, 6 ) NOT NULL";

    $Queries['2_7r8'][] = "ALTER TABLE `customers` CHANGE `discount` `discount` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `customers` CHANGE `credit`   `credit`   DECIMAL( 16, 6 ) NOT NULL               ";

    $Queries['2_7r8'][] = "ALTER TABLE `domain_price` CHANGE `dom_price` `dom_price` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";

    $Queries['2_7r8'][] = "ALTER TABLE `hosting_price` CHANGE `host_setup_fee` `host_setup_fee` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `hosting_price` CHANGE `monthly`        `monthly`        DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `hosting_price` CHANGE `quarterly`      `quarterly`      DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `hosting_price` CHANGE `half_yearly`    `half_yearly`    DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `hosting_price` CHANGE `yearly`         `yearly`         DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";

    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `debit_credit_amount` `debit_credit_amount` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `setup_fee`           `setup_fee`           DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `cycle_fee`           `cycle_fee`           DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `tld_fee`             `tld_fee`             DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `inv_tld_disc`        `inv_tld_disc`        DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `inv_plan_disc`       `inv_plan_disc`       DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `inv_addon_disc`      `inv_addon_disc`      DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `other_amount`        `other_amount`        DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `net_amount`          `net_amount`          DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `tax_amount`          `tax_amount`          DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `gross_amount`        `gross_amount`        DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `pay_curr_factor`     `pay_curr_factor`     DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `invoices` CHANGE `prorate_amount`      `prorate_amount`      DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";

    $Queries['2_7r8'][] = "ALTER TABLE `specials` CHANGE `special_net`      `special_net`      DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `specials` CHANGE `special_net_disc` `special_net_disc` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";

    $Queries['2_7r8'][] = "ALTER TABLE `subdomains` CHANGE `monthly`     `monthly`     DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `subdomains` CHANGE `quarterly`   `quarterly`   DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `subdomains` CHANGE `half_yearly` `half_yearly` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";
    $Queries['2_7r8'][] = "ALTER TABLE `subdomains` CHANGE `yearly`      `yearly`      DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";

    $Queries['2_7r8'][] = "ALTER TABLE `tax` CHANGE `tax_amount` `tax_amount` DECIMAL( 16, 6 ) NOT NULL DEFAULT '0.00'";

    //sqls to upgrade from 2.7 r2 to 2.7 r5 (build no 6)
    $Queries['2_7r5'][] = "ALTER TABLE `emails` ADD `email_subject` TEXT NOT NULL";

    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `decimal_str`           VARCHAR( 15 )         NOT NULL DEFAULT '.'     ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `thousand_str`          VARCHAR( 15 )         NOT NULL DEFAULT ','     ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `en_prorate`            ENUM( '0', '1' )      NOT NULL DEFAULT '0'     ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `curr_symbol_prefixed`  ENUM( '0', '1' )      NOT NULL DEFAULT '1'     ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `date_format`           VARCHAR( 25 )         NOT NULL DEFAULT 'd-M-Y' ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `decimal_number`        INT( 3 )              NOT NULL DEFAULT '2'     ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `records_per_page`      INT( 11 )             NOT NULL DEFAULT '50'    ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `prorate_date`          INT( 2 )              NOT NULL                 ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `tax_calculation`       ENUM( '0', '1', '2' ) NOT NULL DEFAULT '0'     ";
    $Queries['2_7r5'][] = "ALTER TABLE `order_conf` ADD `show_loader`           ENUM( '0', '1' )      NOT NULL DEFAULT '0'     ";

    $Queries['2_7r5'][] = "ALTER TABLE `currency` ADD    `curr_decimal_number`  INT( 3 )            NOT NULL DEFAULT '2'";
    $Queries['2_7r5'][] = "ALTER TABLE `currency` ADD    `curr_decimal_str`     VARCHAR( 15 )       NOT NULL DEFAULT '.'";
    $Queries['2_7r5'][] = "ALTER TABLE `currency` ADD    `curr_thousand_str`    VARCHAR( 15 )       NOT NULL DEFAULT ','";
    $Queries['2_7r5'][] = "ALTER TABLE `currency` ADD    `curr_symbol_prefixed` ENUM( '0', '1' )    NOT NULL DEFAULT '1'";

    $Queries['2_7r5'][] = "ALTER TABLE `invoices` ADD    `pay_curr_decimal_number`      INT( 3 )            NOT NULL DEFAULT '2'  ";
    $Queries['2_7r5'][] = "ALTER TABLE `invoices` ADD    `pay_curr_decimal_str`         VARCHAR( 15 )       NOT NULL DEFAULT '.'  ";
    $Queries['2_7r5'][] = "ALTER TABLE `invoices` ADD    `pay_curr_thousand_str`        VARCHAR( 15 )       NOT NULL DEFAULT ','  ";
    $Queries['2_7r5'][] = "ALTER TABLE `invoices` ADD    `pay_curr_symbol_prefixed`     ENUM( '0', '1' )    NOT NULL DEFAULT '1'  ";
    $Queries['2_7r5'][] = "ALTER TABLE `invoices` ADD    `prorate_desc`                 TEXT                NOT NULL              ";
    $Queries['2_7r5'][] = "ALTER TABLE `invoices` ADD    `prorate_amount`               DECIMAL( 16, 6 )      NOT NULL DEFAULT '0.00'";

    $Queries['2_7r5'][] = "ALTER TABLE `servers` ADD `username_regexp` VARCHAR( 255 ) NOT NULL DEFAULT ''";
    $Queries['2_7r5'][] = "ALTER TABLE `servers` ADD `username_prefix` VARCHAR( 255 ) NOT NULL";

    $Queries['2_7r5'][] = "ALTER TABLE `sub_order` CHANGE `dom_user` `dom_user` VARCHAR( 255 ) NOT NULL";
    $Queries['2_7r5'][] = "ALTER TABLE `sub_order` CHANGE `dom_pass` `dom_pass` VARCHAR( 255 ) NOT NULL";

    $Queries['2_7r5'][] = "ALTER TABLE `subdomains` CHANGE `reserved_names` `reserved_names` TEXT NOT NULL ";

    $Queries['2_7r5'][] = "INSERT INTO `emails` ( `email_id` , `email_text` , `email_subject` )
    VALUES (
    '3', '<lang>Dear</lang> <&&>client_name<&&>,<br><br> <lang>Thanks_for_payment</lang> <&&>invoice_no<&&><br><br> <lang>Date</lang>: <&&>payment_date<&&><br> <lang>Order_no</lang>: <&&>order_no<&&><br> <lang>Amount_paid</lang>: <&&>amount_paid<&&><br> <b><lang>Description</lang></b>:<br> <&&>description<&&><br><br> <lang>regards</lang><br> <&&>company_name<&&><br>', ''
    )";

    //sqls to upgrade from 2.7 to 2.7 r2 (build no 5)
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `emailer`            ENUM( 'mail', 'sendmail', 'smtp' ) NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `email_priority`     ENUM( '1','3','5' )                NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `email_charset`      VARCHAR( 15 )                      NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `email_content_type` VARCHAR( 15 )                      NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `email_encoding`     ENUM( '8bit', '7bit', 'binary', 'base64', 'quoted-printable' ) NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `email_wordwrap`     INT( 3 )                           NOT NULL DEFAULT '0'";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `email_sender`       VARCHAR( 255 )                     NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `sendmail_path`      VARCHAR( 255 )                     NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `reading_confirm`    VARCHAR( 255 )                     NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `smtp_host`          VARCHAR( 255 )                     NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `smtp_port`          INT( 10 )                          NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `smtp_auth`          ENUM( '0', '1' )                   NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `smtp_user`          VARCHAR( 255 )                     NOT NULL";
    $Queries['2_7r2'][] = "ALTER TABLE `order_conf` ADD `smtp_pass`          VARCHAR( 255 )                     NOT NULL";

    $Queries['2_7r2'][] = "
    CREATE TABLE IF NOT EXISTS  `registerfly` (
    `registerfly_id`           MEDIUMINT(8)                    NOT NULL    AUTO_INCREMENT    PRIMARY KEY ,
    `registerfly_uid`          VARCHAR(255)                    NOT NULL                                  ,
    `registerfly_pw`           VARCHAR(255)                    NOT NULL                                  ,
    `registerfly_active`       VARCHAR(10)                     NOT NULL                                  ,
    `registerfly_test_mode`    VARCHAR(255)                    NOT NULL
    )
    TYPE = MYISAM";

    //sqls to upgrade from 2.6 r6 to 2.7 (build no 4)
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `plan_friendly_name`        VARCHAR( 255 )         NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `activation_mail_template`  TEXT                   NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `suspended_mail_template`   TEXT                   NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `cpanel_reseller`           ENUM( '0', '1' )       NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `cpr_profile_id`            INT( 11 )              NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `plesk_profile_id`          INT( 11 )              NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `cip`                       ENUM( '0', '1' )       NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `cgi`                       ENUM( '0', '1' )       NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `quota`                     VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `frontpage`                 ENUM( '0', '1' )       NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `cp`                        VARCHAR( 25 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `maxftp`                    VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `maxsql`                    VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `maxpop`                    VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `maxlst`                    VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `maxsub`                    VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `bwlimit`                   VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `hasshell`                  ENUM( '0', '1' )       NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `maxpark`                   VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `maxaddon`                  VARCHAR( 11 )          NOT NULL";
    $Queries['2_7'][] = "ALTER TABLE `hosting_price` ADD `da_reseller`               ENUM( '0', '1', '2', '3' )  NOT NULL";

    $Queries['2_7'][] = "ALTER TABLE `servers` ADD `server_pass` LONGTEXT NOT NULL AFTER `server_user`";

    $Queries['2_7'][] = "
    CREATE TABLE `cpanel_reseller_profiles`
    (
    `cpr_profile_id`                INT                     NOT NULL    AUTO_INCREMENT PRIMARY KEY ,
    `limit_type`                    ENUM( '0', '1', '2' )   NOT NULL ,
    `resnumlimitamt`                INT                     NOT NULL ,
    `rslimit_disk`                  INT                     NOT NULL ,
    `rsolimit_disk`                 ENUM( '0', '1' )        NOT NULL ,
    `rslimit_bw`                    INT NOT NULL ,
    `rsolimit_bw`                   ENUM( '0', '1' ) NOT NULL ,
    `edit_ns`                       ENUM( '0', '1' ) NOT NULL ,
    `acl_allow_unlimited_disk_pkgs` ENUM( '0', '1' ) NOT NULL ,
    `acl_allow_unlimited_pkgs`      ENUM( '0', '1' ) NOT NULL ,
    `acl_edit_pkg`                  ENUM( '0', '1' ) NOT NULL ,
    `acl_create_acct`               ENUM( '0', '1' ) NOT NULL ,
    `acl_edit_account`              ENUM( '0', '1' ) NOT NULL ,
    `acl_suspend_acct`              ENUM( '0', '1' ) NOT NULL ,
    `acl_kill_acct`                 ENUM( '0', '1' ) NOT NULL ,
    `acl_upgrade_account`           ENUM( '0', '1' ) NOT NULL ,
    `acl_create_dns`                ENUM( '0', '1' ) NOT NULL ,
    `acl_add_pkg`                   ENUM( '0', '1' ) NOT NULL ,
    `acl_all`                       ENUM( '0', '1' ) NOT NULL ,
    `acl_add_pkg_shell`             ENUM( '0', '1' ) NOT NULL ,
    `acl_add_pkg_ip`                ENUM( '0', '1' ) NOT NULL ,
    `acl_allow_addoncreate`         ENUM( '0', '1' ) NOT NULL ,
    `acl_allow_parkedcreate`        ENUM( '0', '1' ) NOT NULL ,
    `acl_limit_bandwidth`           ENUM( '0', '1' ) NOT NULL ,
    `acl_clustering`                ENUM( '0', '1' ) NOT NULL ,
    `acl_kill_dns`                  ENUM( '0', '1' ) NOT NULL ,
    `acl_onlyselfandglobalpkgs`     ENUM( '0', '1' ) NOT NULL ,
    `acl_edit_dns`                  ENUM( '0', '1' ) NOT NULL ,
    `acl_edit_mx`                   ENUM( '0', '1' ) NOT NULL ,
    `acl_frontpage`                 ENUM( '0', '1' ) NOT NULL ,
    `acl_ssl`                       ENUM( '0', '1' ) NOT NULL ,
    `acl_mod_subdomains`            ENUM( '0', '1' ) NOT NULL ,
    `acl_list_accts`                ENUM( '0', '1' ) NOT NULL ,
    `acl_mailcheck`                 ENUM( '0', '1' ) NOT NULL ,
    `acl_disallow_shell`            ENUM( '0', '1' ) NOT NULL ,
    `acl_news`                      ENUM( '0', '1' ) NOT NULL ,
    `acl_park_dns`                  ENUM( '0', '1' ) NOT NULL ,
    `acl_passwd`                    ENUM( '0', '1' ) NOT NULL ,
    `acl_quota`                     ENUM( '0', '1' ) NOT NULL ,
    `acl_rearrange_accts`           ENUM( '0', '1' ) NOT NULL ,
    `acl_res_cart`                  ENUM( '0', '1' ) NOT NULL ,
    `acl_restart`                   ENUM( '0', '1' ) NOT NULL ,
    `acl_resftp`                    ENUM( '0', '1' ) NOT NULL ,
    `acl_demo_setup`                ENUM( '0', '1' ) NOT NULL ,
    `acl_show_bandwidth`            ENUM( '0', '1' ) NOT NULL ,
    `acl_stats`                     ENUM( '0', '1' ) NOT NULL ,
    `acl_status`                    ENUM( '0', '1' ) NOT NULL
    )
    TYPE = MyISAM" ;

    $Queries['2_7'][] = "
    CREATE TABLE `plesk_ids`
    (
    `cust_id`   INT( 11 ) NOT NULL ,
    `plesk_id`  INT( 11 ) NOT NULL
    )
    TYPE = MyISAM" ;

    $Queries['2_7'][] = "
    CREATE TABLE `plesk_profiles`
    (
    `plesk_profile_id`          INT( 11 )        NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `create_domains`            ENUM( '0', '1' ) NOT NULL ,
    `manage_phosting`           ENUM( '0', '1' ) NOT NULL ,
    `manage_quota`              ENUM( '0', '1' ) NOT NULL ,
    `manage_subdomains`         ENUM( '0', '1' ) NOT NULL ,
    `manage_not_chroot_shell`   ENUM( '0', '1' ) NOT NULL ,
    `change_limits`             ENUM( '0', '1' ) NOT NULL ,
    `manage_dns`                ENUM( '0', '1' ) NOT NULL ,
    `manage_log`                ENUM( '0', '1' ) NOT NULL ,
    `manage_crontab`            ENUM( '0', '1' ) NOT NULL ,
    `manage_anonftp`            ENUM( '0', '1' ) NOT NULL ,
    `manage_webapps`            ENUM( '0', '1' ) NOT NULL ,
    `manage_sh_access`          ENUM( '0', '1' ) NOT NULL ,
    `manage_maillists`          ENUM( '0', '1' ) NOT NULL ,
    `manage_drweb`              ENUM( '0', '1' ) NOT NULL ,
    `make_dumps`                ENUM( '0', '1' ) NOT NULL ,
    `site_builder`              ENUM( '0', '1' ) NOT NULL
    )
    TYPE = MyISAM" ;

    $Queries['2_7'][] = "
    CREATE TABLE `ord_inv_rec`
    (
    `rec_ord_id`        INT( 11 )           NOT NULL                        ,
    `rec_next_date`     DATE                NOT NULL DEFAULT '0000-00-00'
    )
    TYPE = MyISAM" ;


    $Queries['2_7'][] = "ALTER TABLE `ord_inv_rec` ADD UNIQUE ( `rec_ord_id` )";

    $Queries['2_7'][] = "ALTER TABLE `order_server_ip` CHANGE `acct_status` `acct_status` ENUM( '0', '1', '2', '3' ) NOT NULL DEFAULT '0'";

    //sqls to upgrade from 2.6 r5 to 2.6 r6 (build no 3)
    $Queries['2_6r6'][] = "
    CREATE TABLE `extra_fields`
    (
    `field_id`  INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `cust_id`   INT( 11 ) NOT NULL ,
    `sub_id`    INT( 11 ) NOT NULL ,
    `inv_no`    INT( 11 ) NOT NULL
    )
    TYPE = MyISAM" ;

    $Queries['2_6r6'][] = "ALTER TABLE `customers` CHANGE `discount` `discount` DECIMAL( 4, 2 ) NOT NULL DEFAULT '0.00'";

    $Queries['2_6r6'][] = "ALTER TABLE `payment_log` ADD    `posted_vars`       TEXT            NOT NULL";
    $Queries['2_6r6'][] = "ALTER TABLE `payment_log` ADD    `payment_method`    VARCHAR( 25 )   NOT NULL";

    $Queries['2_6r6'][] = "ALTER TABLE `order_conf`  ADD `en_html_editor` ENUM( '1', '0' ) NOT NULL DEFAULT '1'";

    $Queries['2_6r6'][] = "ALTER TABLE `invoices` CHANGE `transaction_id` `transaction_id` VARCHAR( 255 ) NOT NULL DEFAULT '0'";

    //sqls to upgrade from 2.6 r4 to 2.6 r5 (build no 2)
    $Queries['2_6r5'][] = "ALTER TABLE `order_conf` ADD `u_invoice_date` INT( 3 )  			NOT NULL DEFAULT '90'";
    $Queries['2_6r5'][] = "ALTER TABLE `order_conf` ADD `build` 		  INT( 11 ) 		NOT NULL DEFAULT '1' ";
    $Queries['2_6r5'][] = "ALTER TABLE `order_conf` ADD `ask_login_info` ENUM( '1', '0' ) 	NOT NULL			 ";

    $Queries['2_6r5'][] = "ALTER TABLE `sub_order` 	ADD `cat_id`  INT( 11 ) NOT NULL DEFAULT '1' AFTER `parent_id`";

    $Queries['2_6r5'][] = "ALTER TABLE `tax` CHANGE `tax_amount` `tax_amount` DECIMAL( 4, 2 ) NOT NULL DEFAULT '0.00'";

    $Queries['2_6r5'][] = "ALTER TABLE `customers` ADD `creation_date` DATE NOT NULL";


    //Install SQLs of accountlab (basic version)
    $install_sql_array1 = array(
        "
        CREATE TABLE    `acl_master`
        (
        `master_id`             INT(11)         NOT NULL                    AUTO_INCREMENT      ,
        `ma_cust_id`            VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `slave_id`              VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `ms_type`               VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `ms_status`             VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        PRIMARY KEY (`master_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `announce`
        (
        `ann_id`                INT(11)         NOT NULL                    AUTO_INCREMENT      ,
        `an_title`              VARCHAR(255)                DEFAULT NULL                        ,
        `an_body`               LONGTEXT                                                        ,
        PRIMARY KEY (`ann_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `cust_tab`
        (
        `id`                    INT(11)         NOT NULL                    AUTO_INCREMENT      ,
        `username`              VARCHAR(16)                 DEFAULT NULL                        ,
        `password`              VARCHAR(16)                 DEFAULT NULL                        ,
        `email`                 VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `name`                  VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `address`               VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `city`                  VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `state`                 VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `zip`                   VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `country`               VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `telephone`             VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `plan`                  VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `bill_cycle`            VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `sign_date`             DATE            NOT NULL    DEFAULT '0000-00-00'                ,
        `domain_name`           VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `dom_reg`               VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `net_pay`               DECIMAL(6,2)    NOT NULL    DEFAULT '0.00'                      ,
        `tax_pay`               DECIMAL(6,2)    NOT NULL    DEFAULT '0.00'                      ,
        `cycle_pay`             DECIMAL(6,2)    NOT NULL    DEFAULT '0.00'                      ,
        `initial_pay`           DECIMAL(6,2)    NOT NULL    DEFAULT '0.00'                      ,
        `cust_status`           VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `remote_ip`             VARCHAR(250)    NOT NULL    DEFAULT ''                          ,
        `client_notes`          VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `server`                VARCHAR(250)    NOT NULL    DEFAULT ''                          ,
        `server_ip`             VARCHAR(250)    NOT NULL    DEFAULT ''                          ,
        `name_ser_1`            VARCHAR(250)    NOT NULL    DEFAULT ''                          ,
        `name_ser_2`            VARCHAR(250)    NOT NULL    DEFAULT ''                          ,
        `pay_proc`              VARCHAR(250)    NOT NULL    DEFAULT ''                          ,
        `fs_complete`           VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `dom_reg_comp`          VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `dom_reg_result`        VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `di_cust_id`            VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `di_cont_id`            VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        `dom_registrar`         VARCHAR(255)    NOT NULL    DEFAULT ''                          ,
        PRIMARY KEY  (`id`)                                                                ,
        UNIQUE KEY `username` (`username`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `dbusers`
        (
        `id`                    INT(11)         NOT NULL                    AUTO_INCREMENT      ,
        `username`              VARCHAR(16)                 DEFAULT NULL                        ,
        `password`              VARCHAR(160)                DEFAULT NULL                        ,
        `email`                 VARCHAR(25)     NOT NULL    DEFAULT ''                          ,
        PRIMARY KEY  (`id`)                                                                ,
        UNIQUE KEY `username` (`username`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `directi`
        (
        `di_id`                 MEDIUMINT(8) UNSIGNED   NOT NULL                AUTO_INCREMENT  ,
        `di_uid`                VARCHAR(100)            NOT NULL DEFAULT ''                     ,
        `di_pw`                 VARCHAR(100)            NOT NULL DEFAULT ''                     ,
        `di_par_id`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `di_active`             VARCHAR(10)             NOT NULL DEFAULT ''                     ,
        `di_url`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `di_debug`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`di_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `domext`
        (
        `dom_extension`         VARCHAR(100)            NOT NULL DEFAULT ''
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `emails`
        (
        `email_id`              INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `email_name`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `email_text`            LONGTEXT                NOT NULL                                ,
        PRIMARY KEY  (`email_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `enom`
        (
        `en_id`                 MEDIUMINT(8) UNSIGNED   NOT NULL                AUTO_INCREMENT  ,
        `enom_uid`              VARCHAR(100)            NOT NULL DEFAULT ''                     ,
        `enom_pw`               VARCHAR(100)            NOT NULL DEFAULT ''                     ,
        `enom_active`           VARCHAR(10)             NOT NULL DEFAULT ''                     ,
        `enom_test_mode`        VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`en_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `faq`
        (
        `faq_id`                INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `questions`             VARCHAR(255)                     DEFAULT NULL                   ,
        `answers`               LONGTEXT                                                        ,
        PRIMARY KEY  (`faq_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `fraud_score`
        (
        `fraud_id`              INT(55)                 NOT NULL                AUTO_INCREMENT  ,
        `user`                  VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `ip_isp`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `ip_org`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `custPhoneInBillingLoc` VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `highRiskCountry`       VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `distance`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `countryMatch`          VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `countryCode`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `freeMail`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `anonymousProxy`        VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `proxyScore`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `spamScore`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `score`                 VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`fraud_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `invoice_schedule`
        (
        `cust_id`               VARCHAR(40)                      DEFAULT NULL                   ,
        `pay_cycle`             VARCHAR(100)            NOT NULL DEFAULT ''                     ,
        `order_date`            DATE                    NOT NULL DEFAULT '0000-00-00'           ,
        `next_pay_date`         DATE                    NOT NULL DEFAULT '0000-00-00'
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `invoices`
        (
        `cust_id`               VARCHAR(40)                      DEFAULT NULL                   ,
        `desc`                  VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `due_date`              DATE                    NOT NULL DEFAULT '0000-00-00'           ,
        `invoice_no`            INT(20)                 NOT NULL                AUTO_INCREMENT  ,
        `net_amount`            DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        `tax_amount`            DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        `gross_amount`          DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        `status`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`invoice_no`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `messages`
        (
        `message_id`            INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `message_parent_id`     INT(11)                          DEFAULT NULL                   ,
        `cat_id`                INT(11)                          DEFAULT NULL                   ,
        `topic`                 VARCHAR(50)                      DEFAULT NULL                   ,
        `author`                VARCHAR(50)                      DEFAULT NULL                   ,
        `message`               TEXT                                                            ,
        `date_entered`          DATETIME                         DEFAULT NULL                   ,
        PRIMARY KEY  (`message_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `order_conf`
        (
        `maor_id`               INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `symbol`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `company_name`          VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `comp_email`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `terms_url`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `mb_fs_lic`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `disp_whois`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `path_url`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `path_abs`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `order_para1`           LONGTEXT                NOT NULL                                ,
        PRIMARY KEY  (`maor_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `pay_proc`
        (
        `id`                    MEDIUMINT(8) UNSIGNED   NOT NULL                AUTO_INCREMENT  ,
        `al_tab_id`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pp_enable`             VARCHAR(40)                      DEFAULT NULL                   ,
        `pp_currency`           VARCHAR(100)            NOT NULL DEFAULT ''                     ,
        `pp_email`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pp_name`               VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `tco_enable`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `tco_id`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `tco_name`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `tco_version`           VARCHAR(100)            NOT NULL DEFAULT ''                     ,
        `wp_enable`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `wp_mode`               VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `wp_instid`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `wp_pass`               VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `wp_currency`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `wp_name`               VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `nc_enable`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `nc_email`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `nc_name`               VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `of_enable`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `of_url`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `of_name`               VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `payment_log`
        (
        `payment_id`            INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `item_name`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `invoice_no`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `payer_email`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `txn_id`                VARCHAR(20)             NOT NULL DEFAULT ''                     ,
        `status`                VARCHAR(20)             NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`payment_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `plesk_auto`
        (
        `auto_id`               INT(55)                 NOT NULL                AUTO_INCREMENT  ,
        `host_name`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `action`                LONGTEXT                NOT NULL                                ,
        PRIMARY KEY  (`auto_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `plesk_ips`
        (
        `psa_ip_id`             INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `psa_ip`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `psa_ip_server`         VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `psa_ip_user`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `psa_ip_status`         VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`psa_ip_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `plesk_plans`
        (
        `plan_name`             VARCHAR(15)             NOT NULL DEFAULT ''                     ,
        `hard_quota`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `fp`                    VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `ssi`                   VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `php`                   VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `cgi`                   VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `perl`                  VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `asp`                   VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `python`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `coldfusion`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `ssl`                   VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `webstat`               VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `err_docs`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `clogin`                VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_disk_space`         VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_traffic`        VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pf_max_box`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_mbox_quota`         VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_redir`          VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_mg`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_resp`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_wu`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_db`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_maillists`      VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_webapps`        VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_max_subdom`         VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_wuscripts`          VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `pr_webmail`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`plan_name`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `pricing`
        (
        `price_id`              INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `dom_ext`               VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `dom_period`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `dom_price`             DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        PRIMARY KEY  (`price_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `pricing_hosting`
        (
        `plan_price_id`         INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `plan_name`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `host_setup_fee`        DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        `monthly`               DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        `quarterly`             DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        `half_yearly`           DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        `yearly`                DECIMAL(6,2)            NOT NULL DEFAULT '0.00'                 ,
        `welc_email`            LONGTEXT                NOT NULL                                ,
        PRIMARY KEY  (`plan_price_id`)
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE    `servers`
        (
        `server_id`             INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `server_name`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `server_ip`             VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `name_server_1`         VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `name_server_2`         VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `server_type`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `server_user`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `server_hash`           LONGTEXT                NOT NULL                                ,
        `server_auto`           VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `server_ssl`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `server_default`        VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`server_id`)
        ) TYPE=MyISAM
        ",
        "
        CREATE TABLE    `tax`
        (
        `tax_id`                INT(11)                 NOT NULL                AUTO_INCREMENT  ,
        `tax_name`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `tax_amount`            VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `tax_area`              VARCHAR(255)            NOT NULL DEFAULT ''                     ,
        `tax_enabled`           CHAR(2)                 NOT NULL DEFAULT ''                     ,
        PRIMARY KEY  (`tax_id`)
        )
        TYPE=MyISAM
        "
    );
    $install_sql_array2 = array(
        "
        INSERT  INTO    `admin_users`
        VALUES
        (
        '',
        'admin',
        '~admin_pass',
        '~admin_email',
        '',
        '0',
        ''
        )
        ",
        "
        INSERT  INTO    `order_conf`
        (
        `maor_id`,
        `symbol`,
        `curr_name`,
        `company_name`,
        `company_address`,
        `comp_email`,
        `terms_url`,
        `disp_whois`,
        `path_url`,
        `path_abs`,
        `order_para1`,
        `d_lang`
        )
        VALUES
        (
        '',
        '$',
        'USD',
        '',
        '',
        '~admin_email',
        '',
        'no',
        '~ins_url',
        '~ins_path',
        '',
        'english'
        )
        ",
        "
        INSERT  INTO    `emails`
        (
        `email_id`,
        `email_text`
        )
        VALUES
        (
        '1',
        '<lang>Hello</lang> <&&>client_name<&&><br><br>

        <lang>mail_body</lang><br><br>

        <lang>regards</lang><br><br>

        <&&>company_name<&&><br><br>

        <hr><br>

        <lang>Order_By</lang>:<br>
        <lang>Name</lang>: <&&>client_name<&&><br>
        <lang>Email</lang>: <&&>client_email<&&><br><br>

        <lang>Address</lang>: <br>
        <&&>client_name<&&><br>
        <&&>client_address<&&><br>
        <&&>client_city<&&><br>
        <&&>client_state<&&> <&&>client_zip<&&><br>
        <&&>client_country<&&><br><br>

        <lang>Order_Details</lang>:<br>
        <lang>Order_no</lang>: <&&>order_no<&&><br>
        <lang>Plan</lang>: <&&>plan_name<&&><br>
        <lang>domain_name</lang>: <&&>domain_name<&&><br>
        <lang>Date</lang>: <&&>sign_date<&&><br><br>
        <&&>login_for<&&><br>
        <lang>Username</lang>: <&&>username<&&><br>
        <lang>Password</lang>: <&&>password<&&><br><br>

        <&&>login_link<&&><br><br>

        <hr><br>'
        ),
        (
        '2',
        '
        <b><lang>Invoice_from</lang></b> :<br>
        <&&>company_name<&&><br>
        <&&>company_email<&&><br>
        <&&>company_address<&&><br><br>

        <b><lang>To</lang></b> :<br>
        <&&>client_name<&&><br>
        <&&>client_address<&&><br>
        <&&>client_city<&&><br>
        <&&>client_state<&&> <&&>client_zip<&&><br>
        <&&>client_country<&&><br><br>

        <b><lang>Invoice_No</lang></b> : <&&>invoice_no<&&><br>
        <b><lang>Date</lang></b> :  <&&>due_date<&&><br>
        <b><lang>Description</lang></b> : <&&>description<&&><br>
        <hr>
        <start_table>
        <if_domain>
        <tr>
        <td align=left width=60%><&&>domain_name<&&></td>
        <td align=right><&&>domain_amount<&&></td></tr>
        </if_domain>
        <if_setup>
        <tr>
        <td align=left><lang>setup_fee</lang></td>
        <td align=right><&&>setup_amount<&&></td>
        </tr>
        </if_setup>
        <if_cycle>
        <tr>
        <td align=left><&&>cycle<&&></td>
        <td align=right><&&>cycle_amount<&&></td>
        </tr>
        </if_cycle>
        <if_order_addon>
        <tr>
        <td align=left><&&>order_addon<&&></td>
        <td align=right><&&>order_addon_amount<&&></td>
        </tr>
        </if_order_addon>
        <if_discount>
        <tr>
        <td align=left><lang>discount</lang></td>
        <td align=right><&&>discount_amount<&&></td>
        </tr>
        </if_discount>
        <if_debit_credit>
        <tr>
        <td align=left><&&>debit_credit<&&>(<&&>debit_credit_reason<&&>)</td>
        <td align=right><&&>debit_credit_amount<&&></td>
        </tr>
        </if_debit_credit>
        <if_prorate>
        <tr>
        <td align=left><&&>prorate_desc<&&></td>
        <td align=right><&&>prorate_amount<&&></td>
        </tr>
        </if_prorate>
        <end_table>
        <hr>
        <start_table>
        <tr>
        <td align=left width=60%><lang>subtotal</lang></td>
        <td align=right><&&>net_amount<&&></td>
        </tr>
        <if_tax>
        <tr>
        <td align=left><&&>tax_name<&&></td>
        <td align=right><&&>tax_amount<&&></td>
        </tr>
        </if_tax>
        <tr>
        <td align=left><lang>total_due</lang></td>
        <td align=right><&&>total_amount<&&></td>
        </tr>
        <tr>
        <td align=right colspan=2>
        <&&>additional_currency<&&>
        </td>
        </tr>
        <end_table>
        <hr>
        <&&>pay_text<&&>
        <hr>
        <mail_footer><br><br>
        <&&>payment_link<&&><br><br>

        <lang>regards</lang><br>

        <&&>company_name<&&><br>
        </mail_footer>'
        )
        "
    );
    //Upgrade SQLs it will upgrade any previous version to the current version
    $upgrade_sql_array1 = array(
        "
        CREATE TABLE IF NOT EXISTS  `sub_order`
        (
        `sub_id`          INT(11)         NOT NULL                                AUTO_INCREMENT  ,
        `parent_id`       INT(11)         NOT NULL    DEFAULT '0'                                 ,
        `plan`            VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `bill_cycle`      VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `sign_date`       DATE            NOT NULL    DEFAULT '0000-00-00'                        ,
        `domain_name`     VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `dom_reg`         VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `net_pay`         DECIMAL(10,2)   NOT NULL    DEFAULT '0.00'                              ,
        `tax_pay`         DECIMAL(10,2)   NOT NULL    DEFAULT '0.00'                              ,
        `cycle_pay`       DECIMAL(10,2)   NOT NULL    DEFAULT '0.00'                              ,
        `initial_pay`     DECIMAL(10,2)   NOT NULL    DEFAULT '0.00'                              ,
        `cust_status`     VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `remote_ip`       VARCHAR(250)    NOT NULL    DEFAULT ''                                  ,
        `client_notes`    VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `server`          VARCHAR(250)    NOT NULL    DEFAULT ''                                  ,
        `server_ip`       VARCHAR(250)    NOT NULL    DEFAULT ''                                  ,
        `name_ser_1`      VARCHAR(250)    NOT NULL    DEFAULT ''                                  ,
        `name_ser_2`      VARCHAR(250)    NOT NULL    DEFAULT ''                                  ,
        `pay_proc`        VARCHAR(250)    NOT NULL    DEFAULT ''                                  ,
        `fs_complete`     VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `dom_reg_comp`    VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `dom_reg_result`  VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `di_cust_id`      VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `di_cont_id`      VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `dom_registrar`   VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `dom_user`        VARCHAR(16)     NOT NULL    DEFAULT ''                                  ,
        `dom_pass`        VARCHAR(160)    NOT NULL    DEFAULT ''                                  ,
        PRIMARY KEY  (`sub_id`)
        )
        TYPE=MyISAM
        "

    );

    $upgrade_sql_array2 = array(
        "
        ALTER TABLE     `cust_tab`
        DROP        `plan`                                                                      ,
        DROP        `bill_cycle`                                                                ,
        DROP        `sign_date`                                                                 ,
        DROP        `domain_name`                                                               ,
        DROP        `dom_reg`                                                                   ,
        DROP        `net_pay`                                                                   ,
        DROP        `tax_pay`                                                                   ,
        DROP        `cycle_pay`                                                                 ,
        DROP        `initial_pay`                                                               ,
        DROP        `cust_status`                                                               ,
        DROP        `remote_ip`                                                                 ,
        DROP        `client_notes`                                                              ,
        DROP        `server`                                                                    ,
        DROP        `server_ip`                                                                 ,
        DROP        `name_ser_1`                                                                ,
        DROP        `name_ser_2`                                                                ,
        DROP        `pay_proc`                                                                  ,
        DROP        `fs_complete`                                                               ,
        DROP        `dom_reg_comp`                                                              ,
        DROP        `dom_reg_result`                                                            ,
        DROP        `di_cust_id`                                                                ,
        DROP        `di_cont_id`                                                                ,
        DROP        `dom_registrar`
        ",
        "
        ALTER TABLE     `sub_order`
        ADD         `dom_user`          VARCHAR(16)     NOT NULL                                ,
        ADD         `dom_pass`          VARCHAR(160)    NOT NULL
        ",
        "
        ALTER TABLE     `cust_tab`
        DROP        `username`
        ",
        "
        ALTER TABLE     `invoices`
        CHANGE      `net_amount`
        `net_amount`        DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `invoices`
        CHANGE      `tax_amount`
        `tax_amount`        DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `invoices`
        CHANGE      `gross_amount`
        `gross_amount`      DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `pricing`
        CHANGE      `dom_price`
        `dom_price`         DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `pricing_hosting`
        CHANGE      `host_setup_fee`
        `host_setup_fee`    DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `pricing_hosting`
        CHANGE      `monthly`
        `monthly`           DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `pricing_hosting`
        CHANGE      `quarterly`
        `quarterly`         DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `pricing_hosting`
        CHANGE      `half_yearly`
        `half_yearly`       DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `pricing_hosting`
        CHANGE      `yearly`
        `yearly`            DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `sub_order`
        CHANGE      `net_pay`
        `net_pay`           DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `sub_order`
        CHANGE      `tax_pay`
        `tax_pay`           DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `sub_order`
        CHANGE      `cycle_pay`
        `cycle_pay`         DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        ALTER TABLE     `sub_order`
        CHANGE      `initial_pay`
        `initial_pay`       DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL
        ",
        "
        DROP TABLE IF EXISTS
        `acl_master`,
        `domext`,
        `fraud_score`,
        `pay_proc`,
        `plesk_auto`,
        `plesk_ips`,
        `plesk_plans`,
        `plesk_res_plans`
        ",
        "
        ALTER TABLE     `cust_tab`
        CHANGE      `password`
        `password`          VARCHAR(255)    NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `company_address`   VARCHAR(255)    NOT NULL    AFTER `company_name`
        ",
        "
        UPDATE          `sub_order`
        SET         `pay_proc`='paypal'
        WHERE       `pay_proc`='pp'
        ",
        "
        UPDATE          `sub_order`
        SET         `pay_proc`='twocheckout'
        WHERE       `pay_proc`='tco'
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `d_lang`            VARCHAR(25) DEFAULT 'english'   NOT NULL
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `transaction_id`    INT(25)     DEFAULT '0'         NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `acc_method`        TINYINT(1)  DEFAULT '0'         NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `vat`               TINYINT(1)  DEFAULT '0'         NOT NULL
        ",
        "
        ALTER TABLE     `cust_tab`
        ADD         `vat_no`            VARCHAR(25) DEFAULT ''          NOT NULL
        ",
        "
        ALTER TABLE     `pricing`
        ADD         `tld_name`          VARCHAR(255)                    NOT NULL                ,
        ADD         `tld_server`        VARCHAR(255)                    NOT NULL                ,
        ADD         `tld_match`         VARCHAR(255)                    NOT NULL                ,
        ADD         `tld_active`        VARCHAR(5)  DEFAULT 'yes'       NOT NULL                ,
        ADD         `tld_registrar`     VARCHAR(255)                    NOT NULL
        ",
        "
        CREATE TABLE IF NOT EXISTS  `dom_reg_log`
        (
        `log_time`      VARCHAR(15)     NOT NULL    DEFAULT ''                                  ,
        `sub_id`        INT(11)         NOT NULL    DEFAULT '0'                                  ,
        `domain`        VARCHAR(255)    NOT NULL    DEFAULT ''                                  ,
        `log_result`    TEXT            NOT NULL    DEFAULT ''                                  ,
        PRIMARY KEY (`log_time`)
        )
        TYPE=MyISAM
        ",
        "
        ALTER TABLE     `pricing_hosting`
        ADD         `server_id`         INT(11)     DEFAULT '0'          NOT NULL
        ",
        /*Var 2.2.r4 addon*/
        "
        CREATE TABLE IF NOT EXISTS  `subdomains`
        (
        `main_id`           INT(11)         NOT NULL    AUTO_INCREMENT  PRIMARY KEY             ,
        `maindomain`        VARCHAR(255)    NOT NULL                                            ,
        `period`            TINYINT         NOT NULL                                            ,
        `price`             TINYINT         NOT NULL                                            ,
        `reserved_names`    VARCHAR(255)    NOT NULL
        )
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `en_sub`            TINYINT(1)      DEFAULT '0'     NOT NULL
        ",
        "
        ALTER TABLE     `pricing_hosting`
        ADD         `acc_method`        TINYINT(1)      DEFAULT '0'     NOT NULL
        ",
        "
        ALTER TABLE     `subdomains`
        CHANGE      `price`
        `price`             DECIMAL(10,2)   DEFAULT '0'     NOT NULL
        ",
        "
        CREATE TABLE IF NOT EXISTS  `temp`
        (
        `temp_id`           VARCHAR(100)    NOT NULL,
        `text_detail`       TEXT            NOT NULL
        )
        ",
        /*Var 2.2.r5 addon*/
        "
        CREATE TABLE IF NOT EXISTS  `addons`
        (
        `addon_id`          INT(11)                         NOT NULL    AUTO_INCREMENT  PRIMARY KEY ,
        `addon_name`        VARCHAR(255)                    NOT NULL                                ,
        `addon_setup`       DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL                                ,
        `recurring`         DECIMAL(10,2)   DEFAULT '0.00'  NOT NULL                                ,
        `recurring_cycle`   INT(2)          DEFAULT '1'     NOT NULL
        )
        ",
        "
        ALTER TABLE     `pricing_hosting`
        ADD         `addons`            VARCHAR(255)                    NOT NULL
        ",
        "
        ALTER TABLE     `sub_order`
        ADD         `addon_ids`         VARCHAR(255)                    NOT NULL
        ",
        "
        ALTER TABLE     `sub_order`
        DROP        `net_pay`                                                                       ,
        DROP        `tax_pay`                                                                       ,
        DROP        `cycle_pay`                                                                     ,
        DROP        `initial_pay`                                                                   ,
        DROP        `server`                                                                        ,
        DROP        `server_ip`                                                                     ,
        DROP        `name_ser_1`                                                                    ,
        DROP        `name_ser_2`                                                                    ,
        DROP        `fs_complete`
        ",
        "
        CREATE TABLE IF NOT EXISTS  `coupons`
        (
        `coupon_id`         INT(11)                         NOT NULL    AUTO_INCREMENT  PRIMARY KEY ,
        `coupon_name`       VARCHAR(255)                    NOT NULL                                ,
        `coupon_discount`   INT(3)                          NOT NULL                                ,
        `coupon_domain`     INT(1)                          NOT NULL                                ,
        `coupon_addons`     INT(1)                          NOT NULL
        )
        ",
        "
        CREATE TABLE IF NOT EXISTS  `coupon_code`
        (
        `coupon_code`       VARCHAR(255)                    NOT NULL                                ,
        `coupon_id`         INT(11)                         NOT NULL                                ,
        `disposable`        INT(1)                          NOT NULL
        )
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `other_amount`      DECIMAL(10,2)       DEFAULT '0.00'  NOT NULL
        AFTER       `invoice_no`
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `en_iv`             TINYINT(1)          DEFAULT '1'     NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `en_cc`             TINYINT(1)          DEFAULT '1'     NOT NULL
        ",
        "
        ALTER TABLE     `cust_tab`
        ADD         `discount`          INT(3)              DEFAULT '0'     NOT NULL                ,
        ADD         `disposable`        INT(1)              DEFAULT '0'     NOT NULL
        ",
        "
        ALTER TABLE     `cust_tab`
        ADD         `credit`            DECIMAL(10,2)                       NOT NULL                ,
        ADD         `credit_type`       INT(1)              DEFAULT '1'     NOT NULL                ,
        ADD         `credit_desc`       VARCHAR(255)                        NOT NULL
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `pay_text`          TEXT NOT NULL
        ",
        "
        DROP TABLE IF EXISTS    `invoice_schedule`
        ",
        "
        ALTER TABLE     `sub_order`
        CHANGE      `bill_cycle`
        `bill_cycle`        INT(2)                              NOT NULL
        ",
        "
        ALTER TABLE     `coupons`
        ADD         `coupon_valid`      DATE                                NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `auto_email`        INT(1)              DEFAULT '1'     NOT NULL
        ",
        "
        ALTER TABLE     `dbUsers`
        CHANGE      `email`
        `email`             VARCHAR(255)                        NOT NULL
        ",
        "
        CREATE TABLE IF NOT EXISTS  `specials`
        (
        `special_id`            INT(11)                     NOT NULL    AUTO_INCREMENT  PRIMARY KEY ,
        `special_name`          VARCHAR(255)                NOT NULL                                ,
        `special_desc`          VARCHAR(255)                NOT NULL                                ,
        `special_valid_from`    DATE                        NOT NULL                                ,
        `special_valid`         DATE                        NOT NULL                                ,
        `special_tld`           VARCHAR(25)                 NOT NULL                                ,
        `special_subdom`        VARCHAR(25)                 NOT NULL                                ,
        `special_plan`          VARCHAR(25)                 NOT NULL                                ,
        `special_net`           DECIMAL(10,2)               NOT NULL                                ,
        `special_tld_disc`      VARCHAR(255)                NOT NULL                                ,
        `special_subdom_disc`   VARCHAR(255)                NOT NULL                                ,
        `special_plan_disc`     VARCHAR(255)                NOT NULL                                ,
        `special_addon_disc`    VARCHAR(255)                NOT NULL                                ,
        `special_net_disc`      DECIMAL(10,2)               NOT NULL
        )
        TYPE = MYISAM
        ",
        "
        ALTER TABLE     `specials`
        ADD         `special_active`    INT(1)              NOT NULL    DEFAULT '0'
        ",
        "
        ALTER TABLE     `specials`
        ADD         `new_order`         INT(1)              NOT NULL    DEFAULT '1'
        ",
        /*Var 2.4 addon*/
        "
        CREATE TABLE IF NOT EXISTS  `pp_vals`
        (
        `pp_name`               VARCHAR(255)                NOT NULL    DEFAULT ''                  ,
        `active`                VARCHAR(255)                NOT NULL    DEFAULT ''                  ,
        `title`                 VARCHAR(255)                NOT NULL    DEFAULT ''                  ,
        `disp_msg`              VARCHAR(255)                NOT NULL    DEFAULT ''
        )
        TYPE=MyISAM
        ",
        "
        CREATE TABLE IF NOT EXISTS  `support_topics`
        (
        `topic_id`              INT(11)                     NOT NULL                AUTO_INCREMENT  ,
        `topic_name`            VARCHAR(255)                NOT NULL    DEFAULT ''                  ,
        PRIMARY KEY  (`topic_id`)
        )
        TYPE=MyISAM
        ",
        "
        ALTER TABLE     `dbUsers`
        RENAME      `admin_users`
        ",
        "
        ALTER TABLE     `dbusers`
        RENAME      `admin_users`
        ",
        "
        ALTER TABLE     `cust_tab`
        RENAME      `customers`
        ",
        "
        ALTER TABLE     `pricing_hosting`
        RENAME      `hosting_price`
        ",
        "
        ALTER TABLE     `pricing`
        RENAME      `domain_price`
        ",
        "
        CREATE TABLE IF NOT EXISTS  `support_tickets`
        (
        `ticket_id`             INT(11)     NOT NULL                AUTO_INCREMENT      PRIMARY KEY ,
        `topic_id`              INT(11)     NOT NULL    DEFAULT '1'                                 ,
        `cust_id`               INT(11)     NOT NULL    DEFAULT '0'                                 ,
        `admin_id`              INT(11)     NOT NULL    DEFAULT '1'                                 ,
        `ticket_text`           TEXT        NOT NULL                                                ,
        `ticket_date`           DATETIME    NOT NULL                                                ,
        `ticket_status`         INT(1)      NOT NULL
        )
        TYPE = MYISAM
        ",
        "
        CREATE TABLE IF NOT EXISTS  `support_reply`
        (
        `reply_id`              INT(11)         NOT NULL            AUTO_INCREMENT      PRIMARY KEY ,
        `ticket_id`             INT(11)         NOT NULL                                            ,
        `reply_by`              VARCHAR(255)    NOT NULL                                            ,
        `reply_text`            TEXT            NOT NULL                                            ,
        `reply_date`            DATETIME        NOT NULL
        )
        TYPE = MYISAM
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `en_support`    INT(1)          NOT NULL DEFAULT '0'
        ",
        "
        ALTER TABLE     `admin_users`
        ADD         `permissions`   TEXT            NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `theme`         VARCHAR(255)    NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        DROP        `mb_fs_lic`
        ",
        "
        ALTER TABLE     `admin_users`
        ADD         `topic_id`      TEXT            NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        DROP        `acc_method`
        ",
        "
        ALTER TABLE     `customers`
        ADD         `cumulative`    INT(1)          NOT NULL    DEFAULT '0'     AFTER `disposable`
        ",
        "
        ALTER TABLE     `emails`
        DROP        `email_name`
        ",
        "
        ALTER TABLE     `customers`
        ADD         UNIQUE (`email`)
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `debit_credit`              VARCHAR(255)    NOT NULL
        AFTER       `cust_id`                                                                       ,
        ADD         `debit_credit_amount`       DECIMAL(10,2)   NOT NULL
        AFTER       `debit_credit`
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `setup_fee`                 DECIMAL(10,2)   NOT NULL
        AFTER       `debit_credit_amount`                                                           ,
        ADD         `cycle_fee`                 DECIMAL(10,2)   NOT NULL
        AFTER       `setup_fee`                                                                     ,
        ADD         `tld_fee`                   DECIMAL(10,2)   NOT NULL
        AFTER       `cycle_fee`                                                                     ,
        ADD         `addon_fee`                 TEXT            NOT NULL
        AFTER       `tld_fee`
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `tax_percent`               DECIMAL(10,2)   NOT NULL
        AFTER       `addon_fee`
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `debit_credit_reason`       VARCHAR(255)    NOT NULL
        AFTER       `debit_credit_amount`
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `inv_tld_disc`              DECIMAL(10,2)   NOT NULL
        AFTER       `addon_fee`                                                                     ,
        ADD         `inv_plan_disc`             DECIMAL(10,2)   NOT NULL
        AFTER       `inv_tld_disc`                                                                  ,
        ADD         `inv_addon_disc`            DECIMAL(10,2)   NOT NULL
        AFTER       `inv_plan_disc`
        ",
        "
        ALTER TABLE     `customers`
        ADD         `cust_deleted`              INT(1)          NOT NULL    DEFAULT '0'
        ",
        "
        ALTER TABLE     `dom_reg_log`
        CHANGE      `log_time`
        `log_time`                  DATETIME        NOT NULL
        ",
        /*Var 2.5 r1 addon*/
        "
        CREATE TABLE IF NOT EXISTS  `geoip`
        (
        `csv_file`              VARCHAR(255)                    NOT NULL                            ,
        `updated_on`            DATETIME                        NOT NULL                            ,
        `feed`                  ENUM('1','2','3')               NOT NULL    DEFAULT '1'
        )
        TYPE = MYISAM
        ",
        "
        CREATE TABLE IF NOT EXISTS  `geoip_db`
        (
        `IP_FROM`               DOUBLE                          NOT NULL                            ,
        `IP_TO`                 DOUBLE                          NOT NULL                            ,
        `COUNTRY_CODE2`         VARCHAR(3)                      NOT NULL
        )
        TYPE = MYISAM
        ",
        "
        ALTER TABLE     `sub_order`
        ADD         `remote_country_code`       VARCHAR(3)      NOT NULL
        AFTER       `remote_ip`
        ",
        "
        ALTER TABLE     `sub_order`
        ADD         `remote_city`               VARCHAR(255)    NOT NULL
        AFTER       `remote_country_code`
        ",
        "
        ALTER TABLE     `sub_order`
        ADD         `order_deleted`             ENUM('0','1')   NOT NULL DEFAULT '0'
        ",
        "
        ALTER TABLE     `tax`
        CHANGE      `tax_amount`
        `tax_amount`                DECIMAL(10,2)   NOT NULL DEFAULT '0'
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `metatags`                  TEXT            NOT NULL
        AFTER       `order_para1`
        ",
        "
        ALTER TABLE     `admin_users`
        CHANGE      `email`
        `email`             VARCHAR(255)            NOT NULL
        ",
        "
        ALTER TABLE     `admin_users`
        CHANGE      `username`
        `username`          VARCHAR(255)            NOT NULL DEFAULT ''
        ",
        "
        ALTER TABLE     `admin_users`
        CHANGE       `password`
        `password`         VARCHAR(255)            NOT NULL DEFAULT ''
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `title`             TEXT                    NOT NULL
        AFTER       `path_abs`
        ",
        "
        CREATE TABLE IF NOT EXISTS  `groups`
        (
        `group_id`              INT(11)                 NOT NULL            AUTO_INCREMENT  PRIMARY KEY ,
        `group_name`            VARCHAR(255)            NOT NULL                                        ,
        `group_desc`            TEXT                    NOT NULL                                        ,
        `group_url`             VARCHAR(255)            NOT NULL                                        ,
        `group_require_domain`  ENUM('1','0')           NOT NULL DEFAULT '1'                            ,
        `group_active`          ENUM('1','0')           NOT NULL DEFAULT '1'                            ,
        `products`              TEXT                    NOT NULL
        )
        TYPE = MYISAM
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `encrypeted` ENUM('0','1')  NOT NULL DEFAULT '0'
        ",
        "
        ALTER TABLE     `hosting_price`
        ADD         `plan_desc`  TEXT           NOT NULL
        ",
        "
        ALTER TABLE     `customers`
        DROP
        INDEX       `email`
        ",
        "
        ALTER TABLE     `sub_order`
        ADD         `card_holder`       VARCHAR(255)    NOT NULL    ,
        ADD         `card_no`           VARCHAR(255)    NOT NULL    ,
        ADD         `card_type`         VARCHAR(255)    NOT NULL    ,
        ADD         `exp_date`          VARCHAR(255)    NOT NULL    ,
        ADD         `CVV2`              VARCHAR(255)    NOT NULL
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `invoice_prefix`    VARCHAR(255)    NOT NULL    ,
        ADD         `invoice_suffix`    VARCHAR(255)    NOT NULL    ,
        ADD         `order_prefix`      VARCHAR(255)    NOT NULL    ,
        ADD         `order_suffix`      VARCHAR(255)    NOT NULL    ,
        ADD         `inv_start_no`      INT(8)          NOT NULL    ,
        ADD         `order_start_no`    INT(8)          NOT NULL
        ",
        "
        UPDATE          `order_conf`
        SET         `d_lang` = 'portuguese'
        WHERE       `d_lang` = 'portugues'
        ",
        /*Var 2.5 r3 addon*/
        "
        ALTER TABLE         `addons`
        DROP        `recurring_cycle`
        ",
        "
        ALTER TABLE         `addons`
        ADD             `quarterly`     DECIMAL(10,2) NOT NULL          ,
        ADD             `half_yearly`   DECIMAL(10,2) NOT NULL          ,
        ADD             `yearly`        DECIMAL(10,2) NOT NULL
        ",
        "
        ALTER TABLE         `addons`
        CHANGE          `recurring`
        `monthly`       DECIMAL(10,2) NOT NULL DEFAULT '0.00'
        ",
        "
        ALTER TABLE         `subdomains`
        DROP        `period`
        ",
        "
        ALTER TABLE         `subdomains`
        ADD             `quarterly`     DECIMAL(10,2) NOT NULL
        AFTER           `price`                                         ,
        ADD             `half_yearly`   DECIMAL(10,2) NOT NULL
        AFTER           `quarterly`                                     ,
        ADD             `yearly`        DECIMAL(10,2) NOT NULL
        AFTER           `half_yearly`
        ",
        "
        ALTER TABLE         `subdomains`
        CHANGE          `price`
        `monthly`       DECIMAL(10,2) NOT NULL DEFAULT '0.00'
        ",
        "
        ALTER TABLE         `hosting_price`
        DROP            `welc_email`
        ",
        "
        ALTER TABLE         `hosting_price`
        ADD             `default_cycle` ENUM('0','1','3','6','12','13')  NOT NULL
        ",
        "
        ALTER TABLE         `domain_price`
        CHANGE          `dom_ext`
        `dom_ext`       VARCHAR(15)             NOT NULL
        ",
        "
        ALTER TABLE         `domain_price`
        CHANGE          `dom_period`
        `dom_period`    INT(2)                  NOT NULL
        ",
        "
        ALTER TABLE         `hosting_price`
        ADD             `subdomain`     ENUM('1','0')           NOT NULL
        ",
        "
        ALTER TABLE         `tax`
        CHANGE          `tax_area`
        `tax_add_sub`   ENUM('A','S')           NOT NULL
        ",
        "
        ALTER TABLE         `tax`
        CHANGE          `tax_enabled`
        `tax_net_comp`  ENUM('N','C')           NOT NULL
        ",
        "
        ALTER TABLE         `tax`
        ADD             `tax_country`   TEXT                    NOT NULL        ,
        ADD             `tax_state`     TEXT                    NOT NULL
        ",
        "
        ALTER TABLE         `tax`
        CHANGE           `tax_amount`
        `tax_amount`    DECIMAL(3,2)            NOT NULL DEFAULT '0.00'
        ",
        "
        ALTER TABLE         `invoices`
        CHANGE          `cust_id`
        `cust_id`       INT(11)                 NOT NULL DEFAULT '0'
        ",
        "
        ALTER TABLE         `tax`
        ADD             `tax_enable`    ENUM('1','0')           NOT NULL
        ",
        "
        ALTER TABLE         `customers`
        ADD             `trusted`       ENUM('0','1')           NOT NULL DEFAULT '0'
        ",
        "
        ALTER TABLE         `sub_order`
        ADD             `dom_reg_year`  INT(2)                  NOT NULL DEFAULT '1'
        ",
        "
        ALTER TABLE         `invoices`
        CHANGE          `tax_percent`
        `tax_percent`   TEXT                    NOT NULL DEFAULT ''
        ",
        "
        ALTER TABLE         `hosting_price`
        CHANGE          `addons`
        `addons`        TEXT                    NOT NULL
        ",
        "
        ALTER TABLE         `order_conf`
        ADD             `show_wizard`   ENUM('1','0')           NOT NULL DEFAULT '1'
        ",
        "
        ALTER TABLE         `tax`
        ADD             `tax_index`     INT(11)                 NOT NULL DEFAULT '1'
        ",
        "
        ALTER TABLE         `order_conf`
        ADD             `send_before_due`   INT(3)              NOT NULL ,
        ADD             `suspend_after_due` INT(3)              NOT NULL
        ",
        "
        ALTER TABLE         `order_conf`
        ADD             `include_sp_rec`    ENUM('1','0')       NOT NULL DEFAULT '1'
        ",
        "
        ALTER TABLE         `temp`
        ADD             `pp`                VARCHAR(25)         NOT NULL
        ",
        "
        ALTER TABLE         `invoices`
        ADD             `payment_method`    VARCHAR(25)         NOT NULL
        ",
        "
        ALTER TABLE         `customers`
        CHANGE          `discount`
        `discount`          DECIMAL(3,2)        NOT NULL DEFAULT '0'
        ",
        "
        CREATE TABLE IF NOT EXISTS  `currency` (
        `curr_id`               INT(11)         NOT NULL        AUTO_INCREMENT  PRIMARY KEY ,
        `curr_symbol`           VARCHAR(25)     NOT NULL                                    ,
        `curr_name`             VARCHAR(25)     NOT NULL                                    ,
        `curr_factor`           DECIMAL(10,2)   NOT NULL
        )
        TYPE = MYISAM
        ",
        "
        ALTER TABLE     `order_conf`
        ADD         `curr_name`             VARCHAR(25)         NOT NULL
        AFTER       `symbol`
        ",
        "
        ALTER TABLE     `invoices`
        ADD         `pay_curr_name`         VARCHAR(25)         NOT NULL                    ,
        ADD         `pay_curr_symbol`       VARCHAR(25)         NOT NULL                    ,
        ADD         `pay_curr_factor`       DECIMAL(10,2)       NOT NULL
        ",
        /*Var 2.6 addon*/
        "
        ALTER TABLE     `order_conf`
        ADD         `order_page_title`      TEXT                NOT NULL                    ,
        ADD         `cp_note`               TEXT                NOT NULL
        ",
        "
        ALTER TABLE 	`order_conf`
        ADD 		`auto_update_curr` 		ENUM('1','0') 		NOT NULL 	DEFAULT '0'
        ",
        "
        ALTER TABLE 	`admin_users`
        ADD 		`admin_theme` 			VARCHAR(100) 		NOT NULL
        ",
        "
        ALTER TABLE     `servers`
        ADD         `httpd_port`            INT(10)             NOT NULL    DEFAULT '80'        ,
        ADD         `smtp_port`             INT(10)             NOT NULL    DEFAULT '25'        ,
        ADD         `ftp_port`              INT(10)             NOT NULL    DEFAULT '21'        ,
        ADD         `pop3_port`             INT(10)             NOT NULL    DEFAULT '110'       ,
        ADD         `mysql_port`            INT(10)             NOT NULL    DEFAULT '3306'      ,
        ADD         `httpd_port_yn`         ENUM('1','0')       NOT NULL    DEFAULT '1'         ,
        ADD         `smtp_port_yn`          ENUM('1','0')       NOT NULL    DEFAULT '1'         ,
        ADD         `ftp_port_yn`           ENUM('1','0')       NOT NULL    DEFAULT '1'         ,
        ADD         `pop3_port_yn`          ENUM('1','0')       NOT NULL    DEFAULT '1'         ,
        ADD         `mysql_port_yn`         ENUM('1','0')       NOT NULL    DEFAULT '1'
        ",
        /*Var 2.6 r3 addon */
        "
        CREATE TABLE IF NOT EXISTS `users_online`
        (
        `log_time`				DATETIME			NOT NULL			,
        `user_type`				ENUM('2','1','0')	NOT NULL			,
        `user_id`				INT(11)				NOT NULL			,
        `user_ip`				VARCHAR(15)			NOT NULL			,
        `user_name`				VARCHAR(255)		NOT NULL			,
        `user_login`			VARCHAR(16)			NOT NULL			,
        `user_email`			VARCHAR(255)		NOT NULL			,
        `visiting_page`			TEXT				NOT NULL			,
        `items_in_basket`		TEXT				NOT NULL
        )
        TYPE = MYISAM
        ",
        "ALTER TABLE 	`users_online` 	ADD 	`entry_time` 		DATETIME 			NOT NULL",
        "ALTER TABLE 	`users_online` 	ADD 	`log_session_id` 	VARCHAR(255) 		NOT NULL",
        "
        CREATE TABLE IF NOT EXISTS `order_server_ip`
        (
        `sub_id`                INT(11)             NOT NULL            ,
        `server_id`             INT(11)             NOT NULL            ,
        `ip_id`                 INT(11)             NOT NULL
        )
        TYPE = MYISAM
        ",
        "
        CREATE TABLE IF NOT EXISTS `ips`
        (
        `ip_id`                 INT(11)             NOT NULL    AUTO_INCREMENT  PRIMARY KEY     ,
        `server_id`             INT(11)             NOT NULL                                    ,
        `ip`                    VARCHAR(15)         NOT NULL
        )
        TYPE = MYISAM
        ",
        "ALTER TABLE     `servers`       ADD     `maximum_accounts`   INT(11)           NOT NULL",
        "ALTER TABLE     `servers`       ADD     `current_accounts`   INT(11)           NOT NULL",
        "
        CREATE TABLE IF NOT EXISTS `package_server`
        (
        `package_id`            INT(11)             NOT NULL            ,
        `server_id`             INT(11)             NOT NULL            ,
        `rotation_index`        INT(11)             NOT NULL
        )
        TYPE = MYISAM
        ",
        "ALTER TABLE     `hosting_price`    ADD    `en_server_rotation`         ENUM('0','1')            NOT NULL",
        "ALTER TABLE     `order_server_ip`  ADD    `acct_status`                ENUM('0','1','2','3')    NOT NULL",
        "ALTER TABLE     `order_conf`       ADD    `en_domain_only`             ENUM('0','1')            NOT NULL DEFAULT '0'",
        "ALTER TABLE     `order_conf`       ADD    `s_status_refresh`           INT(11)                  NOT NULL ",
        "ALTER TABLE     `order_conf`       ADD    `whoisonline_sec`            INT(11)                  NOT NULL",
        "ALTER TABLE     `coupon_code`      RENAME `disc_token_code`",
        "ALTER TABLE     `coupons`          RENAME `disc_token`",
        "ALTER TABLE     `order_conf`       ADD    `en_dt`                      ENUM('1','0')            NOT NULL",

        "ALTER TABLE     `disc_token`       CHANGE `coupon_id`       `disc_token_id`        INT(11)         NOT NULL  AUTO_INCREMENT" ,
        "ALTER TABLE     `disc_token`       CHANGE `coupon_name`     `disc_token_name`      VARCHAR(255)    NOT NULL" ,
        "ALTER TABLE     `disc_token`       CHANGE `coupon_discount` `disc_token_discount`  INT(3)          NOT NULL DEFAULT '0'",
        "ALTER TABLE     `disc_token`       CHANGE `coupon_domain`   `disc_token_domain`    INT(1)          NOT NULL DEFAULT '0'",
        "ALTER TABLE     `disc_token`       CHANGE `coupon_addons`   `disc_token_addons`    INT(1)          NOT NULL DEFAULT '0'",
        "ALTER TABLE     `disc_token`       CHANGE `coupon_valid`    `disc_token_valid`     DATE            NOT NULL DEFAULT '0000-00-00'",
        "ALTER TABLE     `disc_token_code`  CHANGE `coupon_code`     `disc_token_code`      VARCHAR(255)    NOT NULL" ,
        "ALTER TABLE     `disc_token_code`  CHANGE `coupon_id`       `disc_token_id`        INT(11)         NOT NULL DEFAULT '0'",
        "DROP TABLE IF EXISTS   `coupons`" ,
        "DROP TABLE IF EXISTS   `coupon_code`",
        "
        CREATE TABLE IF NOT EXISTS  `coupon`
        (
        `coupon_id`         INT(11)                         NOT NULL    AUTO_INCREMENT  PRIMARY KEY ,
        `coupon_name`       VARCHAR(255)                    NOT NULL                                ,
        `coupon_discount`   INT(3)                          NOT NULL                                ,
        `coupon_domain`     INT(1)                          NOT NULL                                ,
        `coupon_addons`     INT(1)                          NOT NULL                                ,
        `coupon_valid`      DATE                            NOT NULL
        )
        TYPE = MYISAM
        ",
        "ALTER TABLE    `coupon`    ADD     `customer_use`      ENUM('0','1','2')       NOT NULL",
        "ALTER TABLE    `coupon`    ADD     `repeated`          ENUM('0','1')           NOT NULL",
        "
        CREATE TABLE IF NOT EXISTS  `used_coupons`
        (
        `cust_id`           INT(11)         NOT NULL ,
        `sub_id`            INT(11)         NOT NULL ,
        `coupon_id`         INT(11)         NOT NULL
        )
        TYPE = MYISAM
        ",
        "
        CREATE TABLE IF NOT EXISTS  `opensrs` (
        `opensrs_id`           MEDIUMINT(8)                    NOT NULL    AUTO_INCREMENT    PRIMARY KEY ,
        `opensrs_uid`          VARCHAR(255)                    NOT NULL                                  ,
        `opensrs_pw`           VARCHAR(255)                    NOT NULL                                  ,
        `opensrs_active`       VARCHAR(10)                     NOT NULL                                  ,
        `opensrs_test_mode`    VARCHAR(255)                    NOT NULL
        )
        TYPE = MYISAM
        ",
        "ALTER TABLE    `enom`      CHANGE  `enom_pw`   `enom_pw`   VARCHAR(255)    NOT NULL",
        "ALTER TABLE    `enom`      CHANGE  `enom_uid`  `enom_uid`  VARCHAR(255)    NOT NULL",
        "ALTER TABLE    `directi`   CHANGE  `di_uid`    `di_uid`    VARCHAR(255)    NOT NULL",
        "ALTER TABLE    `directi`   CHANGE  `di_pw`     `di_pw`     VARCHAR(255)    NOT NULL",
        "ALTER TABLE    `directi`   CHANGE  `di_id`     `di_id`     MEDIUMINT(8)    NOT NULL    AUTO_INCREMENT",
        "ALTER TABLE    `enom`      CHANGE  `en_id`     `en_id`     MEDIUMINT(8)    NOT NULL    AUTO_INCREMENT"
    );
?>
