<?php
	// start up eloquent
	require_once '_packages.php';

	use Controllers\Packages;
	use Controllers\Countries; 
	use Controllers\States; 

	Class Packages_List {
		private $user_id;
		public $noofpackages;

		function __construct() {
			start_session();

			$this->user_id = get_userid(); // get user id
			$this->get_noofpackages(); // count the no of active traveling packages
		}

		private function get_noofpackages(){
			$packages = Packages::index(); // get the available packages
			$this->noofpackages = count($packages); // count and store the no of available/live packages
		}

		public function show(){
			$user_id = $this->user_id;

			$packages = Packages::index_orderbydate('desc');

	        $max_desclen = 220; // max length for description

			foreach ($packages as $package) {
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

				$user = $package->user;
		?>
				<!-- package -->
                <div class="col-sm-12 col-md-6 col-lg-6 package-details-container">
                    <div class="package-details border bg-light">
                        <p class="package-header fw-bold"><?php echo $country.', '.$state ?></p>
                        
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
                        	<?php 
                        		if($user_id!=$user->id){ 
                        			$bids = $package->bids;
                        			// if logged user's id == one of the offers of this package
                         	?>	
                         			 <!-- data-bs-toggle="modal" data-bs-target="#create-package-bid" -->
		                            <button role="button" class="btn place-bid">
		                                Place Bid
		                                <input type="hidden" class="package_id" value="<?php echo $package->id; ?>">
		                            </button>
                        	<?php 
                        		} 
                        	?>
                            <a href="https://travelpackagebids.com/package.php?package=<?php echo $country.'-'.$state.'-'.$package->id; ?>" class="btn view-listing">
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

		private function checkbids_foruser($bids){
			for ($i=0; $i < count($bids)/2; $i++) { 
				# code...
			}
		}

		public function is_userloggedin(){
			$user_loggedin = is_userloggedin();

            return '<input type="hidden" id="user-loggedin" value="'.$user_loggedin.'">';
		}
	}
?>