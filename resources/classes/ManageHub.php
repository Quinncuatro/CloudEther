<?php
	Class ManageHub {
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
	            FlashMessage::flash('ManageHubError', sanitize($message));
	            header('Location: /client/manage.php');
	            exit();
	        }
	    }

		private function createHub($hubName, $username) {
			if (isset($hubName, $username)) {
				// Replace spaces with underscores
				$hubName = str_replace(" ", "_", $hubName);
				if (!empty(CREATE_HUB_SCRIPT)) {
					exec(CREATE_HUB_SCRIPT . ' "' . $hubName . '"', $outputArray, $return_val);
					if ($return_val == 0) {
						// Cycle through the output
						foreach ($outputArray as $output) {
							// If the array is at the password block
							if (strpos($output, 'Password: ') !== false) {
								$password = Crypto::cust_encrypt(str_replace('Password: ', '', $output));
								$stmt = $this->db_connection->prepare('SELECT id FROM clients WHERE username = ?');
								if ($stmt->execute(array($username))) {
									if ($userid = $stmt->fetchColumn()) {
										$stmt = null;
										$stmt = $this->db_connection->prepare('SELECT null FROM hubs WHERE name = ? AND client_id_fk = ?');
										if ($stmt->execute(array($hubName, $userid))) {
											if ($stmt->rowCount() == 0) {
												$stmt = null;
												$stmt = $this->db_connection->prepare('INSERT INTO hubs (name, password, client_id_fk, created) VALUES (?, ?, ?, ?)');
												if ($stmt->execute(array($hubName, $password, $userid, date('Y-m-d H:i:s')))) {
													return true;
												}
												else {
													throw new Exception('The hub creation failed due to a database error');
												}
											}
											else {
												throw new Exception('The hub ' . $hubName . ' already exists');
											}
										}
										else {
											throw new Exception('The hub creation failed due to a database error');
										}
									}
									else {
										throw new Exception('The hub creation failed due to a database error');
									}
								}
								else {
									throw new Exception('The hub creation failed due to a database error');
								}

								return $password;
							}
						}
					}
					elseif ($return_val == 2) {
						throw new Exception('The hub name is already in use');
					}
				}
			}

			throw new Exception('The hub ' . $hubName . ' failed to be created');
		}

		public function createHubFromPost() {
			if (isset($_POST['create_hub'], $_POST['hub_name'])) {
				try {
					$this->createHub($_POST['hub_name'], $_SESSION['user_name']);
					FlashMessage::flash('ManageHubMessage', sanitize('The hub ' . $_POST['hub_name'] . ' was created' ));
		            header('Location: /client/manage.php');
		            exit();
				}
				catch (exception $e) {
					$this->setErrorAndQuit($e->getMessage());
				}
				
			}
			else {
				$this->setErrorAndQuit('The required fields were not provided');
			}

			$this->setErrorAndQuit('The hub ' . $_POST['hub_name'] . ' could not be added');
		}

		public function getHub($hubName) {
			if (isset($hubName)) {
				$stmt = $this->db_connection->prepare('SELECT * FROM hubs WHERE name = ?');
				if ($stmt->execute(array($hubName))) {
					if ($hub = $stmt->fetch(PDO::FETCH_ASSOC)) {
						if (isset($hub['password'])) {
							// Decrypt the hub password
							$hub['password'] = Crypto::cust_decrypt($hub['password']);
						}
						return $hub;
					}
				}
			}

			return false;
		}

		public function getHubs() {
			if ($stmt = $this->db_connection->query('SELECT * FROM hubs')) {
				if ($hubs = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
					$allHubs = array();
					foreach ($hubs as $hub) {
						if (isset($hub['password'])) {
							// Decrypt the hub password
							$hub['password'] = Crypto::cust_decrypt($hub['password']);
						}

						$allHubs[] = $hub;
					}

					return $allHubs;
				}
			}

			return array();
		}

		public function getClientHubs($username) {
			if (isset($username)) {
				$stmt = $this->db_connection->prepare('SELECT id FROM clients WHERE username = ?');
				if ($stmt->execute(array($username))) {
					$userid = null;
					if ($userid = $stmt->fetchColumn()) {
						if ($stmt = $this->db_connection->query('SELECT * FROM hubs WHERE client_id_fk = ' . $userid)) {
							if ($hubs = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
								$allHubs = array();
								foreach ($hubs as $hub) {
									if (isset($hub['password'])) {
										// Decrypt the hub password
										$hub['password'] = Crypto::cust_decrypt($hub['password']);
									}

									$allHubs[] = $hub;
								}

								return $allHubs;
							}
						}
					}
				}
			}

			return array();
		}

		public function deleteHub($hubName, $username) {
			if (isset($hubName, $username)) {
				if (!empty(DELETE_HUB_SCRIPT)) {
					exec(DELETE_HUB_SCRIPT . ' "' .  $hubName . '"', $outputArray, $return_val);
					if ($return_val == 0) {
						$stmt = $this->db_connection->prepare('SELECT id FROM clients WHERE username = ?');
						if ($stmt->execute(array($username))) {
							$userid = null;
							if ($userid = $stmt->fetchColumn()) {
								$stmt = null;
								$stmt = $this->db_connection->prepare('DELETE FROM hubs WHERE client_id_fk = ? AND name = ?');
								if ($stmt->execute(array($userid, $hubName))) {
									return true;
								}
							}
						}
					}
				}
			}

			return false;
		}

		public function deleteHubFromPost() {
			if (isset($_POST['delete_hub'], $_POST['hub_name'])) {
				if ($this->deleteHub($_POST['hub_name'], $_SESSION['user_name'])) {
					FlashMessage::flash('ManageHubMessage', sanitize('The hub ' . $_POST['hub_name'] . ' was deleted' ));
		            header('Location: /client/manage.php');
		            exit();
				}
			}
			else {
				$this->setErrorAndQuit('The required fields were not provided');
			}

			$this->setErrorAndQuit('The hub ' . $_POST['hub_name'] . ' could not be deleted');
		}

		public function getHubStatus($hubName) {
			if (isset($hubName) && !empty(HUB_STATUS_SCRIPT)) {
				exec(HUB_STATUS_SCRIPT . ' -g "' .  $hubName . '"', $outputArray, $return_val);
				if ($return_val == 6) {
					return true;
				}
			}

			return false;
		}

	}
