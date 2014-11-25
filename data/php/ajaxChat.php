<?php
	error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR);
	@ini_set("display_errors", 1);

	include 'mysqli.php';
	
	$dataRequest = $mysqli->query("SELECT * FROM cloud_chat ORDER BY cas ASC");
	
	while($data = $dataRequest->fetch_assoc()) echo htmlspecialchars($data['cas']." (".$data['Nick'].") ".$data['zprava'])."<br>";
?>
