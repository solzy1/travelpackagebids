<?php 
	class Package extends _Package {
		public $id;
		public $country;
		public $state;
		public $people;
		public $from_date;
		public $to_date;
		public $description;
		public $comments;
		public $bids;
		public $user;

		public function __construct($id, $country, $state, $people, $from_date, $to_date, $description, $comments, $bids, $user) {
			$this->id = $id;
			$this->country = $country;
			$this->state = $state;
			$this->people = $people;
			$this->from_date = $from_date;
			$this->to_date = $to_date;
			$this->description = $description;
			$this->comments = $comments;
			$this->bids = $bids;
			$this->user = $user;
		}

		// public function __construct($id, $country, $state) {
		// 	$this->id = $id;
		// 	$this->country = $country;
		// 	$this->state = $state;
		// }

		// // SET & GET FUNCTIONS
		// private function set_package_id(){
		// 	// validate userinput
		// 	$this->id = $this->validate('int', $this->id);
		// }

		// private function set_country(){
		// 	// validate userinput
		// 	$this->country = $this->validate('string', $this->country);
		// }

		// private function set_state(){
		// 	// validate userinput
		// 	$this->state = $this->validate('string', $this->state);
		// }

		// public function get_country(){
		// 	$this->set_country();

		// 	return $this->country;
		// }

		// public function get_state(){
		// 	$this->set_state();

		// 	return $this->state;
		// }

		// public function get_package_id(){
		// 	$this->set_package_id();

		// 	return $this->id;
		// }
	}
?>