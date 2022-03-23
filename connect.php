<?php
	$db_host	 = "79.189.200.10:3400";
	$db_user 	 = "meteo_zam";
	$db_password = "2&X(jX]l@R$0=]4";
	$db_name 	 = "meteo_zam";
	$connection = mysqli_connect ($db_host, $db_user,$db_password, $db_name);
	
	if (!$connection) 
	{
		echo "MySQL connection problem. " . PHP_EOL;
		echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
?>