#!/usr/bin/perl -w
####
# This script deletes orphan orders after they reach the given expiration date.
# You may wish to place it in cron to run periodically
########

die "This script should work, but has not been fully tested.  Delete this line after testing.\n";

$expiration = 90;	# Orphan orders expire after 90 days

$host = 'localhost';
$username = 'accountlab';
$password = 'password';
$schema = 'accountlab';
$tbl_prefix = '';

####
use DBI;

# Connect to the DB
$dbh = DBI->connect("dbi:mysql:$schema;host=$host",$username,$password)
	or die "Connection Error: $DBI::errstr\n";


# orphan_order_datas table
$sql = "DELETE FROM ${tbl_prefix}orphan_order_datas WHERE ${tbl_prefix}orphan_order_datas.orphan_order_id IN ".
		"(SELECT `orphanorder_id` FROM ${tbl_prefix}orphan_orders WHERE order_date < DATE_SUB(NOW(), INTERVAL $expiration DAY));";
$sth = $dbh->prepare($sql);
$sth->execute  or die "SQL Error: $DBI::errstr\n";

# orphan_orders table
$sql = "DELETE FROM ${tbl_prefix}orphan_orders WHERE order_date < DATE_SUB(NOW(), INTERVAL $expiration DAY);";
$sth = $dbh->prepare($sql);
$sth->execute  or die "SQL Error: $DBI::errstr\n";