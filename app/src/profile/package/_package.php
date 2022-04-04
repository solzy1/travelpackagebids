<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/app/src/_src.php';

	use Controllers\Countries; 
	use Controllers\States; 

	Class _Package {
		function __construct() {
			start_session();
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);
			$value = $validation->validateinput();
		}

		// CHECK AND CREATE COUNTRY
		private function create_country($country){
			$check_country = $this->country_exists($country);
			$country_id = isset($check_country->id) ? $check_country->id : 0; // if country exists, append country id, else append 0 

			// if country_id==0, then country doesn't exist
			if($country_id==0){
				$country = Countries::create($country);

				$country_id = isset($country->id) ? $country->id : $country_id;
			}

			return $country_id;
		}

		private function country_exists($country){
			$country = Countries::find_bycountry($country);

			return $country;
		}

		// CHECK AND CREATE COUNTRY
		public function create_state($state, $country){
			$check_state = $this->state_exists($state);
			$state_id = isset($check_state->id) ? $check_state->id : 0; // if state exists, append state id, else append 0 

			// if state_id==0, then state doesn't exist
			if($state_id==0){
				$country_id = $this->create_country($country); // check if country exists and return country_id
				$state = States::create($country_id, $state); // create state_id

				$state_id = isset($state->id) ? $state->id : $state_id;
			}

			return $state_id;
		}

		private function state_exists($state){
			$state = States::find_bystate($state);

			return $state;
		}

		// configure and switch dates
		public function configure_date($from_date, $to_date, $format){
			if($from_date > $to_date){
				$to__date = $from_date;

				$from_date = $to_date;
				$to_date = $to__date;
			}

			$from_date = date($format, $from_date);
			$to_date = date($format, $to_date);
			
			return array('from_date' => $from_date, 'to_date' => $to_date);
		}
	}
?>