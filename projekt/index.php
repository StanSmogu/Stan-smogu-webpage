<!DOCTYPE html> 
<html lang="pl">
	<head>
		<title>Mapa smogowa</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="css/fontello.css" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Lato|Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="Stylesheet" type="text/css" href="style.css" />
	</head>
	<body>

		<div class='containter'>
			<a href='oczujniku.php' class="link"><div class='romb' id='romb1' ><h1>O czujnikach</h1></div></a>
			<a href='osmogu.php' class="link"><div class='romb' id='romb2'><h1>O smogu</h1></div></a>
			<a href='mapa.php' class="link"><div class='romb' id='romb3'><h1>Mapa</h1></div></a>
			<a href='kontakt.php' class="link"><div class='romb' id='romb4'><h1>Kontakt</h1></div></a>
			<a href='logowanie2.php' class="link"><div class='romb' id='romb5'><h1>Logowanie</h1></div></a>
		</div>

		<?php
			require_once "connect.php";		
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			
			function ip_details($ip) 
			{	
				$TOKEN="1de797de1190de";
				$json = file_get_contents ("http://ipinfo.io/{$ip}/geo?token=$TOKEN");
				$details = json_decode ($json);
				return $details;	
			}
			
			$details = ip_details($ipaddress);
			$region= $details -> region;
			$country= $details -> country; 
			$city= $details -> city;
			$loc= $details -> loc;
			$ip= $details -> ip;

			require_once "_lib_useragentparser.php";
			$ua_info = parse_user_agent($HTTP_USER_AGENT);
			array('platform' => '[Detected Platform]','browser' => '[Detected Browser]','version' => '[Detected Browser Version]');
			$przegladarka = $ua_info['browser']." ".$ua_info['version'];
			$system = $ua_info['platform'];
			
			$sql = mysqli_query ($connection, "INSERT INTO logi_goscie 
			(ip,region,panstwo,miasto,lokalizacja,przegladarka,system_operacyjny,rozdzielczosc ) 
			VALUES ('$ip','$region','$country','$city','$loc','$przegladarka','$system','$rodzielczosc') ") 
					or die ("1SQL query error: $db_name");		

		?>
	</body>
</html>
