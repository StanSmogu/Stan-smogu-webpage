<?php
$ids=3;
$data="0"; 
	
	
	require_once "connect.php";
	
		$result_2 = mysqli_query ($connection, "SELECT * FROM standards WHERE idst=1" ) 
				or die ("SQL query error: $db_name");
	
	$ozone_stan=0;
	$no2_stan 			= 0;
	$co2_stan			= 0;
	$pm25_stan 			= 0;
	$pm10_stan 			= 0;
	
	$i=0;
	while ($db_raw2 = mysqli_fetch_array ($result_2)) 
	{
		$ozone_stan 		= $db_raw2 [1];
		$no2_stan 			= $db_raw2 [4];
		$co2_stan			= $db_raw2 [5];
		$pm25_stan 			= $db_raw2 [6];
		$pm10_stan 			= $db_raw2 [7];
	}
	

	$result_1 = mysqli_query ($connection, "SELECT * FROM meteo_zam.measure_hour WHERE ids=".$ids." AND measure_date > DATE_SUB(NOW(),INTERVAL 24 hour) ORDER by measure_date ASC;") 
				or die ("SQL query error: $db_name");
	
		
			
	while ($db_raw = mysqli_fetch_array ($result_1)) 
	{
		
		$ids			= $db_raw [1];
		$measure_date 	= $db_raw [2];
		$ozone 			= $db_raw [3];
		$no2 			= $db_raw [4];
		$co2 			= $db_raw [5];
		$pm2_5 			= $db_raw [6];
		$pm10 			= $db_raw [7];
		$temp 			= $db_raw [8];
		$wind_d 		= $db_raw [9];
		$wind_s 		= $db_raw [10];
		$wind_g 		= $db_raw [11];
		$ozone_temp 	= $db_raw [12];
		$ozone_hum 		= $db_raw [13];
		$no2_temp 		= $db_raw [14];
		$no2_hum 		= $db_raw [15];
		if ($hour_acc<23)
		{
			$hour_acc++;
		}
		else
		{
			$hour_acc=0;
		}
		
			$data=$data."/".$measure_date.".".$ozone.".".$ozone_stan.".".$no2.".".$no2_stan.".".$co2.".".$co2_stan.".".$pm2_5.".".$pm25_stan.".".$pm10.".".$pm10_stan.".".$temp.".".$wind_d.".".$wind_s.".".$wind_g.".".$ozone_temp.".".$ozone_hum.".".$no2_temp.".".$no2_hum;
	
	}
	echo ($data);

	
	  
	  ?>
	
	