<?php
    
    
    

	// include the login file that holds the class Login
	require_once 'create.php';
	require_once 'update.php';
	require_once 'model.php';

	$package = new Package($_POST['country'], $_POST['state'], $_POST['people'], $_POST['from_date'], $_POST['to_date'], $_POST['description'], $_POST['package_phonecode'], $_POST['package_id']); // package model

	if(!empty($_POST['package_id'])){
		$update_package = new Update($package);
	 
		$update_package->update();
	}
	else{
		$create_package = new Create($package);
	 
		$create_package->create();
	}
?>