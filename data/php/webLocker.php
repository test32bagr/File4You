<?php
	/*
	Název: Web Locker RELOADED 1.0
	Autor: Jan 'janch32' Chaloupka
	URL: www.janch32.cz
	Licence: All Rights Reserved
	*/
	
	$isMobile;
	$hash = 'SHA256';
	include 'mysqli.php';
	$mysql_request = "SELECT Heslo FROM cloud_users WHERE username='%mysqlNick%'"; 
	
	session_start();
	include 'data/php/Mobile_Detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	
	function Mobil(){
		global $detect, $isMobile;
		if($detect->isMobile() && !$detect->isTablet()) {
			$isMobile = true;
			return '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
				<link rel="stylesheet" href="data/style/login_mobil.css">'; 
		} else {
			$isMobile = false;
			return '<link rel="stylesheet" href="data/style/login.css">';
		}
	}
	
	function MobilTlacitka(){
		return '<input type="submit" id="lock_sub" name="lock_sub" value="Přihlásit se">
			<div id="spodni">
				<a href="registrace.php" title="Registrovat se">Registrovat se</a>
			</div>';
	}
	
	function checkPass($currentPass, $nick){
		global $mysqli, $mysql_request, $hash;
		$nick = $mysqli->escape_string($nick);
		$passResult = $mysqli->query(str_replace("%mysqlNick%", $nick, $mysql_request));
		if($passResult->num_rows < 1) return false;
		$heslo = $passResult->fetch_row();
		$heslo = $heslo[0];
		$currentPass = hash($hash, $currentPass);
		if($heslo == $currentPass) 
			return true; 
		else 
			return false; 
	}
	
	function showHTML($jeSpravne){
		global $version;
		if(!$jeSpravne) 
			$text = '<div id="BadLogin">
				Neexistující uživatel nebo chybné heslo!<br>
				<a href="forgetPassword.php" title="Zapoměli jste heslo">Zapoměli jste heslo?</a>
			</div>';
		else
			$text = '';
		
		echo'<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>File4You | Klient | Přístup zamítnut</title>
		<meta name="isMobile" content="'.(($isMobile) ? 'true' : 'false').'" id="isMobile">
		<script src="data/javascript/jquery.js"></script>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,latin-ext" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext" rel="stylesheet">
		'.Mobil().'
		<script>
			var isMobile = document.getElementById("isMobile").content;
		</script>
	</head>
	<body>
		<header>
			<h1>File4You | Přístup je chráněn heslem</h1>
		</header>
		<form method="POST">
			Nick: <input type="text" name="lock_nick" id="lock_nick" maxlength="40">
			Heslo: <input type="password" name="lock_pass" id="lock_pass">
			'.MobilTlacitka().'<br>
			'.$text.'
			<script>
				/*$("#lock_nick").on("input", function(){
					alert(isMobile);
					if(isMobile == "false"){
						var nick = "("+$("#lock_nick").val()+")";
						if(nick == "()") 
							$("#lock_sub").val("Přihlásit se"); 
						else
							$("#lock_sub").val("Přihlásit se " + nick);
					}
				});*/
			</script>
		</form>
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
		if(@$_GET['odhlasit'] == true || !checkPass($exploded[0], $exploded[1])){
			showHTML(true);
			unset($_SESSION['allow']);
			header("Location: index.php");
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
