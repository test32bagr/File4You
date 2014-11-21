<?php
	error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR);
	@ini_set("display_errors", 1);
	
	include 'includes.php';
	
	if($detect->isMobile() && !$detect->isTablet())
		$Mobil = '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
			<link rel="stylesheet" href="data/style/config/regkeys_mobil.css">';
	else 
		$Mobil = '<link rel="stylesheet" href="data/style/config/regkeys.css">';
	
	echo '<!DOCTYPE html>
		<html>
			<head>	
				<meta charset="utf-8">
				<title>Seznam registračních klíčů</title>
				'.$Mobil.'
				<link href=\'http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext\' rel=\'stylesheet\'>
				<link href=\'http://fonts.googleapis.com/css?family=Signika:300&amp;subset=latin-ext\' rel=\'stylesheet\'>
			</head>
			<body>'.$header.'
				<div id="stranka">
					'.getKeys().'
				</div>
			</body>
		</html>
	';
?>
