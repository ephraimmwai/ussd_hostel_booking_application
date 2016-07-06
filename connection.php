<?php
$dbhost='localhost';
$dbuser='root';
$dbpass='';
$db='ussd';
@mysql_connect("$dbhost","$dbuser","$dbpass") or die("Cannot connect to MUST_HOSTELS database!");
@mysql_select_db($db) or die("No database Available!!!");

?>