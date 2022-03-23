<?php
header('Content-type:application/json');	

	require_once "connect.php";	
	
	$green_step=100;
	$yellow_step=150;
	
	
	$result_1 = mysqli_query ($connection, "SELECT COUNT(ids) FROM sensors" ) 
				or die ("SQL query error: $db_name");
	
	while ($db_raw24 = mysqli_fetch_array ($result_1)) 
	{
		$count				= $db_raw24 [0];
		echo ($number);
	}
	
	$result_11 = mysqli_query ($connection,'SELECT ozone_stan,no2_stan,co2_stan,pm25_stan,pm10_stan FROM meteo_zam.standards') 
				or die ("SQL query error: $db_name");
	
	while ($db_raw22 = mysqli_fetch_array ($result_11)) 
	{
		$ozone_stan				= $db_raw22[0];
		$no2_stan				= $db_raw22[1];
		$co2_stan				= $db_raw22[2];
		$pm25_stan				= $db_raw22[3];
		$pm10_stan				= $db_raw22[4];
	}
	
	
	
	
	
	for ($i=1;$i<=$count;$i++)
	{
		
		$grade=0;
		
		$result_2 = mysqli_query ($connection, "SELECT ids,round(avg(ozone),0),round(avg(no2),0),round(avg(co2),0),round(avg(pm2_5),0),round(avg(pm10),0),round(avg(temperature),1),round(avg(wind_direction),0),round(avg(wind_speed),0),round(avg(wind_gust),0) FROM meteo_zam.measure_live WHERE measure_date > DATE_SUB(NOW(),INTERVAL 1 hour) AND ids=".$i ) 
					or die ("SQL query error: $db_name");
		
		
		while ($db_raw2 = mysqli_fetch_array ($result_2)) 
		{
			$ids			= $db_raw2 [0];
			$ozone 			= $db_raw2 [1];
			$no2			= $db_raw2 [2];
			$co2			= $db_raw2 [3];
			$pm25 			= $db_raw2 [4];
			$pm10			= $db_raw2 [5];
			$temperature 	= $db_raw2 [6];
			$wind_direction = $db_raw2 [7];
			$wind_speed 	= $db_raw2 [8];
			$wind_gust 		= $db_raw2 [9];
			
			if($ids!=null)
			{
			
				$result_13 = mysqli_query ($connection, "SELECT * FROM sensors WHERE ids=$ids" ) 
						or die ("SQL query error: $db_name");
			
				while ($db_raw23 = mysqli_fetch_array ($result_13)) 
				{
					$ids				= $db_raw23 [0];
					$date				= $db_raw23 [1];
					$is_ozone			= $db_raw23 [2];
					$is_no2				= $db_raw23 [3];
					$is_co2				= $db_raw23 [4];
					$is_pm25			= $db_raw23 [5];
					$is_pm10			= $db_raw23 [6];
					$is_temp			= $db_raw23 [7];
					$is_wind			= $db_raw23 [8];
					$idu				= $db_raw23 [9];
					$city				= $db_raw23 [10];
					$street				= $db_raw23 [11];
					$number				= $db_raw23 [12];
					$coordinates1		= $db_raw23 [13];
					$coordinates2		= $db_raw23 [14];
					$name				= $db_raw23 [15];
				
				}
				if($is_ozone==1)
				{
					$ozone_pro = ($ozone/$ozone_stan)*100;
				}
				else
				{
					$ozone_pro=-1;
				}
				
				if($is_no2==1)
				{
					$no2_pro = ($no2/$no2_stan)*100;
				}
				else
				{
					$no2_pro=-1;
				}
				
				if($is_co2==1)
				{
					$co2_pro = ($co2/$co2_stan)*100;
				}
				else
				{
					$co2_pro=-1;
				}
				
				if($is_pm25==1)
				{
					$pm25_pro = ($pm25/$pm25_stan)*100;
				}
				else
				{
					$pm25_pro=-1;
				}
				
				if($is_pm10==1)
				{
					$pm10_pro = ($pm10/$pm10_stan)*100;
				}
				else
				{
					$pm10_pro=-1;
				}
				
				switch ($ozone_pro)
				{
					case $ozone_pro==-1 :
						$grade = $grade;
						break;
					case $ozone_pro<$green_step :
						$grade = $grade+ 1;							//zielone
						break;
					case $ozone_pro>=$green_step && $ozone_pro<$yellow_step :
						$grade = $grade+2;			//zolte
						break;
					case $ozone_pro>=$yellow_step:
						$grade = $grade+3;			//czerwone
						break;
					default: 
						$grade = $grade;			//szare
						break;
				}
				switch ($no2_pro)
				{
					case $no2_pro==-1:
						$grade = $grade;	
					case $no2_pro<$green_step:
						$grade = $grade+ 1;							//zielone
						break;
					case $no2_pro>=$green_step && $no2_pro<$yellow_step :
						$grade = $grade+2;			//zolte
						break;
					case $no2_pro>=$yellow_step:
						$grade = $grade+3;			//czerwone
						break;
					default: 
						$grade = $grade;			//szare
						break;
				}
				switch ($co2_pro)
				{
					case $co2_pro==-1:
						$grade = $grade;							//zielone
						break;
					case $co2_pro<$green_step:
						$grade = $grade+ 1;							//zielone
						break;
					case $co2_pro>=$green_step && $co2_pro<$yellow_step :
						$grade = $grade+2;			//zolte
						break;
					case $co2_pro>=$yellow_step:
						$grade = $grade+3;			//czerwone
						break;
					default: 
						$grade = $grade;			//szare
						break;
				}
				switch ($pm25_pro)
				{
					case $pm25_pro==-1:
						$grade = $grade;							//zielone
						break;
					case $pm25_pro<$green_step:
						$grade = $grade+ 1;							//zielone
						break;
					case $pm25_pro>=$green_step && $pm25_pro<$yellow_step :
						$grade = $grade+2;			//zolte
						break;
					case $pm25_pro>=$yellow_step:
						$grade = $grade+3;			//czerwone
						break;
					default: 
						$grade = $grade;			//szare
						break;
				}
				switch ($pm10_pro)
				{
					case $pm10_pro==-1:
						$grade = $grade;							//zielone
						break;
					case $pm10_pro<$green_step:
						$grade = $grade+ 1;							//zielone
						break;
					case $pm10_pro>=$green_step && $pm10_pro<$yellow_step :
						$grade = $grade+2;			//zolte
						break;
					case $pm10_pro>=$yellow_step:
						$grade = $grade+3;			//czerwone
						break;
					default: 
						$grade = $grade;			//szare
						break;
				}
				
				
				
			}
			else
			{
				$ids=$i;
				$grade=0;
			}
			
			
			if ($i==0)
			{
				$data=$ids."/".$grade.":";
			}
			else
			{
			
				$data=$data.$ids."/".$grade.":";
			}
		
		
		}
	}
	echo $data;
	
	

	  
	 
	  
	  ?>
	