 <?php 
	require_once '_user.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/email/_email.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

	use Controllers\Users;

	class Forgotpassword extends _User {
		private $user;

		function __construct($user = '') { 
			$this->user = $user;
			$this->start_session();
		}
		
		function allow_userpass($user){
	        $this->profile_access($user);
	        
	        // set the status, icon & color of the request
	        set_responsevalues('Your password was changed successfully!', true);
		}

		public function reset_password($key){
		    $password = $this->user->get_pass();
			$re_password = $this->user->get_repass();
		    $user_id = $key;
            $is_success = false;
            
			if($password==$re_password && is_numeric($user_id)){
			    $user = Users::find($user_id);
			    
			    if(isset($user->id) && $user->is_verified){
			        $is_success = $this->set_password($password, $user); // change password

			        $this->allow_userpass($user); // allow user to access profile page
			    }
			}

	        $this->status($is_success);

	        return;
		}
		
		private function set_password($password, $user){
        	// update password
        	$password_updated = Users::update($user->id, $user->email, $password);

        	return $password_updated;
		}
		
        private function status($is_success){
            echo $is_success ? "success" : "failure";
        }
        
		public function user_exists($email, $user_id){
		    $reset_email = $this->get_resetemail();
		    
		    if($reset_email==$email){
		        $user = $this->get_user($email);
		        
		        if($user->id==$user_id){
		            return;
		        }
		    }
			
			$this->gotopage('https://travelpackagebids.com');
		}
		
		private function get_resetemail(){
		    if(isset($_SESSION['travelpackagebids.com']['reset_email'])){
		        $reset_email = $_SESSION['travelpackagebids.com']['reset_email'];
		        
                return $reset_email;
		    }    
		    
		    return '';
		}
		
		function send_resetpassword_email(){
		    $email = $this->user->get_email();
		    
		    $user = $this->get_user($email);
		    
		    if(isset($user->id)){
		        $this->sendemail($user);
		        
		        $_SESSION['travelpackagebids.com']['reset_email'] = $email;
		    }
		    else{
			    $this->reportfailure('Email does not exist. Please try again.', 'forgot-password');
			    
			    return;
		    }
		    
			$this->gotopage('https://travelpackagebids.com/user/reset-password.php');
		}
		
		function get_user($email){
		    $user = Users::find_byemail($email);
		    
		    return $user;
		}
		
        // SEND EMAIL to emailaddress FOR USER CONFIRMATION
        function emailbody($user){
         	// state and country
            
            return '<h4>Hello,</h4>
            
                <p>
                    <span>You just made a request to reset your password on</span> 
                    <a href="https://travelpackagebids.com">TravelPackageBids</a>.
                </p>

                <p style="margin-bottom: 20px;">
                 	You can <a href="https://travelpackagebids.com/user/reset-password.php?email='.$user->email.'&user='.$user->id.'" style="color: white;border: #03C6C1;background-color: #03C6C1;padding:5px 8px 5px 8px;text-decoration: none;border-radius: 6px;">Reset your Password here</a> now.
                </p>
                
                <small style="font-size: 10px">NOTE: If you\'re not a Registered Travel Agent on <a href="https://travelpackagebids.com">TravelPackageBids</a> or you didn\'t recently request for a new password, Kindly Ignore this message. Thank you.</small>';
        }
        
		function sendemail($user){
			// GET USER
			$email = $user->email;

            $subject = "[TravelPackageBids] Reset your Password";
            $body = $this->emailbody($user);
            
            // send email
            $email = new Email($email, $subject, $body);
            
            $email->send();
		}
	}
?>