<?php
	require_once '_profile.php';

	use Controllers\Users; 
	use Controllers\Profiles; 

	Class Update_Profile extends _Profile {
		private $profile;
		private $user_id;

		function __construct($profile = []) {
			if(isset($profile->country)){
				$this->profile = $profile;
			}

			start_session();
			$this->user_id = get_userid(); // get user id
		}

		function update(){
			$profile = $this->profile;

			$country = $profile->get_country();
			$phone_code = $profile->get_phone_code();
			$name = $profile->get_name();
			$phone = $profile->get_phone();
			$profile_id = $profile->get_profile_id();

			$response_msg = 'Your profile was not updated successfully. Kindly try again later';
			$is_success = false;

			if($country && $name && $phone && $profile_id){
				$user_id = $this->user_id;

				$profile = Profiles::find($profile_id);

				if(isset($profile->id))
				{
					$country_id = $this->create_country($country, $phone_code); // create country if it doesn't already exist

					// if country_id & user_id, exists
					if($country_id && $user_id){
						// check if phone number already exists
						$phone_exists = $this->phone_exists($phone, $country_id, $profile_id);
						$name_exists = $this->name_exists($name, $profile_id);

						if($phone_exists){
							$response_msg = "Your profile was not updated successfully. Phone number (".$phone.") already exists.";
						}
						else if($name_exists){
							$response_msg = "Your profile was not updated successfully. Name (".$name.") already exists.";
						}
						else{
							$saved =  Profiles::update($profile_id, $user_id, $country_id, $name, $phone);

							if($saved){
								$response_msg = "Your profile was updated successfully";
								$is_success = true;
							}
						}
					}
				}
			}

			// set response
			set_responsevalues($response_msg, $is_success);

			// GO TO profile PAGE
			gotopage('/travelpackagebids/user/profile.php?user=member');

			return;
		}
	}
?>