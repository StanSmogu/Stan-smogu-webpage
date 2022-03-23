<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Mapa smogu</title>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<link rel="Stylesheet" type="text/css" href="mapstyle.css" />
	</head>
	<body onload="pobieranie_pm()" >
 
		<div id="header">			<!--  obszar glownego naglowka -->
			<div id="glowna2"> 
				<a class="glowna" href="index.php">Strona główna</a> 
			</div>
			<h2>Mapa smogu</h2>
			</br> Kliknij w czujnik aby poznać aktualne wyniki pyłów PM10 oraz PM2.5. Wyniki przedstawione są w procentach przekroczenia normy
		</div>

		<div id="gauge_div"></div>		<!--  obszar wyświetlania wykresu pierwszego -->
		<div id="gauge_div2"></div>		<!--  obszar wyświetlania wykresu drugiego -->
		<div id="map"></div>			<!--  obszar wyświetlania mapy -->

		<script>

			google.charts.load('current', {'packages':['gauge']});
	
			var pm25;
			var pm10;
			var map; 
			var heatmap;
			var gradient=czerwony;
			var czerwony = 	
				[
					'rgba(255, 0, 0, 0)',
					'rgba(255, 0, 0, 1)'
				]
		
			var pomaranczowy = 
				[
					'rgba(240, 99, 11, 0)',
					'rgba(240, 99, 11, 1)'
				]
		
			var zolty = 
				[
					'rgba(242, 191, 34, 0)',
					'rgba(242, 191, 34, 1)'
				]
		
			var zielony = 
				[
					'rgba(152, 237, 62, 0)',
					'rgba(152, 237, 62, 1)'
				]
			var pokaz;
			var poka;
			var marker;
			var image = 'img/ikona.gif';  //ladowanie ikony czujnika

			function pobieranie_pm() //funkcja na pobieranie danych z bazy
			{ 
				var xhttp; 
				xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						pm25_pro = this.responseText;
						pm25 = parseInt(pm25_pro);	 
					}
				};
  
				xhttp.open("GET", "pobierz2.php", true);		//wykonywanie skryptu pobierz2.php na pobranie z bazych średniej wyniikow pm25 z ostatnich 24 godzin
				xhttp.send();
				
				var xhttp2; 
				xhttp2 = new XMLHttpRequest();
	  
				xhttp2.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						pm10_pro = this.responseText;
						pm10 = parseInt(pm10_pro);
					}
				};
  
				xhttp2.open("GET", "pobierz3.php", true);		//wykonywanie skryptu pobierz3.php na pobranie z bazych średniej wyniikow pm10 z ostatnich 24 godzin
				xhttp2.send();
	
				var xhttp3; 
				xhttp3 = new XMLHttpRequest();
				xhttp3.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						poka = this.responseText;
						pokaz = parseInt(poka);
					}
				};
  
				xhttp3.open("GET", "pobierz4.php", true);		//wykonywanie skryptu pobierz4.php na pobranie z bazych informacji czy wyniki maja byc wyswietlane
				xhttp3.send();
				changeGradient(pm25,pm10);
				setTimeout(pobieranie_pm, 10000)
			};

			function draw()				//funkcja na rysowanie wykresów z pobranymi danymi 
			{
				var data = google.visualization.arrayToDataTable([
					['Label', 'Value'],
					['PM10[%]', pm10]
				]);
				var options = {min: 0, max: 250,greenFrom:00,greenTo:75, yellowFrom: 75, yellowTo: 100, redFrom: 100, redTo: 250, minorTicks: 10};
				var chart;
				var data2 = google.visualization.arrayToDataTable([
					['Label', 'Value'],
					['PM2.5[%]', pm25]
				]);
				var options2 = {min: 0, max: 500,greenFrom:0,greenTo:75,yellowFrom: 75, yellowTo: 100,redFrom: 100, redTo: 500, minorTicks: 10 };
				var chart2;
       
				chart = new google.visualization.Gauge(document.getElementById('gauge_div'));
				chart.draw(data, options);
				chart2 = new google.visualization.Gauge(document.getElementById('gauge_div2'));
				chart2.draw(data2, options2);
				
				setInterval(function() 			//wywołanie funkcji zmieniającą wartość wyświetlaną na wykresie pierwszym co 10 sekund
				{
					data.setValue(0, 1, pm10);
					chart.draw(data, options);
				}, 10000);
		
				setInterval(function() 			//wywołanie funkcji zmieniającą wartość wyświetlaną na wykresie drugim co 10 sekund 
				{
					data2.setValue(0, 1, pm25);
					chart2.draw(data2, options2);
				}, 10000);
        
			}
	
			var styles = {					//styl wyświetlanej mapy
				default: null,
				hide: [{
					featureType: 'poi',
					stylers: [{visibility: 'off'}]
				},
				{
					featureType: 'transit',
					elementType: 'labels.icon',
					stylers: [{visibility: 'off'}]
				}]};
		
			function initMap() 			//inicjalizacja mapy
			{
				map = new google.maps.Map(document.getElementById('map'), {			//włączanie opcji mapy
					zoom: 14,
					center: {lat: 53.143457, lng: 18.129876},
					mapTypeId: 'roadmap',
					disableDefaultUI: true
				});
		
				heatmap = new google.maps.visualization.HeatmapLayer({			//włączanie kolorwania wybranych punktów mapy
					radius: 600,
					gradient: czerwony,
					data: getPoints(),
					map: map
				});

				marker = new google.maps.Marker({						//ustawienie markera
					position:{lat: 53.143457, lng: 18.129876},
					map: map,
					icon: image,
					animation: google.maps.Animation.DROP,
				});

				map.setOptions({styles: styles['hide']});
				marker.addListener('click', showMeasure);			//funkcja na kliknięcie markera
			}
			
			function changeGradient(pm25, pm10)			//zmienianie koloru obszaru na mapie w zależności od otrzymanych wyników
			{
				if (pm25 <=75 && pm10 <=75)
				{
					gradient=zielony;
				}
				else
				{
					if( (pm25 >75 && pm25 <100)||(pm10 >75 && pm10 <100) ||(pm10 <75 && pm25 >100) )
					{
						gradient=zolty;
					}
					else
					{
						gradient=czerwony;
					}
				}
				heatmap.set('gradient',gradient);
			}

			function showMeasure()		//funckja na kliknięcie markera
			{
		
				if (marker.getAnimation() !== null) 
				{
					marker.setAnimation(null);
					document.getElementById("gauge_div").innerHTML = "";
					document.getElementById("gauge_div2").innerHTML = "";
				} 
				else 
				{
					marker.setAnimation(google.maps.Animation.BOUNCE);
					if(pokaz==1)
					{
						draw();
					}
				}
			}

			function getPoints() //pobieranie wspolrzenych kolorowania obszaru
			{
				return [new google.maps.LatLng(53.143457, 18.129876)];
			}
	 
		</script>
		<!-- ładowanie mapy google z wykupionym kluczem -->
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAs-qB5jmXB9p90rafEWyaRAalb7q-cL-o&libraries=visualization&callback=initMap">
		</script>
	</body>
</html>