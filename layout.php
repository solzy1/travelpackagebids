<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/packages/index.php';
    // require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/_src.php';

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
            
            <!-- header -->
            <nav class="navbar navbar-expand-md sticky-top navbar-light bg-light page-header">
              <div class="container-fluid">
                <a class="navbar-brand website-title" href="https://travelpackagebids.com">TravelPackageBids</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-header" aria-controls="nav-header" aria-expanded="false" aria-label="Toggle navigation" style="background-color: white !important">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="nav-header">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-right">
                        <li class="nav-item">
                          <a class="nav-link active page-header-item" aria-current="page" href="https://travelpackagebids.com">Home</a>
                        </li>
                        <?php 
                            if($user_id <= 0) { 
                        ?>
                                <li class="nav-item">
                                  <a class="nav-link page-header-item" href="https://travelpackagebids.com/user/sign-in.php">Log In</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link page-header-item" href="https://travelpackagebids.com/user/sign-up.php">Sign Up</a>
                                </li>
                        <?php 
                            }
                            else {
                        ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;font-size: 20px;">
                                        <i class="fa-solid fa-circle-user"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <li>
                                            <a class="dropdown-item" href="https://travelpackagebids.com/user/profile.php">
                                                <i class="fa-solid fa-user"></i> Profile
                                            </a>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        <li>
                                            <a class="dropdown-item" id="logout" href="#log-out">
                                                <i class="fa-solid fa-right-from-bracket"></i> Log Out
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                        <?php 
                            }
                        ?>
                    </ul>
                </div>
              </div>
            </nav>
            
            <?php 
            	if($title=="TravelPackaeBids | Home"){
            ?>

		            <!-- jumbotron -->
		            <div class="jumbotron jumbotron-fluid bg-light page-content-intro">
		                <div class="container-fluid" style="color: white">
		                    <h1 class="display-4 intro-title">
		                        #1 marketplace to buy and sell <span style="color: #03C6C1">travel packages</span>
		                    </h1>
		                    <p class="lead packagelistings intro-others">
		                        <i class="fa-solid fa-bars-staggered"></i>
		                        Live listings: <span style="margin-right: 10px;"><?php echo $packages->noofpackages; ?></span>
		                        
		                        <span style="font-weight: bold;">Ready to sell? <a href="https://travelpackagebids.com/user/sign-up.php" class="sellnow" style="color: white">Sell Now</a></span>
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
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center fw-bold" id="staticBackdropLabel"><span class="bid-action">Make an</span> Offer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="margin-top: 0;padding-top: 0">
                        <div class="create-bid-status text-center" style="color: white;padding: 5px;opacity: 0">
                            
                        </div>
                        
                        <!-- action="https://travelpackagebids.com/app/src/bids/receive.php" method="POST" autocomplete="off" -->
                        <div id="bid-form" style="margin-top: 15px">
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
                                <button type="submit" class="btn btn-primary" id="bid-submit" style="background-color: #03C6C1;border-color: #03C6C1;">     Send Offer <i class="fa-solid fa-send"></i>
                                </button>
                            </div>
                        </div>
                    </div>
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
        <script src="js/user.js"></script>
        <script src="js/bids.js"></script>
        <script src="js/comments.js"></script>
        <script src="js/layout.js"></script>
    </body>

</html>
