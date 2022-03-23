

<html>
  <head>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);



	var data_db;


		
		function download_data() //funkcja na pobieranie danych z bazy
			{ 
				var xhttp; 
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						data = this.responseText;
					}
				};
  
				xhttp.open("GET", "download.php", true);		//wykonywanie skryptu pobierz2.php na pobranie z bazych średniej wyniikow pm25 z ostatnich 24 godzin
				xhttp.send();
				
				//document.write(data);
				data_db=data.split(".");
				
				
			};
			
			
			//download_data();
			
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['PM10', 0],
          ['PM2.5', 0],
          ['NO2', 0],
		  ['Ozon', 0],
		  ['CO2', 0],
		  ['Temperatura', 0]
        ]);

        var options = {
          width: 4000, height: 240,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);

        setInterval(function() {
			download_data();
          data.setValue(0,1,data_db[4]);
		  data.setValue(1,1,data_db[3]);
		  data.setValue(2,1,data_db[1]);
		  data.setValue(3,1,data_db[0]);
		  data.setValue(4,1,data_db[2]);
		  data.setValue(5,1,data_db[5]);
          chart.draw(data, options);
        }, 1000);
       
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 4000px; height: 240px;"></div>
	<script>data_db</script>
  </body>
</html>
