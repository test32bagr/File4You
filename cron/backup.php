<?php
	//Cron
	//This is only console app
	
	require 'config.php';
	
	function con_error($which_db, $error, $errno){
		echo "Chyba: ".$which_db." nepracuje správně.\n\n".$error."\n\n".$errno;
		exit;
	}
	
	if($backup_on_db){
		$mysqli_first = new Mysqli($first_DB[0], $first_DB[1], $first_DB[2], $first_DB[3]);
		$mysqli_second = new Mysqli($second_DB[0], $second_DB[1], $second_DB[2], $second_DB[3]);
		
		if($mysqli_first->connect_error) con_error('Zdrojová', $mysqli_first->connect_error, $mysqli_first->connect_errno);
		elseif($mysqli_second->connect_error) con_error('Cílová', $mysqli_second->connect_error, $mysqli_second->connect_errno);
		
		$dataRequest = Array();
		//chat
		$dataRequest[0] = $mysqli_first->query("SELECT * FROM cloud_chat");
		//soubory
		$dataRequest[1] = $mysqli_first->query("SELECT * FROM cloud_files");
		//povolení uživatelé
		$dataRequest[2] = $mysqli_first->query("SELECT * FROM cloud_reg_allow");
		//registrovaní uživatelé
		$dataRequest[3] = $mysqli_first->query("SELECT * FROM cloud_users");
		
		//Zálohování chatu
		while($chatData = $dataRequest[0]->fetch_assoc()){
			
		}
	} else {
	
	}
?>