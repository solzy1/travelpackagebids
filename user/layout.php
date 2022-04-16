<?php
	// include the validation file that holds the class Validation
	require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/user/_user.php';

	$user = new _User($title);

	// get status
	$status = $user->getresponse();
	$user->reset_sessionvalues(); // reset session values
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Travelpackagebids | <?php echo $title; ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
	<!--===============================================================================================-->

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<!--===============================================================================================-->
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="../css/animate/animate.css">
	<!--===============================================================================================-->	
		<link rel="stylesheet" type="text/css" href="../css/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="../css/select2/select2.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="../css/util.css">
		<link rel="stylesheet" type="text/css" href="../css/main.css">
	<!--===============================================================================================-->
	</head>
	<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../images/img-01.png" alt="IMG">
				</div>

				<form action="/travelpackagebids/app/src/user/receive.php" class="login100-form validate-form">
					<p class="login100-form-title">
						<span style="padding-bottom: 20px;">Travelpackagebids</span>
						<br><br>
						<small style="font-weight: lighter !important;">
						<?php 
							if($title=="Sign In")
								echo 'Login';
							else if($title=="Sign Up")
								echo 'Sign up';
							else
								echo 'Forgot Password';
						?>
						</small>
					</p>
					<!-- display status -->
					<p style="color: red;text-align: center;"><?php echo $status; ?></p>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					
					<?php 
						// only show the password input, if title is 'sign in'
						if($title=="Sign In"){
					?>
							<div class="wrap-input100 validate-input" data-validate = "Password is required">
								<input class="input100" type="password" name="pass" placeholder="Password">
								<span class="focus-input100"></span>
								<span class="symbol-input100">
									<i class="fa fa-lock" aria-hidden="true"></i>
								</span>
							</div>
					<?php 
						}
					?>

					<input type="hidden" name="form-type" value="<?php echo $title?>">

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							<?php echo $title=="Forgot Password" ? "Reset Password" : $title; ?>
						</button>
					</div>

					<div class="text-center p-t-12" style="<?php $user->show_forgotpassword($title); ?>">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="/travelpackagebids/user/forgot-password.php">
							Email / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<?php $user->useraction(); ?>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--===============================================================================================-->
	<script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../js/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../js/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>

</body>
</html>