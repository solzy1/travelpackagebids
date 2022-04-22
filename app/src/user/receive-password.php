<?php 
	require_once 'verifyuser.php';
	require_once 'forgot-password.php';
	require_once 'model.php';


	if(isset($_POST['password']) && isset($_POST['re_password']) && isset($_POST['key'])){
	    
    	$user = new User('', $_POST['password'], $_POST['re_password']);
    	
	    if(isset($_SESSION['travelpackagebids.com']['reset_email'])){
            // remove the reset_email
            // unset($_SESSION['travelpackagebids.com']['reset_email']);
            
            // reset email
    		$forgotpassword = new Forgotpassword($user);
    
    		$forgotpassword->reset_password($_POST['key']);
	    }
	    else{
    		$password = new VerifyUser($_POST['key'], $user);
    
    		$password->check();
	    }
	}
?>