<?php
	// namespace Admin;
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/start.php'; // start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/validation/validation.php'; // include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php'; // include the validation file that holds the class Validation

	// use User\Validation; // call the validation class

	use Controllers\Userroles;
	use Controllers\Statuss;

	Class _User {
		private $page_title;

		function __construct($page_title = "") {
			$this->page_title = $page_title;
			
			$this->start_session();
			$user_id = get_userid();
			
			if(isset($user_id) && !empty($user_id)){
			    gotopage('https://travelpackagebids.com');
			}
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);
			$value = $validation->validateinput();

			return $value;
		}

		// to be removed (to _src.php)
		function start_session(){
			start_session();
		}

		function gotopage($url){
			gotopage($url);
		}

		function reportfailure($statusmessage, $page = "sign-in"){
			reportfailure($statusmessage, $page);
		}

		function setresponse($response){
			setresponse($response);
		}

		function getresponse(){
			return getresponse();
		}

		function reset_sessionvalues(){
			reset_sessionvalues();
		}
		// to be removed (end)

		function show_forgotpassword(){
			if($this->page_title!="Sign In")
				echo 'opacity: 0';
		}

		// show create account/sign in
		function useraction(){
			$page_title = $this->page_title;
			$useraction = [];

			if($page_title=="Sign In"){
				$useraction = array('question' => '','action' => 'Create your Account', 'link' => 'https://travelpackagebids.com/user/sign-up.php');
			}
			else{
				$useraction = array('question' => 'Already have an account? ','action' => 'Sign In', 'link' => 'https://travelpackagebids.com/user/sign-in.php');
			}

			echo '<small>'.$useraction['question'].'</small>
				<a class="txt2" href="'.$useraction['link'].'">
					'.$useraction['action'].'
					<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
				</a>';
		}
		
        // USER PROFILE
        function profile_access($user){
            $_SESSION['travelpackagebids.com']['loggedin'] = true;
            $_SESSION['travelpackagebids.com']['is_admin'] = $this->is_admin($user);
            $_SESSION['travelpackagebids.com']['user_id'] = $user->id;
        }
        
        function is_admin($user){
        	$role = Userroles::find($user->userrole_id);

        	return isset($role->name) && $role->name=='admin' ? true : false;
        }

		public function get_status($status){
			$status = Statuss::find_bystatus($status);

			return $status;
		}
	}
?>