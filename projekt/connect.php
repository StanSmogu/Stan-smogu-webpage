<?php
	$db_host	 = "localhost";
	$db_user 	 = "30066006_projekt";
	$db_password = "Macias1112!";
	$db_name 	 = "30066006_projekt";
	$connection = mysqli_connect ($db_host, $db_user,$db_password, $db_name);
	
	if (!$connection) 
	{
		echo "MySQL connection problem. " . PHP_EOL;
		echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
?>