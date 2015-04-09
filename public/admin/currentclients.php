<?php
	require_once('../../resources/core/init.php');

	if (LoginCheck::isLoggedInAsAdmin()) {
		$clients = new Clients();
		if (isset($_POST['delete_client']) && isset($_POST['client_username'])) {
			$clients->deleteClientFromPOST();
		}
		else {
			$allClients = $clients->getClients();
		}

		require_once(RESOURCE_DIR . '/views/current_clients.php');
	}
	else {
		header ('location: /admin.php');
	}
?>