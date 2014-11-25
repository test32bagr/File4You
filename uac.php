<?php
	include 'includes.php';
	
	if($detect->isMobile() && !$detect->isTablet())
		$Mobil = '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
			<link rel="stylesheet" href="data/style/config/uac_mobil.css">';
	else 
		$Mobil = '<link rel="stylesheet" href="data/style/config/uac.css">';
	
	echo '<!DOCTYPE html>
		<html>
			<head>	
				<meta charset="utf-8">
				<title>Řízení uživatelských účtů</title>
				'.$Mobil.'
				<link href=\'http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext\' rel=\'stylesheet\'>
				<link href=\'http://fonts.googleapis.com/css?family=Signika:300&amp;subset=latin-ext\' rel=\'stylesheet\'>
				<script src="data/javascript/jquery.js"></script>
				<script src="data/javascript/core.js"></script>
				<script src="data/javascript/HAO.js"></script>
			</head>
			<body>'.$header.'
				<div id="stranka">'.getuacHTML().'</div>
			</body>
		</html>
	';
?>
