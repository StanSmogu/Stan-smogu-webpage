<?php require_once "session_check.php"; ?>
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



	<header>
	
		<h1  id="logo"> <a  class="link" href="admin.php">SMOG</a></h1>
		
		<nav id="topnav">
		
			<ul class="menu">
				<li><a href="admin.php?id=stronaglowna">Strona główna</a></li>
				<li><a href="http://macbie005.nazwa.pl/Projekt/index.php">Główne menu</a></li>
				<li><a href="admin.php?id=wykresy">Wykresy</a></li>
				<li><a href="admin.php?id=wyniki">Wyniki</a></li>
				
				<li><a href="admin.php?id=wiadomosci_a">Wiadomości</a></li>
				<li><a href="admin.php?id=opcje">Opcje</a></li>
				<li><a href="admin.php?id=logi_goscie">Logi gości</a></li>
				<li><a href="admin.php?id=logi_users">Logi użytkowników</a></li>
				<li><a href="logout.php">Wyloguj</a></li>
			</ul>
			
		</nav>
			<?php
			if (isset($_GET['id'])) 
			{ 
				include ($_GET['id'].'.php');
			} 
			else 
			{ 
				include ('stronaglowna.php'); 
			}
		?>
	
			
	</header>
	
	<article>
	
		<br>
  
	</article>
	
	<footer>
		
		Maciej Bieliński &reg; sp. z o. o.  2019 
		
	</footer>

</body>
</html>