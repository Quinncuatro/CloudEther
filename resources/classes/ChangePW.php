<?php
	Class ChangePW {
		private $db_connection;

		public function __construct() {
			if (!$this->db_connection = startPDOConnection()) {
				echo '<h2>Database Is Down For Maintenace</h2>';
				echo '<h4>Please Try Again Later</h4>';
				die();
			}
		}

		protected function setErrorAndQuit($message) {
            if (isset($message)) {
                FlashMessage::flash('ChangePWError', $message);
                header('Location: /changepw.php');
                exit();
            }
        }

		public function setClientPW($username, $password) {
			if (isset($username, $password)) {
				$password_hash = password_hash($password, PASSWORD_DEFAULT);

				$stmt = $this->db_connection->prepare('UPDATE clients SET password = ? WHERE username = ?');
				if ($stmt->execute(array($password_hash, $username))) {
					if ($stmt->rowCount() == 1) {
						return true;
					}
				}
			}

			return false;
		}

		public function setAdminPW($username, $password) {
			if (isset($username, $password)) {
				$password_hash = password_hash($password, PASSWORD_DEFAULT);

				$stmt = $this->db_connection->prepare('UPDATE admin SET password = ? WHERE username = ?');
				if ($stmt->execute(array($password_hash, $username))) {
					if ($stmt->rowCount() == 1) {
						return true;
					}
				}
			}

			return false;
		}

		private function verifyClientPW($username, $password) {
			if (isset($username, $password)) {
				$stmt = $this->db_connection->prepare('SELECT password FROM clients WHERE username = ?');
				if ($stmt->execute(array($username))) {
					if ($hashed_password = $stmt->fetchColumn()) {
						if (password_verify($password, $hashed_password)) {
							return true;
						}
					}
				}				
			}

			return false;
		}

		private function verifyAdminPW($username, $password) {
			if (isset($username, $password)) {
				$stmt = $this->db_connection->prepare('SELECT password FROM admin WHERE username = ?');
				if ($stmt->execute(array($username))) {
					if ($hashed_password = $stmt->fetchColumn()) {
						if (password_verify($password, $hashed_password)) {
							return true;
						}
					}
				}				
			}

			return false;
		}

		public function setClientPWFromPost() {
			if (isset($_POST['user_currentpassword'], $_POST['user_newpassword'], $_POST['user_repeatpassword'], $_SESSION['user_name'])) {
				if ($this->verifyClientPW($_SESSION['user_name'], $_POST['user_currentpassword'])) {
					if ($_POST['user_newpassword'] == $_POST['user_repeatpassword']) {
						if ($this->setClientPW($_SESSION['user_name'], $_POST['user_newpassword'])) {
							FlashMessage::flash('ChangePWSuccess', 'Your password was changed successfully');
							header('Location: /changepw.php');
							exit();
						}
						else {
							$this->setErrorAndQuit('Your password could not be changed due to a database error. Please try again.');
						}
					}
					else {
						$this->setErrorAndQuit('The passwords you entered did not match. Please try again.');
					}
				}
				else {
					$this->setErrorAndQuit('The password you entered was incorrect. Please try again.');
				}
			}
			else {
				$this->setErrorAndQuit('The required fields were not filled in.');
			}

			$this->setErrorAndQuit('Your password could not be changed.');
		}

		public function setAdminPWFromPost() {
			if (isset($_POST['user_currentpassword'], $_POST['user_newpassword'], $_POST['user_repeatpassword'], $_SESSION['user_name'])) {
				if ($this->verifyAdminPW($_SESSION['user_name'], $_POST['user_currentpassword'])) {
					if ($_POST['user_newpassword'] == $_POST['user_repeatpassword']) {
						if ($this->setAdminPW($_SESSION['user_name'], $_POST['user_newpassword'])) {
							FlashMessage::flash('ChangePWSuccess', 'Your password was changed successfully');
							header('Location: /changepw.php');
							exit();
						}
						else {
							$this->setErrorAndQuit('Your password could not be changed due to a database error. Please try again.');
						}
					}
					else {
						$this->setErrorAndQuit('The passwords you entered did not match. Please try again.');
					}
				}
				else {
					$this->setErrorAndQuit('The password you entered was incorrect. Please try again.');
				}
			}
			else {
				$this->setErrorAndQuit('The required fields were not filled in.');
			}

			$this->setErrorAndQuit('Your password could not be changed.');
		}

	}
