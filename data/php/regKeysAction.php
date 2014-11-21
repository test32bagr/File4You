<?php
	if(!empty($_POST['addUserKey'])){
		if(!empty($_POST['addUserKey-Name']) && !empty($_POST['addUserKey-Surname'])){
			$Name = $mysqli->escape_string(remove_accents($_POST['addUserKey-Name']));
			$Surname = $mysqli->escape_string(remove_accents($_POST['addUserKey-Surname']));
			if($mysqli->query("SELECT * FROM cloud_reg_allow WHERE Surname='$Surname'")->num_rows == 0){
				$key = $mysqli->escape_string(md5($Surname));
				$mysqli->query("INSERT INTO `cloud_reg_allow`(Name, Surname, klic) VALUES ('$Name','$Surname','$key')");
				fwrite($logFile, logFormat('Byl přidán registrační klíč pod příjmením: '.$Surname));
				$addUserKey = '<p id="addKeyComplete">Osoba byla povolena pro registraci.</p>';
			} else { $addUserKey = '<p id="addKeyError">Zadaný uživatel již existuje.</p>'; }
		} else { $addUserKey = '<p id="addKeyError">Nevyplnil jsi některé pole.</p>'; }
	} elseif(!empty($_POST['delUserKey'])){
		if(!empty($_POST['delUserKey-Name']) && !empty($_POST['delUserKey-Surname'])){
			$Name = $mysqli->escape_string(remove_accents($_POST['delUserKey-Name']));
			$Surname = $mysqli->escape_string(remove_accents($_POST['delUserKey-Surname']));
			if($mysqli->query("SELECT * FROM cloud_reg_allow WHERE Surname='$Surname'")->num_rows > 0){
				$mysqli->query("DELETE FROM cloud_reg_allow WHERE Surname='$Surname'");
				fwrite($logFile, logFormat('Byl zablokován registrační klíč pro uživatele: '.$Name.' '.$Surname));
				$delUserKey = '<p id="delKeyComplete">Registrační klíč byl zablokován byl zablokován.</p>';
			} else { $delUserKey = '<p id="delKeyError">Zadaný uživatel neexistuje</p>'; }
		} else { $delUserKey = '<p id="delKeyError">Nevyplnil jsi některé pole.</p>'; }
	} else {
		$addUserKey = '';
		$delUserKey = '';
	}
?>