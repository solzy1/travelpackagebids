<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/user/_user.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/user/forgot-password.php';
    
    $resetpassword = new Forgotpassword();

    if(!isset($_SESSION['travelpackagebids.com']['reset_email'])) {
        $user->gotopage('/travelpackagebids');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

        <!-- Latest compiled and minified CSS -->
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

        <style>
        body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
        </style>
    </head>
    <body style="text-align: center">
        <!-- main-header -->
        <div class="container-fluid sticky-top page-header">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4" style="margin-bottom: 0px !important;">
              <a href="/travelpackagebids" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Travelpackagebids</span>
              </a>

              <ul class="nav nav-pills justify-content-center">
                <li class="nav-item"><a href="/travelpackagebids" class="nav-link text-white">Home</a></li>
                <li class="nav-item"><a href="/travelpackagebids/user/sign-in.php" class="nav-link text-white user-login">Log In</a></li>
                <li class="nav-item"><a href="/travelpackagebids/user/sign-up.php" class="nav-link text-white user-signup">Sign Up</a></li>
              </ul>
            </header>
        </div>
        <!-- end main-header -->

        <div class="container-fluid justify-content-center d-flex" style="margin-top: 100px;">
            <?php 
                $reset_email = isset($_SESSION['travelpackagebids.com']['reset_email']) ? $_SESSION['travelpackagebids.com']['reset_email'] : '';
                
                if(!isset($_GET['email']) && !isset($_GET['user'])) {
                    echo '<h3>We\'ve Just Sent a message to <span style="color: #03C6C1;">'.$reset_email.'</span>.<br>Kindly proceed to your email, to verify your email address.</h3>';
                }
                else {
                    // check if the email and user_id exists, else go to homepage
                    $resetpassword->user_exists($_GET['email'], $_GET['user']);
            ?>
                <!-- reset password -->
                <div class="justify-content-center" style="width: inherit; max-width: 320px;">
                    <h3>Reset the Password for</h3>
                    <h4 style="color: #03C6C1;word-wrap: break-word"><?php echo $_GET['email']; ?></h4>
                    <br>
    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold" style="float: left !important;">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required aria-describedby="passwordHelpBlock" style="width: ">
                        <div id="passwordHelpBlock" class="form-text">
                          Your password must be 8-20 characters long
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold" style="float: left !important;">Re-Password</label>
                        <input type="password" class="form-control" id="re-password" name="re-password" required aria-describedby="re-passwordHelpBlock">
                        <div id="re-passwordHelpBlock" class="form-text">
                          Your password and re-password, must be the same
                        </div>
                    </div>
    
                    <input type="hidden" name="key" id="key" value="<?php echo $_GET['user']; ?>">
    
                    <div class="submit-signup" style="margin-top: 20px;float: right;">
                        <button type="submit" class="btn btn-primary disabled" id="submit-password">Sign Up <i class="fa-solid fa-circle-check"></i></button>
                    </div>
                </div>
                <!-- END reset password-->
            <?php 
                }
            ?>
        </div>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>

        <script src="../js/confirm-email4.js"></script>
    </body>
</html>