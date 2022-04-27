<?php
	require_once '_package.php'; // start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/email/_email.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php'; // include the validation file that holds the class Validation

	use Controllers\Packages;
	use Controllers\Locations;

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
			$phone_code = $package->get_phone_code();
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
					$state_id = $this->create_state($state, $country, $phone_code);

					// configure date, switch dates
					$date = $this->configure_date(strtotime($from_date), strtotime($to_date), 'Y-m-d');
					$from_date = $date['from_date'];
					$to_date = $date['to_date'];

					$status = $this->get_status('active');

					if(isset($status->id)){
						$package = Packages::create($user_id, $state_id, $people, $from_date, $to_date, $description, $status->id);

						// set response, if package was successfully created, else
						if(isset($package->id)){
						    $this->send_emails($package);
						    
							set_responsevalues('Your Travel-Package was created successfully!', true);
						}
						else{
							set_responsevalues('Your Travel-Package was not created successfully. Something went wrong.', false);
						}
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
		
		private function send_emails($package){
		    $state = $package->state;
		    
         	$country = $state->country;
		    $country_id = $country->id;
         	$country = $country->name;
		    
         	$state = $state->name;
            
            $package_tag = $country.'-'.$state.'-'.$package->id;
            
            $url = "https://travelpackagebids.com/package.php?package=".$package_tag;
            
            $user = $package->user->id;
            
		    $locations = Locations::find_bycountry($country_id, $user_id);
		    
            foreach ($locations as $location) {
                $user = $location->user;
                
		        $this->sendemail($country, $state, $url, $user);
            }
		}
		
		private function get_user($user){
			$profile = $user->profile;

			if(isset($profile->name)){
				return $profile->name;
			}

			$user_split = explode('@', $user->email);

			return $user_split[0];
		}

        // SEND EMAIL to emailaddress FOR USER CONFIRMATION
        function emailbody($country, $state, $url, $user){
            // POTENTIAL BIDDER
            $name = $this->get_user($user);

            return '<h4>Hello '.$name.',</h4>
            
                <p>
                    A registered travel-agent just created a new package for <a href="'.$url.'">'.$country.', '.$state.'</a> that you can bid for.
                </p>

                <p style="margin-bottom: 15px;">
                 	Be the first to <a href="'.$url.'">PLACE A BID</a>, to buy this package, now.
                </p>
                
                <small style="font-size: 10px;margin-top: 20px;">NOTE: If you\'re not a Registered Travel Agent on <a href="https://travelpackagebids.com">TravelPackageBids</a>, Kindly Ignore this message. Thank you.</small>';
        }
        
		function sendemail($country, $state, $url, $user){
			// GET USER
			$email = $user->email;

            $subject = "[TravelPackageBids] A new package to bid on, for $country, $state";
            $body = $this->emailbody($country, $state, $url, $user);
            
            // send email
            $email = new Email($email, $subject, $body);
            
            $email->send();
		}
	}
?>