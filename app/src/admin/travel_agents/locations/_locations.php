<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

	use Controllers\Locations; 

	Class _Locations {
		function __construct() {

		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);
			$value = $validation->validateinput();

			return $value;
		}

		// DELETE
		public function delete($location_id, $is_country){
			$deleted = true;
			$location = Locations::find($location_id);

			if(isset($location->id)){
				if($is_country=='no'){
					$deleted = Locations::destroy($location_id);
				}
				else{
					if(isset($location->id)){
						$deleted = Locations::destroy_country($location->user_id, $location->country_id);
					}
				}

				if($deleted){
					echo $location->user_id;

					return;
				}
			}

			echo 'failure';

			return;
		}
	}
?>