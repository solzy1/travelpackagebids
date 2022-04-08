<?php
	// start up eloquent
	// require_once $_SERVER['DOCUMENT_ROOT'].'/start.php';

	// include the validation file that holds the class Validation
	// require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/validation/validation.php';
	require_once '_package.php';
	// require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

	use Controllers\Packages;
	use Controllers\Countries; 
	use Controllers\States; 

	Class Package_List extends _Package {
		private $user_id;

		function __construct() {
			start_session();
			$this->user_id = get_userid();
		}

		function show_userpackages(){
			$user_id = $this->user_id;

			$packages = Packages::find_byuser($user_id);
	        $max_desclen = 235;

			foreach ($packages as $package) {
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
	            <div class="col-sm-6 col-md-4 col-lg-4 package-details-container">
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
	                            <i class="fa-solid fa-pencil"></i>
	                            <input type="hidden" class="package_id" value="<?php echo '1'; ?>">
	                        </button>
	                        <!-- https://travelpackagebids.com/user/profile/delete.php?user_id=<?php echo $user_id; ?> -->
	                        <a href="#" role="button" class="btn btn-danger delete-package">
	                            <i class="fa-solid fa-trash"></i>
	                        </a>
	                        <!-- https://travelpackagebids.com/package.php?package=country-state-id -->
	                        <a href="#" class="btn view-listing">
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
	}
?>