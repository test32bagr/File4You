<?php
	/*
		true --> Zálohování do již existující databáze. --> Doplnit informace o databázích		
			
		false --> Zálohování do souboru. --> Doplnit informace o souborech
	*/	
	$backup_on_db = true;
	
	//Zálohování do databází
	$first_DB = Array();

	$first_DB[0] = ''; //IP
	$first_DB[1] = ''; //Username
	$first_DB[2] = ''; //Pass
	$first_DB[3] = ''; //Nazev databáze
	
	$second_DB = Array();
	
	$second_DB[0] = ''; //IP
	$second_DB[1] = ''; //Username
	$second_DB[2] = ''; //Pass
	$second_DB[3] = ''; //Název databáze
?>