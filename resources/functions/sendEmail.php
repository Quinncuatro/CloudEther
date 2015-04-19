<?php
	require_once(RESOURCE_DIR . 'classes/PHPMailer/PHPMailerAutoload.php');	

	function sendEmail($body, $showExceptions = false) {
		if (isset($body)) {
			$from = Config::get('email/from');
			$to = Config::get('email/to');
			$username = Config::get('email/username');
			$password = Config::get('email/password');
			$fromName = Config::get('email/fromName');
			$server = Config::get('email/server');
			$port = Config::get('email/port');
			$encryption = Config::get('email/encryption');
			$emailSubject = Config::get('email/emailSubject');
			
			if (isset($from, $to, $username, $password, $fromName, $server, $encryption, $emailSubject)) {
				$mail = new PHPMailer($showExceptions);
				$mail->isSMTP();
				$mail->Host = $server;
				$mail->SMTPAuth = true;
				$mail->Username = $username;
				$mail->Password = $password;

				if (strtoupper($encryption) == 'TLS') {
					$mail->SMTPSecure = 'tls';
				}
				elseif (strtoupper($encryption) == 'SSL') {
					$mail->SMTPSecure = 'ssl';
				}
				
				$mail->Port = $port;
				$mail->From = $from;
				$mail->FromName = $fromName;
				$mail->addAddress($to);
				$mail->addReplyTo($from, $fromName);
				$mail->isHTML(true);
				$mail->Subject = $emailSubject;
				$mail->Body = $body;

				if($mail->send()) {
				    return true;
				}
			}
		}

		return false;
	}