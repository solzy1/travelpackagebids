<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/profile/_profile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/profile/package/list.php';

    $title = "TravelPackaeBids | Home";

    // prevent access to profile page, without logging in
    $user_id = get_userid();
    if($user_id<=0)
        gotopage('https://travelpackagebids.com');

    $profile = new _Profile();
    $user = $profile->get_user($user_id);

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
        <title><?php echo $title; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>

        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="../css/profile.css">
        <link href="../css/sidebars.css" rel="stylesheet">
        
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
    <body>
        <!-- main-header -->
        <div class="container-fluid profile-header">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
              <a href="https://travelpackagebids.com" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Travelpackagebids</span>
              </a>

              <ul class="nav nav-pills justify-content-center">
                <li class="nav-item"><a href="https://travelpackagebids.com" class="nav-link text-white">Home</a></li>
                <li class="nav-item"><a href="https://travelpackagebids.com/user/profile.php" class="nav-link text-white profile-menu">My packages</a></li>
                <!-- <li class="nav-item"><a role="button" class="nav-link text-white profile-menu">My bids</a></li> -->
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
                  <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
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
                    <a href="https://travelpackagebids.com/user/profile.php?user=member" class="nav-link text-white d-flex profile-menu" >
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
                    <li><a class="dropdown-item" href=""><i class="fa-solid fa-user"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item logout" role="button"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                  </ul>
                </div>
            </div>
            <!-- header (end)-->
            
            <!-- main page content -->
            <div class="container-fluid main-body">
                <div class="status-report text-center" style="color: white;background-color: <?php echo $success ? 'green' : 'red'; ?>;opacity: <?php echo empty($response_msg) ? '0' : '1'; ?>;padding: 5px;">
                    <?php echo $response_msg; ?>
                </div>
                
                <!-- header -->
                <div style="margin-bottom: 20px;">
                    <p class="page-link page-title bg-light" style="color: black;font-weight: bold;font-size: 20px;">My Packages</p>
                </div>
                <!-- header (end) -->
                
                <!-- body -->   
                <div class="main-body-content container-fluid" style="padding: 0;">

                    <!-- main body -->
                    <div class="row">

                        <?php 
                            if(isset($_GET['user'])){
                                $user = isset($_GET['user']) ? $_GET['user'] : '';

                                $profile->form($user_id);
                            }
                            else{
                                $list = new Package_List();

                                $page = isset($_GET['page']) ? $_GET['page'] : '';

                                $list->show_userpackages($page);

                                $list->packages_pagination($page);
                            }
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
        
        <!-- modal -->
        <div class="modal fade" id="create-package" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center fw-bold" id="staticBackdropLabel">Create/Edit Package</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body create-package-body">
                        <form action="https://travelpackagebids.com/app/src/profile/package/receivepackage.php" method="POST"autocomplete="off">
                            <!-- country -->
                            <div class="mb-3">
                                <label for="package-country" class="form-label fw-bold">Country</label>
                                <select class="form-select form-select-sm countries" id="package-country" aria-label=".form-select-sm" name="country" required>
                                    <option selected>Select Country</option>
                                </select>
                            </div>

                            <!-- state -->
                            <div class="mb-3">
                                <label for="package-state" class="form-label fw-bold">State</label>
                                <select class="form-select form-select-sm" id="package-state" aria-label=".form-select-sm" name="state" required>
                                    <option selected>Select State</option>
                                </select>
                            </div>

                            <!-- no of people -->
                            <div class="mb-3">
                                <label for="package-people" class="form-label fw-bold">No of People</label>
                                <input type="number" class="form-control" id="package-people" name="people" required>
                            </div>

                            <!-- dates -->
                            <label for="package-date" class="form-label fw-bold">Travel Date</label>
                            <div class="input-group mb-3" id="package-date">
                                <span class="input-group-text">From</span>
                                <input type="date" class="form-control" id="package-from-date" placeholder="Select From" aria-label="Select From" name="from_date" required>
                                <!-- <span class="input-group-text">To</span>
                                <input type="date" class="form-control" placeholder="Select To" aria-label="Select To" name="to_date" required> -->
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">To</span>
                                <input type="date" class="form-control" id="package-to-date" placeholder="Select To" aria-label="Select To" name="to_date" required>
                            </div>

                            <!-- description -->
                            <div class="mb-3">
                                <label for="package-description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control" id="package-description" rows="3" style="resize: none;" name="description"></textarea>
                            </div>

                            <!-- if user wants to edit -->
                            <input type="hidden" name="package_id" id="package-id">
                            <input type="hidden" name="package_phonecode" class="phone-code" id="package-phonecode">
                            <input type="hidden" id="profile-exists" value="<?php echo $user->phone; ?>">

                            <div class="submit-package" style="margin-top: 20px;float: right;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                <button type="submit" class="btn btn-primary">Submit <i class="fa-solid fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>
        
        <!-- my scripts -->
        <script src="../js/profile-menu.js"></script>
        <script src="../js/countries.js"></script>
        <script src="../js/packages.js"></script>
        
        <script src="../js/user.js"></script>
        <script src="../js/profile.js"></script>
        <script src="../js/sidebars.js"></script>
    </body>

</html>
