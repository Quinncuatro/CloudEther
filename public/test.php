<?php
	echo '<pre>';
	require_once('../resources/core/init.php');
	$_SESSION['user_name'] = 'mprahl';
	$manageHub = new ManageHub();
	print_r( $manageHub->createHub('The Best Hub', $_SESSION['user_name']) );
?>