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
	<title>Logowanie</title>
	<link rel="Stylesheet" type="text/css" href="logstyle.css" />
</head>
<body>

<div id="logowanie">

	<H2>Podaj dane logowania</H2>
	
	<form method="post" id="log">
	
	<div id="nazwy">
	
		Nazwa użytkownika: 
		</br></br></br>
		Hasło: 
	</div>
		
		<div id="pola">
		<input type="text" 	name="username" maxlength="20" size="30" /> 
		</br></br></br>
		<input type="password" name="password" maxlength="20" size="30" /> 
		</div>
		
		
		
		          
		
		
		<br />
		
		<input type="submit" id="przycisk" value="Zaloguj" />
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
 
 




</body>
</html>