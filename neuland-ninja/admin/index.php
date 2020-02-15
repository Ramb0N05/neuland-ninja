<?php
$page = 'welcome';

if (!empty($_GET['page'])) $page = $_GET['page'];
else if (!empty($_GET['error'])) $page = 'error';

require_once('../db-conf.php');
require_once('../inc/functions.inc.php');
require_once('./inc/acpFunctions.inc.php');
require_once('./inc/main.inc.php');
?>
