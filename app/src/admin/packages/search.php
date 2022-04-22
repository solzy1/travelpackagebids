<?php
	// include the login file that holds the class Login
	require_once '_packages.php';
	
	if(isset($_POST['search'])){
		$package = new _Packages();

		$package->search($_POST['search'], $_POST['filter']);
	}
?>