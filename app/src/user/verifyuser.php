<?php 
	include_once '_user.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

	use Controllers\Users;
	use Controllers\Userroles;
	use Controllers\Userconfirmations;

	class VerifyUser extends _User {
		private $key;
		private $user;

		function __construct($key, $user = []) { 
			$this->key = $key;
			$this->user = $user;

            $this->start_session();
		}

		function key_exists(){
		    $key = $this->key;
			$userconfirmation = Userconfirmations::find_bykey($key);

		    if(isset($userconfirmation->id)){
		        $user = Users::find_byuser($userconfirmation->user_id);

		        if(isset($user->id) && !$user->is_verified){
		    		return $user;
		        }
		    }

		    return false;
		}

		function check(){
			$password = $this->user->get_pass();
			$re_password = $this->user->get_repass();
		    $key = $this->key;

			if($password==$re_password && !empty($key)){
			    $user = $this->key_exists();

			    // if user exists, then key for an unverified user eixsts
			    if(isset($user->id)){
		    		$this->set_password($password, $user);

		    		return;
			    }
			}
		    
	        $this->failure();

		    return;
		}

		function set_password($password, $user){
        	// update password
        	$password_updated = Users::update($user->id, $user->email, $password);

        	if($password_updated){
		        // update verified status
		        $status_updated = Users::update_isverified($user->id, true);
        	
        		if($status_updated){
        			$this->allow_userpass($user);

        			return;
        		}
        	}

	        $this->failure();

	        return;
		}

		function allow_userpass($user){
	        $this->profile_access($user);
	        
	        // set the status, icon & color of the request
	        set_responsevalues('Your email was verified successfully!', true);

	        $this->success();
		}

		function success(){
			echo 'success';
		}

		function failure(){
			echo 'failure';
		}
	}
?>