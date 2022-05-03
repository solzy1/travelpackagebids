<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/profile/_profile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/profile/package/list.php';

    $title = "Packages"; 

    // prevent access to profile page, without logging in
    $user_id = get_userid();

    $profile = new _Profile();
    $is_admin = $profile->useris_admin(); // check if user is admin

    if($user_id<=0 || !$is_admin)
        gotopage('https://travelpackagebids.com');

    $user = $profile->get_user($user_id); // get user details

    $response_msg = '';
    $success = true;

    if(isset($_SESSION['travelpackagebids.com']['status'])){
        $success = $_SESSION['travelpackagebids.com']['status_issuccess'];
        $response_msg = '<i class="fa-solid fa-circle-'.($success ? 'check' : 'exclamation').'"></i>'.$_SESSION['travelpackagebids.com']['status'];

        $profile->unset_responsevalues(); // unset status and status_issuccess values
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>TravelPackaeBids | <?php echo $title; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="https://travelpackagebids.com/css/profile.css">
        <link href="https://travelpackagebids.com/css/sidebars.css" rel="stylesheet">
        <link href="https://travelpackagebids.com/css/admin.css" rel="stylesheet">
        
        <style>
            body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            
            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                  font-size: 3.5rem;
                }
            }
        </style>
    </head>
    <body style="overflow-x: hidden;">
        <!-- main-header -->
        <div class="container-fluid profile-header">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
              <a href="https://travelpackagebids.com" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Travelpackagebids</span>
              </a>

              <ul class="nav nav-pills justify-content-center">
                <li class="nav-item"><a href="https://travelpackagebids.com" class="nav-link text-white">Home</a></li>
                <li class="nav-item"><a href="https://travelpackagebids.com/user/profile.php" class="nav-link text-white profile-menu">My packages</a></li>
                <li class="nav-item"><a href="https://travelpackagebids.com/user/profile.php?bids=show" class="nav-link text-white profile-menu" title="All of the packages you've Bid on" data-bs-toggle="tooltip" data-bs-placement="auto">Other packages</a></li>
                <li class="nav-item"><a href="https://travelpackagebids.com/admin" class="nav-link text-white profile-menu">Packages</a></li>
                <li class="nav-item"><a href="https://travelpackagebids.com/admin/travel-agents" class="nav-link text-white profile-menu">Travel agents</a></li>
                <li class="nav-item"><a href="https://travelpackagebids.com/user/profile.php?user=member" class="nav-link text-white profile-menu">My profile</a></li>
                <li class="nav-item dropdown" style="padding-top: 9px">
                  <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">

                    <!-- <img src="https://github.com/mdo.png" alt=""  class="rounded-circle me-2"> -->
                    <strong>
                        <i class="fas fa-circle-user" style="font-size: 20px;"></i> 
                        <?php 
                            echo $user->name;
                        ?>
                    </strong>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser" style="z-index: 99 !important">
                    <li><a class="dropdown-item" href=""><i class="fa-solid fa-user"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item logout" role="button"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                  </ul>
                </li>
              </ul>
            </header>
        </div>
        <!-- end main-header -->

        <!-- page content -->
        <div class="container-fluid page-content d-flex">
            
            <!-- header -->
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-light profile-menu-bar">
                <a href="https://travelpackagebids.com" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                  <span class="fs-4">Travelpackagebids</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                  <li class="nav-item">
                    <a href="https://travelpackagebids.com" class="nav-link text-white d-flex" aria-current="page">
                        <i class="bi bi-house-door-fill" style="width: 16px;height: 16px;margin-right: 10px;"></i>
                      Home
                    </a>
                  </li>
                  <li>
                    <a href="https://travelpackagebids.com/user/profile.php" class="nav-link text-white d-flex profile-menu">
                        <i class="bi bi-box2-fill" style="width: 16px;height: 16px;margin-right: 10px;"></i>My packages
                    </a>
                  </li>

                  <li>
                    <a title="All of the packages you've Bid on" data-bs-toggle="tooltip" data-bs-placement="auto" href="https://travelpackagebids.com/user/profile.php?bids=show" class="nav-link text-white d-flex profile-menu">
                        <i class="bi bi-box2-heart-fill" style="width: 16px;height: 16px;margin-right: 10px;"></i>Other packages
                    </a>
                  </li>
                  
                  <li>
                    <a href="https://travelpackagebids.com/admin/packages" class="nav-link text-white d-flex profile-menu">
                        <i class="bi bi-boxes" style="width: 16px;height: 16px;margin-right: 10px;"></i>
                        Packages
                    </a>
                  </li>
                  <li>
                    <a href="https://travelpackagebids.com/admin/travel-agents" class="nav-link text-white d-flex profile-menu">
                        <i class="bi bi-people-fill" style="width: 16px;height: 16px;margin-right: 10px;"></i>
                        Travel agents
                    </a>
                  </li>
                  <li>
                    <a href="https://travelpackagebids.com/user/profile.php?user=member" class="nav-link text-white d-flex profile-menu">
                        <i class="bi bi-person-fill" style="width: 16px;height: 16px;margin-right: 10px;"></i>
                        My profile
                    </a>
                  </li>
                </ul>
                <hr>
                <div class="dropdown">
                  <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

                    <!-- <img src="https://github.com/mdo.png" alt=""  class="rounded-circle me-2"> -->
                    <strong>
                        <i class="fas fa-circle-user" style="font-size: 20px;"></i>  
                        <?php 
                            echo $user->name;
                        ?>
                    </strong>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="https://travelpackagebids.com/user/profile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item logout" role="button"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                  </ul>
                </div>
            </div>
            <!-- header (end)-->
            
            <!-- main page content -->
            <div class="container-fluid main-body" style="z-index: 9 !important">
                
                <!-- header -->
                <div style="margin-bottom: 20px;">
                    <p class="page-link page-title bg-light" style="color: black;font-weight: bold;font-size: 20px;"><?php echo $title; ?></p>
                </div>
                <!-- header (end) -->
                
                <!-- body -->   
                <div class="main-body-content container-fluid" style="padding: 0;">

                    <div class="status-report text-center" style="color: white;background-color: <?php echo $success ? 'green' : 'red'; ?>;opacity: <?php echo empty($response_msg) ? '0' : '1'; ?>;padding: 5px;">
                        <?php echo $response_msg; ?>
                    </div>

                    <!-- main body -->
                    <div class="row">
                        
                        <?php 
                            main_body();
                        ?>
                    </div>

                    <!-- main body (end) -->
                </div>
            </div>
            <!-- main page content (end) -->
            
            <!-- footer -->
            
            <!-- footer (end) -->
            
        </div>
        <!-- page content (end) -->
        
        <!-- bids -->
        <div class="modal fade" id="modal-package-bids" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop-bids" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center fw-bold" id="staticBackdrop-bids">Bids</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body" style="margin-top: 10px;padding-top: 0">

                        <div id="package-bids" class="container-fluid">
                            
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END bids -->


        <!-- make offer (modal) -->
        <div class="modal fade" id="create-agent-location" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop-location" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center fw-bold" id="staticBackdrop-location">Location(s)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body container-fluid" style="margin-top: 0;padding-top: 0">
                        <div class="row">
                            <!-- create bid section-->
                            <div class="col-12 col-lg-4 create-bid-section">
                                <div class="create-location-status text-center d-none" style="color: white;padding: 5px;">
                                    
                                </div>
                                
                                <div id="create-location-form" style="margin-top: 15px;">
                                    <!-- make an offer -->
                                    <div class="mb-3">
                                        <label for="package-country" class="form-label fw-bold">Country</label>
                                        <select class="form-select form-select-sm countries agent-country" id="package-country" aria-label=".form-select-sm" name="country" required>
                                            <option value="" selected>Select Country</option>
                                        </select>
                                    </div>

                                    <!-- state -->
                                    <div class="mb-3">
                                        <label for="package-state" class="form-label fw-bold">State</label>
                                        <select class="form-select form-select-sm agent-state" id="package-state" aria-label=".form-select-sm" name="state" required>
                                            <option value="" selected>Select State</option>
                                        </select>
                                    </div>

                                    <!-- if user wants to edit -->
                                    <input type="hidden" name="user_id" id="user-id">
                                    <input type="hidden" name="phone_code" class="phone-code">
        
                                    <div class="submit-package" style="margin-top: 20px;float: right;">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary" id="location-submit" style="background-color: #03C6C1;border-color: #03C6C1;">Assign <i class="fa-solid fa-location-arrow"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- end create bid section-->

                            <!-- list of locations -->
                            <div class="col-12 col-lg-8" style="margin-top: 10px;">
                                <div class="col-12 d-none text-center location-list-status" style="color: white;padding: 5px;">
                                    showing now
                                </div>

                                <!-- locations -->
                                <div id="agent-locations" class="container-fluid">
                                    
                                </div>
                                <!-- END locations -->
                            </div>
                            <!-- END list of locations -->
                        </div>
                    </div>
                    <!-- END modal body -->
                </div>
            </div>
        </div>
        <!-- create location (modal_end) -->

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>
        
        <!-- my scripts -->
        <script src="https://travelpackagebids.com/js/2_profile-menu.js"></script>
        <script src="https://travelpackagebids.com/js/1_countries.js"></script>
        <script src="https://travelpackagebids.com/js/2_packages.js"></script>
        
        <script src="https://travelpackagebids.com/js/1_user.js"></script>
        <script src="https://travelpackagebids.com/js/6_profile.js"></script>
        <script src="https://travelpackagebids.com/js/sidebars.js"></script>

        <!-- ADMIN -->
        <script src="https://travelpackagebids.com/js/6_bids.js"></script>
        <script src="https://travelpackagebids.com/js/admin/1_list.js"></script>
        <script src="https://travelpackagebids.com/js/admin/1_delete.js"></script>
        <script src="https://travelpackagebids.com/js/admin/1_activate.js"></script>
        <script src="https://travelpackagebids.com/js/admin/1_search.js"></script>
        <script src="https://travelpackagebids.com/js/admin/2_locations.js"></script>
        <script src="https://travelpackagebids.com/js/admin/1_bids.js"></script>
        <script src="https://travelpackagebids.com/js/admin/1_admin.js"></script>
    </body>

</html>