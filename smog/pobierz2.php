<?php
header('Content-type: application/json');	
	require_once "connect.php";	
	  $result_1 = mysqli_query ($connection, "SELECT ROUND(AVG(pm2_5)) FROM pomiary WHERE datapomiaru >= DATE_SUB(NOW(),INTERVAL 24 HOUR)") 
				or die ("SQL query error: $db_name");
	
			
	while ($db_raw = mysqli_fetch_array ($result_1)) 
	{
		$pm25_1 			= $db_raw [0];
	}
	  $pm25_pro = ($pm25_1/25)*100;
	  
	 echo ($pm25_pro);
	  
	  
	  ?>
	