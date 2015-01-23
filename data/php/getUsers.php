<?php
	function getUsers(){
		global $mysqli, $detect;
		$isAdmin = $mysqli->query("SELECT isAdmin FROM cloud_users WHERE username='".getNick()."'")->fetch_row();
		if($isAdmin[0] == 'true'){
			$out = '<table>';
			if(!$detect->isMobile()) $out .= '<tr><th>Jméno</th><th>Přijmení</th><th>Nick</th><th>Mail</th><th>IP registrace</th><th>Věk</th><th>Je administrátor?</th></tr>';
			$request = $mysqli->query("SELECT Jmeno, Prijmeni, username, Mail, IPregistrace, vek, isAdmin FROM cloud_users");
			while($data = $request->fetch_assoc()){
				if($data['isAdmin'] == 'true') $isAdmin = 'Ano'; else $isAdmin = 'Ne';
				if($detect->isMobile() && !$detect->isTablet()){
					$out .= '<tr>
						<td><b>Jméno a přijmení: </b>'.$data['Jmeno'].' '.$data['Prijmeni'].'
						<br><b>Nick: </b>'.$data['username'].'
						<br><b>Mail: </b>'.$data['Mail'].'
						<br><b>IP registrace: </b>'.$data['IPregistrace'].'
						<br><b>Věk: </b>'.$data['vek'].'
						<br><b>Je administrátor: </b>'.$isAdmin.'</td>
					</tr>';
				} else { 
					$out .= '<tr>
						<td>'.$data['Jmeno'].' </td>
						<td>'.$data['Prijmeni'].'</td>
						<td>'.$data['username'].'</td>
						<td>'.$data['Mail'].'</td>
						<td>'.$data['IPregistrace'].'</td>
						<td>'.$data['vek'].'</td>
						<td align="center">'.$isAdmin.'</td>
					</tr>';
				}
			}
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