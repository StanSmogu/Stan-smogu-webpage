<?php
header('Content-type: application/json');	
	require_once "connect.php";	
	  $result_1 = mysqli_query ($connection, "SELECT ROUND(AVG(pm10)) FROM pomiary WHERE datapomiaru >= DATE_SUB(NOW(),INTERVAL 24 HOUR)") 
				or die ("SQL query error: $db_name");
	
			
	while ($db_raw = mysqli_fetch_array ($result_1)) 
	{
		$pm10_1  			= $db_raw [0];
	}
	  $pm10_pro = ($pm10_1/50)*100;
	  
	 echo ($pm10_pro);
	  
	  
	  ?>
	