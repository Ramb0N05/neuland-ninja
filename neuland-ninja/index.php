<?php
$page = 'new';

if (!empty($_GET['read'])) $page = 'read';
else if (!empty($_GET['create']) && $_GET['create'] == 1) $page = 'create';
else if (!empty($_GET['refs']) && $_GET['refs'] == 1) $page = 'refs';
else if (!empty($_GET['error'])) $page = 'error';

require_once('./db-conf.php');
require_once('./inc/functions.inc.php');
require_once('./inc/main.inc.php');
?>
