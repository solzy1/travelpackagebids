<?php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/start.php'; // start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/app/src/validation/validation.php'; // include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/app/src/_src.php';

	Class _Profile {
		function __construct() {
			start_session();
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);
			$value = $validation->validateinput();
		}

		function unset_responsevalues(){
			unset_responsevalues();
		}
	}
?>