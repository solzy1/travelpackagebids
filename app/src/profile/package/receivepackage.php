<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

	// include the login file that holds the class Login
	require_once 'create.php';
	require_once 'model.php';

	$package = new Package($_POST['country'], $_POST['state'], $_POST['people'], $_POST['from_date'], $_POST['to_date'], $_POST['description']); // package model

	$create_package = new Create($package);
 
	$create_package->create();
?>