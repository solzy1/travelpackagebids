<?php
	// include the login file that holds the class Login
	require_once 'login.php';
	require_once 'signup.php';
	require_once 'model.php';
	// use User\Login;
	// use User\User;

	// pass the validated values to the receiving class (check if they're correct)
	if($_GET['form-type']!="Sign In")
		$_GET['pass'] = $_GET['form-type'].'-allow';

	$user = new User($_GET['email'], $_GET['pass']);

	if($_GET['form-type']=="Sign In") {
		$login = new Login($user);

		// allow/deny user access to profile page
		$login->allowuseraccess();
	}
	else if($_GET['form-type']=="Sign Up") {
		$signup = new Signup($user
		);

		$signup->createuser();
		// $signup->testemail('solzyfrenzy1@gmail.com');
	}
	else {
		
	}
?>