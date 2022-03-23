<?php require_once "session_check.php"; ?>
<!DOCTYPE html> 
<html lang="pl">
<head>
	<title>Pomiary</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="refresh" content="30" />
	
</head>
<body>
 <form action="logout.php" method="post">

<input type="submit" value="Wyloguj" />
</br>
<a href='test'>Test</a>
 <?php
    echo "Witaj, ".$_SESSION ['user'];

 ?>
</form>
<?php
//<img src="normy.png" alt="normy" height="150" width="500"> 
	//require_once "session_check.php";
	require_once "connect.php";				// DB parameters, connection, error messages 
	
	
	
	$sql = "DELETE from pomiary WHERE pm2_5=3733";
   mysqli_query($connection, $sql);
   
   $sql1_1 = "DELETE from pomiary WHERE pm2_5=2405";
   mysqli_query($connection, $sql1_1);
	
		$sql1_2 = "DELETE from pomiary WHERE datapomiaru <= DATE_SUB(NOW(),INTERVAL 1 WEEK)";
   mysqli_query($connection, $sql1_2);
						    
						

	
	
	print"Wyniki z ostatniej godziny: ";
	print"</br>";
	
	print "<TABLE CELLPADDING=10 BORDER=2 >";
	print "<TR><TD>Data ostatniego pomiaru</TD><TD>PM2.5</TD><TD>Poziom pyłów PM2.5</TD><TD>PM10</TD><TD>Poziom pyłów PM10</TD></TR>\n";
	$result_1 = mysqli_query ($connection, "SELECT ROUND(AVG(pm2_5)),ROUND(AVG(pm10)) FROM pomiary where datapomiaru >= DATE_SUB(NOW(),INTERVAL 1 HOUR)") 
				or die ("SQL query error: $db_name");
	
	$result_2 = mysqli_query ($connection, "SELECT datapomiaru FROM pomiary ORDER by idp ASC;") 
				or die ("SQL query error: $db_name");
		while ($db_raw2 = mysqli_fetch_array ($result_2)) 
	{
		$dataostatnia = $db_raw2[0];
	}		
	while ($db_raw = mysqli_fetch_array ($result_1)) 
	{
		//$idp   			= $db_raw ['idp'];
		//$data		 	= $db_raw ['datapomiaru'];
		$pm25_1 			= $db_raw [0];
		$pm10_1  			= $db_raw [1];
		
		
		
		switch(true)
		{
			case $pm25_1<12: $stanpm25='Bardzo dobry';break;
			case $pm25_1>=12 AND $pm25_1<36: $stanpm25='Dobry';break;
			case $pm25_1>=36 AND $pm25_1<60: $stanpm25='Umiarkowany';break;
			case $pm25_1>=60 AND $pm25_1<84: $stanpm25='Dostateczny';break;
			case $pm25_1>=84 AND $pm25_1<120: $stanpm25='Zły';break;
			case $pm25_1>=120: $stanpm25='Bardzo zły';break;
		}
		
		switch(true)
		{
			case $pm10_1<20: $stanpm10='Bardzo dobry';break;
			case $pm10_1>=20 AND $pm10_1<60: $stanpm10='Dobry';break;
			case $pm10_1>=60 AND $pm10_1<100: $stanpm10='Umiarkowany';break;
			case $pm10_1>=100 AND $pm10_1<140: $stanpm10='Dostateczny';break;
			case $pm10_1>=140 AND $pm10_1<200: $stanpm10='Zły';break;
			case $pm10_1>=200: $stanpm10='Bardzo zły';break;
		}
		
		
		
		
		
		print "<TR><TD>$dataostatnia</TD><TD>$pm25_1</TD><TD>$stanpm25</TD><TD>$pm10_1</TD><TD>$stanpm10</TD></TR>\n";
	}
	print "</TABLE>";	
	
	
	
	print '
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
	
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Wartość", { role: "style" } ],
        ["PM2_5", '.$pm25_1.', "#b87333"],
        ["PM10", '.$pm10_1.', "silver"],
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Aktualny wynik",
        width: 600,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>';
	
	
	
print "Wyniki PM10 z ostatniej godziny </br>";
print "<img src='wykres1_pm10'>";
print "</br></br>";
print "Wyniki PM2.5 z ostatniej godziny </br>";
print "<img src='wykres1_pm25'>";
	print"</br></br></br>";
	print"Wyniki z ostatnich 24 godzin: ";
	print"</br>";


	
	print "<TABLE CELLPADDING=10 BORDER=2 >";
	print "<TR><TD>Data ostatniego pomiaru</TD><TD>PM2.5</TD><TD>Poziom pyłów PM2.5</TD><TD>PM10</TD><TD>Poziom pyłów PM10</TD></TR>\n";
	$result_3 = mysqli_query ($connection, "SELECT ROUND(AVG(pm2_5)),ROUND(AVG(pm10)) FROM pomiary where datapomiaru >= DATE_SUB(NOW(),INTERVAL 24 HOUR)") 
				or die ("SQL query error: $db_name");
	
	$result_4 = mysqli_query ($connection, "SELECT datapomiaru FROM pomiary ORDER by idp ASC;") 
				or die ("SQL query error: $db_name");
		while ($db_raw4 = mysqli_fetch_array ($result_4)) 
	{
		$dataostatnia = $db_raw4[0];
	}		
	while ($db_raw3 = mysqli_fetch_array ($result_3)) 
	{
		//$idp   			= $db_raw ['idp'];
		//$data		 	= $db_raw ['datapomiaru'];
		$pm25 			= $db_raw3 [0];
		$pm10  			= $db_raw3 [1];
		
		
		
		switch(true)
		{
			case $pm25<12: $stanpm25='Bardzo dobry';break;
			case $pm25>=12 AND $pm25<36: $stanpm25='Dobry';break;
			case $pm25>=36 AND $pm25<60: $stanpm25='Umiarkowany';break;
			case $pm25>=60 AND $pm25<84: $stanpm25='Dostateczny';break;
			case $pm25>=84 AND $pm25<120: $stanpm25='Zły';break;
			case $pm25>=120: $stanpm25='Bardzo zły';break;
		}
		
		switch(true)
		{
			case $pm10<20: $stanpm10='Bardzo dobry';break;
			case $pm10>=20 AND $pm10<60: $stanpm10='Dobry';break;
			case $pm10>=60 AND $pm10<100: $stanpm10='Umiarkowany';break;
			case $pm10>=100 AND $pm10<140: $stanpm10='Dostateczny';break;
			case $pm10>=140 AND $pm10<200: $stanpm10='Zły';break;
			case $pm10>=200: $stanpm10='Bardzo zły';break;
		}
		
		
		
		
		print "<TR><TD>$dataostatnia</TD><TD>$pm25</TD><TD>$stanpm25</TD><TD>$pm10</TD><TD>$stanpm10</TD></TR>\n";
		//echo '<script type="text/javascript">getData('.$pm10.','.$pm2_5.')<script>;' ;
	}
	print "</TABLE>";



	

print "Wyniki PM10 z ostatnich 24 godzin </br>";
print "<img src='wykres24_pm10'>";
print "</br></br>";
print "Wyniki PM2.5 z ostatnich 24 godzin </br>";
print "<img src='wykres24_pm25'>";
	/*	print '
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		  <script type="text/javascript">
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			
			function drawChart() {
			  var data = google.visualization.arrayToDataTable([
				["Element", "Wartość", { role: "style" } ],
				["PM2_5", '.$pm25.', "#b87333"],
				["PM10", '.$pm10.', "silver"],
			  ]);

			  var view = new google.visualization.DataView(data);
			  view.setColumns([0, 1,
							   { calc: "stringify",
								 sourceColumn: 1,
								 type: "string",
								 role: "annotation" },
							   2]);

			  var options = {
				title: "Aktualny wynik",
				width: 600,
				height: 400,
				bar: {groupWidth: "95%"},
				legend: { position: "none" },
			  };
			  var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
			  chart.draw(view, options);
		  }
		  </script>
		<div id="columnchart_values" style="width: 900px; height: 300px;"></div>';*/
?>

</body>
</html>
