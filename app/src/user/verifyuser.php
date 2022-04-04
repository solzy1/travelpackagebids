<?php 
	include_once $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/app/src/_src.php';

	use Controllers\Users;
	use Controllers\Userroles;
	use Controllers\Userconfirmations;

	class VerifyUser extends _User {
		private $key;

		function __construct($key) { 
			$this->key = $key;
            $this->start_session();
		}

		function check(){
		    $key = $this->key;
		    
		    $userconfirmation = Userconfirmations::find_bykey($key);
		    
		    if(isset($userconfirmation->id)){
		        $user = Users::find_byuser($userconfirmation->id);
		        
		        if(isset($user->id) && !$user->is_verified){
    		        $this->profile_access($user);
    		        
    		        // update verified status
    		        Users::update_isverified($user->id, true);
    		        
    		        // set the status, icon & color of the request
    		        set_responsevalues('Your email was verified successfully!', true);

    		        $this->gotopage('/travelpackagebids/user/profile.php');
		        }
		        else {
    		        $this->gotopage('/');
    		        
		            return false;
		        }
		    }
		    else{
		        return false;
		    }
		    
		    return true;
		}
	}
?>