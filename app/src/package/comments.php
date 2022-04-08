<?php
	// start up eloquent
	require_once '_package.php';

	use Controllers\Packages;
	use Controllers\Replies;

	Class Comments extends _Package {
		private $user_id;

		function __construct() {
			start_session();

			$this->user_id = get_userid(); // get user id
		}

		public function comments($package_id){
			$package_id = $this->validate('int', $package_id);
			$package = Packages::find($package_id);

			if(isset($package->id)){
				$user_loggedin = is_userloggedin(); // is user loggedin

				$this->show_comments($package, $user_loggedin); // show comments
			}
		}
	}
?>