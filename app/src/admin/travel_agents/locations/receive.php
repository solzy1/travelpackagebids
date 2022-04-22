<?php
	// include the login file that holds the class Login
	require_once 'create.php';
	require_once 'model.php';
	
	if(isset($_POST['user_id']) && isset($_POST['country']) && isset($_POST['phone_code'])){
		$location = new Locations($_POST['user_id'], $_POST['country'], $_POST['phone_code'], $_POST['state']);

		$create = new Create_Location($location);

		$create->create();
	}
	else{
		echo 'failure';
	}
?>