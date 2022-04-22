<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/user/_user.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/user/verifyuser.php';
    
    $user = new _User();

    if(!isset($_SESSION['travelpackagebids.com']['new_email']) && !isset($_GET['verify'])) {
        $user->gotopage('https://travelpackagebids.com');
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
                    <li class="nav-item dropdown">
                        <li class="nav-item">
                            <a class="nav-link page-header-item" href="https://travelpackagebids.com/user/sign-in.php">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link page-header-item" href="https://travelpackagebids.com/user/sign-up.php">Sign Up</a>
                        </li>
                    </li>
                </ul>
            </div>
          </div>
        </nav>

        <div class="container-fluid justify-content-center d-flex" style="margin-top: 100px;">
            <?php 
                $verify = isset($_GET['verify']) ? $_GET['verify'] : '';
                
                if(empty($verify)){
                    $new_email = 'your email address';

                    if(isset($_SESSION['travelpackagebids.com']['new_email'])){
                        $new_email = $_SESSION['travelpackagebids.com']['new_email']; // assign the newly registered email address
                        unset($_SESSION['travelpackagebids.com']['new_email']); // remove email address
                    }
            ?>
                <h3>We've Just Sent a message to <span style="color: #03C6C1;"><?php echo $new_email; ?></span>.<br>Kindly proceed to your email, to verify your email address.</h3>
            <?php
                }
                else {
                    $verifyuser = new VerifyUser($_GET['verify']);
                    
                    // 0ef6e34ad9a6db61aeff1778acbda3c45
                    
                    // check if the url is valid (i.e. it's store in the database and belongs to an unverified user)
                    $key_exists = $verifyuser->key_exists();
                    
                    echo $key_exists ? "" : "<h3 style='color: red'>The url link is invalid!</h3>";

                    // if key doesn't exist, for an unverified user, to go homepage
                    if(!$key_exists){
                        gotopage('https://travelpackagebids.com');
                    }
                    else{
            ?>
                    <div class="justify-content-center" style="width: inherit; max-width: 300px;">
                        <h3>Set your Password</h3>
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

                        <input type="hidden" name="key" id="key" value="<?php echo $_GET['verify']; ?>">

                        <div class="submit-signup" style="margin-top: 20px;float: right;">
                            <button type="submit" class="btn btn-primary disabled" id="submit-password">Sign Up <i class="fa-solid fa-circle-check"></i></button>
                        </div>
                    </div>
            <?php
                    }
                }
            ?>
        </div>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>

        <script src="../js/1_confirm-email.js"></script>
    </body>
</html>