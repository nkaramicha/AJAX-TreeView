<?php

//Database connection
$hostname = "";
$database = "";
$username = "";
$password = "";

$link = @mysqli_connect( $hostname , $username , $password ) or die("Database connection error  : " . mysql_error());
	
mysqli_select_db($link,$database);

?>