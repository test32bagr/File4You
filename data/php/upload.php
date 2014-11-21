<?php
	function returnError($typ, $str){
		if($typ == 'Javascript'){ return ' <script> $(document).ready(function(){ $("#upload_button").click(function(){ $("#upload_button").css({background: "none"}); }); }); </script>';
		} elseif($typ == 'CSS'){ return ' <style> #upload_button{ background: Red; } </style> ';
		} elseif($typ == 'String'){ return '<span style="color: Red">'.$str.'</span>'; }
	}
	
	if(isset($_POST['sendFile'])){
		if(!empty($_FILES['file']['name']) && !empty($_POST['fileNick'])){
			$file = str_replace(" ", "_", $mysqli->escape_string($_FILES['file']['name']));
			$file = explode(".", $file);
			$filename = '';
			for($i = 0; $i <= count($file) - 1 - 1; $i++) $filename .= $file[$i];
			$filename = remove_accents($filename);
			$filetype = $file[count($file) - 1];
			$fileNick = $mysqli->escape_string(str_replace(" ", "", $_POST['fileNick']));
			if(strlen($filename.".".$filetype) <= 255){
				if(strlen($fileNick) > 51) $fileNick = substr($fileNick, 0, 15);
				$size = (int)floor($_FILES['file']['size'] / 1024); //v kB
				if(floor($size / 1024) <= 20){
					if($mysqli->query("SELECT * FROM cloud_files WHERE name='$fileNick'")->num_rows == 0){
						if($mysqli->query("SELECT * FROM cloud_files WHERE filename='$filename'")->num_rows == 0){
							$type = $mysqli->escape_string($_POST['typeFile']);
							$DateTime = StrFTime("%d. %m. %Y %H:%M:%S", Time());
							move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/soubory/".$filename.".".$filetype) or die("Chyba v nahrávání<br>Chyba: ".$_FILES['file']['error']."<br>".ini_get("upload_max_filesize")."<br>".$_SERVER['DOCUMENT_ROOT']);
							$mysqli->query("INSERT INTO cloud_files VALUES ('$filename', '$filetype', '$size', '$fileNick', '$type', '".getNick()."', '$DateTime')");
							fwrite($logFile, $DateTime.' Uživatel '.getNick().' nahrál soubor s nickem: '.$fileNick.'<br>');
							$uploadVysledek = '<span style="color: Green">Soubor byl bez sebemenších problémů nahrán.</span>';
							$extJS_CSS = returnError('Javascript', '').'<style> #upload_button{ background: rgba(0, 255, 0, 0.5); } </style>';
						} else {
							$uploadVysledek = returnError('String', 'Nahrávaný soubor již existuje.');
							$extJS_CSS = returnError('Javascript', '').returnError('CSS', '');
						}
					} else {
						$uploadVysledek = returnError('String', 'Soubor s daným nickem již existuje.');
						$extJS_CSS = returnError('Javascript', '').returnError('CSS', '');
					}
				} else {
					$uploadVysledek = returnError('String', 'Soubor nesmí být větší než 20MB.');
					$extJS_CSS = returnError('Javascript', '').returnError('CSS', '');
				}
			} else {
				$uploadVysledek = returnError('String', 'Název souboru má více než 256 znaků.<br>Zkus zmenšit jeho délku.');
				$extJS_CSS = returnError('Javascript', '').returnError('CSS', '');
			}
		} else {
			$uploadVysledek = returnError('String', 'Nevyplnil jsi nick souboru nebo jsi nevložil soubor.');
			$extJS_CSS = returnError('Javascript', '').returnError('CSS', '');
		}
	} else { 
		$uploadVysledek = 'Maximální velikost: <b>20MB</b>'; 
		$extJS_CSS = '';
	}
?>
