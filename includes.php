<?php
	function includePath($file){ return 'data/php/'.$file.'.php'; }
	function notChange(){ return 'Nebyla provedena změna.'; }
	function retError($string){ return '<span style="color: Red">'.$string.'</span>'; }
	function returnGood($string){ return '<span style="color: Green">'.$string.'</span>'; }
	function logFormat($string){ return StrFTime("%d.%m.%Y %H:%M:%S", Time()).' |--> '.$string.'<br>'; }
	
	if($_SERVER['PHP_SELF'] != '/registrace.php' || $_SERVER['PHP_SELF'] != 'registrace.php') include includePath("webLocker");
	$logFile = fopen("log.txt", "a+");
	include 'data/php/delDiacritic.php';
	include 'data/php/upload.php';
	
	if($_SERVER['PHP_SELF'] != '/registrace.php' || $_SERVER['PHP_SELF'] != 'registrace.php') { 
		$header = '<header>
			<div id="hlavicka">
				<div>
					Přihlášený uživatel: <span id="nick">'.getNick().'</span> ('.$_SERVER['REMOTE_ADDR'].') |
					<a href="?odhlasit=true" title="Odhlásit se">Ukončit relaci</a> |
					<a href="index.php" title="Klientská sekce">Klientská sekce</a> | 
					<a href="admin.php" title="Administrace">Administrace</a>
				</div>
			</div>
			<div id="podhlavicka"><h2>File4You</h2></div>
		</header>';
		$option = '<option value="Word">Dokument word</option>
		<option value="Prezentace">Prezentace</option>
		<option value="Excel">Sešit excel</option>
		<option value="Obrázek">Obrázek</option>
		<option value="Archív">Komprimované soubory</option>
		<option value="Windows aplikace">Windows aplikace</option>
		<option value="Textový dokument">Textový dokument</option>
		<option value="PDF">PDF soubor</option>
		<option value="Audio">Zvukový soubor</option>
		<option value="Javascript">Soubor javascript (*.js)</option>
		<option value="JSON">Soubor JSON (*.json)</option>
		<option value="XML">Soubor XML (*.xml)</option>
		<option value="HTML">Soubor HTML (*.html)</option>
		<option value="PHP">Soubor PHP (*.php)</option>
		<option value="Flash">Shockwave flash</option>
		<option value="Ostatní">Ostatní soubory</option>';
		$upload_window = '<div id="upload_window">
			<form method="post" enctype="multipart/form-data">
				<div id="upload_info">'.$uploadVysledek.'</div>
				Soubor: <input type="file" name="file">
				Nick souboru: <input type="text" name="fileNick" placeholder="Nick souboru: " maxlength="50">
				Typ souboru: <select name="typeFile" size="1">'.$option.'</select>
				<input type="submit" name="sendFile" value="Nahrát soubor">
			</form>
		</div>';
		$reklama = '';
		$chat = '<div id="chat">
			<div id="head">Chat <span id="time"></span><span id="right"><div onclick="openClose()" id="openorclose"></div></span></div>
			<div id="messages" readonly></div>
			<form method="POST">
				<textarea id="message" name="message" placeholder="Zpráva do chatu"></textarea>
				<script>
					$("#message").keypress(function(e){
						if(e.keyCode == 13 && !e.shiftKey) { 
							sendMessage();
						} else if(e.keyCode == 13 && e.shiftKey){
							var content = this.value;
							var caret = getCaret(this);
							this.value =  content.substring(0, caret) + "<br>" + content.substring(caret, content.length);
							e.stopPropagation();
						}
					});
				</script>
				<input type="button" onclick="sendMessage();" id="sendMessageChat" value="Odeslat">
			</form>
		</div>';
	}
	
	if($_SERVER['PHP_SELF'] == '/admin.php' || $_SERVER['PHP_SELF'] == 'admin.php' || $_SERVER['PHP_SELF'] == '/sdileni/admin.php'){
		include includePath('getInfoUser');
		include includePath('adminServicesHTML');
		include includePath('upravitSoubor');
	}
	
	if($_SERVER['PHP_SELF'] == '/regkeys.php' || $_SERVER['PHP_SELF'] == 'regkeys.php' || $_SERVER['PHP_SELF'] == '/sdileni/regkeys.php'){
		include includePath('getKeys');
		include includePath('regKeysAction');
	}
	
	if($_SERVER['PHP_SELF'] == '/regusers.php' || $_SERVER['PHP_SELF'] == 'regusers.php' || $_SERVER['PHP_SELF'] == '/sdileni/regusers.php') include includePath('getUsers');
	
	if($_SERVER['PHP_SELF'] == '/uac.php' || $_SERVER['PHP_SELF'] == 'uac.php' || $_SERVER['PHP_SELF'] == '/sdileni/uac.php'){
		include includePath('getuacHTML');
		include includePath('uac');
	}
?>
