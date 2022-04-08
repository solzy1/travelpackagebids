<?php 
	require_once '_user.php';

	if(isset($_POST['logout']) && $_POST['logout']=='yes'){
		$user = new _User();

		$user->logout();
	}
?>