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

                foreach ($bids as $bid) {
                    if($is_owner){
                        $profile = Profiles::find_byuser($bid->bidder_id);
                        
                        // if profile doesn't exist, move right along
                        if(!isset($profile->id))
                            continue;
                            
                        $phone_code = $profile->country->phone_code;
                        $phone = $phone_code.$profile->phone;
                        $agent_name = $profile->name;
                    }

                    $offer = number_format($bid->offer);
            ?>
                    <!-- agent-offer -->
                    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 10px;">
                        <div class="border text-black bg-light agent-offer">
                            <p class="agent-details" style="font-size: 25px;font-weight: lighter;word-wrap: break-word;">
                                <span style="font-size: 17px;color: grey">BID: </span>
                                <b style="font-size: 20px">$</b><?php echo $offer; ?>
                                <?php 
                                    if($is_owner){
                                ?>
                                        <span class="agent-name" style="font-size: 15px;color: grey;"> by <b class="text-capitalize"><?php echo $agent_name; ?></b></span>
                                <?php
                                    }
                                ?>

                            </p>

                            <?php 
                                if($is_owner){
                            ?>
                                    <!-- bid-action -->
                                    <div class="call-agent-section">
                                        <a href="tel:<?php echo $phone; ?>" class="btn call-agent">
                                            <i class="fa-solid fa-phone"></i> Call Agent
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