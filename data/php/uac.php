<?php
	function notChange(){ return 'Nebyla provedena změna.'; }
	function retError($string){ return '<span style="color: Red">'.$string.'</span>'; }
	function returnGood($string){ return '<span style="color: Green">'.$string.'</span>'; }
	function logFormat($string){ return StrFTime("%d.%m.%Y %H:%M:%S", Time()).' '.$string.'<br>'; }
	
	if(isset($_POST['ApplyChanges_setAdmin'])){
		if(isset($_POST['setAdmin_nick'])){
			$nick = $mysqli->escape_string(remove_accents($_POST['setAdmin_nick']));
			if($_POST['setAdmin_whatSet'] == 'Ano'){
				$mysqli->query("UPDATE cloud_users SET isAdmin='true' WHERE username='$nick'");
				fwrite($logFile, logFormat('Uživatel '.$nick.' je nyní administrátor.'));
				$setAdminVysledek = returnGood('Uživatel '.$nick.' je nyní administrátor.');
			} elseif($_POST['setAdmin_whatSet'] == 'Ne'){
				$mysqli->query("UPDATE cloud_users SET isAdmin='false' WHERE username='$nick'");
				fwrite($logFile, logFormat('Uživatel '.$nick.' nyní není administrátor.'));
				$setAdminVysledek = returnGood('Uživatel '.$nick.' nyní není administrátor.');
			}
		} else { $setAdminVysledek = retError('Nevyplnil jsi nick.'); }
	} else { $setAdminVysledek = notChange(); }
	
	if(isset($_POST['ApplyChanges_deleteAccount'])){
	 	if(isset($_POST['deleteAccount_Nick'])){
			$nick = $mysqli->escape_string(remove_accents($_POST['deleteAccount_Nick']));
			$isExists = (int)$mysqli->query("SELECT * FROM cloud_users WHERE username='$nick'")->num_rows;
			if($isExists == 1){
				$mysqli->query("DELETE FROM cloud_users WHERE username='$nick'");
				fwrite($logFile, logFormat('Byl smazán účet: '.$nick));
				$deleteAccountVysledek = returnGood('Účet byl smazán.');
			} elseif($isExists < 1){ $deleteAccountVysledek = 'Účet neexistuje'; }
		} else { $deleteAccountVysledek = retError('Nevyplnil jsi nick.'); }
	} else { $deleteAccountVysledek = notChange(); }
	
	if(isset($_POST['ApplyChanges_deleteFile'])){
		if(isset($_POST['deleteFileNick'])){
			$nick = $mysqli->escape_string(remove_accents($_POST['deleteFileNick']));
			if($mysqli->query("SELECT * FROM cloud_files WHERE name='$nick'")->num_rows == 1){
				$fileNameTypeRequest = $mysqli->query("SELECT filename, filetype FROM cloud_files WHERE name='$nick'")->fetch_assoc();
				$mysqli->query("DELETE FROM cloud_files WHERE name='$nick'");				
				unlink('./soubory/'.$fileNameTypeRequest['filename'].'.'.$fileNameTypeRequest['filetype']);
				fwrite($logFile, logFormat('Byl smazán soubor: '.$nick));
				$deleteFileVysledek = returnGood('Soubor byl smazán.');
			} else { $deleteFileVysledek = retError('Soubor s tímto nickem neexistuje.'); }
		} else { $deleteFileVysledek = retError('Nevyplnil jsi nick.'); }
	} else { $deleteFileVysledek = notChange(); }
	
	if(isset($_POST['ApplyChanges_zmenitNick'])){
		if(isset($_POST['editNickNewNick'])){
			$newNick = $mysqli->escape_string(remove_accents($_POST['editNickNewNick']));
			if($newNick != getNick()){
				if($mysqli->query("SELECT username FROM cloud_users WHERE username='$newNick'")->num_rows == 0){
					fwrite($logFile, logFormat('Byl změněn nick z: '.getNick().' na '.$newNick));
					$mysqli->query("UPDATE cloud_users SET username='$newNick' WHERE username='".getNick()."'");
					header("Location: ".$_SERVER['PHP_SELF']);
				} else { $zmenitNickVysledek = retError('Uživatel s tímto nickem již existuje.'); }
			} else { $zmenitNickVysledek = retError('Nový nick se nesmí shodovat se starým.'); }
		} else { $zmenitNickVysledek = retError('Nebyl vyplněn nový nick.'); }
	} else { $zmenitNickVysledek = notChange(); }
	
	if(isset($_POST['ApplyChanges_zmenitHeslo'])){
		if(isset($_POST['editPassOldPass']) && isset($_POST['editPassNewPass'])){
			$oldPass = hash('SHA256', $mysqli->escape_string(remove_accents($_POST['editPassOldPass'])));
			$oldPassDB = $mysqli->query("SELECT Heslo FROM cloud_users WHERE username='".getNick()."'")->fetch_row();
			if($oldPass == $oldPassDB[0]){
				$newPass = hash('SHA256', $mysqli->escape_string(remove_accents($_POST['editPassNewPass'])));
				if($oldPass != $newPass){
					$mysqli->query("UPDATE cloud_users SET Heslo='$newPass' WHERE username='".getNick()."'");
					fwrite($logFile, logFormat('Uživatel '.getNick().' změnil své heslo.'));
					header("Location: ".$_SERVER['PHP_SELF']);
				} else { $zmenitHesloVysledek = retError('Nové heslo nesmí být stejné jako staré.'); }
			} else { $zmenitHesloVysledek = retError('Staré heslo neodpovídá zadanému starému heslu.'); }
		} else { $zmenitHesloVysledek = retError('Nebyly vyplněny všechna pole.'); }
	} else { $zmenitHesloVysledek = notChange(); }
	
	if(isset($_POST['ApplyChanges_zmenitMail'])){
		if(isset($_POST['editMailNewMail'])){
			$oldMail = $mysqli->query("SELECT Mail FROM cloud_users WHERE username='".getNick()."'")->fetch_row();
			$newMail = $mysqli->escape_string($_POST['editMailNewMail']);
			if($oldMail[0] != $newMail){
				$mysqli->query("UPDATE cloud_users SET Mail='$newMail' WHERE username='".getNick()."'");
				fwrite($logFile, logFormat('Uživatel '.getNick().' změnil svůj mail.'));
				$zmenitMailVysledek = returnGood('Mail byl úspěšně změněn.');
			} else { $zmenitMailVysledek = retError('Nový mail nesmí být stejný jako starý.'); }
		} else { $zmenitMailVysledek = retError('Nebyl vyplněn nový mail'); }
	} else { $zmenitMailVysledek = notChange(); }
	
	if(isset($_POST['ApplyChanges_deleteMyAccount'])){
		if(isset($_POST['deleteMyAccountPass'])){
			$pass = $mysqli->escape_string(hash('sha256', $_POST['deleteMyAccountPass']));
			$passDB = $mysqli->query("SELECT Heslo FROM cloud_users WHERE username='".getNick()."'")->fetch_row();
			if($pass == $passDB[0]){
				$dellAllFilesRequest = $mysqli->query("SELECT * FROM cloud_files WHERE who='".getNick()."'");
				while($data = $dellAllFilesRequest->fetch_assoc()){
					@unlink($_SERVER['DOCUMENT_ROOT']."/soubory/".$data['filename'].".".$data['filetype']);
					$mysqli->query("DELETE FROM cloud_files WHERE who='".getNick()."' AND name='".$data['name']."'");
				}
				//Smazání účtu
				$mysqli->query("DELETE FROM cloud_users WHERE username='".getNick()."'");
				fwrite($logFile, logFormat('Uživatel '.getNick().' se smazal.'));
				header("Location: index.php");
			} else { $smazatMujUcetVysledek = retError('Špatné heslo'); }
		} else { $smazatMujUcetVysledek = retError('Nebylo vyplněno heslo.'); }
	} else { $smazatMujUcetVysledek = notChange(); }
?>