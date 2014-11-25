<?php	
	include 'mysqli.php';
	
	$nick = $mysqli->escape_string($_POST['nick']);
	$zprava = $mysqli->escape_string($_POST['message']);

	$mysqli->query("INSERT INTO cloud_chat (Nick, zprava, cas) VALUES ('$nick', '$zprava', Now())");
?>