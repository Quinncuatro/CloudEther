<?php
	require_once('../resources/core/init.php');

	if(isset($_POST['InputSubmit'])) {
		require_once(RESOURCE_DIR . 'functions/sendEmail.php');
		// Send email
		if (isset($_POST['InputName'], $_POST['InputEmail'], $_POST['InputMessage'])) {
			$body = 'From: ' . sanitize($_POST['InputName']) . '<br />' . 
					'From Email: ' . sanitize($_POST['InputEmail']) . '<br />' . 
					'Message: ' . sanitize($_POST['InputMessage']);
			if (sendEmail($body)) {
				FlashMessage::flash('ContactSuccess', 'The email message was sent. You should hear a response within 24 hours.');
			}
			else {
				FlashMessage::flash('ContactError', 'The email could not be sent. Please contact ' . sanitize(Config::get('email/to')) . ' directly.');
			}

			header('Location: /contact.php');
            exit();
				
		}
	}

	require_once(RESOURCE_DIR . 'views/contact.php');