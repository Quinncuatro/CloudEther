<?php
	require_once('../../resources/core/init.php');

	if (LoginCheck::isLoggedInAsAdmin()) {
		header ('location: /admin.php');
	}
	elseif (LoginCheck::isLoggedIn()) {
		$manageHub = new ManageHub();
		if (isset($_POST['delete_hub'])) {
			$manageHub->deleteHubFromPost();
		}
		elseif (isset($_POST['create_hub'])) {
			$manageHub->createHubFromPost();
		}

		$allHubs = $manageHub->getClientHubs($_SESSION['user_name']);
		require_once(RESOURCE_DIR . '/views/manage.php');
	}
	else {
		header ('location: /account.php');
	}
