<?php
	session_start();
	function retError($error){ return '<span style="color: Red;">'.$error.'</span>'; }

	$mysqli = new Mysqli('localhost', 'c2cloud', 'passwd', 'c2mycloud');
	$headers = '';
	$logFile = fopen("data/log.txt", "a+");
	include 'data/php/delDiacritic.php';
	include 'data/php/Mobile_Detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;

	function Mobil(){
		global $detect;
		if($detect->isMobile() && !$detect->isTablet()) 
			return '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
				<link rel="stylesheet" href="data/style/register_mobil.css">'; 
		else 
			return '<link rel="stylesheet" href="data/style/registrace.css">';
	}
	
	function Buttons(){
		global $detect;
		if($detect->isMobile() && !$detect->isTablet()) 
			return '<tr>
				<td align="center" colspan="2">
					<input type="submit" name="sendRequest" value="Zaregistrovat se">
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<a href="index.php" title="Zpět na přihlášení">Zpět na přihlášení</a>
				</td>
			</tr>';
		else 
			return '<tr><td align="left"><a href="index.php" title="Zpět na přihlášení">Zpět na přihlášení</a></td><td align="right"><input type="submit" name="sendRequest" value="Zaregistrovat se"></td></tr>';
	}
	
	if(isset($_POST['sendRequest'])){
		if(isset($_POST['nick']) && isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['age']) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['pass_two'])){
			if(isset($_POST['textCaptcha'])){
				if($_SESSION['code'] == $_POST['textCaptcha']){
					$Surname = $mysqli->escape_string(remove_accents($_POST['surname']));
					if($mysqli->query("SELECT * FROM cloud_reg_allow WHERE Surname='$Surname'")->num_rows > 0){
						$Age = (int)floor($_POST['age']);
						if($Age >= 15){
							if(strlen($_POST['pass']) >= 6){
								$pass = $mysqli->escape_string(hash("sha256", $_POST['pass']));
								$pass2 = $mysqli->escape_string(hash("sha256", $_POST['pass_two']));
								if($pass == $pass2){
									$nick = $mysqli->escape_string($_POST['nick']);
									if($mysqli->query("SELECT * FROM cloud_users WHERE username='$nick'")->num_rows == 0){
										$Name = $mysqli->escape_string(remove_accents($_POST['name']));
										$mail = $mysqli->escape_string($_POST['mail']);
										$IPreg = $mysqli->escape_string($_SERVER['REMOTE_ADDR']);
										$mysqli->query("INSERT INTO cloud_users VALUES('$Name', '$Surname', '$nick', '$mail', '$pass', '$IPreg', '$Age', 'false')");
										$text = '<span style="color: Green">Byl jsi úspěšně registrován.</p>';
										fwrite($logFile, StrFTime("%d/%m/%Y %H:%M:%S", Time()).' Byl registrován nový uživatel s uživatelským jménem: '.$nick.'<br>');
										$headers .= 'Content-type: text/html; charset=utf-8'."\r\n"."From: 5130c2@seznam.cz";
										Mail($mail, "File4You - Registrace", "Byl\a jsi úspěšně registrován na File4You.<br><br>Tvoje zadané údaje:<br>Uživatelské Jméno: ".$nick."<br>Jméno a přijmení: ".$Name." ".$Surname."<br>Věk: ".$Age." let.", $headers);
									} else { $text = retError('Uživetel s tímto uživatelským jménem již existuje.'); }
								} else { $text = retError('Zadaná hesla nejsou stejná.'); }
							} else { $text = retError('Heslo musí mít minimálně 6 znaků.'); }
						} else { $text = retError('Nesplňuješ podmíniky: Minimální věk --> 15 let.'); }
					} else { $text = retError('Nejsi v seznamu povolených uživatelů.'); }
				} else { $text = retError('Obrázkové heslo je chybné.'); }
			} else { $text = retError('Nebylo vyplněno obrázkové heslo.'); }
		} else { $text = retError('Nebyly vyplněny všechny pole.'); }
	} else { $text = 'Pro registraci vyplňtě prosím údaje.'; }
	
	echo '
		<!DOCTYPE html>
		<html>
			<head>
				<title>File4you | Registrace</title>
				<meta charset="utf-8">
				<link href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext" rel="stylesheet">
				'.Mobil().'
			</head>
			<body>
				<form method="POST">
					<h2>File4you | Registrace</h2>
					<p id="RegText">'.$text.'</p>
					<table>
						<tr><td>Uživatelské jméno: </td><td><input type="text" name="nick" tabindex="1"></td></tr>
						<tr><td>Jméno: </td><td><input type="text" name="name" tabindex="2"></td></tr>
						<tr><td>Přijmení: </td><td><input type="text" name="surname" tabindex="3"></td></tr>
						<tr><td>Věk: </td><td><input type="number" name="age" min="1" tabindex="4"></td></tr>
						<tr><td>E-Mail</td><td><input type="email" name="mail" tabindex="5"></td></tr>
						<tr><td>Heslo: </td><td><input type="password" name="pass" tabindex="6"></td></tr>
						<tr><td>Heslo znovu: </td><td><input type="password" name="pass_two" tabindex="7"></td></tr>
						<tr><td>Captcha: </td><td><img src="data/php/captcha.php" alt="Captcha"><br><input type="text" name="textCaptcha"></td></tr>
						'.Buttons().'
					</table>
				</form>
				<div id="endora"><endora></div>
			</body>
		</html>
	';
	exit;
?>
