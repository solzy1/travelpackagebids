<?php
	// start up eloquent
	require_once '_packages.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/profile/_profile.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

	use Controllers\Packages;
	use Controllers\Bids; 
	use Controllers\Users; 
	use Controllers\Blocked_Bidders; 

	Class Packages_List {
		private $user_id;
		private $noof_items = 21; // max no of packages per page
		public $noofpackages; 

		function __construct() {
			start_session();

			$this->user_id = get_userid(); // get user id
			$this->get_noofpackages(); // count the no of active traveling packages
			
			// delete all the expired bids
			Bids::delete_expiredbids();
		}

		private function get_noofpackages(){
			$packages = Packages::index(); // get the available packages
			$this->noofpackages = count($packages); // count and store the no of available/live packages 
		}
        
        public function user_isblocked($user, $package_id = 0){
            if(isset($user->id)){
                $blocked_user = $user->blocked_user;
                
                if(isset($blocked_user->id)){
                    if($blocked_user->all_packages){
                        return true;
                    }
                    else if(is_numeric($package_id) && $package_id > 0){
                        $blocked_bidder = Blocked_Bidders::find_byuser($blocked_user->id, $package_id);
                        
                        return isset($blocked_bidder->id);
                    }
                }
            }
            
            return false;
        }	
        
		public function show($page){
			$user_id = $this->user_id;
            
			$loggedin_user = Users::find($user_id);

            // PACKAGES
			$packages = $this->get_packages();
            
            $noof_pages = noof_pages($packages, $this->noof_items); // get the no of pages
			$page =  configure_page($page, $noof_pages); // configure the selected page

			// stop me, if page is not numeric
			if(!is_numeric($page) || !$page)
				return;

			$start = ($page - 1) * $this->noof_items; // initializer
			$countdown = 0;
			
	        $max_desclen = 220; // max length for description

			if(count($packages) == 0){
				?>
					<div class="text-start text-secondary">There are no available packages, at the moment.</div>
				<?php
				return;
			}

			for ($i=$start; $i < count($packages); $i++) { 
			    if($countdown >= $this->noof_items)
					break;
				$countdown++;

				$package = $packages[$i];
				
				// get user
				$user = $package->user;

				// if user is not found, continue
				if(!isset($user->id))
					continue;

				$state = $package->state->name; // get state
				$country = $package->state->country->name; // get country, of state

				$people = $package->people; // get no of people for the trip

				// DATE (from - to)
				$format = "jS, M Y";
				$from_date = format_date($format, $package->from_date); // get from date
				$to_date = format_date($format, $package->to_date); // get to date

				$noof_comments = count($package->comments); // count no of comments
				$description = $package->description;
				$noof_bids = count($package->bids); // count no of bids

			    $user_isblocked = $this->user_isblocked($loggedin_user, $package->id);
		?>
				<!-- package -->
                <div class="col-sm-12 col-md-6 col-lg-4 package-details-container">
                    <div class="package-details border bg-light">
                        <p class="package-header fw-bold">
                            <?php echo $country.', '.$state; ?>
                        </p>
                        
                        <div class="container-fluid package-items" style="padding: 0px;color: grey;font-size: 12px;word-wrap: break-word;">
                            <span>
                                <i class="fa-solid fa-people-group"></i>
                                <?php echo $people; ?> people
                            </span>
                            <span>
                                <i class="fa-solid fa-calendar-days"></i> 
                                <?php echo $from_date.' - '.$to_date; ?>
                            </span>
                            <span>
                                <i class="fa-solid fa-comments"></i> 
                                <?php echo $noof_comments > 0 ? $noof_comments : 'No'; ?> Comment(s)
                            </span>
                            <span>
                                <i class="fa-solid fa-handshake-simple"></i> 
                                <?php echo $noof_bids > 0 ? $noof_bids : 'No'; ?> Offer(s)
                            </span>
                        </div>
                        <br>
                        
                        <div>
                            <p class="package-description">
                            	<?php 
	                        		$desc_len = strlen($description);

	                        		echo $desc_len > $max_desclen ? substr($description, 0, $max_desclen).'<a href="/travelpackagebids/package.php?package=country-state-id">...</a>' : $description; 
	                        	?>
                            </p>
                        </div>
                        <br>
                        
                        <div>
                        	<?php 
                        		if($user_id!=$user->id){
                        			// if logged user's id == one of the offers of this package
                         	?>	
                         			<!-- data-bs-toggle="modal" data-bs-target="#create-package-bid" -->
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
                            <a href="/travelpackagebids/package.php?package=<?php echo $country.'-'.$state.'-'.$package->id; ?>" class="btn view-listing">
                                View Listing <i class="fa-solid fa-right-long"></i>
                            </a>
                        </div>
                        <?php 
                        	if($user_isblocked){
                        		$message = '<small class="d-none blocked-message" style="font-size: 10px;color: red">You\'ve been barred from placing a bid on this package!</small>';
                        		echo $message;
                        	}
                        ?>
                    </div>
                </div>
                <!-- package (end) -->
                <br>

		<?php
			}
		}
        
        private function get_packages(){
			$packages = Packages::index_orderbydate('desc');
			
			return $packages;
        }
        
		public function is_userloggedin(){
			$user_loggedin = is_userloggedin();

            return '<input type="hidden" id="user-loggedin" value="'.$user_loggedin.'">';
		}

		// PROFILE
		public function get_profile(){
			$user_id = $this->user_id;

			$profile = new _Profile();

			return $profile->get_user($user_id);
		}

		public function pagination($page){
            // packages	
            $packages = $this->get_packages();
            
			if(count($packages) == 0){
				return;
			}

			$base_url = '/travelpackagebids?';
			
			pagination($page, $packages, $base_url, $this->noof_items);
		}
	}
?>