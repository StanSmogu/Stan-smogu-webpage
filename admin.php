<?php
	session_start();
	if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true) && (!isset($_SESSION['admin'])))
	{
		echo "<script>window.location.href='user.php';</script>";
		exit();
	}	
	else if (!isset($_SESSION['loggedin']))
	{
		echo "<script>window.location.href='index.php';</script>";
		exit();
	} 
?>
<!DOCTYPE html>
<html>
	<head>
	
		<title>Stan smogu</title>
		<meta charset="utf-8" />
		<meta name="description" content="Rrejestracja i wizualizacja stanu smogu oraz wybranych parametrów powietrza na żywo">
		<meta name="keywords" content="smog,stan powietrza,powietrze,pm10,pm2.5,no2,co2,o3,temperatura,bydgoszcz,3D,live,wiatr,indeks jakosci powietrza">
		<meta name="author" content="Maciej Bieliński">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="style2.css">
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128054002-2"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-159452040-1');
		</script>
		<script data-ad-client="ca-pub-9803685555370102" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script type="text/javascript" src="charts/chart2.js"></script>
		<script type="text/javascript" src="wykresy/wykres_user.js"></script>
		<script type="text/javascript" src="technicals.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="menu" id="user_menu">
				<a href="javascript:void(0)" class="open_page" onclick="open_ch(0)">Strona główna</a>
				<a href="javascript:void(0)" class="open_page" onclick="open_ch(1)">Dane czujników</a>
				<a href="javascript:void(0)" class="open_page" onclick="open_ch(2)">Wzkaźniki</a>
				<a href="javascript:void(0)" class="open_page" onclick="open_ch(3)">Wykresy</a>
				<a href="javascript:void(0)" class="open_page" onclick="open_ch(4)">Parametry techniczne</a>
				<a href="javascript:void(0)" class="open_page" onclick="open_ch(5)">Wiadomości</a>
				<a href="javascript:void(0)" class="open_page" onclick="open_ch(6)">Dodaj czujnik</a>
				<a href="logout.php" 		class="open_page" onclick="">Wyloguj</a>
				
				<?php
					include"main.php";
					include "download_sensors.php";
					require_once"connect.php";
					
					$ids_tot=[];
					$ids_choos=[];
					$i=0;
					$idu=$_SESSION ['idu'];
					
					$sql_a1 = mysqli_query ($connection, "SELECT COUNT(ids) FROM sensors" ) 
							or die ("SQL query error: $db_name");
					
					while ($db_a1 = mysqli_fetch_array ($sql_a1)) 
					{
						$sensors_am	=	(int)$db_a1[0];
					}
					
					mysqli_query($connection, "SET CHARSET utf8");
					mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
					
					$sql_a2 = mysqli_query ($connection, "SELECT ids,city,street FROM sensors" ) 
							or die ("SQL query error: $db_name");
					
					while ($db_a2 = mysqli_fetch_array ($sql_a2)) 
					{
						$ids			= (int)$db_a2[0];
						$city			= $db_a2[1];
						$street			= $db_a2[2];
						$ids_tot[$i]	= $ids;
						$city_tot[$i]	= $city;
						$street_tot[$i]	= $street;
						$i++;
					}
					
					if($sensors_am==0)
					{
						$error=true;
						$one=false;
					}
					else if ($sensors_am==1)
					{
						$error=false;
						$ids_choos=$ids;
						$one=true;
					}
					else if ($sensors_am>1)
					{
						$error=false;
						$one=false;
						print'<div class="select_ids"><select name="ids">';
						for ($a=0;$a<$sensors_am;$a++)
						{
							print'<option value='.$ids_tot[$a].' selected="selected" onclick="draw('.$ids_tot[$a].')">'.$city_tot[$a].', ul.'.$street_tot[$a].'</option>';
						}
						print'</select></div>';
						$ids_choos=$ids_tot[$a];
					}
				?>
		
			</div>
			<span class="spanstyle" id="menu_span" onclick="openMen()">&#9776; Menu</span>
			<div class="data" id="user_data">
				<div id="main"></div>
				<div id="sensors">
					<div class="sensors">
						<p id="city"></p>
						<p id="street"></p>
						<p id="company"></p>
						<p id="measure_date"></p>
						<p id="state"><p id="state2"></p></p>
						<p id="install_date"></p>
						<p id="measure_param"></p>
					</div>
				</div>
				<div id="gauge">
					<p>Dane na żywo</p>
					<div id="gauge_live" class="gau_charts">
						<div class="gau_chart_temp" id="user_gau_chart_temp_live"></div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">PM2.5</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_pm25_live"></div>
							<div class="gau_chart" id="user_gau_chart_pm25_live"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">OZON</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_ozone_live"></div>
							<div class="gau_chart" id="user_gau_chart_ozone_live"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">PM10</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_pm10_live"></div>
							<div class="gau_chart" id="user_gau_chart_pm10_live"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">NO2</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_no2_live"></div>
							<div class="gau_chart" id="user_gau_chart_no2_live"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">Wiatr</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_wind_live"></div>
							<div class="gau_chart" id="user_gau_chart_wind_live"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">CO2</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_co2_live"></div>
							<div class="gau_chart" id="user_gau_chart_co2_live"></div>
						</div>
					</div>
					<p>Średnia z 1 godziny</p>
					<div id="gauge_1" class="gau_charts">
						<div class="gau_chart_temp" id="user_gau_chart_temp_1"></div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">PM2.5</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_pm25_1"></div>
							<div class="gau_chart" id="user_gau_chart_pm25_1"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">OZON</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_ozone_1"></div>
							<div class="gau_chart" id="user_gau_chart_ozone_1"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">PM10</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_pm10_1"></div>
							<div class="gau_chart" id="user_gau_chart_pm10_1"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">NO2</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_no2_1"></div>
							<div class="gau_chart" id="user_gau_chart_no2_1"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">Wiatr</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_wind_1"></div>
							<div class="gau_chart" id="user_gau_chart_wind_1"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">CO2</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_co2_1"></div>
							<div class="gau_chart" id="user_gau_chart_co2_1"></div>
						</div>
					</div>
					<p id="label_gau_24">Średnia z 24 godzin</p>
					<div id="gauge_24" class="gau_charts">
						<div class="gau_chart_temp" id="user_gau_chart_temp_24"></div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">PM2.5</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_pm25_24"></div>
							<div class="gau_chart" id="user_gau_chart_pm25_24"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">OZON</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_ozone_24"></div>
							<div class="gau_chart" id="user_gau_chart_ozone_24"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">PM10</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_pm10_24"></div>
							<div class="gau_chart" id="user_gau_chart_pm10_24"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">NO2</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_no2_24"></div>
							<div class="gau_chart" id="user_gau_chart_no2_24"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">Wiatr</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_wind_24"></div>
							<div class="gau_chart" id="user_gau_chart_wind_24"></div>
						</div>
						<div class="gau_chart_pack">
							<div class="gau_chart_title">CO2</div>
							<div class="gau_chart_pro" id="user_gau_chart_pro_co2_24"></div>
							<div class="gau_chart" id="user_gau_chart_co2_24"></div>
						</div>
						<div class="select_date">
							<form>
							  <label for="datemax">Wybierz inny dzień:</label>
							  <input name="setDateUser" type="date" id="datemax">
							  <input type="button" value="Zatwierdź" onClick="selected_gau(this.form)">
							  <input type="button" value="Pokaż ostatnie 24h" onClick="last_gau(this.form)">
							</form>
						</div>
					</div>
				</div>
				<div id="charts">
					<div class="charts">
						<p id="user_none_col">Dane z ostatnich 24 godzin</p>
						<div class="select_date2">
							<form>
								<label for="datemax">Wybierz inny dzień:</label>
								<input name="setDateUser2" type="date" id="datemax">
								<input type="button" value="Zatwierdź" onClick="selected_col(this.form)">
								<input type="button" value="Pokaż ostatnie 24h" onClick="last_col(this.form)">
							</form>
						</div>
						<div id="user_chart_pm25_10_col" class="col"></div>
						<div id="user_chart_ozone_col" class="col"></div>
						<div id="user_chart_no2_col" class="col"></div>
						<div id="user_chart_co2_col" class="col"></div>
						<div id="user_chart_temp_col" class="col"></div>
						<div id="user_chart_wind_col" class="col"></div>
					</div>
				</div>
				<div id="technicals"></div>
				<div id="messages">
					<div class="contact">
						<h2> Otrzymane wiadomości</h2>
						<div id="messages_tab"></div>
					</div>
				</div>
			
				<div id="add_sensor">
					<div class="add_sensor">
						<h1>Dodaj czujnik</h1>
						<form action="add_sensor.php" method="post">
							<div class="insert">
								<label>Data montażu: </label> 
								<input type="date" name="install_date">
							</div>
							<div class="insert">
								<label>Wybierz mierzone parametry: </label>
								<p><input type="checkbox" name="ozone" value="1">Ozon</p>
								<p><input type="checkbox" name="no2" value="1">NO2</p>
								<p><input type="checkbox" name="co2" value="1">CO2</p>
								<p><input type="checkbox" name="pm10" value="1">PM10</p>
								<p><input type="checkbox" name="pm25" value="1">PM2.5</p>
								<p><input type="checkbox" name="temperature" value="1">Temperatura</p>
								<p><input type="checkbox" name="wind" value="1">Wiatr</p>
							</div>
							<div class="insert">
								<label>Wybierz użytkownika</label>
								<select name="idu">
									<?php
										mysqli_query($connection, "SET CHARSET utf8");
										mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
										$sql_a3 = mysqli_query ($connection, "SELECT idu,name,surname FROM users" ) 
													or die ("SQL query error: $db_name");
							
										while ($db_a3 = mysqli_fetch_array ($sql_a3)) 
										{
											$ids		=	$db_a3[0];
											$name		=	$db_a3[1];
											$surname	=	$db_a3[2];
											print('<option value='.$ids.' >'.$name.' '.$surname.'</option>');
										}
									?>
								</select>
							</div>
							<div class="insert">
								<label>Miasto: </label>
								<input type="text" name="city">
							</div>
							<div class="insert">
								<label>Ulica: </label>
								<input type="text" name="street">
							</div>
							<div class="insert">
								<label>Numer: </label>
								<input type="number" min="1" name="number">
							</div>
							<div class="insert">
								<label style="float: left">Współrzędne: </label>
								<div class="coor">
									<p style="font-size: 20px;"><input type="number" name="coor_11">&nbsp;&deg;</p>
									<p style="font-size: 20px;"><input type="number" name="coor_12">&nbsp;&lsquo;</p>  
									<p style="font-size: 20px;"><input type="number" name="coor_13">&nbsp;&quot;</p>
									<select name="coor_1">
										<option value="north">N</option>
										<option value="south">S</option>
									</select>
								</div>
								<div class="coor">
									<p style="font-size: 20px;"><input type="number" name="coor_21">&nbsp;&deg;</p>
									<p style="font-size: 20px;"><input type="number" name="coor_22">&nbsp;&lsquo;</p>  
									<p style="font-size: 20px;"><input type="number" name="coor_23">&nbsp;&quot;</p>
									<select name="coor_2">
										<option value="east">E</option>
										<option value="west">W</option>
									</select>
								</div>
							</div>
							<input type="submit" value="Dodaj czujnik" name="add_sensor">
						</form> 
					</div>
					<div class="add_sensor">
						<h1>Dodaj użytkownika</h1>
						<form action="add_user.php" method="post">
							<div class="insert">
								<label>Imię</label>
								<input type="text" name="name">
							</div>
							<div class="insert">
								<label>Nazwisko</label>
								<input type="text" name="surname">
							</div>
							<div class="insert">
								<label>Login</label>
								<input type="text" name="login">
							</div>
							<div class="insert">
								<label>E-mail</label>
								<input type="email" name="mail">
							</div>
							<div class="insert">
								<label>Hasło</label>
								<input type="password" name="pass1">
							</div>
							<div class="insert">
								<label>Powtórz hasło</label>
								<input type="password" name="pass2">
							</div>
							<div class="insert">
								<label>Firma</label>
								<input type="text" name="company">
							</div>
							<div class="insert">
								<label>Rola</label>
								<select name="role">
									<option value="user">Użytkownik</option>
									<option value="admin">Administrator</option>
								</select>
							</div>
							<input type="submit" value="Dodaj użytkownika" name="add_user">
						</form>
					</div>
				</div>
			</div>
		</div>
		<script>
			var ids=[];
			var date2=[];
			var is_ozone2=[];
			var is_no22=[];
			var is_co22=[];
			var is_pm252=[];
			var is_pm102=[];
			var is_temp2=[];
			var is_wind2=[];
			var idu=[];
			var city=[];
			var street=[];
			var number=[];
			var coordinates1=[];
			var coordinates2=[];
			var name=[];
			var company=[];
			var date_install=[];
			var download_sensors_meta1;
			var download_sensors_meta2=[];
			var download_sensors_meta3=[];
			var download_sensors_meta4=[];
			var download_sensors_meta5=[];
			var download_data_state1;
			var download_data_state2=[];
			var download_data_state3=[];
			var state_ids=[];
			var state_state=[];
			var state_date=[];
			var cat;
			var mes;
			var measure_param;
			var color_bzl="#FF0000";
			var color_zl="#FF4E00";
			var color_do="#FFB91D";
			var color_um="#FFFF14";
			var color_db="#A0FF64";
			var color_bdb="#31FF32";
			var color_nd="#B8B8B8";
			var messages_table;
			var nr_sens=<?php echo json_encode($ids_choos); ?>;
			var nr_user=<?php echo json_encode($_SESSION['idu']); ?>;
			var download_sensors_meta1 = <?php echo json_encode($sensors_meta); ?>;
			var main = <?php echo json_encode($main); ?>;
			
			var table_tech1='<div class="technicals"><table><tr><th rowspan="2">Data</th><th colspan="3">Ozon</th><th colspan="3">NO2</th><th rowspan="2">Wentylator</th><th rowspan="2">Grzałka</th></tr><tr><th>Temperatura</th><th>Wilgotność</th><th>Praca</th><th>Temperatura</th><th>Wilgotność</th><th>Praca</th></tr><tr><td id="date_tech"></td><td id="ozone_temp"></td><td id="ozone_hum"></td><td id="ozone_err"></td><td id="no2_temp"></td><td id="no2_hum"></td><td id="no2_err"></td><td id="vent"></td><td id="heater"></td></tr></table></div>';
		
			var table_tech2='<div class="technicals"><table><tr><th colspan="2">Data</th><td id="date_tech"></td></tr><tr><th rowspan="3">Ozon</th><th>Temperatura</th><td id="ozone_temp"></td></tr><tr><th>Wilgotność</th><td id="ozone_hum"></td></tr><tr><th>Praca</th><td id="ozone_err"></td></tr><tr><th rowspan="3">NO2</th><th>Temperatura</th><td id="no2_temp"></td></tr><tr><th>Wilgotność</th><td id="no2_hum"></td> </tr><tr><th>Praca</th><td id="no2_err"></td></tr><tr><th colspan="2">Wentylator</th><td id="vent"></td></tr><tr><th colspan="2">Grzałka</th><td id="heater"></td></tr></table></div>';
			
			var today = new Date().toISOString().split('T')[0];
			document.getElementsByName("setDateUser")[0].setAttribute('max', today);
			document.getElementsByName("setDateUser2")[0].setAttribute('max', today);
			
			if (window.innerWidth<1000)
			{
				document.getElementById("user_data").style.display="none";
				document.getElementById("user_menu").style.width="100%";
				document.getElementById("menu_span").style.display="none";
				document.getElementById("messages_tab").style.fontSize="50%";
				document.getElementById("messages_tab").style.paddingLeft="0px";				
				document.getElementById("technicals").innerHTML=table_tech2;
			}
			else
			{
				document.getElementById("technicals").innerHTML=table_tech1;
			}
			
			download_data_state();
			document.getElementById("user_data").style.display="block";
			document.getElementById("menu_span").style.display="none";
			
			download_sensors_meta2=download_sensors_meta1.split("&");
			count=download_sensors_meta2[0];
			download_sensors_meta3=download_sensors_meta2[1];		
			download_sensors_meta4=download_sensors_meta3.split("|");
			
			for (i=0;i<count;i++)
			{
				download_sensors_meta5[i] = download_sensors_meta4[i].split("/");
				ids[i]				= download_sensors_meta5[i][0];
				date2[i]			= download_sensors_meta5[i][1];
				is_ozone2[i]		= download_sensors_meta5[i][2];
				is_no22[i]			= download_sensors_meta5[i][3];
				is_co22[i]			= download_sensors_meta5[i][4];
				is_pm252[i]			= download_sensors_meta5[i][5];
				is_pm102[i]			= download_sensors_meta5[i][6];
				is_temp2[i]			= download_sensors_meta5[i][7];
				is_wind2[i]			= download_sensors_meta5[i][8];
				idu[i]				= download_sensors_meta5[i][9];
				city[i]				= download_sensors_meta5[i][10];
				street[i]			= download_sensors_meta5[i][11];
				number[i]			= download_sensors_meta5[i][12];
				coordinates1[i]		= download_sensors_meta5[i][13];
				coordinates2[i]		= download_sensors_meta5[i][14];
				name[i]				= download_sensors_meta5[i][15];
				company[i]			= download_sensors_meta5[i][16];
				date_install[i]		= download_sensors_meta5[i][17];
			}
			
			document.getElementById("city").innerHTML = city[nr_sens-1];
			document.getElementById("street").innerHTML = "ul. "+street[nr_sens-1];
			document.getElementById("company").innerHTML = "Właściciel czujnika: "+company[nr_sens-1];
			document.getElementById("measure_date").innerHTML = "Czas ostatniego pomiaru: "+date2[nr_sens-1];
			document.getElementById("install_date").innerHTML = "Data instalacji: "+date_install[nr_sens-1];
			document.getElementsByName("setDateUser")[0].setAttribute('min', date_install[nr_sens-1]);
			document.getElementsByName("setDateUser2")[0].setAttribute('min', date_install[nr_sens-1]);
			
			if (is_pm252[nr_sens-1]==1)
			{
				measure_param+="PM<sub>2.5</sub>";
			}
			if (is_pm102[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="PM<sub>10</sub>";
			}
			if (is_ozone2[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="ozon";
			}
			if (is_no22[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="NO<sub>2</sub>";
			}
			if (is_co22[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="CO<sub>2</sub>";
			}
			if (is_wind2[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="prędkośc wiatru";
			}
			if (is_temp2[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="temperatura";
			}
			
			document.getElementById("main").innerHTML = main;
			
			user_download_1 = setInterval(() => {user_set_data_chart_1(nr_sens)}, 60000);
			user_download_24 = setInterval(() => {user_set_data_chart_24(nr_sens)}, 60000);
			user_download_col = setInterval(() => {user_update_col(nr_sens)}, 60000);
			user_download_tech = setInterval(() => {update_tech(nr_sens)}, 60000);
		
			document.getElementById("main").style.display = "block";
			document.getElementById("sensors").style.display = "none";
			document.getElementById("gauge").style.display = "none";
			document.getElementById("charts").style.display = "none";
			document.getElementById("technicals").style.display = "none";
			document.getElementById("messages").style.display = "none";
			document.getElementById("add_sensor").style.display = "none";
			
			function open_ch(menu)
			{
				if (window.innerWidth<1000)
				{
					document.getElementById("user_data").style.width="100%";
					document.getElementById("user_menu").style.display="none";
					document.getElementById("user_data").style.display="block";
					document.getElementById("menu_span").style.display="block";	
				}
				switch(menu)
				{
					case 0: document.getElementById("main").style.display = "block";
							document.getElementById("sensors").style.display = "none";
							document.getElementById("gauge").style.display = "none";
							document.getElementById("charts").style.display = "none";
							document.getElementById("technicals").style.display = "none";
							document.getElementById("messages").style.display = "none";
							document.getElementById("add_sensor").style.display = "none";
							break;
					case 1: document.getElementById("main").style.display = "none";
							document.getElementById("sensors").style.display = "block";
							document.getElementById("gauge").style.display = "none";
							document.getElementById("charts").style.display = "none";
							document.getElementById("technicals").style.display = "none";
							document.getElementById("messages").style.display = "none";
							document.getElementById("add_sensor").style.display = "none";
							break;
					case 2: document.getElementById("main").style.display = "none";
							document.getElementById("sensors").style.display = "none";
							document.getElementById("gauge").style.display = "block";
							document.getElementById("charts").style.display = "none";
							document.getElementById("technicals").style.display = "none";
							document.getElementById("messages").style.display = "none";
							document.getElementById("add_sensor").style.display = "none";
							break;
					case 3: document.getElementById("main").style.display = "none";
							document.getElementById("sensors").style.display = "none";
							document.getElementById("gauge").style.display = "none";
							document.getElementById("charts").style.display = "block";
							document.getElementById("technicals").style.display = "none";
							document.getElementById("messages").style.display = "none";
							document.getElementById("add_sensor").style.display = "none";
							break;
					case 4: document.getElementById("main").style.display = "none";
							document.getElementById("sensors").style.display = "none";
							document.getElementById("gauge").style.display = "none";
							document.getElementById("charts").style.display = "none";
							document.getElementById("technicals").style.display = "block";
							document.getElementById("messages").style.display = "none";
							document.getElementById("add_sensor").style.display = "none";
							break;
					case 5: document.getElementById("main").style.display = "none";
							document.getElementById("sensors").style.display = "none";
							document.getElementById("gauge").style.display = "none";
							document.getElementById("charts").style.display = "none";
							document.getElementById("technicals").style.display = "none";
							document.getElementById("messages").style.display = "block";
							document.getElementById("add_sensor").style.display = "none";
							break;
					case 6: document.getElementById("main").style.display = "none";
							document.getElementById("sensors").style.display = "none";
							document.getElementById("gauge").style.display = "none";
							document.getElementById("charts").style.display = "none";
							document.getElementById("technicals").style.display = "none";
							document.getElementById("messages").style.display = "none";
							document.getElementById("add_sensor").style.display = "block";
							break;
					default:
							document.getElementById("main").style.display = "block";
							document.getElementById("sensors").style.display = "none";
							document.getElementById("gauge").style.display = "none";
							document.getElementById("charts").style.display = "none";
							document.getElementById("technicals").style.display = "none";
							document.getElementById("messages").style.display = "none";
							document.getElementById("add_sensor").style.display = "none";
				}
			}
		
			function openMen()
			{
				document.getElementById("user_data").style.display="none";
				document.getElementById("user_menu").style.display="block";
				document.getElementById("user_menu").style.width="100%";
				document.getElementById("menu_span").style.display="none";
			}
			
			function answer()
			{
				var xhttp16; 
				xhttp16 = new XMLHttpRequest();
				idmes = document.getElementById("idmes");
				ans = document.getElementById("anwser_write");
				
				if(ans.value=="")
				{
					alert("Proszę uzupełnić wszystkie pola!");
				}
				else
				{
					xhttp16.open("GET", "send_answer.php?idm="+idmes.value+"&ans="+ans.value, true);	
					xhttp16.send();
					document.getElementById("idm"+idmes.value).innerHTML=ans.value;
				}
			}
			
			function download_messages_admin()
				{ 
					var xhttp17; 
					xhttp17 = new XMLHttpRequest();
					xhttp17.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							messages_table = this.responseText;
						}
					};
						
					xhttp17.open("GET", "messages_tab_admin.php", true);	
					xhttp17.send();
				}
				
			setInterval(function()
				{
					download_messages_admin();
					setTimeout(function()
						{
							document.getElementById("messages_tab").innerHTML=messages_table;
						},250);
				},60000);
			
			function download_data_state()
			{ 
				var xhttp7; 
				xhttp7 = new XMLHttpRequest();
				xhttp7.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						download_data_state1 = this.responseText;
						download_data_state2=download_data_state1.split("|");
								
						for (i=0;i<count;i++)
						{
							download_data_state3[i] = download_data_state2[i].split("/")
							state_ids[i]	=download_data_state3[i][0];
							state_state[i]	=download_data_state3[i][1];
							state_date[i]	=download_data_state3[i][2];	
						}
					}
				};
				xhttp7.open("GET", "map_state.php", true);	
				xhttp7.send();			
			}
			
			setInterval( function()
			{
				download_data_state();
				
				setTimeout(function()
				{
					document.getElementById("measure_date").innerHTML = "Czas ostatniego pomiaru: "+state_date[nr_sens-1];
					state(nr_sens);
				},500);
			},60000);
			
			function state(nr)
			{
				document.getElementById("measure_date").innerHTML = "Czas ostatniego pomiaru: "+state_date[nr-1];
				document.getElementById("state").innerHTML = "Ocena jakości powietrza: ";
				document.getElementById("state2").innerHTML = state_state[nr-1];
				
				switch (state_state[nr_sens-1])
				{
					case "Bardzo zła":	document.getElementById("state2").style.color = color_bzl;
										break;
					case "Zła":			document.getElementById("state2").style.color = color_zl;
										break;
					case "Dostateczna":	document.getElementById("state2").style.color = color_do;
										break;
					case "Umiarkowana":	document.getElementById("state2").style.color = color_um;
										break;
					case "Dobra":		document.getElementById("state2").style.color = color_db;
										break;
					case "Bardzo dobra":document.getElementById("state2").style.color = color_bdb;
										break;
					case "Brak oceny":	document.getElementById("state2").style.color = color_nd;
										break;
					default:			document.getElementById("state2").style.color = color_nd;
				}
			}	
				
			setTimeout(function()
				{
					user_clear_vars();
					user_drawChart();
					user_drawVisualization();
					update_tech(nr_sens);
					user_set_data_col(nr_sens);
					user_set_data_chart_1(nr_sens);
					user_set_data_chart_24(nr_sens);
					state(nr_sens);
					document.getElementById("messages_tab").innerHTML=messages_table;
				},500);
		
		function user_clear_vars()
		{
			user_is_ozone=0;
			user_is_no2=0;
			user_is_co2=0;
			user_is_pm25=0;
			user_is_pm10=0;
			user_is_temp=0;
			user_is_wind=0;
		}
		
		function draw(nr_sens)
		{
			measure_param="Mierzone parametry: ";
			document.getElementById("city").innerHTML = city[nr_sens-1];
			document.getElementById("street").innerHTML = "ul. "+street[nr_sens-1];
			document.getElementById("company").innerHTML = "Właściciel czujnika: "+company[nr_sens-1];
			document.getElementsByName("setDateUser")[0].setAttribute('min', date_install[nr_sens-1]);
			document.getElementsByName("setDateUser2")[0].setAttribute('min', date_install[nr_sens-1]);
			state(nr_sens);
			if (is_pm252[nr_sens-1]==1)
			{
				measure_param+="PM<sub>2.5</sub>";
			}
			if (is_pm102[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="PM<sub>10</sub>";
			}
			if (is_ozone2[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="ozon";
			}
			if (is_no22[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="NO<sub>2</sub>";
			}
			if (is_co22[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="CO<sub>2</sub>";
			}
			if (is_wind2[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="prędkośc wiatru";
			}
			if (is_temp2[nr_sens-1]==1)
			{
				measure_param+=", ";
				measure_param+="temperatura";
			}
			
			document.getElementById("measure_param").innerHTML = measure_param;	
			document.getElementById("install_date").innerHTML = "Data instalacji: "+date_install[nr_sens-1];
			user_set_data_chart_1(nr_sens);
			user_set_data_chart_24(nr_sens);
			user_set_data_col(nr_sens);
			update_tech(nr_sens);
			clearInterval(user_download_1);
			user_download_1 = setInterval(() => {user_set_data_chart_1(nr_sens)}, 60000);
			clearInterval(user_download_24);
			user_download_24 = setInterval(() => {user_set_data_chart_24(nr_sens)}, 60000);
			clearInterval(user_download_col);
			user_download_col = setInterval(() => {user_update_col(nr_sens)}, 60000);
			clearInterval(user_download_tech);
			user_download_col = setInterval(() => {update_tech(nr_sens)}, 60000);	
		}
			
		function selected_gau (form) 
		{
			var date_selected =form.setDateUser.value;
			user_set_data_chart_24_sel(nr_sens,date_selected);
			clearInterval(user_download_24);
			user_download_24 = setInterval(() => {user_set_data_chart_24_sel(nr_sens,date_selected)}, 60000);
			if(none_user==true)
			{
				document.getElementById("label_gau_24").innerHTML = "Brak danych z tego dnia";
			}
			else
			{
				document.getElementById("label_gau_24").innerHTML = "Średnia z dnia: "+date_selected;
			}
		}
		
		function selected_col (form) 
		{
			var date_selected_col =form.setDateUser2.value;
			user_select_data_col(nr_sens,date_selected_col);
			clearInterval(user_download_col);
			if(none_user_col==true)
			{
				document.getElementById("user_none_col").innerHTML = "Brak danych z tego dnia";
			}
			else
			{
				document.getElementById("user_none_col").innerHTML = "Średnia z dnia: "+date_selected_col;
			}
		}
		
		function last_gau (form) 
		{
			var date_selected =form.setDateUser.value;
			user_set_data_chart_24(nr_sens);
			clearInterval(user_download_24);
			user_download_24 = setInterval(() => {user_set_data_chart_24(nr_sens)}, 60000);
			document.getElementById("label_gau_24").innerHTML = "Średnia z ostatnich 24 godzin";
		}
		
		function last_col (form) 
		{
			user_set_data_col(nr_sens);
			user_download_col = setInterval(() => {user_update_col(nr_sens)}, 60000);
			document.getElementById("user_none_col").innerHTML = "Średnia z ostatnich 24 godzin";
		}
		</script>
	</body>
</html>