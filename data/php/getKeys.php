<?php
	function getKeys(){
		global $mysqli, $addUserKey, $delUserKey, $detect;
		$isAdmin = $mysqli->query("SELECT isAdmin FROM cloud_users WHERE username='".getNick()."'")->fetch_row();
		
		if($isAdmin[0] == 'true'){
			$out = '<table>';
			if(!$detect->isMobile()) $out .= '<tr><th>ID</th><th>Jméno</th><th>Přijmení</th><th>Klíč</th></tr>';
			$getRequest = $mysqli->query("SELECT id, Name, Surname, klic FROM cloud_reg_allow");
			while($data = $getRequest->fetch_assoc()){
				if($detect->isMobile() && !$detect->isTablet()){
					$out .= '<tr>
						<td><b>ID: </b>'.$data['id'].'
						<br><b>Jméno a přijmení: </b>'.$data['Name'].' '.$data['Surname'].'
						<br><b>Klíč: </b>'.$data['klic'].'</td>
					</tr>';
				} else {
					$out .= '<tr>
						<td>'.$data['id'].'</td>
						<td>'.$data['Name'].'</td>
						<td>'.$data['Surname'].'</td>
						<td>'.$data['klic'].'</td>
					</tr>';
				}
			}
			$out .= '</table><table class="regkeysAction">
			<tr>
				<td>
					<h2>Přidat uživatele</h2>
					<form method="post">
						'.$addUserKey.'
						<table style="border-bottom: none;">
							<tr>
								<td>Jméno: </td>
								<td><input type="text" name="addUserKey-Name"></td>
							</tr>
							<tr>
								<td>Přijmení: </td>
								<td><input type="text" name="addUserKey-Surname"></td>
							</tr>
							<tr><td align="center" colspan="2"><input type="submit" name="addUserKey" value="Přidat uživatelský klíč"></td></tr>
						</table>
					</form>
				</td>
				<td>
					<h2>Odebrání uživatele</h2>
					<form method="post">
						'.$delUserKey.'
						<table style="border-bottom: none;">
							<tr>
								<td>Jméno: </td>
								<td><input type="text" name="delUserKey-Name"></td>
							</tr>
							<tr>
								<td>Přijmení: </td>
								<td><input type="text" name="delUserKey-Surname"></td>
							</tr>
							<tr><td align="center" colspan="2"><input type="submit" name="delUserKey" value="Odebrat uživatelský klíč"></td></tr>
						</table>
					</form>
				</td>
			</tr>';
		} else {
			$out = '<table>
				<caption>
					<div id="caption">
						Nebyla zadána vlastnost zobrazení nebo nejsi administrátor<br>
						<img src="data/images/errorGetData.png" alt="Nebyla zadána vlastnost zobrazení nebo nejsi administrátor" title="Nebyla zadána vlastnost zobrazení nebo nejsi administrátor">
					</div>
				</caption>';
		}
		return $out.'</table>';
	}
?>