<?php
	// start up eloquent
	require_once '_packages.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/profile/_profile.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

	use Controllers\Packages;
	use Controllers\Countries;
	use Controllers\States; 
	use Controllers\Profiles; 
	use Controllers\Bids; 

	Class Packages_List {
		private $user_id;
		private $noof_items = 21; // max no of packages per page
		public $noofpackages;

		function __construct() {
			start_session();

			$this->user_id = get_userid(); // get user id
		}

		public function show($page){
			$user_id = $this->user_id;
            
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

				$noof_bids = count($package->bids); // count no of bids

				$user = $package->user;
				$status = $package->status->status;
		?>

				<!-- package -->
				<tr>
                    <th scope="row"><input type="checkbox" name="all" class="form-check-input row-check" value="<?php echo $package->id; ?>"></th>
                    <td><?php echo $country; ?></td>
                    <td><?php echo $state; ?></td>
                    <td><?php echo $people; ?></td>
                    <td>
                        <span class="fw-bold">From:</span> <?php echo $from_date; ?>
                        <br>
                        <span class="fw-bold">To:</span> <?php echo $to_date; ?>
                    </td>
                    <td>
                    	<a role="button" class="link view-bids row-view-bids" title="View Bids" data-bs-toggle="tooltip" data-bs-placement="top" style="<?php echo $this->deactivate($noof_bids==0); ?>">
                    		<?php echo $noof_bids; ?>
	                        <input type="hidden" class="package_id" value="<?php echo $package->id; ?>">
                    	</a>
                    </td>
                    <td class="bg-light row-action">
                        <a class="btn btn-success row-activate toggle-activate-<?php echo $package->id; ?>" role="button" title="Activate package" data-bs-toggle="tooltip" data-bs-placement="top" style="<?php echo $this->deactivate($status=='active'); ?>">
                        	<i class="fas fa-circle-check"></i>
                        </a>
                        <a class="btn btn-warning text-white row-deactivate toggle-activate-<?php echo $package->id; ?>" role="button" title="De-activate package" data-bs-toggle="tooltip" data-bs-placement="top" style="<?php echo $this->deactivate($status=='inactive'); ?>"><i class="fas fa-circle-pause"></i></a>
                        <a class="btn btn-danger row-delete" role="button" title="Delete package" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-trash"></i></a>
                        <a href="/travelpackagebids/package.php?package=<?php echo $country.'-'.$state.'-'.$package->id; ?>" class="btn btn-primary" title="View Listing" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-eye"></i></a>

                        <input type="hidden" class="id" value="<?php echo $package->id; ?>">
                    </td>
                </tr>
                <!-- package (end) -->

		<?php
			}
		}
        
        private function deactivate($de_activate){
        	if($de_activate){
        		return 'pointer-events: none; text-decoration: none; cursor: not-allowed; opacity: 0.4';
        	}

        	return '';
        }

        private function get_packages(){
        	$search = get_searchvalues('packages');
			$packages = Packages::index($search);
			
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
            
			$base_url = '/travelpackagebids/admin?';
			
			pagination($page, $packages, $base_url, $this->noof_items);
		}
	}
?>