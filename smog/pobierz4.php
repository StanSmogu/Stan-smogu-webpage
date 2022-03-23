<?php
header('Content-type: application/json');	
	require_once "connect.php";	
	  $result_1 = mysqli_query ($connection, "SELECT poka FROM pokaz WHERE idpo=1") 
				or die ("SQL query error: $db_name");
	
			
	while ($db_raw = mysqli_fetch_array ($result_1)) 
	{
		$poka  			= $db_raw [0];
	}
	 
	  
	 echo ($poka);
	  
	  
	  ?>
	