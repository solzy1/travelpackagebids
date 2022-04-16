<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

	use Controllers\Packages;
	use Controllers\Countries; 
	use Controllers\States; 

	Class _Packages {
		function __construct() {
			start_session();
		}

	}
?>