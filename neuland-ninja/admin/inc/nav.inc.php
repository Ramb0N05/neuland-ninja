<nav class="nav-extended">
	<div class="nav-wrapper">
		<a id="acpBrand" href="/admin/" class="brand-logo">
			<div class="row">
				<img id="acpLogo" src="/img/ninja.svg" alt="NeulandNinja" height="64" width="64" class="col s1 m1 l1 xl1">
				<div id="acpCaption" class="col s10 m10 l10 xl10">Administration</div>
			</div>
		</a>
		
		<ul id="nav-mobile" class="right hide-on-med-and-down">
<?php
				$menuItems = getAcpMenuItems($mysqli);
				
				foreach ($menuItems as $item)
					if (checkPermission($mysqli, getClientCert()['CN'], $item['permission']))
							echo('<li id="acpItem_'.$item['name'].'"'.($item['pageName'] == $page ? ' class="active"' : '').'>
									<a href="index.php?page='.$item['pageName'].'" target="_self">'.$item['displayName'].'</a>
								  </li>');
?>
		</ul>
	</div>
	<div class="nav-content">
		<ul class="tabs tabs-transparent">
			<li class="tab">Test</li>
		</ul>
	</div>
</nav>