<?php
    // start up eloquent
    require_once '_bids.php';

    use Controllers\Bids;
    use Controllers\Profiles;
    use Controllers\Packages;

    Class List_Bids extends _Bids {
        private $user_id;
        private $bid;

        function __construct($bid) {
            $this->bid = $bid;

            start_session();

            $this->user_id = get_userid(); // get user id
        }

        public function bid_offers($is_owner){
            $package_id = $this->bid->get_package_id(); // get package id

            $useris_admin = $this->useris_admin();

            $bids = Bids::find_bypackage($package_id, $useris_admin); //find all the bids for the given package
            $noof_bids = count($bids);

            $package = Packages::find($package_id);

            $state = $package->state;
            $country = $state->country->name;
            $state = $state->name;
        ?>

            <h4 class="fw-bold text-center" style="margin-bottom: 18px;"><?php echo $noof_bids > 0 ? $noof_bids : 'No'; ?> Bid(s) so far <span style="color: grey;font-size: 13px;font-weight: lighter;">for <b class="text-capitalize" ><?php echo $country.', '.$state; ?></b></span></h4>
            <div class="row" style="max-height: 400px;overflow-y: auto;">
            <?php
                $is_owner = !empty($is_owner) && $is_owner=='yes' ? true : false;
                $user_id = $this->user_id;

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
                    $users_bid = $bid->bidder_id==$user_id;
            ?>
                    <!-- agent-offer -->
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4" style="margin-bottom: 10px;">
                        <div class="border agent-offer <?php echo $users_bid ? 'text-white' : 'text-black'; ?>" style="<?php echo $users_bid ? 'background-color: #34DB89' : ''; ?>">
                            <p class="agent-details" style="font-size: 25px;font-weight: lighter;word-wrap: break-word;">
                                <span style="font-size: 17px;color: <?php echo $users_bid ? 'white' : 'grey'; ?>">BID: </span> <?php echo $offer; ?>
                                <?php 
                                    if($is_owner){
                                ?>
                                        <span class="agent-name" style="font-size: 15px;color: <?php echo $users_bid ? 'white' : 'grey'; ?>;"> by <b class="text-capitalize"><?php echo $agent_name; ?></b></span>
                                <?php
                                    }
                                ?>

                            </p>
                            <?php 
                                if($users_bid){
                            ?>
                                <button class="btn btn-light edit-bid" onclick="show_offer(this)" style="margin-bottom: 5px;">
                                    <i class="fas fa-pen" role="button" title="Edit your Bid" data-bs-toggle="tooltip" data-bs-placement="top"></i>
		                            <input type="hidden" class="package_id" value="<?php echo $bid->package_id; ?>">
                                    <div class="bid-details-container">
                                        <input type="hidden" class="offer" value="<?php echo round($bid->offer); ?>">
                                        <?php 
                                            $start = strtotime($bid->updated_at);
                                            $end = strtotime($bid->deadline);

                                            $deadline = abs($end - $start) / 3600;
                                            $deadline = round($deadline > 1 ? $deadline - 1 : $deadline); // it's adding an hour to the result
                                        ?>

                                        <input type="hidden" class="deadline" value="<?php echo $deadline; ?>">
                                    </div>
                                </button>
                            <?php 
                                }
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
    }
?>