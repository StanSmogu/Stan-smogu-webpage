<?php
	$db_host	 = "localhost";
	$db_user 	 = "30066006_pomiary";
	$db_password = "Smog3d1221!";
	$db_name 	 = "30066006_pomiary";
	$connection = mysqli_connect ($db_host, $db_user,$db_password, $db_name);
	
	if (!$connection) 
	{
		echo "MySQL connection problem. " . PHP_EOL;
		echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
?>