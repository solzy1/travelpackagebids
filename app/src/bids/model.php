<?php 
	// namespace User;

	class Bid extends _Bids {
		private $package_id;
		private $offer;
		private $deadline;

		public function __construct($offer, $package_id, $deadline = '') {
			$this->offer = $offer;
			$this->package_id = $package_id;
			$this->deadline = $deadline;
		}

		// SET & GET FUNCTIONS
		public function set_offer(){
			// validate userinput
			$this->offer =  $this->validate('int', $this->offer);
		}

		public function set_package_id(){
			// validate userinput
			$this->package_id = $this->validate('int', $this->package_id);
		}

		public function set_deadline(){
			// validate userinput
			$this->deadline = $this->validate('int', $this->deadline);
		}

		// GET
		public function get_offer(){
			$this->set_offer();

			return $this->offer;
		}
		
		public function get_package_id(){
			$this->set_package_id();

			return $this->package_id;
		}

		public function get_deadline(){
			$this->set_deadline();

			return $this->deadline;
		}
	}
?>