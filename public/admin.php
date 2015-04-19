<?php
	require_once('../resources/core/init.php');
	if (isset($_POST['admin_login']) || isset($_GET['logout'])) {
		$login = new AdminLogin();
	}

	if (LoginCheck::isLoggedInAsAdmin()) {
		header ('location: /admin/currentclients.php');
	}
	elseif (LoginCheck::isLoggedIn()) {
		header ('location: /account.php');
	}
	else {
		require_once(RESOURCE_DIR . '/views/not_logged_in_admin.php');
	}
