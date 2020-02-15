<?php
function getAcpMenuItems($mysqliConn) {
	$sql = "SELECT * FROM `acpMenuItems` ORDER BY `itemOrder`";
	$result = $mysqliConn->query($sql);
	
	if ($result && $result->num_rows > 0) {
		$i = 0;
		while ($data = $result->fetch_assoc()) {
			$items[$i] = $data;
			$i++;
		}
		
		return $items;
	} else return false;
}
?>