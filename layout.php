<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/packages/index.php';
    // require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/_src.php';

    $title = "TravelPackaeBids | ".$title;
    $user_id = get_userid();

    $packages = new Packages_List();
?>

<!DOCTYPE html> 
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<meta http-equiv='cache-control' content='no-cache'>-->
        <!--<meta http-equiv='expires' content='0'>-->
        <!--<meta http-equiv='pragma' content='no-cache'>-->
        <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
        
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="css/layout.css">
        <link rel="stylesheet" href="css/package.css">
        <link rel="stylesheet" href="css/comments.css">
        
        <style>
            body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
        </style>
    </head>
    <body>
        <!-- page content -->
        <div class="container-fluid page-content">
            
            <!-- main-header -->
            <div class="container-fluid sticky-top page-header">
                <header class="d-flex flex-wrap justify-content-center py-3 mb-4" style="margin-bottom: 0px !important;">
                  <a href="/travelpackagebids" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-4">Travelpackagebids</span>
                  </a>

                  <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item"><a href="/travelpackagebids" class="nav-link text-white">Home</a></li>
                    <?php 
                        if($user_id <= 0) {
                    ?>
                        <li class="nav-item"><a href="/travelpackagebids/user/sign-in.php" class="nav-link text-white user-login">Log In</a></li>
                        <li class="nav-item"><a href="/travelpackagebids/user/sign-up.php" class="nav-link text-white user-signup">Sign Up</a></li>
                    <?php
                        } 
                        else {
                    ?>
                        <li class="nav-item dropdown" style="padding-top: 9px">
                          <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">

                            <!-- <img src="https://github.com/mdo.png" alt=""  class="rounded-circle me-2"> -->
                            <strong>
                                <i class="fas fa-circle-user" style="font-size: 20px;"></i> 
                                <?php 
                                    $profile = $packages->get_profile();
                                    $name = $profile->name;

                                    echo $name;
                                ?>
                            </strong>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                            <li><a class="dropdown-item" href="/travelpackagebids/user/profile.php?user=member"><i class="fa-solid fa-user"></i> My profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item btn" href="/travelpackagebids/user/profile.php"><i class="fa-solid fa-box"></i> My packages</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item btn logout" role="button"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                          </ul>
                        </li>
                    <?php 
                        } 
                    ?>
                  </ul>
                </header>
            </div>
            <!-- end main-header -->

            <?php 
            	if($title=="TravelPackaeBids | Home"){
            ?>
		            <!-- jumbotron -->
		            <div class="jumbotron jumbotron-fluid bg-light page-content-intro" style="padding-top: 20px;">
		                <div class="container-fluid" style="color: white">
		                    <h1 class="display-4 intro-title">
		                        #1 marketplace to buy and sell <span style="color: #03C6C1">travel packages</span>
		                    </h1>
		                    <p class="lead packagelistings intro-others">
		                        <i class="fa-solid fa-bars-staggered"></i>
		                        Live listings: <span style="margin-right: 10px;"><?php echo $packages->noofpackages; ?></span>
		                        
		                        <span style="font-weight: bold;">Ready to sell? <a href="<?php echo '/travelpackagebids/user/'.(isset($user_id) && !empty($user_id) ? 'profile.php' : 'sign-up.php'); ?>" class="sellnow" style="color: white">Sell Now</a></span>
		                    </p>
		                </div>
		            </div>

            <?php
            	}
            ?>
            <!-- header (end)-->
            
            
            <!-- main page content -->
            <div class="container-fluid main-body">
                <br>
                <?php
                	body($packages);
                ?>
            </div>
            <!-- main page content (end) -->
            
            
            <!-- footer -->
            
            <!-- footer (end) -->
            
        </div>
        <!-- page content (end) -->
        
        <!-- make offer (modal) -->
        <div class="modal fade" id="create-package-bid" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center fw-bold" id="staticBackdropLabel"><span class="bid-action">Make an</span> Offer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="margin-top: 0;padding-top: 0">
                        <!-- create bid section-->
                        <div class="create-bid-section">
                            <div class="create-bid-status text-center" style="color: white;padding: 5px;opacity: 0">
                                
                            </div>
                            
                            <!-- action="/travelpackagebids/app/src/bids/receive.php" method="POST" autocomplete="off" -->
                            <div id="bid-form" style="margin-top: 15px;">
                                <!-- make an offer -->
                                <!-- <label for="package-bid" class="form-label fw-bold">Make an Offer</label> -->
    
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="bid-offer" name="offer" placeholder="Make Offer Here" required>
                                </div>
    
                                <!-- description -->
                                <!-- <div class="mb-3">
                                    <label for="package-description" class="form-label fw-bold">Description</label>
                                    <textarea class="form-control" id="package-description" rows="3" style="resize: none;" name="description"></textarea>
                                </div> -->
    
                                <!-- if user wants to edit -->
                                <input type="hidden" name="package_id" id="package-id">
    
                                <div class="submit-package" style="margin-top: 20px;float: right;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                    <button type="submit" class="btn btn-primary" id="bid-submit" style="background-color: #03C6C1;border-color: #03C6C1;">Send Offer <i class="fa-solid fa-send"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- end create bid section-->
                    </div>

                    <!-- list of bids -->
                    <div class="border-top" style="padding: 15px">
                        <!-- bids -->
                        <div id="package-bids" class="container-fluid">
                            
                        </div>
                        <!-- END bids -->
                    </div>
                    <!-- END list of bids -->
                </div>
            </div>
        </div>
        <!-- make offer (modal_end) -->

        <!-- sign up (modal) -->
        <div class="modal fade" id="modal-signup-now" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center fw-bold" id="staticBackdropLabel1">Sign Up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center" id="sign-up-first">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    <!-- check if user is logged in -->
                    <?php 
                        echo $packages->is_userloggedin();
                    ?>
                </div>
            </div>
        </div>
        <!-- sign up (modal_end) -->

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- font awesome library -->
        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>
        
        <!-- my scripts -->
        <!-- <script src="js/countries.js"></script> -->
        <script src="js/user5.js"></script>
        <script src="js/bids4.js"></script>
        <script src="js/comments4.js"></script>
        <script src="js/layout4.js"></script>
    </body>

</html>