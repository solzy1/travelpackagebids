<?php
	// include the login file that holds the class Login
	require_once '_packages.php';
	
	if(isset($_POST['id']) && isset($_POST['status'])){
		$package = new _Packages();

		$package->update_status($_POST['id'], $_POST['status']);
	}
	else{
		echo 'failure';
	}
?>