<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';
	require_once 'model.php';

	use Controllers\Countries; 
	use Controllers\Packages; 
	use Controllers\States; 

	Class _Package {
		function __construct() {
			start_session();
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);
			$value = $validation->validateinput();

			return $value;
		}

		// CHECK AND CREATE COUNTRY
		private function create_country($country, $phone_code){
			$check_country = $this->country_exists($country);
			$country_id = isset($check_country->id) ? $check_country->id : 0; // if country exists, append country id, else append 0 

			// if country_id==0, then country doesn't exist
			if($country_id==0){
				$country = Countries::create($country, $phone_code);

				$country_id = isset($country->id) ? $country->id : $country_id;
			}
			else{// remove this later
				Countries::update($country_id, $country, $phone_code); // update phone code
			}

			return $country_id;
		}

		private function country_exists($country){
			$country = Countries::find_bycountry($country);

			return $country;
		}

		// CHECK AND CREATE COUNTRY
		public function create_state($state, $country, $phone_code){
			$check_state = $this->state_exists($state);
			$state_id = isset($check_state->id) ? $check_state->id : 0; // if state exists, append state id, else append 0 

			// if state_id==0, then state doesn't exist
			if($state_id==0){
				$country_id = $this->create_country($country, $phone_code); // check if country exists and return country_id
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

		// GET PACKAGE
		public function get_package($package_id){
			$package_id = $this->validate('int', $package_id);

			if($package_id){
				$package = Packages::find($package_id);

				$package = $this->set_package($package); // check if package exists, and configure new package format

				if(isset($package->country)){
					$package = '{"country": "'.$package->country.'", "state": "'.$package->state.'", "people": "'.$package->people.'", "from_date": "'.$package->from_date.'", "to_date": "'.$package->to_date.'", "phone_code": "'.$package->phone_code.'", "description": "'.$package->description.'"}';

					echo $package;

					return;
				}
			}
		}

		public function set_package($package){
			if(isset($package->id)){
				$state = $package->state->name; // get state
				$country = $package->state->country->name; // get country, of state
				$phone_code = $package->state->country->phone_code;

				$people = $package->people; // get no of people for the trip

				// DATE (from - to)
				$format = "Y-m-d";
				$from_date = format_date($format, $package->from_date); // get from date 
				$to_date = format_date($format, $package->to_date); // get to date

				$description = $package->description;

				$package = new Package($country, $state, $people, $from_date, $to_date, $description, $phone_code);

				return $package;
			}

			return [];
		}

		// DELETE PACKAGE
		public function delete_package($package_id){
			$package_id = $this->validate('int', $package_id);

			$response_msg = "Your Package was not deleted successfully. Something went wrong";
			$is_success = false;

			if($package_id){
				$package = Packages::find($package_id);

				if(isset($package->id)){
					$deleted = Packages::destroy($package_id);

					if($deleted){
						$response_msg = "Your Package was successfully deleted.";
						$is_success = true;
					}
				}
			}
			
			// set response for when the page reloads
			set_responsevalues($response_msg, $is_success);

			return;
		}
	}
?>