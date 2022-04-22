<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

	use Controllers\Users; 
	use Controllers\Blocked_Users; 
	use Controllers\Blocked_Bidders;

	Class _Bidding {
		private $id;
		private $status;

		function __construct($id, $status) {
			$this->id = $id;
			$this->status = $status;
		}

		public function allow_multiplebidding(){
			$user_ids = $this->id;
			$all_packages = $this->status=='allow' ? false : true;

			$is_success = true;

			$package = get_biddingvalues();
			$package_id = $package['package_id'];

			foreach ($user_ids as $user_id) {
				$a_success = $this->bidding($user_id, $all_packages, $package_id);

				$is_success = $a_success && $is_success;
			}

			$status = $this->status=='allow' ? 'allowed to bid' : 'barred from bidding';

			$response = 'The travel-agents '.($is_success ? 'have been' : 'have not been').' '.$status.' successfully!';

			set_responsevalues($response, $is_success);
		}

		public function allow_bidding(){
			$user_id = $this->id;
			$all_packages = $this->status=='allow' ? false : true;

			$package = get_biddingvalues();
			$package_id = $package['package_id'];

			$is_success = $this->bidding($user_id, $all_packages, $package_id);

			echo $is_success ? 'success' : 'failure';
		}

		private function bidding($user_id, $all_packages, $package_id){
			$is_success = false;

			$blockeduser = Blocked_Users::find_byuser($user_id); // check if user exists on the blocked user's list

			// if the travel agent exists, as one of the blocked users
			if(isset($blockeduser->id)){ 
				$blockedbidders = Blocked_Bidders::find_byuser($blockeduser->id); // check if user has been blocked on individual packages, before

				// if a travel agent hasn't been barred from bidding on a particular package, and request is to 'block user' remove the user from the blocked list
				if(!isset($blockedbidders->id) && !$all_packages){
					$is_success = Blocked_Users::destroy($blockeduser->id);
				}

				// if the user wasn't removed from the list of blocked users
				if(!$is_success){
					$is_success = Blocked_Users::update($blockeduser->id, $user_id, $all_packages);
				}
			}
			else if($all_packages){ // else if, and only if request is 'to disable bidding'
				$blockeduser = Blocked_Users::create($user_id, $all_packages);

				$is_success = isset($blockeduser->id);
			}

			if(isset($blockeduser->id)){
				$saved = $this->package_isset($blockeduser->id, $package_id, $all_packages);

				$is_success = $saved && $is_success;
			}
			else if(!$all_packages){
				$is_success = true;
			}

			return $is_success;
		}

		private function package_isset($blocked_user_id, $package_id, $all_packages){
			$package_exists = !empty($package_id) && $package_id > 0;
			$is_success =  false;

			if($blocked_user_id > 0 && $package_exists){
				$blocked_bidder = Blocked_Bidders::find_byuser($blocked_user_id, $package_id);

				// if blocked user doesn't exist, for the selected package, the add to blocked list
				if(!isset($blocked_bidder->id)){
					$blocked_bidder = Blocked_Bidders::create($blocked_user_id, $package_id);

					$is_success = isset($blocked_bidder->id);
				}
				else if(!$all_packages){
					$is_success = Blocked_Bidders::destroy($blocked_bidder->id);
				}

				return $is_success;				
			}

			return $package_exists ? false : true;
		}
	}
?>