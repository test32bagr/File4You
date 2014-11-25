<?php
	error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR);
	@ini_set("display_errors", 1);

	include 'mysqli.php';
	$mysqli->set_charset('utf8');
	
	include './Mobile_Detect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	
	if($mysqli->query("SELECT * FROM cloud_files")->num_rows == 0){
		echo '<caption>
			<div id="caption">
				Na serveru nebyl nalezen žádný soubor.<br>
				<img src="data/images/404.png" alt="File not found" title="Data nebyla nalezena">
			</div>
		</caption>';
	} else {
		if(!$detect->isMobile()){ echo '<tr><th>Odkaz na stažení</th><th>Název souboru</th><th>Typ</th><th>Velikost</th><th>Kdo nahrál</th><th>Kdy nahrál</th></tr>'; }
		$get_DB = $mysqli->query("SELECT filename, filetype, name, typ, size, who, Date_time FROM cloud_files");
		while($data = $get_DB->fetch_assoc()){
			if(!$detect->isMobile()){
				echo '<tr>
					<td><a href="./soubory/'.$data['filename'].'.'.$data['filetype'].'" title="'.$data['name'].'">'.$data['name'].'</a></td>
					<td>'.$data['filename'].'.'.$data['filetype'].'</td>
					<td>'.$data['typ'].'</td>
					<td>'.$data['size'].' kB</td>
					<td>'.$data['who'].'</td>
					<td>'.$data['Date_time'].'</td>
				</tr>'; 
			} else {
				echo '<tr>
					<td><a href="./soubory/'.$data['filename'].'.'.$data['filetype'].'" title="'.$data['name'].'">'.$data['name'].'</a><br>
						Název souboru: <b>'.$data['filename'].'.'.$data['filetype'].'</b><br>
						Typ: <b>'.$data['typ'].'</b><br>
						Velikost: <b>'.$data['size'].' kB</b><br>
						Nahrál: <b>'.$data['who'].'</b><br>
						Datum a čas: <b>'.$data['Date_time'].'</b>
					</td>
				</tr>';
			}
		}
	}
?>
