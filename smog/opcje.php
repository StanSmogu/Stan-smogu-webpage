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
		<article>	
			<header>	
				<h1 class="tytul"> Witamy w panelu sterowania! </h1>	
			</header>
			<div id="content">
				Czy pomiary z czujnika mają być widoczne na mapie?
				</br>	
				<form method="post" action="aktualizuj.php">
					<select name="opcja">
						<option value="1">Tak</option>
						<option value="0">Nie</option>
					</select> 
					<input type="submit" value="Ustaw">
				</form> 
			</div>		
		</article>
	</body>
</html>