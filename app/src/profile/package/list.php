<?php




	require_once '_package.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

	use Controllers\Packages;
	use Controllers\Countries; 
	use Controllers\States; 

	Class Package_List extends _Package {
		private $user_id;

		function __construct() {
			start_session();
			$this->user_id = get_userid();
		}

		function show_userpackages($page){
			$user_id = $this->user_id;
			$packages = Packages::find_byuser($user_id);

			// no of pages
			$noof_pages = noof_pages($packages, 8); // get the no of pages
			$page =  configure_page($page, $noof_pages); // configure the selected page

			// stop me, if page is not numeric
			if(!is_numeric($page))
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

			// show the bids container
			$this->view_bids();
		}
        
        function packages_pagination($page){
			$user_id = $this->user_id;
			
            // packages			
			$packages = Packages::find_byuser($user_id);
			
			$base_url = 'https://travelpackagebids.com/user/profile.php?';
			
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
	}
?>