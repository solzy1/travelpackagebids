<?php
	// start up eloquent
	require_once $_SERVER['DOCUMENT_ROOT'].'/start.php';

	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';
	require_once 'model.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/profile/model.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/packages/index.php';

	use Controllers\Packages;
	use Controllers\Comments;
	use Controllers\Replies;
	use Controllers\Bids;
	use Controllers\Profiles; 
	use Controllers\Users;

	Class _Package {
		private $request;
		private $user_id;

		function __construct($request = '') {
			$this->request = $request;

			start_session();
			$this->user_id = get_userid();
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);

			return $validation->validateinput();
		}

		function get_package(){
			$request = $this->filter_packagerequest();
			$package = '';

			if(isset($request['package_id']) && !empty($request['package_id'])){
				$package_id = $request['package_id'];

				$package = Packages::find($package_id);

				if(isset($package->id)){
					$state = $package->state->name; // get state
					$country = $package->state->country->name; // get country, of state
					$user = $package->user; // get country, of state

					// check if the country and name, fits the package id
					if($state==$request['state'] && $country==$request['country']){
						$people = $package->people; // get no of people for the trip

						// DATE (from - to)
						$format = "jS, M Y";
						$from_date = format_date($format, $package->from_date); // get from date 
						$to_date = format_date($format, $package->to_date); // get to date

						$description = $package->description;
						$comments = $package->comments; // count no of comments
						$bids = $package->bids; // count no of bids

						$package = new Package($package_id, $country, $state, $people, $from_date, $to_date, $description, $comments, $bids, $user);
					}
				}
			}

			return $package;
		}

		function show(){
			$package = $this->get_package();

			if(isset($package->id)){
				// CHECK IF USER HAS A BID FOR THIS PACKAGE
				$user_id = $this->user_id;

				$page_title = $package->country.', '.$package->state;

				$loggedin_user = Users::find($user_id);
				
				$package_list = new Packages_List();
				
			    $user_isblocked = $package_list->user_isblocked($loggedin_user, $package->id);
			?>      
		        
		        <!-- main body -->
		        <div class="row" style="padding-left: 17px;margin-bottom: 40px;">
					<div class="package-cover col-sm-12 col-md-8" style="padding-top: 20px;margin-bottom: 30px;">
				        <h2 class="text-capitalize fw-bold">
				        	<?php echo $page_title; ?>
                            <input type="hidden" id="package_id" value="<?php echo $package->id; ?>">
				        </h2>
				                
				        <br>
		        		<div class="container-fluid" style="padding: 0px;color: grey;font-size: 12px;word-wrap: break-word;">
		        			<div class="row" style="font-size: 14px;">
	                            <p class="col-sm-8 col-md-3 col-lg-3">
	                                <i class="fa-solid fa-people-group"></i> 
	                                <?php echo $package->people; ?> people
	                            </p>
	                            <p class="col-sm-8 col-md-4 col-lg-4">
	                                <i class="fa-solid fa-calendar-days"></i> 
	                                <?php echo $package->from_date.' - '.$package->to_date; ?>
	                            </p>
	                            <p class="col-sm-8 col-md-3 col-lg-3">
	                                <i class="fa-solid fa-handshake-simple"></i> 
	                                <?php $noof_bids = count($package->bids); echo $noof_bids > 0 ? $noof_bids : 'No'; ?> Offer(s)
	                            </p>
	                            <div class="travel-package-description" style="color: black;font-size: 15px;margin-top: 15px">
	                            	<p><?php echo $package->description; ?></p>
	                            </div>
	                            
	                            <br>

	                            <div style="margin-top: 15px;">
	                            	<?php 
	                           // 	$package = Packages::find($package->id);
									$is_owner = $this->is_owner($package->user);

	                            	if(!$is_owner) {
	                            	?>
			                            <button role="button" class="btn place-bid <?php echo $user_isblocked ? 'no-bidding' : '' ?>">
			                                Place Bid
			                                <input type="hidden" class="package_id" value="<?php echo $package->id; ?>">
			                            </button>
			                        <?php 
	                        		} 
	                        		else {
		                        	?>
	                        		    <button role="button" class="btn place-bid">
			                                View Bids <i class="fa-solid fa-eye"></i>
			                                <input type="hidden" class="package_id" value="<?php echo $package->id; ?>">
			                                <input type="hidden" class="is-owner" value="yes">
			                            </button>
				                    <?php
		                        	}
		                            ?>
		                            <a href="https://travelpackagebids.com" class="btn btn-secondary go-back">
		                                <i class="fa-solid fa-left-long"></i> Go Back
		                            </a>
		                        </div>
		                        <?php 
		                        	if($user_isblocked){
		                        		$message = '<small class="d-none blocked-message" style="font-size: 10px;color: red">You\'ve been barred from placing a bid on this package!</small>';
		                        		echo $message;
		                        	}
		                        ?>
	                            <!-- COMMENTS -->
	                            <div style="margin-top: 30px">
	                            	<hr style="margin-bottom: 10px">
	                            	<p class="lead" style="color: black">COMMENTS</p>
	                            	<?php $this->comments_section($package); ?>
	                            </div>
	                        </div>
                        </div>
                        <br>
					</div>
					<!-- END package details and comments -->

					<!-- bids -->
					<div class="col-sm-12 col-md-4" id="package-bids-display" style="padding-left: 20px;padding-right: 20px;">
						<?php 
							$this->bids($package->id);
						?>
					</div>
					<!-- END bids -->
		        </div>
		        <!-- main body (end) -->

			<?php
			}
			else{
				echo '<div style="font-weight: bold;font-size: 25px;">You have not requested for an existing package. <br></div>';

				// Kindly check out, our other <a href="https://travelpackagebids.com">travel packages</a>, below.	
			}
		}

		function bids($package_id){
			$package = Packages::find($package_id);

			$is_owner = $this->is_owner($package->user);

            $useris_admin = useris_admin();

            $bids = Bids::find_bypackage($package->id, $useris_admin); //find all the bids for the given package
            $noof_bids = count($bids);

            $state = $package->state;
            $country = $state->country->name;
            $state = $state->name;
        ?>

            <h4 class="fw-bold text-center" style="margin-bottom: 18px;"><?php echo $noof_bids > 0 ? $noof_bids : 'No'; ?> Bid(s) so far <span style="color: grey;font-size: 13px;font-weight: lighter;">for <b class="text-capitalize" ><?php echo $country.', '.$state; ?></b></span></h4>
            <div class="row" style="max-height: 600px;overflow-y: auto;">
            <?php
                $is_owner = !empty($is_owner) && $is_owner=='yes' ? true : false;

                foreach ($bids as $bid) {
                    if($is_owner){
                        $profile = Profiles::find_byuser($bid->bidder_id);
                        
                        // if profile doesn't exist, move right along
                        if(!isset($profile->id))
                            continue;
                            
                        $phone_code = $profile->country->phone_code;
                        $phone = '+'.$phone_code.$profile->phone;
                        $agent_name = $profile->name;
                    }

                    $offer = number_format($bid->offer);
            ?>
                    <!-- agent-offer -->
                    <div class="col-12 col-sm-6 col-md-6" style="margin-bottom: 10px;">
                        <div class="border text-black agent-offer">
                            <p class="agent-details" style="font-size: 25px;font-weight: lighter;word-wrap: break-word;">
                                <span style="font-size: 17px;color: grey">BID: </span> <?php echo $offer; ?>
                                <?php 
                                    if($is_owner){
                                ?>
                                        <span class="agent-name" style="font-size: 15px;color: grey;"> by <b class="text-capitalize"><?php echo $agent_name; ?></b></span>
                                <?php
                                    }
                                ?>

                            </p>

                            <?php 
                                if($is_owner){
                            ?>
                                    <!-- bid-action -->
                                    <div class="call-agent-section">
                                        <a href="tel:<?php echo $phone; ?>" class="btn call-agent" style="text-align: left;max-width: 160px;word-wrap: break-word !important;">
                                            <i class="fa-solid fa-phone"></i> CALL AGENT <span style="word-wrap: break-word;">(<?php echo $phone; ?>)</span>
                                        </a>
                                    </div>
                                    <!-- END bid-action -->
                            <?php
                                }

                                if($useris_admin){
                                    $status = $bid->status->status;
                            ?>  
                                <div>
                                    <a onclick="bid_status(this)" class="btn btn-success activate-bid toggle-status-<?php echo $bid->id; ?>" role="button" title="Activate bid" data-bs-toggle="tooltip" data-bs-placement="top" style="margin-bottom: 5px;<?php echo deactivate($status=='active'); ?>">
                                        <i class="fas fa-circle-check"></i>
                                    </a>
                                    <a onclick="bid_status(this)" class="btn btn-warning text-white deactivate-bid toggle-status-<?php echo $bid->id; ?>" role="button" title="De-activate bid" data-bs-toggle="tooltip" data-bs-placement="top" style="margin-bottom: 5px;<?php echo deactivate($status=='inactive'); ?>"><i class="fas fa-circle-pause"></i></a>

                                    <input type="hidden" class="id" value="<?php echo $bid->id; ?>">
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                    <!-- END agent-offer -->
            <?php
                }
            ?>
            </div>

        <?php
		}

		function comments_section($package){
		?>
			<!-- continue: comments -->
	        <div class="container-fluid commentsection">
	            <div class="row">
	                <!-- add comments section -->
	                <div class="col-lg-12">
	                    <div id="create-comment-content">
	                    	<?php 
	                    		$user_loggedin = is_userloggedin();

	                    		// only prevent user, from commenting, if user isn't logged in
	                    		if($user_loggedin=='no'){
	                    	?>
		                    	<div class="prevent-comment" data-bs-toggle="modal" data-bs-target="#modal-signup-now">

		                    	</div>
	                    	<?php 
	                    		}
	                    	?>
                            <div class="mb-3">
	                        	<textarea class="guestcomment form-control user-comment" name="comment" placeholder="Leave a Comment" rows="7" style="resize: none;"></textarea>
	                        </div>

	                        <!-- submit form -->
	                        <div class="submitcommentcontainer">
	                        	<div class="comment-response" style="opacity: 0;font-size: 20px;text-align: left;;margin-bottom: 1px;padding: 2px;"></div>
	                            <button type="submit" class="btn btn-primary submitcomment" onclick="send_comment(this)">
	                            	Send <i class="fa-solid fa-send"></i>
	                            </button>
	                        </div>
	                    </div>
	                </div>
	                
	                <!-- list comments section -->
	                <div class="col-lg-12 guestcomments">
	                    <p class="noofcomments"><?php echo count($package->comments); ?> Comment(s)</p>

	                    <!-- show loading comment, icon -->
						<div class="loading-comments">
							<div class="d-flex justify-content-center">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>

	                    <!-- COMMENT -->
	                    <div id="package-comments" style="background-color: white;height: 700px;overflow-y: auto;">
		                <?php
		                    //$this->show_comments($package, $user_loggedin);
		                ?>
	                    <!-- END COMMENT -->
	                	</div>
	                </div>
	            </div>
	        </div>
		<?php
		}

		function show_comments($package, $user_loggedin){
			$comments = $package->comments;

			foreach ($comments as $comment) {
				$isareply = $this->comment_isareply($comment->id);

				if($isareply)
					continue;

				$this->comment($comment, $user_loggedin);
			}
		}

		function comment($comment, $user_loggedin, $is_areply = false){
			$comment_id = $comment->id;

			// USER
			$user = $comment->user;
			$package = $comment->package;
			$is_owner = $this->is_owner($user, $package);
			
			$profile = $this->get_user($user->id);
			$name = $profile->name.($is_owner ? ' <span style="color: #03C6C1;">(OWNER)</span>' : ''); // replace this with profile->name... later

			$user_comment = $comment->comment;
			$date_created = format_date('M Y', $comment->created_at);
		?>
			<!-- comment -->
            <div class="guestcommentdisplay">
                <div class="guestcommenttop">
                   <!--  <div class="guestimage col-2 col-2-lg">
                        <i class="fa fa-circle-user"></i>
                    </div> -->
                    <div class="guestcontent">
                        <!-- identifier, date of comment -->
                        <p class="guestnamedisplay">
                        	<?php echo $name; ?>
                        	<span class="guestcommentdate"><?php echo $date_created; ?></span>
                        </p>
                        <!-- comment -->
                        <p class="user-comment"><?php echo $user_comment; ?></p>
                        <!-- reply btn -->
                        <?php 
                        	// if($user_loggedin=='yes' && !$is_areply){
                        ?>
	                        <div class="container-fluid" style="padding: 0;">
	                            <div class="guestcommentbottom" style="margin-bottom: 5px;" onclick="prevent_reply(this)">
	                                <button type="button" class="btn button replycomment">
	                                	<i class="fa fa-reply"></i> Reply
	                                	<!-- add user_id -->
	                            		<input type="hidden" class="comment_id" value="<?php echo $comment_id; ?>">
	                                </button>
	                            </div>
	                            <!-- REPLY SECTION -->
			                    <div class="reply-comment">
			                    </div>
	                            <!-- END REPLY SECTION -->
	                    	</div>
	                    <?php 
	                    	// }
	                    ?>
                    </div>
                </div>

                <!-- comment replies -->
                <?php 
                	// get replies, if any exist
                	$replies = Replies::find_bycomment($comment_id);
                	// $comment->replies;
                	
                	if(count($replies) > 0){
                		foreach ($replies as $reply) {
                			$reply = Comments::find($reply->reply_id);

							$this->comment($reply, $user_loggedin, true);
                		}
                	}
                ?>
                <!-- end comment replies -->
            </div>
            <!-- end comment -->
		<?php
		}

		function comment_isareply($comment_id){
	    	$reply = Replies::find_byreply($comment_id);

	    	return isset($reply->id);
		}

		function is_owner($user, $package = []){
			$user_id = isset($package->id) ? $package->user_id : get_userid();
			$is_owner = $user->id==$user_id ? true : false;
			
			return $is_owner;
		}

		function page_nav($page_title){
		?>
			<nav aria-label="breadcrumb">
	            <ol class="breadcrumb">
	                <li class="breadcrumb-item"><a href="/">Home</a></li>
	                <li class="breadcrumb-item active text-capitalize" aria-current="page"><?php echo $page_title; ?> Travel Package</li>
	            </ol>
	        </nav>
		<?php
		}

	    function filter_packagerequest(){
	    	$request = $this->request;

	        $package = filter_packagerequest($request, $this);

	        return $package;
	    }

		function get_user($user_id){
			$_profile = new Profile('', '', '', '');

			if(isset($user_id)){
				$profile = Profiles::find_byuser($user_id);

				if(isset($profile->id)){
					$country = $profile->country->name;
					$phone_code = $profile->country->phone_code;

					$_profile = new Profile($country, $profile->name, $profile->phone, $profile->id, $phone_code);		  
				}
				else{
					$user = Users::find($user_id);

					if(isset($user->id)){
                    	$name = isset($user->email) ? explode('@', $user->email)[0] : "";
						$_profile = new Profile('', $name, '', '', '');
					}
				}
			}

			return $_profile;
		}
	}
?>