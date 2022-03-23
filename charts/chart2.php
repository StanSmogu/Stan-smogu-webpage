<html>
	<head>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['gauge']});
			google.charts.setOnLoadCallback(drawChart);
			var data_db;
			
			var width=400;
			var height=240;
			
			var ozone_green_from;
			var ozone_green_to;
			var ozone_yellow_from;
			var ozone_yellow_to;
			var ozone_red_from;
			var ozone_red_to;
			
			var no2_green_from;
			var no2_green_to;
			var no2_yellow_from;
			var no2_yellow_to;
			var no2_red_from;
			var no2_red_to;
			
			var co2_green_from;
			var co2_green_to;
			var co2_yellow_from;
			var co2_yellow_to;
			var co2_red_from;
			var co2_red_to;;
			
			var pm25_green_from;
			var pm25_green_to;
			var pm25_yellow_from;
			var pm25_yellow_to;
			var pm25_red_from;
			var pm25_red_to;
			
			var pm10_green_from;
			var pm10_green_to;
			var pm10_yellow_from;
			var pm10_yellow_to;
			var pm10_red_from;
			var pm10_red_to;
			
			
			var ozone_data=0;
			var no2_data=0;
			var co2_data=0;
			var pm25_data=0;
			var pm10_data=0;
			var temp_data=0;
			
			var data_db;
			var stand_db;
			
			var data;
			var data2;

			var ids=2;
			
			function download_data() //funkcja na pobieranie danych z bazy
			{ 
				var xhttp; 
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						data = this.responseText;
						data_db=data.split(".");
						ozone_data	=data_db[0];
						no2_data	=data_db[1];
						co2_data	=data_db[2];
						pm25_data	=data_db[3];
						pm10_data	=data_db[4];
						temp_data	=data_db[5];
					}
				};
				
				xhttp.open("GET", "download.php?ids=ids", true);		//wykonywanie skryptu pobierz2.php na pobranie z bazych średniej wyniikow pm25 z ostatnich 24 godzin
				xhttp.send();
				
			};
			
			function download_standards() //funkcja na pobieranie danych z bazy
			{ 
				
				var xhttp2; 
				xhttp2 = new XMLHttpRequest();
				xhttp2.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						data2 = this.responseText;
						stand_db=data2.split(".");
						ozone_green_from	=stand_db[9];
						ozone_green_to		=stand_db[10];
						ozone_yellow_from	=stand_db[11];
						ozone_yellow_to		=stand_db[12];
						ozone_red_from		=stand_db[13];
						ozone_red_to		=stand_db[14];
						
						no2_green_from		=stand_db[15];
						no2_green_to		=stand_db[16];
						no2_yellow_from		=stand_db[17];
						no2_yellow_to		=stand_db[18];
						no2_red_from		=stand_db[19];
						no2_red_to			=stand_db[20];
						
						co2_green_from		=stand_db[21];
						co2_green_to		=stand_db[22];
						co2_yellow_from		=stand_db[23];
						co2_yellow_to		=stand_db[24];
						co2_red_from		=stand_db[25];
						co2_red_to			=stand_db[26];
						
						pm25_green_from		=stand_db[27];
						pm25_green_to		=stand_db[28];
						pm25_yellow_from	=stand_db[29];
						pm25_yellow_to		=stand_db[30];
						pm25_red_from		=stand_db[31];
						pm25_red_to			=stand_db[32];
						
						pm10_green_from		=stand_db[33];
						pm10_green_to		=stand_db[34];
						pm10_yellow_from	=stand_db[35];
						pm10_yellow_to		=stand_db[36];
						pm10_red_from		=stand_db[37];
						pm10_red_to			=stand_db[38];
					}
				};
				xhttp2.open("GET", "download2.php", true);		//wykonywanie skryptu pobierz2.php na pobranie z bazych średniej wyniikow pm25 z ostatnich 24 godzin
				xhttp2.send();
				
			};
			
      function drawChart() 
	  {
		
        var data_ozone = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Ozon', 0],
        ]);
		
		var data_no2 = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['NO2', 0],
        ]);
		
		var data_co2 = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['CO2', 0],
        ]);
		
		var data_pm25 = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['PM2.5', 0],
        ]);
		
		var data_pm10 = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['PM10', 0],
        ]);
		
		var data_temp = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Temperatura', 0],
        ]);
		
		
		  
		//download_standards();
		//document.write(ozone_green_to);
        var options_ozone = {
         width: width, height: height,
		 
         minorTicks: 5
        };
		
		var options_no2 = {
          width: width, height: height,
          
          minorTicks: 5
        };
		
		var options_co2 = {
          width: width, height: height,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };
		
		var options_pm25 = {
          width: width, height: height,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };
		
		var options_pm10 = {
          width: width, height: height,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };
		
		var options_temp = {
          width: width, height: height,
          min: -30,
		  max: 30,
          minorTicks: 5
        };

        var chart_ozone = new google.visualization.Gauge(document.getElementById('chart_div_ozone'));
		var chart_no2 = new google.visualization.Gauge(document.getElementById('chart_div_no2'));
		var chart_co2 = new google.visualization.Gauge(document.getElementById('chart_div_co2'));
		var chart_pm25 = new google.visualization.Gauge(document.getElementById('chart_div_pm25'));
		var chart_pm10 = new google.visualization.Gauge(document.getElementById('chart_div_pm10'));
		var chart_temp = new google.visualization.Gauge(document.getElementById('chart_div_temp'));
		
		

     /*   chart_ozone.draw(data_ozone, options_ozone);
		chart_no2.draw(data_no2, options_no2);
		chart_co2.draw(data_co2, options_co2);
		chart_pm25.draw(data_pm25, options_pm25);
		chart_pm10.draw(data_pm10, options_pm10);
		chart_temp.draw(data_temp, options_temp);*/
		
		
		download_standards();





        setInterval(function() 
		{
			download_data();
			
			data_ozone.setValue(0,1,ozone_data);
			data_no2.setValue(0,1,no2_data);
			data_co2.setValue(0,1,co2_data);
			data_pm25.setValue(0,1,pm25_data);
			data_pm10.setValue(0,1,pm10_data);
			data_temp.setValue(0,1,temp_data);
		  
			options_ozone = 
			{
				width: width, 
				height: height,
				greenFrom: ozone_green_from, 
				greenTo: ozone_green_to,
				yellowFrom: ozone_yellow_from, 
				yellowTo: ozone_yellow_to,
				redFrom: ozone_red_from, 
				redTo: ozone_red_to,
				min: ozone_green_from, 
				max: ozone_red_to,
				minorTicks: 5
			};
			
			options_no2 = 
			{
				width: width, 
				height: height,
				greenFrom: no2_green_from, 
				greenTo: no2_green_to,
				yellowFrom: no2_yellow_from, 
				yellowTo: no2_yellow_to,
				redFrom: no2_red_from, 
				redTo: no2_red_to,
				min: no2_green_from, 
				max: no2_red_to,
				minorTicks: 5
			};
			
			options_co2 = 
			{
				width: width, 
				height: height,
				greenFrom: co2_green_from, 
				greenTo: co2_green_to,
				yellowFrom: co2_yellow_from, 
				yellowTo: co2_yellow_to,
				redFrom: co2_red_from, 
				redTo: co2_red_to,
				min: co2_green_from, 
				max: co2_red_to,
				minorTicks: 5
			};
			
			options_pm25 = 
			{
				width: width, 
				height: height,
				greenFrom: pm25_green_from, 
				greenTo: pm25_green_to,
				yellowFrom: pm25_yellow_from, 
				yellowTo: pm25_yellow_to,
				redFrom: pm25_red_from, 
				redTo: pm25_red_to,
				min: pm25_green_from, 
				max: pm25_red_to,
				minorTicks: 5
			};
			
			options_pm10 = 
			{
				width: width, 
				height: height,
				greenFrom: pm10_green_from, 
				greenTo: pm10_green_to,
				yellowFrom: pm10_yellow_from, 
				yellowTo: pm10_yellow_to,
				redFrom: pm10_red_from, 
				redTo: pm10_red_to,
				min: pm10_green_from, 
				max: pm10_red_to,
				minorTicks: 5
			};
		  
			chart_ozone.draw(data_ozone, options_ozone);
			chart_no2.draw(data_no2, options_no2);
			chart_co2.draw(data_co2, options_co2);
			chart_pm25.draw(data_pm25, options_pm25);
			chart_pm10.draw(data_pm10, options_pm10);
			chart_temp.draw(data_temp, options_temp);
		}, 1000);
       
	   
	   
	   
      }
    </script>
  </head>
  <body>
    <div id="chart_div_ozone" style="width: 400px; height: 240px;"></div>
	<div id="chart_div_no2" style="width: 400px; height: 240px;"></div>
	<div id="chart_div_co2" style="width: 400px; height: 240px;"></div>
	<div id="chart_div_pm25" style="width: 400px; height: 240px;"></div>
	<div id="chart_div_pm10" style="width: 400px; height: 240px;"></div>
	<div id="chart_div_temp" style="width: 400px; height: 240px;"></div>
  </body>
</html>
