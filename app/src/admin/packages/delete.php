<?php
	// include the login file that holds the class Login
	require_once '_packages.php';
	
	if(isset($_POST['id'])){
		$package = new _Packages();

		$package->delete_package($_POST['id']);
	}
	else{
		echo 'failure';
	}
?>