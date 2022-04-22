<?php
	// include the login file that holds the class Login
	require_once '_travel_agents.php';
	
	if(isset($_POST['search'])){
		$travel_agents = new _Travel_Agents();

		$travel_agents->search($_POST['search'], $_POST['filter']);
	}
?>