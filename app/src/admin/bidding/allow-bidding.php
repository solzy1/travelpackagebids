<?php
	// include the login file that holds the class Login
	require_once '_bidding.php';
	
	if(isset($_POST['id']) && isset($_POST['status'])){
		$bidding = new _Bidding($_POST['id'], $_POST['status']);

		if(is_array($_POST['id'])){
			$bidding->allow_multiplebidding();
		}
		else{
			$bidding->allow_bidding();
		}
	}
	else{
		echo 'failure';
	}
?>