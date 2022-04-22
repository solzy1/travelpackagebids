<?php
	// include the login file that holds the class Login
	require_once 'list.php';
	require_once 'model.php';
	
	if(isset($_POST['user_id'])){
		$location = new Locations($_POST['user_id'], '', '', '');

		$list = new List_Locations($location);

		$list->show();
	}
	else{
		echo 'failure';
	}
?>