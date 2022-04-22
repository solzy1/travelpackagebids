<?php
//   

	// include the login file that holds the class Login
	require_once '_package.php';
	
	if(isset($_POST['package_id'])){
		$package = new _Package();

		$package->delete_package($_POST['package_id']);
	}
?>