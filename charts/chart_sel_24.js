		
			function user_download_sel_data_chart_24(ids_s,date_s) //funkcja na pobieranie danych z bazy
			{ 
			var ids = ids_s;
			var date = date_s;
				var xhttp3; 
				xhttp3 = new XMLHttpRequest();
				xhttp3.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						user_data_24 = this.responseText;
						user_data_db_24=user_data_24.split("|");
						user_ozone_data_24	=user_data_db_24[1];
						user_no2_data_24	=user_data_db_24[3];
						user_co2_data_24	=user_data_db_24[5];
						user_pm25_data_24	=user_data_db_24[7];
						user_pm10_data_24	=user_data_db_24[9];;
						user_temp_data_24	=user_data_db_24[11];
						user_wind_data_24	=user_data_db_24[15];
					}
				};
				
				xhttp3.open("GET", "charts/gau_data_sel_24.php?ids="+ids+"&date="+date, true);		//wykonywanie skryptu pobierz2.php na pobranie z bazych średniej wyniikow pm25 z ostatnich 24 godzin
				xhttp3.send();
				
			};
	

		function user_set_data_chart_24_sel(ids_sel,date_sel)
		{

			var ids=ids_sel;
			var date=date_sel;
			user_download_sel_data_chart_24(ids,date);
		
			setTimeout(function()
			{
				if(user_is_ozone==1)
				{
					user_data_ozone_24.setValue(0,1,user_ozone_data_24);
					user_ozone_pro_24=Math.round((user_ozone_data_24/ozone_stan)*100);
					document.getElementById("user_gau_chart_pro_ozone_24").innerHTML = user_ozone_pro_24+"%";
				}
				else
				{
					user_data_ozone_24.setValue(0,1,0);
					document.getElementById("user_gau_chart_pro_ozone_24").innerHTML = "N/A";
				}
				
				if (user_is_no2==1)
				{
					user_data_no2_24.setValue(0,1,user_no2_data_24);
					user_no2_pro_24=Math.round((user_no2_data_24/no2_stan)*100);
					document.getElementById("user_gau_chart_pro_no2_24").innerHTML = user_no2_pro_24+"%";
				}
				else
				{
					user_data_no2_24.setValue(0,1,0);
					document.getElementById("user_gau_chart_pro_no2_24").innerHTML = "N/A";
				}
				
				if(user_is_co2==1)
				{
					user_data_co2_24.setValue(0,1,user_co2_data_24);
					user_co2_pro_24=Math.round((user_co2_data_24/co2_stan)*100);
					document.getElementById("user_gau_chart_pro_co2_24").innerHTML = user_co2_pro_24+"%";
				}
				else
				{
					user_data_co2_24.setValue(0,1,0);
					document.getElementById("user_gau_chart_pro_co2_24").innerHTML = "N/A";
				}
				
				if (user_is_pm25==1)
				{
					user_data_pm25_24.setValue(0,1,user_pm25_data_24);
					user_pm25_pro_24=Math.round((user_pm25_data_24/pm25_stan)*100);
					document.getElementById("user_gau_chart_pro_pm25_24").innerHTML = user_pm25_pro_24+"%";
				}
				else
				{
					user_data_pm25_24.setValue(0,1,0);
					document.getElementById("user_gau_chart_pro_pm25_24").innerHTML = "N/A";
				}
				
				if(user_is_pm10==1)
				{
					user_data_pm10_24.setValue(0,1,user_pm10_data_24);
					user_pm10_pro_24=Math.round((user_pm10_data_24/pm10_stan)*100);
					document.getElementById("user_gau_chart_pro_pm10_24").innerHTML = user_pm10_pro_24+"%";
				}
				else
				{
					user_data_pm10_24.setValue(0,1,0);
					document.getElementById("user_gau_chart_pro_pm10_24").innerHTML = "N/A";
				}
				
				if(user_is_wind==1)
				{
					user_data_wind_24.setValue(0,1,user_wind_data_24);
					document.getElementById("user_gau_chart_pro_wind_24").innerHTML = user_wind_data_24+" km/h";
				}
				else
				{
					user_data_wind_24.setValue(0,1,0);
					document.getElementById("user_gau_chart_pro_wind_24").innerHTML = "N/A";
				}
			  
				user_chart_ozone_24.draw(user_data_ozone_24, options_ozone);
				user_chart_no2_24.draw(user_data_no2_24, options_no2);
				user_chart_co2_24.draw(user_data_co2_24, options_co2);
				user_chart_pm25_24.draw(user_data_pm25_24, options_pm25);
				user_chart_pm10_24.draw(user_data_pm10_24, options_pm10);
				user_chart_wind_24.draw(user_data_wind_24, options_wind);
				
				
				if(user_is_temp==1)
				{
					document.getElementById("user_gau_chart_temp_24").innerHTML = "TEMPERATURA: "+user_temp_data_24+" &deg;C";
				}
				else
				{
					document.getElementById("user_gau_chart_temp_24").innerHTML = "TEMPERATURA: BRAK POMIARU";
				}
				
				
				
				
				
			},250);
       
	   
	   
		}
      
