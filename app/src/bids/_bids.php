<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

	use Controllers\Packages;
	use Controllers\Countries; 
	use Controllers\States; 
	use Controllers\Statuss; 
	use Controllers\Bids; 

	Class _Bids {
		private $user_id;

		function __construct() {
			start_session();

			$this->user_id = get_userid(); // get user id
			
			Bids::delete_expiredbids(); // delete all the expired bids
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);
			$value = $validation->validateinput();

			return $value;
		}

		public function useris_admin(){
			return useris_admin();
		}

		public function get_status($status){
			$status = Statuss::find_bystatus($status);

			return $status;
		}

		public function update_status($id, $status){
			$status_id = $this->get_status($status)->id;

			$saved = Bids::update_status($id, $status_id);

			if($saved){
				echo 'success';

				return;
			}

			echo 'failure';
		}
	}
?>