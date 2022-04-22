<?php 
    require_once '_profile.php';
    
	class Profile extends _Profile {
		public $country;
		public $name;
		public $phone;
		public $profile_id;
		public $phone_code;

		function __construct($country, $name, $phone, $profile_id, $phone_code = '') {
			$this->country = $country;
			$this->name = $name;
			$this->phone = $phone;
			$this->profile_id = $profile_id;
			$this->phone_code = $phone_code;
		}

		// SET & GET FUNCTIONS
		function set_country(){
			// validate userinput
			$this->country = $this->validate('string', $this->country);
		}

		function set_name(){
			// validate userinput
			$this->name = $this->validate('string', $this->name);
		}

		function set_phone(){
			// validate userinput
			$this->phone = $this->validate('phone', $this->phone);
		}

		function set_profile_id(){
			// validate userinput
			$this->profile_id = $this->validate('int', $this->profile_id);
		}

		function set_phone_code(){
			// validate userinput
			$this->phone_code = $this->validate('string', $this->phone_code);
		}

		// GET
		function get_country(){
			$this->set_country();

			return $this->country;
		}

		function get_name(){
			$this->set_name();

			return $this->name;
		}

		function get_phone(){
			$this->set_phone();

			return $this->phone;
		}

		function get_profile_id(){
			$this->set_profile_id();

			return $this->profile_id;
		}

		function get_phone_code(){
			$this->set_phone_code();

			return $this->phone_code;
		}
	}
?>