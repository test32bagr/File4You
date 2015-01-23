<?php
	error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR);
	@ini_set("display_errors", 1);
	include 'includes.php';
	
	if($detect->isMobile() && !$detect->isTablet())
		$Mobil = '<meta name="viewport" content="width=device-width, maximum-scale=1.5, initial-scale=1">
			<link rel="stylesheet" href="data/style/admin_mobil.css">';
	else 
		$Mobil = '<link rel="stylesheet" href="data/style/admin.css">';
	
	echo '<!DOCTYPE html>
		<html>
			<head>
				<title>File4You | Administrace</title>
				<meta charset="utf-8">
				'.$Mobil.'
				<link href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext" rel="stylesheet">
				<link href="http://fonts.googleapis.com/css?family=Signika:300&amp;subset=latin-ext" rel="stylesheet">
				<script src="data/javascript/jquery.js"></script>
				<script src="data/javascript/core.js"></script>
				<script src="data/javascript/HAO.js"></script>
			</head>
			<body>'.$header.'
				<div id="stranka">'.getInfoUserAndSystem().adminServices().'</div>
				'.$reklama.'
			</body>
		</html>';
?>