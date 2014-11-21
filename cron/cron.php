<?php
	//CRON
	$mysqli = new mysqli('127.0.0.1', 'c2cloud', 'passwd', 'c2mycloud');
	$logFile = fopen("data/log.txt", "a+");
	
	//Chat
	if($mysqli->query("SELECT * FROM cloud_chat")->num_rows >= 1) $mysqli->query("DELETE FROM cloud_chat WHERE 1");
?>
