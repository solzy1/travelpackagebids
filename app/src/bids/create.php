<?php
	// start up eloquent
	require_once '_bids.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/email/_email.php';

	use Controllers\Bids;
	use Controllers\Packages;

	Class Create_Bids extends _Bids {
		private $user_id;
		private $bid;

		function __construct($bid) {
			$this->bid = $bid;

			start_session();

			$this->user_id = get_userid(); // get user id
		}

		public function bid(){
			$package_id = $this->bid->get_package_id(); // get package id
			$user_id = $this->user_id;
			$offer = $this->bid->get_offer(); // get offer
			$is_success = false;
			
			// YOU'RE COMING BACK, TO THIS. THE WHERE FUNCTION ISN'T WORKING... FOR SOME REASON, IF YOU CAN'T FIND A SOLUTION, JUST DELETE AND RECREATE EVERYTIME THAT THEY BID
			$bid = Bids::find_byuser($package_id, $user_id); // to check, if user has already placed a bid for this package

			// // if bid already exists, update bid, else create bid
			if(isset($bid->bidder_id)){
				$saved = Bids::update($bid->id, $package_id, $user_id, $offer);
				$is_success = $saved;
			}
			else{
				$bid = Bids::create($package_id, $user_id, $offer);
				$is_success = isset($bid->id);
			}

			// bid was created
			if($is_success){
				// $package = Packages::find($package_id);
				// $this->sendemail($package);

				echo 'success';
			}
			else{
				echo 'failed';
			}

			return;
		}

        // SEND EMAIL to emailaddress FOR USER CONFIRMATION
  //       function emailbody($package){
  //       	// state and country
  //       	$state = $package->state;
  //       	$country = $state->country->name;
  //       	$state = $state->name;


  //           $url = "https://travelpackagebids.com/package.php?package=".$value;
            
  //           return '<h4 class="col-sm-12 col-md-12 col-lg-12">Hello Ahmed,</h4>

  //           <div class="col-sm-12 col-md-12 col-lg-12">
  //               <p>
  //                   <span>Abdul Quadri just placed a Bid on your travel package <a href="https://travelpackagebids.com/package.php?package=country-state-id" class="link text-capitalize" style="color: #03C6C1;">Country, State</a> on</span> <a href="https://travelpackagebids.com">TravelPackageBids</a>.
  //               </p>

  //               <p style="margin-bottom: 15px;">
  //               	You can <a href="tel:2347082821966" class="btn text-capitalize" style="color: white;border: #03C6C1;background-color: #03C6C1;">Call Abdul Quadri</a> now, to talk further about their offer of $45000.
  //               </p>
                
  //               <small style="font-size: 10px">NOTE: If you\'re not a Registered Travel Agent on <a href="https://travelpackagebids.com">TravelPackageBids</a>, Kindly Ignore this message. Thank you.</small>
  //           </div>';
  //       }
        
		// function sendemail($package){
		// 	// GET USER
		// 	$email = $package->user->email;

  //           $subject = "[TravelPackageBids] Verify your Email address";
  //           $body = $this->emailbody($package);
            
  //           // send email
  //           $email = new Email($email, $subject, $body);
            
  //           $email->send();
		// }

		// function owners_profile($user){
		// 	if(isset($user->profile))
		// }
	}
?>