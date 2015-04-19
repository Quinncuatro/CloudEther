<?php
	require_once('../resources/core/init.php');

	if (LoginCheck::isLoggedInAsAdmin() || LoginCheck::isLoggedIn()) {
		if (isset($_POST['change_password'])) {
			$changePW = new ChangePW();

			if (LoginCheck::isLoggedInAsAdmin()) {
				$changePW->setAdminPWFromPost();
			}
			elseif (LoginCheck::isLoggedIn()) {
				$changePW->setClientPWFromPost();
			}	
		}
			
		require_once(RESOURCE_DIR . 'views/change_password.php');
	}
	else {
		header('location: /account.php');
	}