<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Zalogowano</title>
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
	
	<link rel="stylesheet" type="text/css" href="style2.css" title="standardowy" />
	
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>
	<script>
function myFunction(komunikat) {
  alert(komunikat);
}
</script>
<?php
require_once "connect.php"; 
	$wiadomosc="Brak niepoprawnych logowań!";

	$login = $_SESSION ['login'];
		$result_2 = mysqli_query ($connection, "SELECT * FROM logi_users WHERE user='$login' AND czy_poprawne='Nie' ORDER by data_ost ASC;") 
				or die ("SQL query error: $db_name");

	while ($db_raw2 = mysqli_fetch_array ($result_2)) 
	{
		$data_ost = $db_raw2[1];
		$ip = $db_raw2[2];
		$region = $db_raw2[3];
		$panstwo = $db_raw2[4];
		$miasto = $db_raw2[5];
		$lokalizacja = $db_raw2[6];
		$przegladarka = $db_raw2[7];
		$system = $db_raw2[8];
		$rozdzielczosc = $db_raw2[9];
		$user = $db_raw2[10];
		$haslo = $db_raw2[11];
		$czy_poprawne = $db_raw2[12];
		$wiadomosc="Ostatnie niepoprawne logowanie było ".$data_ost." w okolicy ".$miasto." ".$region." ".$panstwo." z numeru IP ".$ip." Wpisane hasło to: ".$haslo;
	}
	
	

	
	
		echo "<script>myFunction('$wiadomosc')</script>";
	
	//echo $wiadomosc;
		?>

		<article>
				
			<header>	
				
				<h1 class="tytul"> Witamy w panelu sterowania! </h1>
					
			</header>
			
				<div id="content">


				Witamy w panelu sterowania państwa czujnikiem!</br>
				Aby poznać szczegółowe wyniki zmierzone przez czujnik smogu - proszę wybrać jedną z powyższych kart.</br>
				W karcie Wykresy znajdziecie państwo cztery wykresy słupkowe- wykres danych z ostatniej godziny oraz z ostatnich 24 godzin osobno dla pyłów PM10 oraz PM25.</br>
				W karcie Wyniki znajdziecie państwo uśrdnione wyniki z godziny i 24 godzin umieszczone w tabeli, wraz z najnowszym odczytanym wynikiem.</br>
				W karcie Wiadomości mają Państwo możliwość kontaktu z administratorem strony.</br>
				W karcie Opcje macie państwo możliwośc wyłączenia widoczności czujnika na mapie.</br>
				W karcie Powrót do menu jest możliwość powrotu do głównego menu na głównej stronie, skąd można przejść do każdej z zakładek tam istniejących.</br>
				Liczymy na przyjemne wrażenia z kożystania państwa z naszej strony.</br>
				
				</br></br>
				~Administrator

			
					
					
			
			
					
				</div>
					
					
					
		</article>
	
</body>
</html>