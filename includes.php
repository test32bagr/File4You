<?php
	if($_SERVER['PHP_SELF'] != '/registrace.php' || $_SERVER['PHP_SELF'] != 'registrace.php') include 'data/php/webLocker/webLocker.php';
	$logFile = fopen("data/log.txt", "a+");
	include 'data/php/delDiacritic.php';
	include 'data/php/upload.php';
	
	if($_SERVER['PHP_SELF'] != '/registrace.php' || $_SERVER['PHP_SELF'] != 'registrace.php') { 
		$header = file_get_contents("data/php/HTML/header.html"); 
		$header .= getNick().' ('.$_SERVER['REMOTE_ADDR'].') '.file_get_contents("data/php/HTML/header2.html");
		$upload_button = file_get_contents("data/php/HTML/upload_button.html");
		$option = file_get_contents("data/php/HTML/option1.html");		
		$upload_window = file_get_contents("data/php/HTML/upload_window.html").$uploadVysledek.file_get_contents("data/php/HTML/upload_window2.html").$option.file_get_contents("data/php/HTML/upload_window3.html");
		$shutdownAlert = '<div id="shutdown"></div>';
		$reklama = '<footer><endora></footer>';	
		$chat = '<div id="chat">
			<div id="head">Chat<span><div onclick="openClose()" id="openorclose"></div></span></div>
			<div id="messages" readonly></div>
			<form method="POST">
				<textarea id="message" name="message" placeholder="Zpráva do chatu"></textarea>
				<input type="submit" name="sendMessageChat" value="Odeslat!">
			</form>
		</div>';
	}

	if($_SERVER['PHP_SELF'] == '/index.php' || $_SERVER['PHP_SELF'] == 'index.php' || $_SERVER['PHP_SELF'] == '/'){
		if(isset($_POST['sendMessageChat'])){
			$_SESSION['nick'] = $mysqli->escape_string(getNick());
			$nick = $_SESSION['nick'];
			$zprava = $mysqli->escape_string($_POST['message']);
		
			$mysqli->query("INSERT INTO cloud_chat (Nick, zprava, cas) VALUES ('$nick', '$zprava', Now())");	
		}
	}
	
	if($_SERVER['PHP_SELF'] == '/admin.php' || $_SERVER['PHP_SELF'] ==  'admin.php'){
		include 'data/php/getInfoUser.php';
		include 'data/php/adminServicesHTML.php';
		include 'data/php/upravitSoubor.php';
	}
	
	if($_SERVER['PHP_SELF'] == '/regkeys.php' || $_SERVER['PHP_SELF'] == 'regkeys.php'){
		include 'data/php/getKeys.php';
		include 'data/php/regKeysAction.php';
	}
	
	if($_SERVER['PHP_SELF'] == '/regusers.php' || $_SERVER['PHP_SELF'] == 'regusers.php') include 'data/php/getUsers.php';
	if($_SERVER['PHP_SELF'] == '/uac.php' || $_SERVER['PHP_SELF'] == 'uac.php'){
		include 'data/php/getuacHTML.php';
		include 'data/php/uac.php';
	}
?>
