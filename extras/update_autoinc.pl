#!/usr/bin/perl -w
####
# This script updates the auto-increment columns for accountlab_plus
# so that they don't leak information like how many customers you have
# or how many signups you get per month and so on.
####
# WARNING:
#	If you generate 10k invoices per month, or if you get over 1k
#	new subscribers per month, or if you otherwise have an abnormally
#	busy site, or if the year hits 2100, this script will malfunction.  
#	You may want to change the relevant columns to BIGINT to get more 
#	digits, and then modify this program to give you more zeros after
#	the prefix we add to each autoinc.  Also, change the strftime formats 
#	as necessary.  I don't expect this to be an issue for most people.
########

$host = 'localhost';
$username = 'accountlab';
$password = 'password';
$schema = 'accountlab';
$tbl_prefix = '';
$debug = 0;

####
use DBI;
use POSIX 'strftime';

# Connect to the DB
$dbh = DBI->connect("dbi:mysql:$schema;host=$host",$username,$password)
	or die "Connection Error: $DBI::errstr\n";


# Retrieve MySQL's autoincrement values for every column in our DB.
$sql = "SELECT `AUTO_INCREMENT`, `TABLE_NAME` FROM  INFORMATION_SCHEMA.TABLES ".
	" WHERE TABLE_SCHEMA='$schema';";
$sth = $dbh->prepare($sql);
$sth->execute  or die "SQL Error: $DBI::errstr\n";
while (@row = $sth->fetchrow_array) {
	$autoinc{$row[1]} = $row[0];
 } 

# Set the invoice column's autoinc if necessary
update_table("invoices", strftime('%Y%m', localtime)."0001");

# Set the orders column's autoinc if necessary
update_table("orders", strftime('%Y%U', localtime)."001");

# Set the customers column's autoinc if necessary
update_table("customers", strftime('%y%U', localtime)."001");

# Set the support_topicss column's autoinc if necessary
update_table("support_topics", strftime('%y%j', localtime)."001");

# Set the support_tickets column's autoinc if necessary
update_table("support_tickets", strftime('%y%j', localtime)."001");

# Set the support_replies column's autoinc if necessary
update_table("support_replies", strftime('%y%j', localtime)."001");

########################################

sub update_table {
	my ($table, $autoinc) = @_;
	$table = $tbl_prefix . $table;
	if ($autoinc{$table} < $autoinc) {
		print "\$autoinc{$table} was ${autoinc{$table}} setting $autoinc.\n" if $debug;
		$sql = "ALTER TABLE `${table}` AUTO_INCREMENT = $autoinc;";
		$sth = $dbh->prepare($sql);
		$sth->execute  or die "SQL Error: $DBI::errstr\n";
	} else {
		print "\$autoinc{$table} was ${autoinc{$table}} - keeping, >= $autoinc.\n" if $debug;
	}
}

