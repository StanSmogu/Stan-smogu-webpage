<?php	
	$station= new \stdClass();
	require_once "connect.php";	
	$first=true;
	$count=0;
	$sql_ds1 = mysqli_query ($connection, "SELECT COUNT(ids) FROM sensors" ) 
				or die ("SQL query error: $db_name");
	
	while ($db_ds1 = mysqli_fetch_array ($sql_ds1)) 
	{
		$count = $db_ds1[0];
	}
	
	mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	$sql_ds2 = mysqli_query ($connection, "SELECT * FROM sensors" ) 
				or die ("SQL query error: $db_name");
	
	while ($db_ds2 = mysqli_fetch_array ($sql_ds2)) 
	{
		$station->ids			= $db_ds2[0];
		$station->install_date	= $db_ds2[1];
		$station->is_ozone		= $db_ds2[2];
		$station->is_no2			= $db_ds2[3];
		$station->is_co2			= $db_ds2[4];
		$station->is_pm25		= $db_ds2[5];
		$station->is_pm10		= $db_ds2[6];
		$station->is_temp		= $db_ds2[7];
		$station->is_wind		= $db_ds2[8];
		$station->idu			= $db_ds2[9];
		$station->city			= $db_ds2[10];
		$station->street			= $db_ds2[11];
		$station->number			= $db_ds2[12];
		$station->coordinates1	= $db_ds2[13];
		$station->coordinates2	= $db_ds2[14];
		$station->name			= $db_ds2[15];
		$ids=$db_ds2[0];
		$idu=$db_ds2[9];
		/*$ids			= $db_ds2[0];
		$install_date	= $db_ds2[1];
		$is_ozone		= $db_ds2[2];
		$is_no2			= $db_ds2[3];
		$is_co2			= $db_ds2[4];
		$is_pm25		= $db_ds2[5];
		$is_pm10		= $db_ds2[6];
		$is_temp		= $db_ds2[7];
		$is_wind		= $db_ds2[8];
		$idu			= $db_ds2[9];
		$city			= $db_ds2[10];
		$street			= $db_ds2[11];
		$number			= $db_ds2[12];
		$coordinates1	= $db_ds2[13];
		$coordinates2	= $db_ds2[14];
		$name			= $db_ds2[15];
		*/
		$sql_ds3 = mysqli_query ($connection, "SELECT company FROM users WHERE idu=idu" ) 
						or die ("SQL query error: $db_name");
		while ($db_ds3 = mysqli_fetch_array ($sql_ds3)) 
		{
			$station->company = $db_ds3[0];
		}		
			
		$sql_ds4 = mysqli_query ($connection, "SELECT measure_date FROM meteo_zam.measure_live WHERE ids=ids ORDER by measure_date DESC LIMIT 1" ) 
						or die ("SQL query error: $db_name");
		while ($db_ds4 = mysqli_fetch_array ($sql_ds4)) 
		{
			$station->measure_date = $db_ds4[0];
						
		}
		
		/*if($first==true)
		{
			$sensors_meta=$count."&".$ids."/".$measure_date."/".$is_ozone."/".$is_no2."/".$is_co2."/".$is_pm25."/".$is_pm10."/".$is_temp."/".$is_wind."/".$idu."/".$city."/".$street."/".$number."/".$coordinates1."/".$coordinates2."/".$name."/".$company."/".$install_date."|";
			$first=false;
		}
		else
		{
			$sensors_meta=$sensors_meta.$ids."/".$measure_date."/".$is_ozone."/".$is_no2."/".$is_co2."/".$is_pm25."/".$is_pm10."/".$is_temp."/".$is_wind."/".$idu."/".$city."/".$street."/".$number."/".$coordinates1."/".$coordinates2."/".$name."/".$company."/".$install_date."|";
		}*/
		$stations = json_encode($station);
		echo $stations;		
	}
	
 ?>