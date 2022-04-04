<?php
// if (session_status() == PHP_SESSION_NONE) {
//  session_start();
// }

  // include($_SERVER['DOCUMENT_ROOT'] . '/cocoruns/travelpackagebids/app/Funcs/Layout/_Layout.php');
    
    // include($_SERVER['DOCUMENT_ROOT'] . '/project blog/travelpackagebids/app/functions/posts/layout.php');

    // $layout = new Layout();
    // $content = [];
    $title = "TravelPackaeBids | Home";
?>

<!DOCTYPE html> 
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--<link rel="stylesheet" href="css/layout.css">-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        
        <style>
            body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
            .page-content {
                padding: 0px;
            }
            nav {
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
            <nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light" style="background-color: #141424 !important;">
                <a class="navbar-brand" href="#" style="color: white !important">TravelPackageBids</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation" style="background-color: white !important">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarToggler">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="float: right !important">
                        <!--<li class="nav-item active">-->
                        <!--    <a class="nav-link" href="https://travelpackagebids.com">TravelPackageBids <span class="sr-only">(current)</span></a>-->
                        <!--</li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="https://travelpackagebids.com/user/sign-in.php" style="color: white !important">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://travelpackagebids.com/user/sign-up.php" style="color: white !important">Sign Up</a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link disabled" href="#">Disabled</a>-->
                        <!--</li>-->
                    </ul>
                </div>
            </nav>
            
            <!-- jumbotron -->
            <div class="jumbotron jumbotron-fluid bg-light page-content-intro">
                <div class="container-fluid" style="color: white">
                    <h1 class="display-4 intro-title">
                        #1 marketplace to buy and sell <span style="color: #03C6C1">travel packages</span>
                    </h1>
                    <p class="lead packagelistings intro-others">
                        <i class="fa-solid fa-signal-stream"></i>
                        Live listings: <span style="margin-right: 10px;">0</span>
                        
                        <span style="font-weight: bold;">Ready to sell? <a href="https://travelpackagebids.com/user/sign-up.php" class="sellnow" style="color: white">Sell Now</a></span>
                    </p>
                </div>
            </div>
            <!-- header (end)-->
            
            
            <!-- main page content -->
            <div class="container-fluid main-body">
                <br>
                <h2>Browse Latest Travel packages</h2>
                
                <br>
                
                <!-- main body -->
                <div class="row" style="padding-left: 17px;">
                    <!-- package -->
                    <div class="col-sm-12 col-md-6 col-lg-6 package-details-container">
                        <div class="package-details  border bg-light">
                            <p class="header" style="margin: 0px 0px 8px 0px;font-size: 20px;">Country, State</p>
                            
                            <div class="container-fluid package-items" style="padding: 0px;color: grey;font-size: 12px;word-wrap: break-word;">
                                <span>
                                    <i class="fa-solid fa-people-group"></i> 
                                    no of people
                                </span>
                                <span>
                                    <i class="fa-solid fa-calendar-days"></i> 
                                    20th, August 2022 - 31st, May 2023
                                </span>
                                <span>
                                    <i class="fa-solid fa-comments"></i> 
                                    3 Comments
                                </span>
                                <span>
                                    <i class="fa-solid fa-handshake-simple"></i> 
                                    3 Offers
                                </span>
                            </div>
                            <br>
                            
                            <div>
                                <p style="font-size: 15px">This is a once is a lifetime trip, you shouldn't miss it</p>
                            </div>
                            <br>
                            
                            <div>
                                <button role="button" class="btn place-bid">
                                    Place Bid
                                </button>
                                <a role="button" class="btn view-listing">
                                    View Listing <i class="fa-solid fa-right-long"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- package (end) -->
                    <br>
                    
                </div>
                <!-- main body (end) -->
            </div>
            <!-- main page content (end) -->
            
            
            <!-- footer -->
            
            <!-- footer (end) -->
            
        </div>
        <!-- page content (end) -->
        
        
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>
        
        <!-- <script src="js/modal.js"></script> -->
    </body>

</html>
