<?php
	error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR);
	@ini_set("display_errors", 1);

	include 'mysqli.php';
	
	$dataRequest = $mysqli->query("SELECT * FROM cloud_chat ORDER BY cas ASC");
		
	while($data = $dataRequest->fetch_assoc()) {
		$color = $mysqli->query("SELECT color FROM cloud_users WHERE username='".$data['Nick']."'")->fetch_assoc();
		echo '<span style="color: Darkgreen;">'.Date("j. m. Y H:i:s", strtotime($data['cas'])).'</span> (<span style="color: '.$color['color'].';">'.$data['Nick'].'</span>) '.$data['zprava'].'<br>';
	}
?>