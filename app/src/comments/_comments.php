<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

	Class _Comments {
		private $user_id;

		function __construct() {
			start_session();

			$this->user_id = get_userid(); // get user id
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);
			return $validation->validateinput();
		}
	}
?>