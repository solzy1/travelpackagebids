<?php
    
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/start.php'; // start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/validation/validation.php'; // include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';
	require_once 'model.php';

	use Controllers\Users; 
	use Controllers\Countries; 
	use Controllers\Profiles; 
	use Controllers\Bids; 

	Class _Profile {
		private $profile;

		function __construct($profile = []) {
			if(isset($profile->country)){
				$this->profile = $profile;
			}

			start_session();
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);
			$value = $validation->validateinput();

			return $value;
		}

		function unset_responsevalues(){
			unset_responsevalues();
		}

		// this is supposed to change later, to profile details
		function get_user($user_id){
			$_profile = new Profile('', '', '', '');

			if(isset($user_id)){
				$profile = Profiles::find_byuser($user_id);

				if(isset($profile->id)){
					$country = $profile->country->name;

					$_profile = new Profile($country, $profile->name, $profile->phone, $profile->id);
				}
				else{
					$user = Users::find($user_id);

					if(isset($user->id)){
                    	$name = isset($user->email) ? explode('@', $user->email)[0] : "";
						$_profile = new Profile('', $name, '', '');
					}
				}
			}

			return $_profile;
		}

		// CREATE PROFILE
		function form($user_id){
			$profile = Profiles::find_byuser($user_id);
			$_profile = new Profile('', '', '', '');

			if(isset($profile->id)){
				$country = $profile->country->name;
				$phone_code = $profile->country->phone_code;
                
				$_profile = new Profile($country, $profile->name, $profile->phone, $profile->id, $phone_code);
			}
		?>
			<div class="col-sm-12 col-md-6 col-lg-4 user-profile">
	            <form action="/travelpackagebids/app/src/profile/receive.php" method="POST" autocomplete="off">
	                <!-- country -->
	                <div class="mb-3">
	                    <label for="profile-country" class="form-label fw-bold">Country</label>
	                    <select class="form-select form-select-sm countries" id="profile-country" aria-label=".form-select-sm" name="country" required>
	                        <option>Select Country</option>
	                    </select>
	                	
	                	<input type="hidden" value="<?php echo $_profile->country; ?>">
	                </div>

	                <!-- name -->
	                <div class="mb-3">
	                    <label for="profile-name" class="form-label fw-bold">Name</label>
	                    <input type="text" class="form-control" id="profile-name" name="name" maxlength="100" placeholder="Input your name" required value="<?php echo $_profile->name; ?>">
	                </div>

	                <!-- phone number -->
	                <label for="profile-phone-cont" class="form-label fw-bold">Phone number</label>
	                <div class="input-group mb-3" id="profile-phone-cont">
	                    <span class="input-group-text" id="phone-code"><?php echo $_profile->phone_code; ?></span>
	                    <input type="number" class="form-control" id="profile-phone" placeholder="Input your phone number" name="phone" required value="<?php echo $_profile->phone; ?>">
	                </div>

	                <!-- if user wants to edit -->
	                <input type="hidden" name="profile_id" value="<?php echo $_profile->profile_id; ?>">
                    <input type="hidden" name="profile_phonecode" class="phone-code" id="profile-phonecode" value="<?php echo $_profile->phone_code; ?>">

	                <div class="submit-package" style="margin-top: 10px;float: right;">
	                    <button type="submit" class="btn btn-primary">Update Profile <i class="fa-solid fa-arrow-right"></i></button>
	                </div>
	            </form>
	        </div>
		<?php
		}

		// CHECK IF, COUNTRY ALREADY EXISTS AND CREATE IT IF IT DOESN'T
		public function create_country($country, $phone_code){
			$check_country = $this->country_exists($country);
			$country_id = isset($check_country->id) ? $check_country->id : 0; // if country exists, append country id, else append 0 

			// if country_id==0, then country doesn't exist
			if($country_id==0){
				$country = Countries::create($country, $phone_code);
                
				$country_id = isset($country->id) ? $country->id : $country_id;
			}
			else{
			    Countries::update($country_id, $country, $phone_code);
			}

			return $country_id;
		}

		public function country_exists($country){
			$country = Countries::find_bycountry($country);

			return $country;
		}

		// PHONE & NAME exists
		function phone_exists($phone, $country_id, $profile_id = ''){
			$profile = Profiles::find_byphone($phone, $country_id);
			$exists = isset($profile->id) && (is_numeric($profile_id) ? $profile_id!=$profile->id : true);

			return $exists;
		}

		function name_exists($name, $profile_id = ''){
			$profile = Profiles::find_byname($name);
			$exists = isset($profile->id) && (is_numeric($profile_id) ? $profile_id!=$profile->id : true);

			return $exists;
		}

        function useris_admin(){
        	return useris_admin();
        }
	}
?>