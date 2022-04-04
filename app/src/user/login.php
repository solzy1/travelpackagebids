 <?php 
	// start up eloquent
	// require $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/start.php';
	require_once '_user.php';

	use Controllers\Users; 
	use Controllers\Userroles;
	use Controllers\Admins;

	class Login extends _User {
		private $user;

		function __construct($user) { 
			$this->user = $user;
			$this->start_session();
		}

		// OTHER FUNCTIONS
		function allowuseraccess(){
			$email = $this->user->get_email(); // get & store email (user input)
			$pass = $this->user->get_pass(); // get & store password (user input)

			// check if user input (email & password are valid entries)
			if($email & $pass){
				// find user, by email
				$user = Users::find_byemail($email);

				// check if user is empty and if user input for email fits an user
				if(!empty($user) && $email==$user->email){
					$user = Users::find_byuser($user->id); // retrieve the user password for that users

					// check if the user input for password, matches the user password for that user
					if($pass==$user->password && $user->is_verified){
						$userrole = Userroles::find($user->userrole_id);

						// assign session values
					    $this->profile_access($user);

						$this->gotopage('/travelpackagebids/user/profile.php');
					}
					else{
						$this->reportfailure('Wrong Email or Password. Please try again.');
					}
				}
				else{
					$this->reportfailure('Wrong Email or Password. Please try again.');
				}
			}
			else{
				$this->reportfailure('Invalid Email or Password. Please try again.');
			}
		}
	}
?>