<?php
	// include the login file that holds the class Login
	require_once '_locations.php';
	
	if(isset($_POST['location_id'])){
		$locations = new _Locations();

		$locations->delete($_POST['location_id'], $_POST['is_country']);
	}
	else{
		echo 'failure';
	}
?>