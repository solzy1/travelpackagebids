<?php 
	require_once 'verifyuser.php';
	require_once 'model.php';

	if(isset($_POST['password']) && isset($_POST['re_password']) && isset($_POST['key'])){
		$user = new User('', $_POST['password'], $_POST['re_password']);

		$password = new VerifyUser($_POST['key'], $user);

		$password->check();
	}
?>