<?php
$dbhost = "localhost"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "host1408042_bm"; // the name of the database that you are going to use for this project
$dbuser = "host1408042_bm"; // the username that you created, or were given, to access your database
$dbpass = "XMM_2nVT"; // the password that you created, or were given, to access your database
mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());
?>