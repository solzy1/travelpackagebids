<?php
	// include the login file that holds the class Login
	require_once '_travel_agents.php';
	
	if(isset($_POST['id']) && isset($_POST['status'])){
		$travel_agents = new _Travel_Agents();

		$travel_agents->update_status($_POST['id'], $_POST['status']);
	}
	else{
		echo 'failure';
	}
?>