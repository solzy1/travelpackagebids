<?php
	// start session
	start_session();

	// go to the specified url
	function gotopage($url){
		header("Location: ".$url);
	}

	// START SESSION, IF IT DOESN'T ALREADY EXIST
	function start_session(){
		if (session_status() == PHP_SESSION_NONE) {
	    	session_start();
	    }
	}

	// set the SESSION response, for the request and go the the specified page
	function reportfailure($statusmessage, $page = "sign-in"){
		// set response, to be shown to the user after page failure
		setresponse($statusmessage);

		gotopage('/travelpackagebids/user/'.$page.'.php');
	}

	function setresponse($response){
		$_SESSION['travelpackagebids.com']['status'] = $response;
	}

	// get the response
	function getresponse(){
		return isset($_SESSION['travelpackagebids.com']['status']) ? 
			$_SESSION['travelpackagebids.com']['status'] : '';
	}

	// rest session values
	function reset_sessionvalues(){
		unset($_SESSION['travelpackagebids.com']['status']);
	}

	function set_responsevalues($status, $is_success){
		$_SESSION['travelpackagebids.com']['status'] = $status;
        $_SESSION['travelpackagebids.com']['status_issuccess'] = $is_success;
	}

	function unset_responsevalues(){
		unset($_SESSION['travelpackagebids.com']['status']);
        unset($_SESSION['travelpackagebids.com']['status_issuccess']);
	}
?>