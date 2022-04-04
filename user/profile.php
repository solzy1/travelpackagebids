<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/travelpackagebids/app/src/profile/_profile.php';

    $title = "TravelPackaeBids | Home";

    $profile = new _Profile();
    $response_msg = '';
    $success = true;

    if(isset($_SESSION['travelpackagebids.com']['status'])){
        $response_msg = $_SESSION['travelpackagebids.com']['status'];
        $success = $_SESSION['travelpackagebids.com']['status_issuccess'];

        $profile->unset_responsevalues(); // unset status and status_issuccess values
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--<link rel="stylesheet" href="css/layout.css">-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        
        <style>
            body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
            .page-content {
                padding: 0px;
            }
            nav.page-header {
                padding-right: 50px !important;
                padding-left: 50px !important;
            }
            .page-content-intro {
                padding-right: 100px !important;
                padding-left: 100px !important;
                background-color: #141424 !important;
            }
            .intro-title {
                /*font-size: 20px !important;*/
                font-weight: bold !important;
                width: inherit;
                max-width: 700px !important;
                word-wrap: break-word !important;
            }
            .intro-others {
                font-size: 13px;
            }
            .main-body {
                padding-right: 110px !important;
                padding-left: 110px !important;
            }
            .package-details {
                padding: 10px 12px 10px 12px !important;
                cursor: pointer;
                border-radius: 3px;
            }
            .package-details:hover {
                background-color: white !important;
                box-shadow: 2px 2px 1px #ECF0F1;
            }
            .package-items span {
                margin-right: 8px;
            }
            .package-items span i {
                margin-right: 3px;
            }
            .package-details-container {
                padding-left: 0px !important;
                margin-bottom: 13px;
            }
            .package-details-container:hover {
                /*background-color: white !important;*/
                /*box-shadow: 3px 3px 1px #aaaaaa;*/
            }
            .place-bid {
                background-color: inherit;
                color: #03C6C1;
                border-color: #03C6C1;
            }
            .place-bid:hover {
                background-color: #03C6C1;
                color: white;
            }
            .view-listing {
                background-color: #3498DB;
                color: white !important;
            }
            .view-listing:hover {
                background-color: #2874A6;
            }
        </style>
    </head>
    <body>
        <!-- page content -->
        <div class="container-fluid page-content">
            
            <!-- header -->
            <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light page-header" style="background-color: #141424 !important;">
                <a class="navbar-brand" href="#" style="color: white !important">TravelPackageBids</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation" style="background-color: white !important">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarToggler">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0 navbar-right">
                        <!--<li class="nav-item active">-->
                        <!--    <a class="nav-link" href="https://travelpackagebids.com">TravelPackageBids <span class="sr-only">(current)</span></a>-->
                        <!--</li>-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#profile" id="userdropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;font-size: 20px;">
                                <i class="fa-solid fa-circle-user"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="userdropdown">
                                <a class="dropdown-item" href="https://travelpackagebids.com/user/profile.php">
                                    <i class="fa-solid fa-user"></i> Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="https://travelpackagebids.com/user/log-out.php">
                                    <i class="fa-solid fa-right-from-bracket"></i> Log Out
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="status-report text-center" style="color: white;background-color: <?php echo $success ? 'green' : 'red'; ?>;opacity: <?php echo empty($response_msg) ? '0' : '1'; ?>;padding: 5px;">
                <i class="fa-solid fa-circle-<?php echo $success ? 'check' : 'exclamation'; ?>"></i>
                <?php echo $response_msg; ?>
            </div>
            <!-- header (end)-->
            
            <!-- main page content -->
            <div class="container-fluid main-body">
                <br>
                <!-- header -->
                <div>
                    <nav aria-label="...">
                        <ul class="pagination pagination-md" style="background-color: #F7F9F9">
                            <li class="page-item disabled" aria-current="page">
                                <span class="page-link">My Packages</span>
                            </li>
                            <!-- <li class="page-item">
                                <a class="page-link" href="#" style="border-radius: 0px !important;">My Bids</a>
                            </li> -->
                        </ul>
                    </nav>
                </div>
                <!-- header (end) -->
                
                <!-- body -->
                
                <div class="main-body-content">
                    <!-- content -->
                    <button data-bs-toggle="modal" data-bs-target="#create-package" class="btn bg-light text-center" style="width: 150px;height: 150px;">
                        <i class="fa-solid fa-plus" style="font-size: 50px"></i>
                    </button>
                    <!-- content (end) -->

                    <!-- pagination -->
                    <nav aria-label="Page navigation" style="margin-top: 20px;">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <!--<li class="page-item">-->
                            <!--    <a class="page-link" href="#">2</a>-->
                            <!--</li>-->
                            <!--<li class="page-item">-->
                            <!--    <a class="page-link" href="#">3</a>-->
                            <!--</li>-->
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
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

                    <div class="modal-body">
                        <form action="/travelpackagebids/app/src/profile/package/receivepackage.php" method="POST" target="_blank" autocomplete="off">
                            <!-- country -->
                            <div class="mb-3">
                                <label for="package-country" class="form-label fw-bold">Country</label>
                                <select class="form-select form-select-sm" id="package-country" aria-label=".form-select-sm" name="country" required>
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
                                <input type="date" class="form-control" placeholder="Select From" aria-label="Select From" name="from_date" required>
                                <!-- <span class="input-group-text">To</span>
                                <input type="date" class="form-control" placeholder="Select To" aria-label="Select To" name="to_date" required> -->
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">To</span>
                                <input type="date" class="form-control" placeholder="Select To" aria-label="Select To" name="to_date" required>
                            </div>

                            <!-- description -->
                            <div class="mb-3">
                                <label for="package-description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control" id="package-description" rows="3" style="resize: none;" name="description"></textarea>
                            </div>

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
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>
        
        <script src="../js/countries.js"></script>
        <script src="../js/layout.js"></script>
    </body>

</html>
