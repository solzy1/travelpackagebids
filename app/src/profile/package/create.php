<?php
	
	require_once '_package.php'; // start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/validation/validation.php'; // include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php'; // include the validation file that holds the class Validation

	use Controllers\Packages; 

	Class Create extends _Package{
		private $package;
		private $user_id;

		public function __construct($package) {
			$this->package = $package;

			start_session();
			$this->user_id = get_userid(); // get logged in user_id
		}

		public function create(){
			$package = $this->package;
			$country = $package->get_country();
			$state = $package->get_state();
			$people = $package->get_people();
			$from_date = $package->get_from_date();
			$to_date = $package->get_to_date();
			$description = $package->get_description();

			// if country, state, people, fromdate, todate are PRESENT
			if($country && $state && $people && $from_date && $to_date){
				$user_id = $this->user_id;

				// if user is logged in
				if($user_id > 0){
					$state_id = $this->create_state($state, $country);

					// configure date, switch dates
					$date = $this->configure_date(strtotime($from_date), strtotime($to_date), 'Y-m-d h:i:s');
					$from_date = $date['from_date'];
					$to_date = $date['to_date'];

					$package = Packages::create($user_id, $state_id, $people, $from_date, $to_date, $description);

					// set response, if package was successfully created, else
					if(isset($package->id)){
						set_responsevalues('Your Travel-Package was created successfully!', true);
					}
					else{
						set_responsevalues('Your Travel-Package was not created successfully. Something went wrong.', false);
					}
				}
				else{
					set_responsevalues('Your Travel-Package was not created successfully. A user is currently, not Logged in.', false);
				}
			}
			else{
				set_responsevalues('Your Travel-Package was not created successfully. In-complete Field Values for Package.', false);
			}
			
			// GO TO profile PAGE
			gotopage('https://travelpackagebids.com/user/profile.php');
		}
	}
?>