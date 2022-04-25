<?php
	// start up eloquent
	require_once '_travel_agents.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/profile/_profile.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/validation/validation.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/packages/index.php';

	use Controllers\Packages;
	use Controllers\Countries;
	use Controllers\States; 
	use Controllers\Profiles; 
	use Controllers\Bids; 
	use Controllers\Users; 
	use Controllers\Locations; 

	Class Travel_Agents {
		private $user_id;
		private $noof_items = 21; // max no of users per page
		public $noofusers;

		function __construct() {
			start_session();

			$this->user_id = get_userid(); // get user id
		}

		function validate($inputtype, $value){ 
			// validate userinput
			$validation = new Validation($inputtype, $value);

			return $validation->validateinput();
		}

		public function show($page){
			$user_id = $this->user_id;
            
            // USERS
        	$search = get_searchvalues('travel-agents');
			$users = $this->get_users($search);
            
            $noof_pages = noof_pages($users, $this->noof_items); // get the no of pages
			$page =  configure_page($page, $noof_pages); // configure the selected page

			// stop me, if page is not numeric
			if(!is_numeric($page) || !$page)
				return;

			$start = ($page - 1) * $this->noof_items; // initializer
			$countdown = 0;
			
	        $max_desclen = 220; // max length for description
            
            $bidding_values = get_biddingvalues();
            
			$package_list = new Packages_List();
            
			for ($i=$start; $i < count($users); $i++) {  
				// FILTER ALLOWED TO BID AND NOT ALLOWED TO BID
				$user = $users[$i];
                
			    $user_isblocked = $package_list->user_isblocked($user, $bidding_values['package_id']);
			    
	        	$filter = isset($search['filter']) ? $search['filter'] : '';
	        	
	        	if($filter=="Barred from bidding" && !$user_isblocked){
		        	continue;
		        }
	        	else if($filter=="Allowed to bid" && $user_isblocked){
	        		continue;
	        	}
	        	
			    if($countdown >= $this->noof_items)
					break;
				$countdown++;

				$email = $user->email;
				$profile = $user->profile;

				$country = isset($profile->country->name) ? $profile->country : '';
				$name = !empty($country) ? $profile->name : '-';
				$phone = !empty($country) ? $country->phone_code.$profile->phone : '-';
				$country = !empty($country) ? $country->name : '-';

				$noof_packages = count($user->packages);

				$status = $user->status->status;
				// $noof_locations = count($user->locations);

				// locations
				$countries = Locations::find_byuser($user->id);
				$states = Locations::find_bystates($user->id);

				$is_admin = $user->userrole->name=='admin';
		?>

				<!-- user -->
				<tr>
                    <th scope="row">
                    	<input type="checkbox" name="all" class="form-check-input row-check" value="<?php echo $user->id; ?>">
                    </th>
                    <td><?php echo $email; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $phone; ?></td>
                    <td>
                        <a role="button" class="link view-locations row-view-locations" data-bs-toggle="modal" data-bs-target="#create-agent-location">
                    		<span title="View Countries" data-bs-toggle="tooltip" data-bs-placement="top">
                    			<?php echo count($countries); ?>
                    		</span>
                        	<input type="hidden" class="user-id" value="<?php echo $user->id; ?>">
                    	</a>
                    </td>
                    <td>
                        <a role="button" class="link view-locations row-view-locations" data-bs-toggle="modal" data-bs-target="#create-agent-location">
                    		<span title="View States" data-bs-toggle="tooltip" data-bs-placement="top">
                    			<?php echo count($states); ?>
                    		</span>
                        	<input type="hidden" class="user-id" value="<?php echo $user->id; ?>">
                    	</a>
                    </td>
                    <td>
                    	<?php echo $noof_packages; ?>
                    </td>
                    <td class="bg-light row-action">
                    <?php 
                    	if(!$is_admin){
                    ?>
                        <a class="btn btn-success row-activate toggle-activate-<?php echo $user->id; ?>" role="button" title="Activate user" data-bs-toggle="tooltip" data-bs-placement="top" style="<?php echo $this->deactivate($status=='active'); ?>">
                        	<i class="fas fa-circle-check"></i>
                        </a>
                        <a class="btn btn-warning text-white row-deactivate toggle-activate-<?php echo $user->id; ?>" role="button" title="De-activate user" data-bs-toggle="tooltip" data-bs-placement="top" style="<?php echo $this->deactivate($status=='inactive'); ?>"><i class="fas fa-circle-pause"></i>
                        </a>
                        <a class="btn btn-danger row-delete" role="button" title="Delete user" data-bs-toggle="tooltip" data-bs-placement="top">
                        	<i class="fas fa-trash"></i>
                        </a>
                    <?php 
                    	}
                    ?>
                        <a data-bs-toggle="modal" data-bs-target="#create-agent-location" class="btn btn-primary row-create-location" role="button">
                        	<i class="fas fa-location-dot" title="Create Location" data-bs-toggle="tooltip" data-bs-placement="top"></i>
                        	<input type="hidden" class="user-id" value="<?php echo $user->id; ?>">
                        </a>
                    <?php 
                    	if(!$is_admin){
                    ?>
                        <a class="btn btn-info text-white row-allow-bidding allow-bidding allow-bidding-<?php echo $user->id.' '.($user_isblocked ? '' : 'no-bidding'); ?>" role="button" title="Allow to Bid" data-bs-toggle="tooltip" data-bs-placement="top">
                        	<i class="fas fa-handshake"></i>
                        </a>
                        <a class="btn btn-dark text-white row-allow-bidding prevent-bidding allow-bidding-<?php echo $user->id.' '.($user_isblocked ? 'no-bidding' : ''); ?>" role="button" title="Prevent from Bidding" data-bs-toggle="tooltip" data-bs-placement="top">
                        	<i class="fas fa-handshake-slash"></i>
                        </a>
                    <?php 
                    	}
                    ?>

                        <input type="hidden" class="id" value="<?php echo $user->id; ?>">
                    </td>
                </tr>
                <!-- user (end) -->

		<?php
			}
		}
        
        private function deactivate($de_activate){
        	return deactivate($de_activate);
        }

        private function get_users($search = []){
			$users = Users::index($search);
			
			return $users;
        }
        
		public function pagination($page){
            // users	
            $users = $this->get_users();
            
			$base_url = '/traveluserbids/admin/travel-agents?';
			
			pagination($page, $users, $base_url, $this->noof_items);
		}

	    public function set_package($package, $bidding){
	        $package = $this->validate_packagerequest($package);


	        return set_biddingvalues($package, $bidding); // set the package values for allowing/preventing bidding
	    }

	    public function validate_packagerequest($package){
	    	$request = filter_packagerequest($package, $this);

	    	$package = array('package_id' => '', 'package_title' => '');

	    	$package_id = '';

			if(isset($request['package_id']) && !empty($request['package_id'])){
				$package_id = $request['package_id'];

				$package = Packages::find($package_id);

				if(isset($package->id)){
					$state = $package->state->name; // get state
					$country = $package->state->country->name; // get country, of state
					$user = $package->user; // get country, of state

					// check if the country and name, fits the package id
					if($state==$request['state'] && $country==$request['country']){
						$user = $package->user;

						$profile = new _Profile();

						$profile = $profile->get_user($user->id);

						$package_title = $country.', '.$state.' <span style="font-size: 13px;">by '.$profile->name.'</span>';

						$package = array('package_id' => $request['package_id'], 'package_title' => $package_title);
					}
				}
			}

	    	return $package;
	    }

	    public function package_isset($package){
	    	return isset($package['package_id']) && !empty($package['package_id']) && ($package['action']=='allow' || $package['action']=='prevent');
	    }

	    public function no_bidding($bid_request, $action){
	    	if(isset($bid_request['action']) && $bid_request['action']==$action)
            	return 'no-bidding';

           	return '';
	    }
	}
?>