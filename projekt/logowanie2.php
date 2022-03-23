<?php
	session_start();
	if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true))
	{
		echo "<script>window.location.href='zalogowany.php';</script>";
		exit();
	} 
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="Stylesheet" type="text/css" href="logstyle2.css" />
	</head>
	<body>
		<div id="glowna2">
			<a class="glowna" href="index.php">Strona główna</a>
		</div>
		<h2>Podaj dane logowania</h2>

		<div class="container">
			<form  method="post">
				<div class="row">
					<div class="col-25">
						<label for="fname">Login: </label>
					</div>
					<div class="col-75">
						<input type="text" id="fname" name="username" placeholder="Login...">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="lname">Hasło: </label>
					</div>
					<div class="col-75">
						<input type="password" id="lname" name="password" placeholder="Hasło...">
					</div>
				</div>
				<div class="row">
					<input type="submit" value="Zaloguj" name="logowanie">
				</div>
			</form>
		</div>
		<?php
			if (isset($_REQUEST['logowanie']))
			{
				if ((isset($_POST ['username'])) && (isset($_POST ['password'])))
				{
					session_start();
					$login = $_POST ['username']; 
					$haslo = $_POST ['password']; 
					require_once "connect.php"; 									
		
					$result_1 = mysqli_query($connection, "SELECT * FROM users WHERE login='$login'")
									or die ("SQL query error1: $db_name");
					$db_raw = mysqli_fetch_array($result_1); 
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
			
					if(!$db_raw) 														
					{
						echo "Invalid username or password!!!"; 
					}
					else
					{ 
						if($db_raw['login']=='admin') 
						{	
							if($db_raw['password']==$haslo) 
							{
								$_SESSION ['loggedin'] = true;
								$_SESSION ['login']  = $db_raw ['login'];
								unset ($_SESSION ['error']);

								//$sql = mysqli_query ($connection, "INSERT INTO logi_users (ip,region,panstwo,miasto,lokalizacja,przegladarka,system_operacyjny,,user,haslo,czy_poprawne ) VALUES //('$ip','$region','$country','$city','$loc','$przegladarka','$system','$login','$haslo','Tak') ") 
								//				or die ("2SQL query error: $db_name");
								echo "<script>window.location.href='admin.php';</script>";
							}
							else
							{
								$sql = mysqli_query ($connection, "INSERT INTO logi_users (ip,region,panstwo,miasto,lokalizacja,przegladarka,system_operacyjny,user,haslo,czy_poprawne ) VALUES ('$ip','$region','$country','$city','$loc','$przegladarka','$system','$login','$haslo','Nie') ") 
											or die ("2SQL query error: $db_name");
								echo "Nieladnie adminie";
							}
						}
						else
						{
							if($db_raw['password']==$haslo) 
							{	
								$_SESSION ['loggedin'] = true;
								$_SESSION ['login']  = $db_raw ['login'];
								unset ($_SESSION ['error']);
								$sql = mysqli_query ($connection, "INSERT INTO logi_users (ip,region,panstwo,miasto,lokalizacja,przegladarka,system_operacyjny,rozdzielczosc,user,haslo,czy_poprawne ) VALUES ('$ip','$region','$country','$city','$loc','$przegladarka','$system','$rodzielczosc','$login','$haslo','Tak') ") 
												or die ("3SQL query error: $db_name");
								echo "<script>window.location.href='zalogowany.php';</script>";
							}
							else
							{
					
								$sql = mysqli_query ($connection, "INSERT INTO logi_users (ip,region,panstwo,miasto,lokalizacja,przegladarka,system_operacyjny,rozdzielczosc,user,haslo,czy_poprawne ) VALUES ('$ip','$region','$country','$city','$loc','$przegladarka','$system','$rodzielczosc','$login','$haslo','Nie') ") 
												or die ("3SQL query error: $db_name");	
								echo "Invalid username or password.";  
							}
						}
					}
					mysqli_close($connection);
				}
			}
		?>
	</body>
</html>
