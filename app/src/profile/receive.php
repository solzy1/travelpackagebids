<?php
	// include the login file that holds the class Login
	require_once 'create.php';
	require_once 'update.php';
	require_once 'model.php';
	
	if(isset($_POST['country']) && isset($_POST['phone']) && isset($_POST['name'])){
		$profile = new Profile($_POST['country'], $_POST['name'], $_POST['phone'], $_POST['profile_id'], $_POST['profile_phonecode']);
    
		if(!empty($_POST['profile_id'])){
			$update_profile = new Update_Profile($profile);

			$update_profile->update();
		}
		else{
			$create_profile = new Create_Profile($profile);

			$create_profile->create();
		}
	}
	else{
	    header("Location: https://travelpackagebids.com/user/profile.php?user=member");
	}
?>