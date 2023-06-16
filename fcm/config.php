<?php
	define('G5_SERVER_TIME',    time());
	define('G5_TIME_YMDHIS',    date('Y-m-d H:i:s', G5_SERVER_TIME));
	define('FIREBASE_API_KEY',    "AAAAb4lGK-s:APA91bGTObGKLJh3bbY5X9maj15Iaz8SAzIAjBXr0TNxNZrfYY2i6gcpP-eHs9ybJQEX0dAqikdqOtvrGsnnUq2WCURkZ95ZAyks913yuvPxHV1uh-GdfCwoXbkTzgI3TaBGO2l35Kp4");
	$db_host   = "localhost"; 
	$db_user   = "tj_test"; 
	$db_passwd = "tj2019!~";
	$db_name   = "tj_test"; 
	$conn      = mysqli_connect($db_host,$db_user,$db_passwd,$db_name);
?>