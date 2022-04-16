<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php'; // include the validation file that holds the class Validation
	
	if(isset($_POST['logout']) && $_POST['logout']=='yes'){
		start_session();

		if(isset($_SESSION['travelpackagebids.com']))
        	unset($_SESSION['travelpackagebids.com']);

        echo 'success';
	}
?>