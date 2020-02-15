<?php
$action = $_GET['action'];
$itemID = $_GET['itemID'];

if ($action && !is_empty($action)) {
	switch ($action) {
		case 'add':
			require_once('./inc/menu/menu.itemForm.inc.php');
			break;
			
		case 'edit':
			if ($itemID >= 0) 
				require_once('./inc/menu/menu.itemForm.inc.php');
			break;
			
		case 'delete':
			if ($itemID >= 0)
				require_once('./inc/menu/menu.itemDelete.inc.php');
			break;
			
		case 'order':
			if ($itemID >= 0)
				require_once('./inc/menu/menu.itemOrder.inc.php');
			break;
			
		default:
			require_once('./inc/menu/menu.itemOverview.inc.php');
			break;
	}
} else
	require_once('./inc/menu/menu.itemOverview.inc.php');
?>