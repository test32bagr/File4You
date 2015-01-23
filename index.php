<?php
	error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR);
	@ini_set("display_errors", 1);
	include_once 'includes.php';
	
	if($detect->isMobile() && !$detect->isTablet())
		$Mobil = '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
			<link rel="stylesheet" href="data/style/hlavni_mobil.css">';
	else 
		$Mobil = '<link rel="stylesheet" href="data/style/hlavni.css">
			<link rel="stylesheet" href="data/style/chat.css">';
	
	echo '<!DOCTYPE html>
		<html>
			<head>
				<title>File4You | Klientská sekce</title>
				<meta charset="utf-8">
				<meta id="request-method" name="request-method" content="'.$_SERVER['REQUEST_METHOD'].'">
				'.$Mobil.'
				<link href="http://fonts.googleapis.com/css?family=Roboto:300,100&amp;subset=latin-ext" rel="stylesheet">
				<link href="http://fonts.googleapis.com/css?family=Signika:300&amp;subset=latin-ext" rel="stylesheet">
				<script src="data/javascript/jquery.js"></script>
				<script src="data/javascript/core.js"></script>
				<script src="data/javascript/chat.js"></script>
				<script src="data/javascript/HAO.js"></script>
				'.$extJS_CSS.'
			</head>
			<body>'.$header.'
				<div id="stranka"><table id="getFiles"></table></div>
				<div id="upload_button" onclick="uploadForm();"><img src="data/images/upload.png" alt="Upload_Button" width="256" height="40"></div>
				'.$upload_window.$chat.$reklama.'<div id="shutdown"></div>
			</body>
		</html>';
?>