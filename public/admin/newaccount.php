<?php
	require_once('../../resources/core/init.php');

	if (LoginCheck::isLoggedInAsAdmin()) {
		if (isset($_POST["register"])) {
			$register = new Registration();
	        $register->registerNewUser();
	    }

		require_once(RESOURCE_DIR . '/views/new_account.php');
	}
	else {
		header ('location: /admin.php');
	}
?>