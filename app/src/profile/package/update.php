<?php
	require_once '_package.php'; // start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php'; // include the validation file that holds the class Validation

	use Controllers\Packages; 

	Class Update extends _Package{
		private $package;
		private $user_id;

		public function __construct($package) {
			$this->package = $package;

			start_session();
			$this->user_id = get_userid(); // get logged in user_id
		}

		public function update(){
			$package = $this->package;
			$country = $package->get_country();
			$phone_code = $package->get_phone_code();
			$state = $package->get_state();
			$people = $package->get_people();
			$from_date = $package->get_from_date();
			$to_date = $package->get_to_date();
			$description = $package->get_description();
			$package_id = $package->get_package_id();

			// if country, state, people, fromdate, todate, package_id are PRESENT
			if($country && $state && $people && $from_date && $to_date && $package_id){
				$user_id = $this->user_id;

				// if user is logged in
				if($user_id > 0){
					$package = Packages::find($package_id);

					// if package exists
					if(isset($package->id)){
						$state_id = $this->create_state($state, $country, $phone_code);

						// configure date, switch dates
						$date = $this->configure_date(strtotime($from_date), strtotime($to_date), 'Y-m-d');
						$from_date = $date['from_date'];
						$to_date = $date['to_date'];

						$saved = Packages::update($package_id, $user_id, $state_id, $people, $from_date, $to_date, $description);

						// set response, if package was successfully updated, else
						if($saved){
							set_responsevalues('Your Travel-Package was updated successfully!', true);
						}
						else{
							set_responsevalues('Your Travel-Package was not updated successfully. Something went wrong.', false);
						}
					}
					else{
						set_responsevalues('The selected package, no longer exists.', false);
					}
				}
				else{
					set_responsevalues('Your Travel-Package was not updated successfully. A user is currently, not Logged in.', false);
				}
			}
			else{
				set_responsevalues('Your Travel-Package was not updated successfully. In-complete Field Values for Package.', false);
			}
			
			// GO TO profile PAGE
			gotopage('https://travelpackagebids.com/user/profile.php');
		}
	}
?>