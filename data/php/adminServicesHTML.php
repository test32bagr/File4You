<?php
	function adminServices(){
		global $mysqli;
		$isAdmin = $mysqli->query("SELECT isAdmin FROM cloud_users WHERE username='".getNick()."'")->fetch_row();
		
		if($isAdmin[0] == 'true'){
			return '<div id="adminServices">
				<table>
					<thead><h2>Řízení systému</h2></thead>
					<tbody>
						<tr>
							<td>Seznam registračních klíčů: </td>
							<td><a href="regkeys.php"><img src="data/images/regKey.png" alt="Registrační klíče" title="Registrační klíče"></a></td>
						</tr>
						<tr>
							<td>Seznam registrovaných uživatelů: </td>
							<td><a href="regusers.php"><img src="data/images/users.png" alt="Registrovaní uživatelé" title="Registrovaní uživatelé"></a></td>
						</tr>
						<tr>
							<td>Řízení uživatelských účtů: </td>
							<td><a href="uac.php"><img src="data/images/uac.png" alt="Řízení uživatelských účtů" title="Řízení uživatelských účtů"></a></td>
						</tr>
						<tr>
							<td>Logovací soubor</td>
							<td><a href="log.php"><img src="data/images/log.png" alt="Logoací soubor" title="Logovací soubor"></a></td>
						</tr>
					</tbody>
				</table>
			</div>
			';
		} elseif($isAdmin[0] == 'false'){ 
			return '<div id="adminServices">
				<table>
					<thead><h2>Řízení systému</h2></thead>
					<tbody>
						<tr>
							<td>Řízení uživatelského účtu: </td>
							<td><a href="uac.php"><img src="data/images/uac.png" alt="Řízení uživatelských účtů" title="Řízení uživatelských účtů"></a></td>
						</tr>
					</tbody>
				</table>
			</div>'; 
		}
	}
?>