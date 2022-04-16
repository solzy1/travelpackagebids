<?php
	// start up eloquent
	require_once '_travel_agents.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/profile/_profile.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

	use Controllers\Packages;
	use Controllers\Countries;
	use Controllers\States; 
	use Controllers\Profiles; 
	use Controllers\Bids; 
	use Controllers\Users; 

	Class Travel_Agents {
		private $user_id;
		private $noof_items = 21; // max no of users per page
		public $noofusers;

		function __construct() {
			start_session();

			$this->user_id = get_userid(); // get user id
		}

		public function show($page){
			$user_id = $this->user_id;
            
            // PACKAGES
			$users = $this->get_users();
            
            $noof_pages = noof_pages($users, $this->noof_items); // get the no of pages
			$page =  configure_page($page, $noof_pages); // configure the selected page

			// stop me, if page is not numeric
			if(!is_numeric($page) || !$page)
				return;

			$start = ($page - 1) * $this->noof_items; // initializer
			$countdown = 0;
			
	        $max_desclen = 220; // max length for description

			for ($i=$start; $i < count($users); $i++) {  
			    if($countdown >= $this->noof_items)
					break;
				$countdown++;


				$user = $users[$i];

				$email = $user->email;
				$profile = $user->profile;

				$country = isset($profile->country->name) ? $profile->country : '';
				$name = !empty($country) ? $profile->name : '-';
				$phone = !empty($country) ? $country->phone_code.$profile->phone : '-';
				$country = !empty($country) ? $country->name : '-';

				$noof_packages = count($user->packages);

				$status = $user->status->status;
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
                        <?php echo $country; ?>
                    </td>
                    <td>
                    	<?php echo $noof_packages; ?>
                    </td>
                    <td class="bg-light row-action">
                        <a class="btn btn-success row-activate toggle-activate-<?php echo $user->id; ?>" role="button" title="Activate user" data-bs-toggle="tooltip" data-bs-placement="top" style="<?php echo $this->deactivate($status=='active'); ?>">
                        	<i class="fas fa-circle-check"></i>
                        </a>
                        <a class="btn btn-warning text-white row-deactivate toggle-activate-<?php echo $user->id; ?>" role="button" title="De-activate user" data-bs-toggle="tooltip" data-bs-placement="top" style="<?php echo $this->deactivate($status=='inactive'); ?>"><i class="fas fa-circle-pause"></i></a>
                        <a class="btn btn-danger row-delete" role="button" title="Delete user" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-trash"></i></a>

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

        private function get_users(){
        	$search = get_searchvalues('travel-agents');
			$users = Users::index($search);
			
			return $users;
        }
        
		public function pagination($page){
            // users	
            $users = $this->get_users();
            
			$base_url = '/traveluserbids/admin/travel-agents?';
			
			pagination($page, $users, $base_url, $this->noof_items);
		}
	}
?>