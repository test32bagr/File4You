<?php
	function dirsize($dir) {
		$homedir = opendir($dir);
		$size = 0;
		while ($file = @readdir($homedir)) {
			if ($file != "." and $file != "..") {
				$path = $dir."/".$file;
				if (is_dir($path)) $size += dirsize($path); 
				elseif (is_file($path)) $size += filesize($path);
			}
		}
		@closedir($homedir);
		//Počet v kilobajtech
		$size = $size/1024;
		$size = floor($size);
		//Ověření, pokud soubor není větší než 1MB
		if($size >= 1024){
			$full = $size;
			$size = $size/1024;
			return floor($size).' MB'.' ('.$full.' kB)';
		} else return $size.' kB';
		
    }
	function getInfoUserAndSystem(){
		global $mysqli, $detect, $option, $outputDataRename, $outputDataType;
		
		$userInfo = $mysqli->query("SELECT * FROM cloud_users WHERE username='".getNick()."'")->fetch_assoc();
		$isAdmin = $userInfo["isAdmin"];
		
		if($isAdmin[0] == 'true'){
			$pocetUzivatelu = (int)$mysqli->query("SELECT * FROM cloud_users")->num_rows;
			if($pocetUzivatelu === 0) $pocetUzivatelu .= ' uživatelů';
			elseif($pocetUzivatelu === 1) $pocetUzivatelu .= ' uživatel';
			elseif($pocetUzivatelu === 2 && $pocetUzivatelu < 5) $pocetUzivatelu .= ' uživatelé';
			elseif($pocetUzivatelu >= 5) $pocetUzivatelu .= ' uživatelů';
			
			$pocetUzivateluAdmin = (int)$mysqli->query("SELECT * FROM cloud_users WHERE isAdmin='true'")->num_rows;
			if($pocetUzivateluAdmin === 0) $pocetUzivateluAdmin .= ' uživatelů';
			elseif($pocetUzivateluAdmin === 1) $pocetUzivateluAdmin .= ' uživatel';
			elseif($pocetUzivateluAdmin === 2 && $pocetUzivateluAdmin < 5) $pocetUzivateluAdmin .= ' uživatelé';
			elseif($pocetUzivateluAdmin >= 5) $pocetUzivateluAdmin .= ' uživatelů';
			
			$adresar = opendir("/web/sdileni/soubory");
			$numberFiles = (int)0;
			while($soubor = readdir($adresar)) $numberFiles++;
			$numberFiles = $numberFiles - 2;
			$numberFiles = $numberFiles - 1; //Odebrání .htaccess /*.htaccess je skrytý soubor na serveru, který donastavuje Apache*/
			if($numberFiles == 0) $numberFiles = $numberFiles.' souborů';
			elseif($numberFiles == 1) $numberFiles = $numberFiles.' soubor';
			elseif($numberFiles >= 2 && $numberFiles < 5) $numberFiles = $numberFiles.' soubory';
			elseif($numberFiles >= 5) $numberFiles = $numberFiles.' souborů';
			
			if($mysqli->query("SELECT filename FROM cloud_files WHERE who='".getNick()."'")->num_rows == 0) $files = '<caption id="NoFiles">Nenahrál jsi žádný soubor</caption>';
			else {
				$files = '';
				if(!$detect->isMobile()) $files = '<tr><th>Nick souboru</th><th>Název souboru</th><th>Typ</th><th>Velikost</th><th>Kdo nahrál</th><th>Akce</th></tr>';
				$get_DB = $mysqli->query("SELECT filename, filetype, name, typ, size, Date_time FROM cloud_files WHERE who='".getNick()."'");
				while($data = $get_DB->fetch_assoc()){
					if($detect->isMobile() && !$detect->isTablet()){
						$files .= '<tr align="center"><td>'.$data['name'].'</td><td>'.$data['filename'].'.'.$data['filetype'].'</td><td>'.$data['typ'].'</td><td>'.$data['size'].' kB</td><td>'.$data['Date_time'].'</td></tr>';
					} else {
						$files .= '<tr id="'.$data['name'].'"><td>'.$data['name'].'</td><td>'.$data['filename'].'.'.$data['filetype'].'</td><td>'.$data['typ'].'</td><td>'.$data['size'].' kB</td><td>'.$data['Date_time'].'</td><td align="center"><form method="post"><input type="submit" name="DeleteFile-'.$data['name'].'" value="Smazat"></form></td></tr>';
					}
				}
			}
			
			$sizeDb = $mysqli->query("SELECT table_schema \"DB_Name\", Sum(data_length + index_length) / 1024 / 1024 \"db_size_in_mb\" FROM information_schema.tables GROUP BY table_schema")->fetch_assoc();
						
			$root = $_SERVER['DOCUMENT_ROOT'];
			$port = (int)$_SERVER['SERVER_PORT'];
			if($port === 80){
				$page = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
				$pageType = 'HTTP';
			} elseif($port === 443){
				$page = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
				$pageType = 'HTTPS';
			} else {
				$page = $_SERVER['SERVER_NAME'].':'.$port.$_SERVER['PHP_SELF'];
				$pageType = 'Neznámý port: '.$port;
			}

			return '<h2>Informace o uživateli a systému</h2>
			<table class="tables">
				<tr><td>Jméno: </td><td>'.$userInfo['Jmeno'].'</td></tr>
				<tr><td>Přijmení: </td><td>'.$userInfo['Prijmeni'].'</td></tr>
				<tr><td>Nick: </td><td>'.getNick().'</td></tr>
				<tr><td>Mail: </td><td>'.$userInfo['Mail'].'</td></tr>
				<tr><td>IP adresa registrace: </td><td>'.$userInfo['IPregistrace'].'</td></tr>
				<tr><td>Věk: </td><td>'.$userInfo['vek'].' let</td></tr>
			</table>
			<table class="tables">
					<tr><td>Verze PHP: </td><td>'.phpversion().'</td></tr>
					<tr><td>Verze Zend: </td><td>'.zend_version().'</td></tr>
					<tr><td>Aktuální stránka: </td><td>'.$page.'</td></tr>
					<tr><td>ROOT: </td><td>'.$root.'</td></tr>
					<tr><td>Port: </td><td>'.$port.' ('.$pageType.')</td></tr>
					<tr><td>Klientská IP: </td><td>'.$_SERVER['REMOTE_ADDR'].'</td></tr>
					<tr><td>Počet registrovaných uživatelů: </td><td>'.$pocetUzivatelu.'</td></tr>
					<tr><td>Počet administrátorů: </td><td>'.$pocetUzivateluAdmin.'</td></tr>
					<tr><td>Počet uložených souborů: </td><td>'.$numberFiles.'</td></tr>
					<tr><td>Využití souborů: </td><td>'.dirsize("./soubory").' (Limit: '.(disk_total_space("/") / 1024 / 1024 / 1024).' GB)</td</tr>
					<tr><td>Velikost databáze: </td><td>'.$sizeDb['db_size_in_mb'].' MB (Limit: '.(disk_total_space("/") / 1024 / 1024 / 1024).' GB)</td></tr>
					<tr><td>Počet odeslaných zpráv v chatu: </td><td>'.$mysqli->query("SELECT * FROM cloud_chat")->num_rows.' zpráv</td></tr>
				</table>
				<h2>Moje nahrané soubory</h2>
				<p id="InfoFiles">Soubory jsou k dispozici ke stažení v klientské sekci.</p>
				<table id="Files" class="tables">'.$files.'</table>
				<div id="upravitSoubor">
					<table class="tables">
							<thead><h2>Úprava souborů</h2></thead>
							<tbody>
								<tr>
									<td>
										<form method="POST" class="changeForm" id="zmenit_typ">
											<h2>Změnit typ souboru</h2>
											'.$outputDataType.'
											<input type="text" name="changeTypeFileNick" placeholder="Nick: "><br>
											Nový typ souboru: <select name="NewType" size="1">'.$option.'</select>
											<input type="submit" name="changeType" value="Změnit typ">
										</form>
									</td>
									<td>
										<form method="POST" class="changeForm" id="prejmenovat">
											<h2>Přejmenování souborů</h2>
											'.$outputDataRename.'
											<input type="text" name="FileNick" placeholder="Nick: ">
											<input type="text" name="NewName" placeholder="Nový název souboru: ">
											<input type="submit" name="renameFile" value="Přejmenovat">
										</form>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
		';
		} elseif($isAdmin[0] == 'false'){
			if($mysqli->query("SELECT filename FROM cloud_files WHERE who='".getNick()."'")->num_rows == 0){ $files = '<caption id="NoFiles">Nenahrál jsi žádný soubor</caption>'; }
			else {
				$files = '<tr><th>Nick souboru</th><th>Název souboru</th><th>Typ</th><th>Velikost</th><th>Kdo nahrál</th><th>Akce</th></tr>';
				$get_DB = $mysqli->query("SELECT filename, filetype, name, typ, size, Date_time FROM cloud_files WHERE who='".getNick()."'");
				while($data = $get_DB->fetch_assoc()){
					$files .= '<tr id="'.$data['name'].'">
						<td>'.$data['name'].'</td>
						<td>'.$data['filename'].'.'.$data['filetype'].'</td>
						<td>'.$data['typ'].'</td>
						<td>'.$data['size'].' kB</td>
						<td>'.$data['Date_time'].'</td>
						<td><form method="post"><input type="submit" name="DeleteFile-'.$data['name'].'" value="Smazat"></form></td>
					</tr>'; 
				}
			}
			$userInfo = $mysqli->query("SELECT * FROM cloud_users WHERE username='".getNick()."'")->fetch_assoc();
			return '<h2>Informace o uživateli</h2>
			<table class="tables">
				<tr><td>Jméno: </td><td>'.$userInfo['Jmeno'].'</td></tr>
				<tr><td>Přijmení: </td><td>'.$userInfo['Prijmeni'].'</td></tr>
				<tr><td>Nick: </td><td>'.getNick().'</td></tr>
				<tr><td>Mail: </td><td>'.$userInfo['Mail'].'</td></tr>
				<tr><td>IP adresa registrace: </td><td>'.$userInfo['IPregistrace'].'</td></tr>
				<tr><td>Věk: </td><td>'.$userInfo['vek'].'</td></tr>
			</table>
			<h2>Moje nahrané soubory</h2>
				<p id="InfoFiles">Soubory jsou k dispozici ke stažení v klientské sekci.</p>
				<table id="Files" class="tables">'.$files.'</table>
				<table id="upravitSoubor" class="tables">
						<thead><h2>Úprava souborů</h2></thead>
						<tbody>
							<tr>
								<td>
									<form method="POST" class="changeForm" id="zmenit_typ">
										<h2>Změnit typ souboru</h2>
										'.$outputDataType.'
										<input type="text" name="changeTypeFileNick" placeholder="Nick: "><br>
										Nový typ souboru: <select name="NewType" size="1">'.$option.'</select>
										<input type="submit" name="changeType" value="Změnit typ">
									</form>
								</td>
								<td>
									<form method="POST" class="changeForm" id="prejmenovat">
										<h2>Přejmenování souborů</h2>
										'.$outputDataRename.'
										<input type="text" name="FileNick" placeholder="Nick: ">
										<input type="text" name="NewName" placeholder="Nový název souboru: ">
										<input type="submit" name="renameFile" value="Přejmenovat">
									</form>
								</td>
							</tr>
						</tbody>
					</table>';
		}	
	}
?>
