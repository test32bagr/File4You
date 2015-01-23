<?php
	session_start();
	function retError($error){ return '<span style="color: Red;">'.$error.'</span>'; }
	function logFormat($string){ return StrFTime("%d.%m.%Y %H:%M:%S", Time()).' |--> '.$string.'<br>'; }
	include 'data/php/Mobile_Detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;

	if($detect->isMobile() && !$detect->isTablet())
		$Mobil = '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
			<link rel="stylesheet" href="data/style/zapomenuteHeslo_mobil.css">';
	else 
		$Mobil = '<link rel="stylesheet" href="data/style/zapomenuteHeslo.css">';
	
	include 'data/php/mysqli.php';
	$logFile = fopen("log.txt", "a+");
	include 'data/php/delDiacritic.php';
	
	if(isset($_POST['sendRequest'])){
		if(!empty($_POST['Nick'])){
			if(!empty($_POST['textCaptcha']) && $_SESSION['code'] == $_POST['textCaptcha']){
				$Nick = $mysqli->escape_string($_POST['Nick']);
				if($mysqli->query("SELECT * FROM cloud_users WHERE username='$Nick'")->num_rows == 1){
					$oldPass = $mysqli->query("SELECT Heslo FROM cloud_users WHERE username='$Nick'")->fetch_row();
					$newPass = substr($oldPass[0], rand(0, 20), 10);
					$newPassHash = hash('sha256', $newPass);
					$mysqli->query("UPDATE cloud_users SET Heslo='$newPassHash' WHERE username='$Nick'");
					$text = '<tr>
						<td>Nové heslo: </td>
						<td>'.$newPass.'</td>
					</tr>';
					fwrite($logFile, logFormat("Bylo resetováno heslo pro uživatele ".$Nick));
				} else { $text = '<tr align="center"><td colspan="2">'.retError('Zadaný uživatel neexistuje.').'</td></tr>'; }
			} else { $text = '<tr align="center"><td colspan="2">'.retError('Obrázkové heslo nebylo správně zadané.').'</td></tr>'; }
		} else { $text = '<tr align="center"><td colspan="2">'.retError('Nebyl vložen nick.').'</td></tr>'; }
	} else { $text = ''; }
	
	echo '<!DOCTYPE html>
		<html>
			<head>
				<title>File4you | Registrace</title>
				<meta charset="utf-8">
				<link href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext" rel="stylesheet">
				<script src="data/javascript/jquery.js"></script>
				<script src="data/javascript/core.js"></script>
				<script src="data/javascript/HAO.js"></script>
				'.$Mobil.'
			</head>
			<body>
				<form method="POST">
					<h2>File4you | Zapomenuté heslo</h2>
					<table>
						<tr>
							<td>Uživatelské jméno: </td>
							<td><input type="text" name="Nick"></td>
						</tr>
						<tr>
							<td>Captcha: </td>
							<td><img src="data/php/captcha.php" alt="Captcha"><br><input type="text" name="textCaptcha"></td>
						</tr>
						'.$text.'
						<tr><td align="left"><a href="index.php" title="Zpět na přihlášení">Zpět na přihlášení</a></td><td align="right"><input type="submit" name="sendRequest" value="Obnovit heslo"></td></tr>
					</table>
				</form>
			</body>
		</html>
	';
?>
