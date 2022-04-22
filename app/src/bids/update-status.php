<?php
	// include the login file that holds the class Login
	require_once '_bids.php';
	
	if(isset($_POST['id']) && isset($_POST['status'])){
		$bids = new _Bids();

		$bids->update_status($_POST['id'], $_POST['status']);
	}
	else{
		echo 'failure';
	}
?>