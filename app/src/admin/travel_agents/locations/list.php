<?php
	// start up eloquent
	require_once '_locations.php';
	// require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/profile/_profile.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

	use Controllers\Locations;
	use Controllers\Countries;
	use Controllers\States;
	use Controllers\Users;

	Class List_Locations extends _Locations {
		private $location;

		function __construct($location) {
			$this->location = $location;
		}

		public function show(){
			$user_id = $this->location->get_user_id();

			if(!isset($user_id))
				return;

			$locations = Locations::find_byuser($user_id);

			$states = Locations::find_bystates($user_id);

			$user = Users::find($user_id);

			$profile = isset($user->profile->name) ? $user->profile : '';
			$name = isset($profile->name) ? $profile->name : explode('@', $user->email)[0];
		?>
			<!-- header -->
			<div class="text-center">
                <p class="lead fw-bold" style="word-wrap: break-word;"><span class="text-capitalize"><?php echo $name; ?></span> deals in <span style="color: grey;font-size: 16px;"><?php echo count($locations); ?> Countries and <?php echo count($states); ?> States</span></p>
            </div>

            <!-- list of locations -->
            <div class="row" style="max-height: 400px;overflow-y: auto;overflow-x: hidden;">

        <?php 
        	foreach ($locations as $location) {
        		$location_id = $location->id;
        		
        		$country = $location->country->name;

        		$states = Locations::find_bystates($user_id, $location->country_id);
        		$noof_states = count($states);
        ?>
                <!-- location -->
                <div class="col-12 col-md-6 location-<?php echo $location_id; ?>" style="margin-bottom: 10px;">
                    <div class="agent-locations border-top">
                        <div style="padding: 0;margin-bottom: 0;text-align: right;">
                            <a role="button" class="btn delete-location delete-country" title="Remove <?php echo $country; ?>" data-bs-toggle="tooltip" data-bs-placement="top" onclick="delete_location(this)" style="padding: 0px 5px 0px 0px;margin-bottom: 0">
                                <i class="fas fa-times" style="padding: 0;margin-bottom: 0"></i>
                            </a>
                            <input type="hidden" class="location-id" value="<?php echo $location_id; ?>">
                        </div>

                        <div class="dropdown" style="padding: 0px 10px 6px 10px;margin: 0;">
                        <?php 
                        	if($noof_states > 0){
                        ?>
                            <a role="button" class="d-flex align-items-center text-black text-decoration-none dropdown-toggle text-capitalize btn" id="dropdownUser-<?php echo $location_id; ?>" data-bs-toggle="dropdown" aria-expanded="false" style="padding-left: 0;margin-left: 0;padding-top: 0">
                                <b style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $country; ?></b>
                            </a>
                        <?php
                        	}
                        	else{
                        ?>
                        	<a role="button" class="d-flex align-items-center text-black text-decoration-none text-capitalize btn" style="padding-left: 0;margin-left: 0;padding-top: 0">
                                <b style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $country; ?></b>
                            </a>
                        <?php
                        	}
                        ?>
                            <small style="padding: 0 6px 10px 0px;color: grey;margin: 0;">active in <b style="color: black"><?php echo $noof_states; ?></b> state(s)</small>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow text-white" aria-labelledby="dropdownUser-<?php echo $location_id; ?>" style="max-height: 250px;overflow-y: auto;position: absolute !important;">
                            <?php 
                            	foreach ($states as $i => $state) {
                            		$state = $state->state;

                            		if(!isset($state->name))
                            			continue;

                            		$name = $state->name;
                            ?>
	                                <li>
	                                    <a class="dropdown-item btn" role="button" style="width: inherit;">
	                                        <i class="fa-solid fa-times delete-location text-lowercase" title="Remove <?php echo $name; ?>" data-bs-toggle="tooltip" data-bs-placement="top" onclick="delete_location(this)"></i>
	                                        <span><?php echo $name; ?></span>
	                                        <input type="hidden" class="location-id" value="<?php echo $location_id; ?>">
	                                    </a>
	                                </li>
                            <?php
                            		if($i + 1 < $noof_states){
                            			echo '<li><hr class="dropdown-divider"></li>';
                            		}
                            	}
                            ?>
                            </ul>
                        </div>
                        <!-- END dropdown -->

                    </div>
                </div>
                <!-- END location -->
        <?php 
        	}
        ?>
            </div>

		<?php
		}
	}
?>