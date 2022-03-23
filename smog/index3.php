<?php
	session_start();
	if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true))
	{
		echo "<script>window.location.href='index2.php';</script>";
		
		exit();
	} 
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
<meta http-equiv="refresh" content="30" />
	<title>Bielinski</title>
	
	  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gauge']});
    google.charts.setOnLoadCallback(drawGauge);

    var gaugeOptions = {min: 0, max: 400,greenFrom:50,greenTo:200, yellowFrom: 200, yellowTo: 300,
      redFrom: 300, redTo: 400, minorTicks: 10};
    var gauge;
	var pm25_1;
	var pm10_1;
function getData(pm25,pm10)
{
	pm25_1 = pm25;
	pm10_1 = pm10;
}
    function drawGauge() {
      gaugeData = new google.visualization.DataTable();
      gaugeData.addColumn('number', 'PM2.5');
      gaugeData.addColumn('number', 'PM10');
      gaugeData.addRows(2);
	  
	  
	  gaugeData.setCell(0, 0, pm25_1);
	   gaugeData.setCell(0, 1, pm10_1);
	  
	  
      

      gauge = new google.visualization.Gauge(document.getElementById('gauge_div'));
      gauge.draw(gaugeData, gaugeOptions);
    }

   
  </script>
  
	
	
	
</head>
<body>
<div id="logowanie">
	<H2>Podaj dane logowania</H2>
	<form method="post">
		Nazwa użytkownika: <br /> <input type="text" 	name="username" maxlength="20" size="20" /> <br />
		Hasło: <br /> <input type="password" name="password" maxlength="20" size="20" /> <br /><br />
		<input type="submit" value="Zaloguj" />
	</form>
</div>
<br />
<br />




<?php
require_once "connect.php";

	if ((isset($_POST ['username'])) && (isset($_POST ['password'])))
	{
		session_start();
		$username = $_POST ['username']; 
		$password = $_POST ['password']; 
												// DB parameters, connection, error messages 
		$result_1 = mysqli_query ($connection, "SELECT  * FROM users WHERE login='$username' ") 
				or die ("3SQL query error: $db_name");
		   
	while ($db_raw = mysqli_fetch_array ($result_1)) 
		{
			$idu = $db_raw[0];
			$user = $db_raw[1];
			$pass = $db_raw[2];
		}
		
			if($password==$pass && $username==$user) 
			{	
		
		
		
				$_SESSION ['loggedin'] = true;
				$_SESSION ['user']  = $username;
				unset ($_SESSION ['error']);
				
			
				echo "<script>window.location.href='index2.php';</script>";
				
			}
			else
			{
				
				echo "Invalid username or password.";  // only username is correct, but password not !!
			}
	}
	

	  require_once "connect.php";	
	  $result_2 = mysqli_query ($connection, "SELECT ROUND(AVG(pm2_5)),ROUND(AVG(pm10)) FROM pomiary WHERE datapomiaru >= DATE_SUB(NOW(),INTERVAL 24 HOUR)") 
				or die ("SQL query error: $db_name");
	
			
	while ($db_raw2 = mysqli_fetch_array ($result_2)) 
	{
		$pm25_1 			= $db_raw2 [0];
		$pm10_1  			= $db_raw2 [1];
	}
	  
	  
	  echo"<script type='text/javascript'>getData(".$pm25_1." ,".$pm10_1." )</script>"
	  
	  ?>
 
 
  <div id="gauge_div" style="width:560px; height: 280px;"></div>




</body>
</html>