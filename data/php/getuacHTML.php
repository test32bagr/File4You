<?php
	function getuacHTML(){
		global $mysqli, $option2, $setAdminVysledek, $deleteAccountVysledek, $deleteFileVysledek, $zmenitNickVysledek, $zmenitHesloVysledek, $zmenitMailVysledek, $smazatMujUcetVysledek;
		
		$isAdmin = $mysqli->query("SELECT isAdmin FROM cloud_users WHERE username='".getNick()."'")->fetch_row();
		
		$out = '<table>';
		if($isAdmin[0] == 'true'){
			$out .= '<h2 id="nadpis">Řízení uživatelských účtů a souborů.</h2><tr>
				<td class="adminServices">
					<h2>Upravit administrátorská práva</h2>
					<form method="POST">
						<table>
							<tr><td>Nick uživatele: </td><td colspan="2"><input type="text" name="setAdmin_nick"></td></tr>
							<tr><td>Nastavit oprávnění: </td><td><input type="radio" name="setAdmin_whatSet" value="Ano">Je administrátor</td><td><input type="radio" name="setAdmin_whatSet" value="Ne" checked>Není administrátor</td></tr>
							<tr align="center"><td colspan="2">'.$setAdminVysledek.'</td><td><input type="submit" name="ApplyChanges_setAdmin" value="Nastavit oprávnění"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class="adminServices">
					<h2>Smazat účet</h2>
					<form method="POST">
						<table>
							<tr><td>Nick uživatele: </td><td><input type="text" name="deleteAccount_Nick"></td></tr>
							<tr align="center"><td>'.$deleteAccountVysledek.'</td><td><input type="submit" name="ApplyChanges_deleteAccount" value="Smazat účet"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class="adminServices">
					<h2>Smazat soubor</h2>
					<form method="POST">
						<table>
							<tr><td>Nick souboru: </td><td><input type="text" name="deleteFileNick"></td></tr>
							<tr align="center"><td>'.$deleteFileVysledek.'</td><td><input type="submit" name="ApplyChanges_deleteFile" value="Smazat soubor"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr><td><h2 id="nadpis">Nastavení aktuálního účtu</h2></td></tr>
			<tr>
				<td class="adminServices">
					<h2>Změnit nick</h2>
					<form method="POST">
						<table>
							<tr><td>Aktuální nick: </td><td><input type="text" name="editNickOldNick" value="'.getNick().'" readonly></td></tr>
							<tr><td>Nový nick: </td><td><input type="text" name="editNickNewNick"></td></tr>
							<tr align="center"><td>'.$zmenitNickVysledek.'</td><td><input type="Submit" name="ApplyChanges_zmenitNick" value="Změnit nick"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class="adminServices">
					<h2>Změnit heslo</h2>
					<form method="POST">
						<table>
							<tr><td>Staré heslo: </td><td><input type="password" name="editPassOldPass"></td></tr>
							<tr><td>Nové heslo: </td><td><input type="password" name="editPassNewPass"></td></tr>
							<tr align="center"><td>'.$zmenitHesloVysledek.'</td><td><input type="Submit" name="ApplyChanges_zmenitHeslo" value="Změnit heslo"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class="adminServices">
					<h2>Změnit mail</h2>
					<form method="POST">
						<table>
							<tr><td>Nový mail: </td><td><input type="email" name="editMailNewMail"></td></tr>
							<tr align="center"><td>'.$zmenitMailVysledek.'</td><td><input type="Submit" name="ApplyChanges_zmenitMail" value="Změnit heslo"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class="adminServices">
					<h2>Smazat svůj účet</h2>
					<form method="POST">
						<table>
							<tr><td>Tvoje heslo: </td><td><input type="password" name="deleteMyAccountPass"></td></tr>
							<tr align="center"><td>'.$smazatMujUcetVysledek.'</td><td><input type="submit" name="ApplyChanges_deleteMyAccount" value="Smazat účet"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			';
		} elseif($isAdmin[0] == 'false') {
			$out .= '<h2 id="nadpis">Nastavení uživatelského účtu</h2>
			<tr>
				<td class="adminServices">
					<h2>Změnit nick</h2>
					<form method="POST">
						<table>
							<tr><td>Aktuální nick: </td><td><input type="text" name="editNickOldNick" value="'.getNick().'" readonly></td></tr>
							<tr><td>Nový nick: </td><td><input type="text" name="editNickNewNick"></td></tr>
							<tr align="center"><td>'.$zmenitNickVysledek.'</td><td><input type="Submit" name="ApplyChanges_zmenitNick" value="Změnit nick"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class="adminServices">
					<h2>Změnit heslo</h2>
					<form method="POST">
						<table>
							<tr><td>Staré heslo: </td><td><input type="password" name="editPassOldPass"></td></tr>
							<tr><td>Nové heslo: </td><td><input type="password" name="editPassNewPass"></td></tr>
							<tr align="center"><td>'.$zmenitHesloVysledek.'</td><td><input type="Submit" name="ApplyChanges_zmenitHeslo" value="Změnit heslo"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class="adminServices">
					<h2>Změnit mail</h2>
					<form method="POST">
						<table>
							<tr><td>Nový mail: </td><td><input type="email" name="editMailNewMail"></td></tr>
							<tr align="center"><td>'.$zmenitMailVysledek.'</td><td><input type="Submit" name="ApplyChanges_zmenitMail" value="Změnit heslo"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td class="adminServices">
					<h2>Smazat svůj účet</h2>
					<form method="POST">
						<table>
							<tr><td>Tvoje heslo: </td><td><input type="password" name="deleteMyAccountPass"></td></tr>
							<tr align="center"><td>'.$smazatMujUcetVysledek.'</td><td><input type="submit" name="ApplyChanges_deleteMyAccount" value="Smazat účet"></td></tr>
						</table>
					</form>
				</td>
			</tr>
			';
		}
		return $out.'</table>';
	}
?>