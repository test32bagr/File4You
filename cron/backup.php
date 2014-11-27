<?php
	require 'config.php';
	
	if($backup_on_db){
		$mysqli_first = new Mysqli($first_DB[0], $first_DB[1], $first_DB[2], $first_DB[3]);
		$mysqli_second = new Mysqli($second_DB[0], $second_DB[1], $second_DB[2], $second_DB[3]);
		
		$dataRequest = Array();
		//chat
		$dataRequest[0] = $mysqli_first->query("SELECT * FROM cloud_chat");
		//soubory
		$dataRequest[1] = $mysqli_first->query("SELECT * FROM cloud_files");
		//povolení uživatelé
		$dataRequest[2] = $mysqli_first->query("SELECT * FROM cloud_reg_allow");
		//registrovaní uživatelé
		$dataRequest[3] = $mysqli_first->query("SELECT * FROM cloud_users");
		
		
	} else {
	
	}
?>