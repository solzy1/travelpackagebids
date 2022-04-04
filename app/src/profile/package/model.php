<?php 
	class Package extends _Package {
		public $country;
		public $state;
		public $people;
		public $from_date;
		public $to_date;
		public $description;

		function __construct($country, $state, $people, $from_date, $to_date, $description) {
			$this->country = $country;
			$this->state = $state;
			$this->people = $people;
			$this->from_date = $from_date;
			$this->to_date = $to_date;
			$this->description = $description;
		}

		// SET & GET FUNCTIONS
		function set_country(){
			// validate userinput
			$this->validate('country', $this->country);
		}

		function set_state(){
			// validate userinput
			$this->validate('string', $this->state);
		}

		function set_people(){
			// validate userinput
			$this->validate('int', $this->people);
		}

		function set_from_date(){
			// validate userinput
			$this->validate('string', $this->from_date);
		}

		function set_to_date(){
			// validate userinput
			$this->validate('string', $this->to_date);
		}

		function set_description(){
			// validate userinput
			$this->validate('string', $this->description);
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
	}
?>