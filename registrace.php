<?php
	session_start();
	function retError($error){ return '<span style="color: Red;">'.$error.'</span>'; }

	include 'data/php/mysqli.php';
	$headers = '';
	$logFile = fopen("log.txt", "a+");
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
			return '<tr><td align="center" colspan="2"><input type="submit" name="sendRequest" value="Zaregistrovat se"></td></tr>
			<tr><td align="center" colspan="2"><a href="index.php" title="Zpět na přihlášení">Zpět na přihlášení</a></td></tr>';
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
									$nick = $mysqli->escape_string(remove_accents($_POST['nick']));
									if($mysqli->query("SELECT * FROM cloud_users WHERE username='$nick'")->num_rows == 0){
										///////////////////////////////////
										//Barvy
										///////////////////////////////////
										$colors = Array('#da70d6', '#c71585', '#ff1493', '#ff69b4', '#fff0f5', '#db7093', '#dc143c', '#ffc0cb', '#ffb6c1', '#fffafa', '#f08080', '#bc8f8f', '#cd5c5c','#ff0000', '#b22222', '#a52a2a', '#8b0000', '#800000', '#ffe4e1', '#fa8072','#ff6347', '#e9967a', '#ff7f50', '#ff4500', '#ffa07a', '#a0522d', '#fff5ee', '#d2691e', '#8b4513', '#f4a460', '#ffdab9', '#cd853f', '#faf0e6', '#ffe4c4', '#ff8c00', '#deb887', '#faebd7', '#d2b48c', '#ffdead', '#ffebcd', '#ffefd5', '#ffe4b5', '#ffa500', '#f5deb3', '#fdf5e6', '#fffaf0', '#b8860b', '#daa520', '#fff8dc', '#ffd700', '#fffacd', '#f0e68c', '#eee8aa',  '#bdb76b', '#fffff0', '#ffffe0', '#f5f5dc', '#fafad2', '#ffff00', '#808000', '#6b8e23', '#9acd32', '#556b2f', '#adff2f', '#7fff00', '#7cfc00',  '#8fbc8b', '#f0fff0', '#98fb98', '#90ee90', '#32cd32', '#00ff00', '#228b22', '#008000', '#006400', '#2e8b57', '#3cb371', '#00fa9a', '#66cdaa',  '#7fffd4', '#40e0d0', '#20b2aa', '#48d1cc', '#afeeee', '#00ffff', '#008b8b', '#008080', '#2f4f4f', '#00ced1', '#5f9ea0', '#b0e0e6', '#add8e6',  '#00bfff', '#87ceeb', '#87cefa', '#4682b4', '#f0f8ff', '#1e90ff', '#778899', '#708090', '#b0c4de', '#4169e1', '#151b8d', '#f8f8ff', '#e6e6fa', '#0000ff', '#0000cd', '#00008b', '#191970', '#000080', '#6a5acd', '#483d8b', '#7b68ee', '#9370db', '#8a2be2', '#4b0082', '#9932cc', '#9400d3', '#ba55d3', '#d8bfd8', '#dda0dd', '#ee82ee', '#ff00ff', '#8b008b', '#800080', '#fff', '#f5f5f5', '#dcdcdc', '#d3d3d3', '#c0c0c0', '#a9a9a9', '#808080', '#696969', '#000');
										$Name = $mysqli->escape_string(remove_accents($_POST['name']));
										$mail = $mysqli->escape_string($_POST['mail']);
										$IPreg = $mysqli->escape_string($_SERVER['REMOTE_ADDR']);
										$mysqli->query("INSERT INTO cloud_users VALUES('$Name', '$Surname', '$nick', '$mail', '$pass', '$IPreg', '$Age', 'false', '".$colors[mt_rand(0, count($colors))]."')");
										$text = '<span style="color: Green">Byl jsi úspěšně registrován.</p>';
										fwrite($logFile, StrFTime("%d/%m/%Y %H:%M:%S", Time()).' |--> Byl registrován nový uživatel s uživatelským jménem: '.$nick.'<br>');
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
				<script src="data/javascript/jquery.js"></script>
				<script src="data/javascript/core.js"></script>
				<script src="data/javascript/HAO.js"></script>
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
			</body>
		</html>
	';
	exit;
?>
