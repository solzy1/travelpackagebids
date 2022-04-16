<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

	use Controllers\Users; 
	use Controllers\Statuss; 

	Class _Travel_Agents {
		function __construct() {
			start_session();
		}

		// UPDATE PACKAGE STATUS
		public function update_status($user_id, $status){
			$response = $status=='active' ? 'activated' : 'de-activated';

			$status = $this->get_status($status);

			$saved = Users::update_status($user_id, $status->id);

			if($saved){
				echo 'success';

				if(is_array($user_id))
					set_responsevalues('The travel-agents were '.$response.' successfully!', true);

				return;
			}

			if(is_array($user_id))
				set_responsevalues('The travel-agents were not '.$response.' successfully!', false);
				
			echo 'failure';
		}

		public function get_status($status){
			$status = Statuss::find_bystatus($status);

			return $status;
		}

		// DELETE
		public function delete_user($user_id){
			$deleted = Users::destroy($user_id);
			$response = is_array($user_id) ? 'travel-agents were' : 'travel-agent was';

			if($deleted){
				set_responsevalues('The '.$response.' deleted successfully!', true);

				return;
			}

			set_responsevalues('The '.$response.' not deleted successfully', false);

			return;
		}

		// SEARCH
		public function search($value, $filter){
			$search = set_searchvalues('travel-agents', $value, $filter);
		}
	}
?>