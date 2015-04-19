<?php
	require_once(__DIR__ . '/../core/init.php');

	Class Clients {
		private $db_connection;

		public function __construct() {
			if (!$this->db_connection = startPDOConnection()) {
				echo '<h2>Database Is Down For Maintenace</h2>';
				echo '<h4>Please Try Again Later</h4>';
				die();
			}
		}

		private function setErrorAndQuit($message) {
            if (isset($message)) {
                FlashMessage::flash('ClientsError', $message);
                header('Location: /admin/currentclients.php');
                exit();
            }
        }

		public function getClients() {
			if ($stmt = $this->db_connection->query('SELECT username, email, name, created FROM clients')) {
				if ($results = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
					return $results;
				}
			}
			
			return array();
		}

		private function deleteClient($username) {
			if (isset($username)) {
				$stmt = $this->db_connection->prepare('SELECT id FROM clients WHERE username = ?');
				if ($stmt->execute(array($username))) {
					if ($userid = $stmt->fetchColumn()) {
						$stmt = null;
						$stmt = $this->db_connection->prepare('DELETE FROM hubs WHERE client_id_fk = ?');
						if ($stmt->execute(array($userid))) {
							$stmt = $this->db_connection->prepare('DELETE FROM clients WHERE id = ?');
							if ($stmt->execute(array($userid))) {
								return true;
							}
						}
					}
				}				
			}

			return false;
		}

		public function deleteClientFromPOST() {
			if (isset($_POST['client_username'])) {
				if ($this->deleteClient($_POST['client_username'])) {
					FlashMessage::flash('ClientsMessage', 'The client ' . sanitize($_POST['client_username']) . ' was successfully deleted');
	                header('Location: /admin/currentclients.php');
	                exit();
				}
				$this->setErrorAndQuit('The client ' . sanitize($_POST['client_username']) . ' could not be deleted due to a database error');
			}

			$this->setErrorAndQuit('The client could not be deleted due to a submission error');
			exit();
		}
	}