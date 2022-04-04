
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
