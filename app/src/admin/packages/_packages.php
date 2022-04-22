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

	Class _Packages {
		function __construct() {
			start_session();
		}

		// UPDATE PACKAGE STATUS
		public function update_status($package_id, $status){
			$response = $status=='active' ? 'activated' : 'de-activated';

			$status = $this->get_status($status);

			$saved = Packages::update_status($package_id, $status->id);

			if($saved){
				echo 'success';

				if(is_array($package_id))
					set_responsevalues('The packages were '.$response.' successfully!', true);

				return;
			}

			if(is_array($package_id))
				set_responsevalues('The packages were not '.$response.' successfully!', false);
				
			echo 'failure';
		}

		public function get_status($status){
			$status = Statuss::find_bystatus($status);

			return $status;
		}

		// DELETE
		public function delete_package($package_id){
			$deleted = Packages::destroy($package_id);
			$response = is_array($package_id) ? 'packages were' : 'package was';

			if($deleted){
				set_responsevalues('The '.$response.' deleted successfully!', true);

				return;
			}

			set_responsevalues('The '.$response.' not deleted successfully', false);

			return;
		}

		// SEARCH
		public function search($value, $filter){
			$search = set_searchvalues('packages', $value, $filter);
		}
	}
?>