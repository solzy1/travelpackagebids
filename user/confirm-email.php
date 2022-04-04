<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/travelpackagebids/app/src/user/_user.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/travelpackagebids/app/src/user/verifyuser.php";
    
    $user = new _User();

    if(!isset($_SESSION['travelpackagebids.com']['new_email']) && !isset($_GET['verify'])) {
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

        <style>
        body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
        </style>
    </head>
    <body style="text-align: center">
        <div class="container-fluid" style="margin-top: 100px;">
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
                    
                    // check if the url is valid (i.e. it's store in the database and belongs to an unverified user)
                    $is_valid = $verifyuser->check();
                    
                    echo $is_valid ? "" : "<h3 style='color: red'>The url link is invalid!</h3>";
                }
            ?>
        </div>

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>
    </body>
</html>