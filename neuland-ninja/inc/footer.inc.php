<footer>
    <ul class="navListH">
        <li><a href="/" target="_self" class="internalLink">Neue Ninja-Nachricht schreiben</a></li>
        <li><a href="index.php?refs=1" target="_self" class="internalLink">Quellenangaben</a></li>
		<?php if (checkPermission($mysqli, getClientCert()['CN'], 'admin.controlPanel.access')) { ?> <li><a href="admin/index.php" target="_blank" class="internalLink">Administration</a></li> <?php } ?>
    </ul>
</footer>
