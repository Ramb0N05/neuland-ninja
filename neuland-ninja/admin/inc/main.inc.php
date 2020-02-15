<!DOCTYPE html>
<html>
<?php
	require_once('./inc/head.inc.php');
?>

    <body>
<?php
		require_once('./inc/nav.inc.php');
?>
		<div class="container">
<?php
			switch ($page) {
				case 'welcome':
					require_once('./inc/welcome.inc.php');
					break;
					
				case 'menu':
					require_once('./inc/menu/menu.inc.php');
					break;
				
				default:
					require_once('./inc/error.inc.php');
					break;
			}
?>
		</div>
    </body>
</html>
