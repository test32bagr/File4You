<?php
	function retError($string){ return '<p style="color: Red; text-align: center;">'.$string.'</p>'; }
	$outputDataRename = '';
	if(!empty($_POST['renameFile'])){
		if(!empty($_POST['FileNick']) && !empty($_POST['NewName'])){
			$fileNick = $mysqli->escape_string($_POST['FileNick']);
			$pocetSouboru = (int)$mysqli->query("SELECT * FROM cloud_files WHERE name='$fileNick'")->num_rows;
			if($pocetSouboru >= 1){
				$NewName = str_replace(".", "_", $mysqli->escape_string($_POST['NewName']));
				$isExists = (int)$mysqli->query("SELECT * FROM cloud_files WHERE filename='$NewName'")->num_rows;
				if($isExists === 0){
					$nickDB = $mysqli->query("SELECT who FROM cloud_files WHERE name='$fileNick'")->fetch_row();
					if($nickDB[0] == getNick()){
						$OldName = $mysqli->query("SELECT filename, filetype FROM cloud_files WHERE name='$fileNick'")->fetch_assoc();
						$mysqli->query("UPDATE cloud_files SET filename='$NewName' WHERE name='$fileNick'");
						rename('./soubory/'.$OldName['filename'].'.'.$OldName['filetype'], './soubory/'.$NewName.'.'.$OldName['filetype']);
						$outputDataRename = '<p style="color: Green; text-align: center">Soubor byl úspěšně přejmenován.<br>'.$OldName['filename'].'.'.$OldName['filetype'].' -> '.$NewName.'.'.$OldName['filetype'].'</p>';
					} else { $outputDataRename = retError('Zadaný soubor jsi nenahrál ty.<br>Takže nemáš oprávnění do něj zasahovat.'); }
				} else { $outputDataRename = retError('Zadaný název souboru již existuje'); }
			} else { $outputDataRename = retError('Soubor s daným nickem neexistuje.'); }
		} else { $outputDataRename = retError('Nebyl zadán nick souboru nebo nový název souboru'); }
	}
	
	$outputDataType = '';
	if(!empty($_POST['changeType'])){
		if(!empty($_POST['changeTypeFileNick'])){
			$fileNick = $mysqli->escape_string($_POST['changeTypeFileNick']);
			$isExists = (int)$mysqli->query("SELECT * FROM cloud_files WHERE name='$fileNick'")->num_rows;
			if($isExists > 0){
				$nickDB = $mysqli->query("SELECT who FROM cloud_files WHERE name='$fileNick'")->fetch_row();
				if($nickDB[0] == getNick()){
					$NewType = $mysqli->escape_string($_POST['NewType']);
					$oldType = $mysqli->query("SELECT typ FROM cloud_files WHERE name='$fileNick'")->fetch_row();
					$mysqli->query("UPDATE cloud_files SET typ='$NewType' WHERE name='$fileNick'");
					$outputDataType = '<p style="color: Green">Typ byl úspěšně změněn.<br>'.$oldType[0].' -> '.$NewType.'</p>';
				} else { $outputDataType = retError("Zadaný soubor jsi nenahrál ty.<br>Takže nemáš oprávnění do něj zasahovat."); }
			} else { $outputDataType = retError("Zadaný soubor neexistuje.<br>Zkontroluj správnost svého zadání."); }
		} else { $outputDataType = retError("Nevyplnil jsi nick souboru."); }
	}
	
	$request = $mysqli->query("SELECT name, filename, filetype FROM cloud_files WHERE who='".getNick()."'");
	while($deleteData = $request->fetch_assoc()){
		if(isset($_POST['DeleteFile-'.$deleteData['name']])){
			$filename = $deleteData['filename'].'.'.$deleteData['filetype'];
			$file = $deleteData['name'];
			$mysqli->query("DELETE FROM cloud_files WHERE name='$file'");
			unlink('./soubory/'.$filename);
			break;
		}
	}
	
?>