<?php
	// start up eloquent
	require_once '_bids.php';

	use Controllers\Bids;

	Class Create_Bids extends _Bids {
		private $user_id;
		private $bid;

		function __construct($bid) {
			$this->bid = $bid;

			start_session();

			$this->user_id = get_userid(); // get user id
		}

		public function bid(){
			$package_id = $this->bid->get_package_id(); // get package id
			$user_id = $this->user_id;
			$offer = $this->bid->get_offer(); // get offer

			// YOU'RE COMING BACK, TO THIS. THE WHERE FUNCTION ISN'T WORKING... FOR SOME REASON, IF YOU CAN'T FIND A SOLUTION, JUST DELETE AND RECREATE EVERYTIME THAT THEY BID
			$bid = Bids::find_byuser($package_id, $user_id); // to check, if user has already placed a bid for this package

			// if bid already exists, update bid, else create bid
			if(isset($bid->user_id))
				$bid = Bids::update($bid->id, $package_id, $user_id, $offer);
			else
				$bid = Bids::create($package_id, $user_id, $offer);

			// bid was created
			if(isset($bid->id)){
				echo 'success';
				// set_responsevalues('Your Bid was created successfully.', true);
			}
			else{
				echo 'failed';
				// set_responsevalues('Your Bid was not created. Kindly Try again later', false);
			}
		}
	}
?>