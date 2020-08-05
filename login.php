<?php 
require_once 'main.php';

require_once 'header.php';
if (isset($_POST['login'])) {
	$pass= $_POST['password'];
	$username= $_POST['username'];

	if (isset($_SESSION['incorrect_password']) && isset($_POST['security_code'])) {
		$security_code= $_POST['security_code'];
		if ($admin->Login($username,md5($pass))==1) {
			if (($_SESSION['security_code'] == $security_code) && (!empty($_SESSION['security_code']))) {
			setcookie("iproject",$username.':'.md5($pass),time()+860000);
			header("location: ./");
			}
			else{
				Toast('error', 'خطا', 'کد داخل کادر را اشتباه وارد کردید');

			}
		}
		else{
			Toast('error', 'خطا', 'نام کاربری یا رمز عبور اشتباه است');
		}
	}
	else{
		if ($admin->Login($username,md5($pass))==1) {
			setcookie("iproject",$username.':'.md5($pass),time()+860000);
			header("location: ./");
		}
		else{
			$_SESSION['incorrect_password'] = "1";
			Toast('error', 'خطا', 'نام کاربری یا رمز عبور اشتباه است');
		}
		
	}
}

echo '
		<!--=========================================================================================-->
		<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
		<!--=========================================================================================-->
		<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
		<!--=========================================================================================-->
		<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
		<!--=========================================================================================-->
		<link rel="stylesheet" type="text/css" href="themes/'.$themes.'/login/css/util.css">
		<link rel="stylesheet" type="text/css" href="themes/'.$themes.'/login/css/main.css">
  </head>

  <body>
  	<div class="limiter">
  		<div class="container-login100">
  			<div class="wrap-login100">
  				<div class="login100-pic js-tilt" data-tilt>
  					<img src="themes/'.$themes.'/login/images/img-01.png" alt="IMG">
  				</div>
  				';

  				if (isset($_COOKIE['iproject'])) {
  					echo '
  					<span class="login100-form-title">
  						'._YOU_HAVE_ALREADY_LOGGED_IN_WITH_YOUR_USERNAME.'
  					</span>';
  					echo '
  					<p class="login100-form-btn">
  						'._GO_TO.' <b><a href="./">'._HOME_PAGE.'</a>
  					</p>';
  				}
  				else{
  					echo'
  				<form method="post" class="login100-form validate-form form_login">
  					<span class="login100-form-title">
  						'._HI_YOU_MUST_BE_LOGGED_IN_TO_USE_THE_SYSTEM.'
  					</span>

  					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
  						<input type="text" style="direction: ltr;" autofocus="" name="username" class="input100" placeholder="'._USERNAME.'" aria-describedby="basic-addon1">
  						<span class="focus-input100"></span>
  						<span class="symbol-input100">
  							<i class="fa fa-envelope" aria-hidden="true"></i>
  						</span>
  					</div>

  					<div class="wrap-input100 validate-input" data-validate = "Password is required">
  						<input type="password" style="direction: ltr;" name="password" class="input100" placeholder="'._PASSWORD.'" aria-describedby="basic-addon1">
  						<span class="focus-input100"></span>
  						<span class="symbol-input100">
  							<i class="fa fa-lock" aria-hidden="true"></i>
  						</span>
  					</div>
  					';
	                  if (isset($_SESSION['incorrect_password'])) {
	                  echo'
	                  <div class="form-group">
	                  	<label for="uhome_zipcode">'._PLEASE_ENTER_THE_CODE_IN_THE_BOX.' <img src="include/captcha.php" alt=""></label>
	                  	<div class="controls">
	                  		<input type="text" class="form-control" id="security_code" name="security_code" style="direction: ltr;">
	                  	</div>
	                  </div>';
	                  }
	                  echo'
  					<div class="container-login100-form-btn">
  						<input type="submit" name="login" value="'._LOGIN.'" class="login100-form-btn">
  					</div>

  					<div class="text-center p-t-12">
  						<!-- <span class="txt1">
  							Forgot
  						</span>
  						<a class="txt2" href="#">
  							Username / Password?
  						</a> -->
  					</div>

  					<div class="text-center p-t-136">
  						<!-- <a class="txt2" href="#">
  							Create your Account
  							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
  						</a> -->
  					</div>
  				</form>
  				';

				}
				echo'
  			</div>
  		</div>
  	</div>

	<!--===============================================================================================-->
		<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
		<script src="vendor/tilt/tilt.jquery.min.js"></script>
		<script >
			$(\'.js-tilt\').tilt({
				scale: 1.1
			})
		</script>
	<!--===============================================================================================-->
		<script src="themes/'.$themes.'/login/js/main.js"></script>
';
require_once 'footer.php';
 ?>