<?php
	$mysqli_ip = 'localhost';
	$mysqli_user = '';
	$mysqli_pass = '';
	$mysqli_db = '';
	
	$mysqli = new Mysqli($mysqli_ip, $mysqli_user, $mysqli_pass, $mysqli_db);
	
	if(!$mysqli->connect_error){
		$mysqli->set_charset("utf8");
	} else {
		die("<!DOCTYPE html>
			<html>
				<head>
					<meta charset=\"utf-8\">
					<title>Chyba webu | Misha12</title>
					<link href=\"http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext\" rel=\"stylesheet\">
					<style>
						html, body{
							background: Wihtesmoke;
							margin: 0px;
						}
						header{
							margin: 0px;
							margin-left: auto;
							margin-right: auto;
							width: 80vw;
							text-align: center;
						}
						header h1{
							margin: 0px;
							font-weight: 100;
							font-family: 'Roboto', sans-serif;
						}
						section{
							margin-left: auto;
							margin-right: auto;
							width: 80vw;
						}
						#page{ border-bottom: 1px solid; }
						#error{ padding-bottom: 5px; }
					</style>
				</head>
				<body>
					<header><h1>Chyba připojení do MySQL</h1></header>
					<section>
						<div id=\"page\">
							<p>Byly detekovány problémy s připojením do MySQL databáze.</p>
							<p>Pro chod tohoto webu je nutná funkčnost MySQL serveru.</p>
							<p>Pokud se vám zobrazila tato stránka, tak kontaktujte administrátora stránek. <a href=\"mailto: m.halabica@gmail.com\" title=\"Misha12 | Mail\">m.halabica@gmail.com</a></p>
							<div id=\"error\">(".$mysqli->connect_errno.") ".$mysqli->connect_error."</div>
						</div>
					</section>
				</body>
			</html>
		");
	}
?>