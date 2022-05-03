<?php
	require_once '_package.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

	use Controllers\Packages;
	use Controllers\Countries; 
	use Controllers\States; 
	use Controllers\Users; 
	use Controllers\Blocked_Bidders; 
	use Controllers\Bids; 

	Class Package_List extends _Package {
		private $user_id;
		private $noof_items = 21; // max no of packages per page

		function __construct() {
			start_session();
			$this->user_id = get_userid();
			
			// delete all the expired bids
			Bids::delete_expiredbids();
		}

		function show_userpackages($page){
			$user_id = $this->user_id;
			$packages = Packages::find_byuser($user_id);

			// no of pages
			$noof_pages = noof_pages($packages, 8); // get the no of pages
			$page =  configure_page($page, $noof_pages); // configure the selected page

			// stop me, if page is not numeric
			if(!is_numeric($page) || !$page)
				return;

			$start = ($page - 1) * 8; // initializer
			$countdown = 0;

	        $max_desclen = 235;
        ?>
        
        	<!-- content -->
            <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 10px;min-height: 200px">
                <button data-bs-toggle="modal" data-bs-target="#create-package" id="create-a-package" class="btn bg-light text-center">
                    <i class="fa-solid fa-plus" title="Create a Package" data-bs-toggle="tooltip" data-bs-placement="top"></i>
                </button>
            </div>
            <!-- content (end) -->

        <?php 
			for ($i=$start; $i < count($packages); $i++) { 
				// STOP COUNTING, WHEN THE NO OF ALLOWED ITEMS ARE COMPLETE
				if($countdown >= 8)
					break;
				$countdown++;

				$package = $packages[$i];

				$package_id = $package->id;
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
		?>

	            <!-- package -->
	            <div class="col-sm-12 col-md-4 col-lg-4 package-details-container">
	                <div class="package-details border bg-light">
	                    <p class="package-header fw-bold"><?php echo $country.', '.$state ?></p>
	                    
	                    <div class="container-fluid package-items">
	                        <span>
	                            <i class="fa-solid fa-people-group"></i> 
	                            <?php echo $people; ?> people
	                        </span>
	                        <span>
	                            <i class="fa-solid fa-calendar-days"></i> 
	                            <!-- 20th, August 2022 - 31st, May 2023 -->
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

	                        		echo $desc_len > $max_desclen ? substr($description, 0, $max_desclen).'<a href="https://travelpackagebids.com/package.php?package=country-state-id">...</a>' : $description; 
	                        	?>
	                        </p>
	                    </div>
	                    <br>
	                    
	                    <div>
	                        <button data-bs-toggle="modal" data-bs-target="#create-package" role="button" class="btn btn-secondary edit-package">
	                            <i class="fa-solid fa-pencil" title="Edit Package" data-bs-toggle="tooltip" data-bs-placement="top"></i>
	                            <input type="hidden" class="package_id" value="<?php echo $package_id; ?>">
	                        </button>
	                        <button role="button" class="btn btn-danger delete-package" title="Delete Package" data-bs-toggle="tooltip" data-bs-placement="top">
	                            <i class="fa-solid fa-trash"></i>
	                            <input type="hidden" class="package_id" value="<?php echo $package_id; ?>">
	                        </button>
	                        <button role="button" class="btn view-bids">
	                            View Bids <i class="fa-solid fa-eye"></i>
	                            <input type="hidden" class="package_id" value="<?php echo $package_id; ?>">
	                            <input type="hidden" class="is_owner" value="yes">
	                        </button>
	                        <a href="https://travelpackagebids.com/package.php?package=<?php echo $country.'-'.$state.'-'.$package_id; ?>" class="btn view-listing">
                                View Listing <i class="fa-solid fa-right-long"></i>
                            </a>
	                    </div>
	                </div>
	            </div>
	            <!-- package (end) -->
	            <br>

		<?php
			}
		}
        
        function packages_pagination($page, $show_saved = false){
			$user_id = $this->user_id;
			
            // packages			
			$packages = $show_saved ? $this->get_packages($user_id) : Packages::find_byuser($user_id);
			
			$base_url = 'https://travelpackagebids.com/user/profile.php?';
			if($show_saved)
				$base_url .= 'bids=show&';
			
			pagination($page, $packages, $base_url, 8);
        }

        function view_bids(){
        ?>	
	        <!-- make offer (modal) -->
	        <div class="modal fade" id="modal-package-bids" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h5 class="modal-title text-center fw-bold" id="staticBackdropLabel">My Bids</h5>
	                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	                    </div>

	                    <div class="modal-body" style="margin-top: 0;padding-top: 0">
		                    <!-- list of bids -->
		                    <div style="padding: 15px">
		                        <!-- bids -->
		                        <div id="package-bids" class="container-fluid">
		                            
		                        </div>
		                        <!-- END bids -->
		                    </div>
		                    <!-- END list of bids -->
	                    </div>
	                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- make offer (modal_end) -->
        <?php
        }

        function createpackage_form($user){
        ?>
        	<!-- modal -->
	        <div class="modal fade" id="create-package" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <h5 class="modal-title text-center fw-bold" id="staticBackdropLabel">Create/Edit Package</h5>
	                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	                    </div>

	                    <div class="modal-body create-package-body">
	                        <form action="https://travelpackagebids.com/app/src/profile/package/receivepackage.php" method="POST"autocomplete="off">
	                            <!-- country -->
	                            <div class="mb-3">
	                                <label for="package-country" class="form-label fw-bold">Country</label>
	                                <select class="form-select form-select-sm countries" id="package-country" aria-label=".form-select-sm" name="country" required>
	                                    <option selected>Select Country</option>
	                                </select>
	                            </div>

	                            <!-- state -->
	                            <div class="mb-3">
	                                <label for="package-state" class="form-label fw-bold">State</label>
	                                <select class="form-select form-select-sm" id="package-state" aria-label=".form-select-sm" name="state" required>
	                                    <option selected>Select State</option>
	                                </select>
	                            </div>

	                            <!-- no of people -->
	                            <div class="mb-3">
	                                <label for="package-people" class="form-label fw-bold">No of People</label>
	                                <input type="number" class="form-control" id="package-people" name="people" required>
	                            </div>

	                            <!-- dates -->
	                            <label for="package-date" class="form-label fw-bold">Travel Date</label>
	                            
	                            <div class="input-group mb-3" id="package-date">
	                                <span class="input-group-text">From</span>
	                                <input type="date" class="form-control" id="package-from-date" placeholder="Select From" aria-label="Select From" name="from_date" required>
	                            </div>
 
	                            <div class="input-group mb-3">
	                                <span class="input-group-text">To</span>
	                                <input type="date" class="form-control" id="package-to-date" placeholder="Select To" aria-label="Select To" name="to_date" required>
	                            </div>

	                            <!-- description -->
	                            <div class="mb-3">
	                                <label for="package-description" class="form-label fw-bold">Description (<small style="font-size: 11px;color: grey">Please include details of your requirements, such as <span class="fw-bold">Number of people going, Children, Date of travel, Star category of hotels, Any special places to visit, If a guide is needed or not, etc.</span> </small>)</label>
	                                <textarea class="form-control" id="package-description" rows="3" style="resize: none;" name="description"></textarea>
	                            </div>

	                            <!-- if user wants to edit -->
	                            <input type="hidden" name="package_id" id="package-id">
	                            <input type="hidden" name="package_phonecode" class="phone-code" id="package-phonecode">
	                            <input type="hidden" id="profile-exists" value="<?php echo $user->phone; ?>">

	                            <div class="submit-package" style="margin-top: 20px;float: right;">
	                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
	                                <button type="submit" class="btn btn-primary">Submit <i class="fa-solid fa-arrow-right"></i></button>
	                            </div>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- end modal -->
        <?php
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
        
        // PACKAGES that user's have bid on
        public function show_savedpackages($page){
			$user_id = $this->user_id;
            
			$loggedin_user = Users::find($user_id);

            // PACKAGES
			$packages = $this->get_packages($user_id);
            
            $noof_pages = noof_pages($packages, $this->noof_items); // get the no of pages
			$page =  configure_page($page, $noof_pages); // configure the selected page

			// stop me, if page is not numeric
			if(!is_numeric($page) || !$page)
				return;

			$start = ($page - 1) * $this->noof_items; // initializer
			$countdown = 0;
			
	        $max_desclen = 220; // max length for description

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
                <div class="col-sm-12 col-md-6 col-lg-4 package-details-container other-packages">
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

	                        		echo $desc_len > $max_desclen ? substr($description, 0, $max_desclen).'<a href="https://travelpackagebids.com/package.php?package=country-state-id">...</a>' : $description; 
	                        	?>
                            </p>
                        </div>
                        <br>
                        
                        <div>	
                 			<!-- data-bs-toggle="modal" data-bs-target="#create-package-bid" -->
                            <button style="margin-bottom: 5px;" role="button" class="btn place-bid <?php echo $user_isblocked ? 'no-bidding' : '' ?>">
                                Place Bid
                                <input type="hidden" class="package_id" value="<?php echo $package->id; ?>">
                            </button>
	                       
                            <a style="margin-bottom: 5px;" href="https://travelpackagebids.com/package.php?package=<?php echo $country.'-'.$state.'-'.$package->id; ?>" class="btn view-listing">
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

			if(count($packages)==0){
				echo '<div class="text-center other-packages" style="font-size: 25px;">You\'ve not placed a bid on any package yet. You can do that <a href="https://travelpackagebids.com">here</a>.</div>';
			}
		}
        
        private function get_packages($user_id){
			$packages = Packages::find_savedpackages($user_id);
			
			return $packages;
        }
	}
?>