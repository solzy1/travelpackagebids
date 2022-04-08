<?php 
	// namespace User;

	class Bid extends _Bids {
		private $package_id;
		private $offer;

		public function __construct($offer, $package_id) {
			$this->offer = $offer;
			$this->package_id = $package_id;
		}

		// SET & GET FUNCTIONS
		public function set_offer(){
			// validate userinput
			$this->validate('int', $this->offer);
		}

		public function set_package_id(){
			// validate userinput
			$this->validate('int', $this->package_id);
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
	}
?>