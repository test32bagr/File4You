<?php
	/*
	Název: Web Locker RELOADED 1.0
	Autor: Jan 'janch32' Chaloupka
	URL: www.janch32.cz
	Licence: All Rights Reserved
	*/
	
	$hash = 'SHA256';
	include 'mysqli.php';
	$mysql_request = "SELECT Heslo FROM cloud_users WHERE username='%mysqlNick%'"; 
	
	session_start();
	$version = "1.00";
	include 'data/php/Mobile_Detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	
	function Mobil(){
		global $detect;
		if($detect->isMobile() && !$detect->isTablet()) 
			return '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
				<link rel="stylesheet" href="data/style/login_mobil.css">'; 
		else 
			return '<link rel="stylesheet" href="data/style/login.css">';
	}
	
	function MobilTlacitka(){
		global $detect;
		if($detect->isMobile() && !$detect->isTablet())
			return '<input id="submit" type="submit" name="lock_sub" value="Přihlásit se"><br><div id="reg"><a href="registrace.php">Registrovat se</a></div>'; 
		else 
			return '<a href="registrace.php">Registrovat se</a><input id="submit" type="submit" name="lock_sub" value="Přihlásit se"><br>';
		
	}
	
	function checkPass($currentPass, $nick){
		global $mysqli, $mysql_request, $hash;
		$nick = $mysqli->escape_string($nick);
		$passResult = $mysqli->query(str_replace("%mysqlNick%", $nick, $mysql_request));
		if($passResult->num_rows < 1) return false;
		$heslo = $passResult->fetch_row();
		$heslo = $heslo[0];
		$currentPass = hash($hash, $currentPass);
		if($heslo == $currentPass) return true; else return false; 
	}
	
	function showHTML($jeSpravne){
		global $version;
		$text = '';
		if(!$jeSpravne) $text = '<br><div style="color: red; font: 25px \'Open Sans Condensed\', sans-serif; text-align: center;">Heslo nebo jméno je chybné!<br><a href="forgetPassword.php" title="Zapoměli jste heslo">Zapoměli jste heslo?</a></div>';
		
		echo'
		<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Přihlášení | File4You</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,latin-ext" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext" rel="stylesheet">
		'.Mobil().'
	</head>
	<body>
		<div id="hlavicka"><h2>File4you | Přístup zabezpečen</h2></div>
		<div id="powered">Powered by WebLocker '.$version.'</div>
		<form method="POST">
			<input type="text" placeholder="Jméno" name="lock_nick"><br>
			<input type="password" placeholder="Heslo" name="lock_pass"><br>
			'.MobilTlacitka().'
			'.$text.'
		</form>
		<div style="display: none;"><endora></div>
	</body>
</html>
		';
	}
	
	function getNick(){
		$exploded = explode("%space%", $_SESSION['allow']);
		return $exploded[1];
	}
	if(!empty($_SESSION['allow'])){
		$exploded = explode("%space%", $_SESSION['allow']);
		if(@$_GET['odhlasit'] == true){
			showHTML(true);
			unset($_SESSION['allow']);
			exit;
		}elseif(!(checkPass($exploded[0],$exploded[1]))){
			showHTML(true);
			unset($_SESSION['allow']);
			exit;
		}
	} else {
		if(empty($_POST['lock_sub'])){
			showHTML(true);
			exit;
		} else {
			if(checkPass($_POST['lock_pass'], $_POST['lock_nick'])){ 
				$_SESSION['allow'] = $_POST['lock_pass']."%space%".$_POST['lock_nick']; 
				session_regenerate_id(true); 
			} else {
				showHTML(false);
				exit;
			}
		}
	}
?>
