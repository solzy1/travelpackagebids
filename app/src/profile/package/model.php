<?php 
	class Package extends _Package {
		public $country;
		public $state;
		public $people;
		public $from_date;
		public $to_date;
		public $description;
		public $package_id;
		public $phone_code;

		function __construct($country, $state, $people, $from_date, $to_date, $description, $phone_code = '', $package_id = 0) {
			$this->country = $country;
			$this->state = $state;
			$this->people = $people;
			$this->from_date = $from_date;
			$this->to_date = $to_date;
			$this->description = $description;
			$this->package_id = $package_id;
			$this->phone_code = $phone_code;
		}

		// SET & GET FUNCTIONS
		function set_country(){
			// validate userinput
			$this->country = $this->validate('string', $this->country);
		}

		function set_state(){
			// validate userinput
			$this->state = $this->validate('string', $this->state);
		}

		function set_people(){
			// validate userinput
			$this->people = $this->validate('int', $this->people);
		}

		function set_from_date(){
			// validate userinput
			$this->from_date = $this->validate('string', $this->from_date);
		}

		function set_to_date(){
			// validate userinput
			$this->to_date = $this->validate('string', $this->to_date);
		}

		function set_description(){
			// validate userinput
			$this->description = $this->validate('string', $this->description);
		}

		function set_package_id(){
			// validate userinput
			$this->package_id = $this->validate('int', $this->package_id);
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

		function get_state(){
			$this->set_state();

			return $this->state;
		}

		function get_people(){
			$this->set_people();

			return $this->people;
		}

		function get_from_date(){
			$this->set_from_date();

			return $this->from_date;
		}

		function get_to_date(){
			$this->set_to_date();

			return $this->to_date;
		}

		function get_description(){
			$this->set_description();

			return $this->description;
		}

		function get_package_id(){
			$this->set_package_id();

			return $this->package_id;
		}

		function get_phone_code(){
			$this->set_phone_code();

			return $this->phone_code;
		}
	}
?>