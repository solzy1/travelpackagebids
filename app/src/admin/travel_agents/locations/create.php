<?php
	// start up eloquent
	require_once '_locations.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/profile/package/_package.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

	use Controllers\States; 
	use Controllers\Locations; 
	use Controllers\Countries; 

	Class Create_Location extends _Locations {
		private $location;

		function __construct($location) {
			$this->location = $location;
		}

		public function create(){
			$location = $this->location;

			$user_id = $location->get_user_id();
			$country = $location->get_country();
			$state = $location->get_state();
			$phone_code = $location->get_phone_code();

			$package = new _Package();
			
			$state_id = $package->create_state($state, $country, $phone_code);

			if(is_numeric($state_id) && $state_id > 0){
				$country = States::find_bycountry($state_id);

				$location = $this->location_exists($user_id, $country->id, $state_id);

				if(!isset($location->id)){
					$location = Locations::create($user_id, $country->id, $state_id);

					if(isset($location->id)){ 
						echo 'success';

						return;
					}
				}

				echo 'Location already exists.';

				return;
			}

			echo 'failure';
		}

		private function location_exists($user_id, $country_id, $state_id){
			$location = Locations::agentlocation_exists($user_id, $country_id, $state_id);

			return $location;
		}
	}
?>