	<table class="highlight centered responsive-table" style="margin-top: 0.5em;">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Anzeigename</th>
				<th>Seitenname</th>
				<th>Berechtigung</th>
				<th>Position</th>
				<th>Aufgaben</th>
			</tr>
		</thead>
		
		<tbody>
<?php
			$menuItems = getAcpMenuItems($mysqli);
			$lastItemID = count($menuItems) - 1;
			
			foreach ($menuItems as $i => $item) {
				echo('<tr id="acpItem_'.$item['name'].'">
						<td>'.$item['ID'].'</td>
						<td>'.$item['name'].'</td>
						<td>'.$item['displayName'].'</td>
						<td>'.$item['pageName'].'</td>
						<td>'.$item['permission'].'</td>
						<td>'.(($item['itemOrder'] === NULL) ? 'NULL' : $item['itemOrder']).'</td>
						<td>');
				
				if (checkPermission($mysqli, getClientCert()['CN'], 'admin.controlPanel.menu.edit')) echo('<a href="index.php?page=menu&edit='.$item['ID'].'"><img src="/admin/img/edit.png" alt="Men&uuml;eintrag bearbeiten" height="36" width="36"></a>');
				if (checkPermission($mysqli, getClientCert()['CN'], 'admin.controlPanel.menu.delete')) echo('<a href="index.php?page=menu&delete='.$item['ID'].'"><img src="/admin/img/remove.png" alt="Men&uuml;eintrag entfernen" height="36" width="36"></a>');
				
				if (checkPermission($mysqli, getClientCert()['CN'], 'admin.controlPanel.menu.order') && count($menuItems) > 1) {
					switch ($i) {
						case 0:
							echo('<img src="/admin/img/control_down.png" alt="Men&uuml;eintrag nach unten schieben" height="36" width="36">');
							echo('<img src="/admin/img/control_stop_down.png" alt="Men&uuml;eintrag an letzte Stelle schieben" height="36" width="36">');
							break;
						
						case $lastItemID:
							echo('<img src="/admin/img/control_stop_up.png" alt="Men&uuml;eintrag nach oben schieben" height="36" width="36">');
							echo('<img src="/admin/img/control_up.png" alt="Men&uuml;eintrag an erste Stelle schieben" height="36" width="36">');
							break;
							
						default:
							echo('<img src="/admin/img/control_stop_up.png" alt="Men&uuml;eintrag an erste Stelle schieben" height="36" width="36">');
							echo('<img src="/admin/img/control_up.png" alt="Men&uuml;eintrag nach oben schieben" height="36" width="36">');
							echo('<img src="/admin/img/control_down.png" alt="Men&uuml;eintrag nach unten schieben" height="36" width="36">');
							echo('<img src="/admin/img/control_stop_down.png" alt="Men&uuml;eintrag an letzte Stelle schieben" height="36" width="36">');
							break;
					}
				}
				
				echo('</td></tr>');
			}
?>
		</tbody>
	</table>
<?php
	if (checkPermission($mysqli, getClientCert()['CN'], 'admin.controlPanel.menu.add'))
		echo('<br><a href="index.php?page=menu&action=add" class="waves-effect waves-light btn"><i class="material-icons left">add</i>Hinzuf&uuml;gen</a>');
?>