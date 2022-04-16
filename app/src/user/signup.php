<?php 
	// start up eloquent
	// require '_user.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/email/_email.php';

	use Controllers\Users;
	use Controllers\Userroles;
	use Controllers\Userconfirmations;
	
	class Signup extends _User {
		private $user;

		function __construct($user) { 
			$this->user = $user;
            $this->start_session();
		}

		function createuser(){
			$email = $this->user->get_email(); // get & store email (user input)
			$pass = $this->user->get_pass(); // get & store password (user input)

			// IF email already exists, re-direct to sign up page
			$emailexists = $this->emailexists($email);

			if(!$emailexists){
				// ELSE
				$finduser_role = Userroles::find_byrole('user');
                
                if(isset($finduser_role->id)){
    				$userrole_id = $finduser_role->id;

                    // get status
                    $status = $this->get_status('inactive');

                    if(isset($status->id)){
        				$user = Users::create($email, $userrole_id, $status->id);
        
        				// check if user was successfully created
        				if(isset($user->id)){
        				    // create the verification link key
        				    $key = $this->generateuser_key($user->id);
        				    $userconfirmation = Userconfirmations::create($user->id, $key);
        				    
        				    if(isset($userconfirmation->id)){
            					$_SESSION['travelpackagebids.com']['new_email'] = $email;
            					
            					$this->sendemail_confirmation($user->email, $key);
            					$this->gotopage("/travelpackagebids/user/confirm-email.php");

                                return;
        				    }
        				}
                    }
                }
    			
                $this->reportfailure('User was not created. Something went wrong.', 'sign-up');
			}
		}

		function emailexists($email){
			$user = Users::find_byemail($email);
            
			if(isset($user->id)){
				$this->reportfailure($user->email.' already exists. Please try again.', 'sign-up');

				return true;
			}

			return false;
		}
        
        // SEND EMAIL to emailaddress FOR USER CONFIRMATION
        function emailbody($key){
            $url = "/travelpackagebids/user/confirm-email.php?verify=".$key;
            
            return '<h4 class="col-sm-12 col-md-12 col-lg-12">Hello,</h4>

            <div class="col-sm-12 col-md-12 col-lg-12">
                <p>
                    <span>You just signed-up on</span>
                    <a href="/travelpackagebids">TravelPackageBids</a><span>, but you have to verify your email, to gain access to your profile.</span>
                </p>

                <p style="margin-bottom: 15px;">Kindly Verify your email address</p>
                <a href="'.$url.'" style="background-color: lightgreen;color: white;padding: 10px 10px 10px 10px;text-decoration: none;border-radius: 5px;font-size: 19px;">Verify My Email Address</a>

                <p style="word-wrap: break-word;"> 
                    <span>to proceed to the next stage.</span>
                </p>
                <br>
                
                <small style="font-size: 10px">NOTE: If you did not recently register on <a href="/travelpackagebids">TravelPackageBids</a>, Kindly Ignore this message. <br>Thank you.</small>
            </div>';
        }
        
		function sendemail_confirmation($email, $key){
            $subject = "[TravelPackageBids] Verify your Email address";
            $body = $this->emailbody($key);
            
            // send email
            $email = new Email($email, $subject, $body);
            
            $email->send();
		}
		
		function generateuser_key($user_id){
		    $str=rand();
            $key = md5($str).$user_id;
            
            return $key;
		}
		
	}
?>