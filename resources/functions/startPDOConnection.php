<?php
	require_once(__DIR__ . '/../core/init.php');
	function startPDOConnection() {
		try {
			$db_connection = new PDO(
						    Config::get('db/type') . ':host=' . Config::get('db/host') . ';dbname=' . Config::get('db/db_name') . ';charset=utf8',
						    Config::get('db/username'),
						    Config::get('db/password')
		    );
			$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db_connection;
		}
		catch (PDOException $e) {
			// Eventually log the exception
			return false;
		}
	}
