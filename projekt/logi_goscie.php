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
				<h1 class="tytul"> Wejścia i ich lokalizacja przez gości portalu </h1>	
			</header>
				<div id="content">
					<?php
						require_once "connect.php";
						print"<div id='wiadomosci'>";
						$result_1 = mysqli_query ($connection, "SELECT  DISTINCT ip FROM logi_goscie GROUP by ip ORDER BY COUNT(*) DESC") 
										or die ("3SQL query error: $db_name");
						print "Goscie portalu <br />";
						print "<TABLE class='wiadomosci' >";
						print "<TR><TD>IP</TD><TD>DATA WEJSCIA</TD><TD>REGION</TD><TD>PANSTWO</TD><TD>MIASTO</TD><TD>LOKALIZACJA</TD><TD>PRZEGLADARKA</TD><TD>SYSTEM</TD><TD>WEJSCIA</TD></TR>\n";
						while ($db_raw = mysqli_fetch_array ($result_1)) 
						{	
							$ip 		= $db_raw[0];
							$result_2 = mysqli_query ($connection, "SELECT  * FROM logi_goscie WHERE ip='$ip' ORDER BY data_ost ASC") 
										or die ("3SQL query error: $db_name");
							while ($db_raw = mysqli_fetch_array ($result_2)) 
							{
								$idlg			= $db_raw[0];
								$data_ost		= $db_raw[1];
								$region		 	= $db_raw[3];
								$panstwo		= $db_raw[4];
								$miasto			= $db_raw[5];
								$lokalizacja 	= $db_raw[6];
								$przegladarka 	= $db_raw[7];
								$system 		= $db_raw[8];
								$rozdzielczosc 	= $db_raw[9];
							}
							$result2 = mysqli_query ($connection, "SELECT ip FROM logi_goscie WHERE ip='$ip' ") 
										or die ("2SQL query error: $db_name");
							$wejscia1 = mysqli_num_rows ($result2);
							print  "<TR><TD>$ip</TD><TD>$data_ost</TD><TD>$region</TD><TD>$panstwo</TD><TD>$miasto</TD><TD>$lokalizacja</TD><TD>$przegladarka</TD><TD>$system</TD><TD>$wejscia1</TD></TR>\n";
						}
						print "</TABLE>";		
						print"</div>";			
					?>		
				</div>	
		</article>
	</body>
</html>