<?php 
	class Locations extends _Locations {
		private $user_id;
		private $country;
		private $state;
		private $phone_code;

		function __construct($user_id, $country, $phone_code, $state = '') {
			$this->user_id = $user_id;
			$this->country = $country;
			$this->phone_code = $phone_code;
			$this->state = $state;
		}

		// SET & GET FUNCTIONS
		function set_user_id(){
			// validate userinput
			$this->user_id = $this->validate('int', $this->user_id);
		}

		function set_country(){
			// validate userinput
			$this->country = $this->validate('string', $this->country);
		}

		function set_state(){
			// validate userinput
			$this->state = $this->validate('string', $this->state);
		}

		function set_phone_code(){
			// validate userinput
			$this->phone_code = $this->validate('string', $this->phone_code);
		}

		// GET
		function get_user_id(){
			$this->set_user_id();

			return $this->user_id;
		}

		function get_country(){
			$this->set_country();

			return $this->country;
		}

		function get_state(){
			$this->set_state();

			return $this->state;
		}
		
		function get_phone_code(){
			$this->set_phone_code();

			return $this->phone_code;
		}
	}
?>