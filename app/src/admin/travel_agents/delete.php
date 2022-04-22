<?php
	// include the login file that holds the class Login
	require_once '_travel_agents.php';
	
	if(isset($_POST['id'])){
		$travel_agents = new _Travel_Agents();

		$travel_agents->delete_user($_POST['id']);
	}
	else{
		echo 'failure';
	}
?>