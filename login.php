<?php 
require_once 'main.php';
$error= "";
if (isset($_POST['login'])) {
	$pass= $_POST['password'];
	$username= $_POST['username'];

	if (isset($_SESSION['incorrect_password'])) {
		$security_code= $_POST['security_code'];
		if ($admin->Login($username,md5($pass))==1) {
			if (($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code']))) {
			setcookie("iproject",$username.':'.md5($pass),time()+860000);
			header("location: ./");
			}
			else{
				$error= 'کد داخل کادر را اشتباه وارد کردید';
			}
		}
		else{
			$error= 'نام کاربری یا رمز عبور اشتباه است';
		}
	}
	else{
		if ($admin->Login($username,md5($pass))==1) {
			setcookie("iproject",$username.':'.md5($pass),time()+860000);
			header("location: ./");
		}
		else{
			$_SESSION['incorrect_password'] = "1";
			$error= 'نام کاربری یا رمز عبور اشتباه است';
		}
		
	}
}
require_once 'header.php';
if (isset($_COOKIE['iproject'])) {
	echo '<p class="text-danger">'._YOU_HAVE_ALREADY_LOGGED_IN_WITH_YOUR_USERNAME.'</p>';
	echo '<p class="text-success">'._GO_TO.' <b><a href="./">'._HOME_PAGE.'</a></p>';
}
else{
echo '
	<style>
	.login{
		width:300px;
		min-height:400px;
		position:relative;
		margin: 0 auto;
		padding: 20px !important;
		margin-top: 100px;
	}
	#wrapper {
    padding-left: 0;    
    margin-top: -80px;
	}
	</style>



	<style>
	body{

	}
	#login-bg {
	    background-color: ;
	}

	#login-bg-top {
	    background-image: url("themes/default/img/login_header.jpg");
	    background-size: cover;
	    background-repeat: no-repeat;
	    background-position: 50% 50%;
	    height: 300px;
	    display: block;
	    text-align: center;
	}
	#login-bg-top h3 {
	    color: #101010;
	}

	.logo-circle {
	    background-image: url("themes/default/img/logo.png");
	    background-repeat: no-repeat;
	    background-size: cover;
	    border-radius: 125px;
	    width: 130px;
	    height: 130px;
	    margin-top: 230px;
	    display: inline-block;
	    border: 5px solid rgba(211,211,211,0.9);
	}

	.bg-content {
	    text-align: center;
	    padding-top: 20px;
	    margin-top: 60px;
	    margin-bottom: 0px;
	    background-color: #FFF;
	    min-height: 350px;
	}
    @media (max-width: 767px) {
		#login-bg-top {
	    	height: 130px;
	    	background-image: url("themes/default/img/login_header.jpg");
		}
		.logo-circle {
	    	margin-top: 50px;
		}
		.bg-content {
		    min-height: 350px;
		}
	}

	.input-group {
	    width: 100%;
	}

	</style>
	<section id="login-bg">
	    <div id="login-bg-top">
	        <div class="logo-circle"></div>
	    </div>
	    <div class="container">
	        <div class="col-md-12">
	            <div class="bg-content">
	            	<div class="col-md-2">
	            	</div>
		            <div class="col-md-8">
						<h3>'._HI_YOU_MUST_BE_LOGGED_IN_TO_USE_THE_SYSTEM.'</h3>
		            ';
						if (!empty($error)) {
							Failure($error);
						}
						if (!empty($success)) {
							Success($success);
						}
						echo'
			            <form method="post" class="form_login">
		                  <input type="text" style="direction: ltr;" autofocus="" name="username" class="form-control" placeholder="'._USERNAME.'" aria-describedby="basic-addon1"><br><br>
		                  <input type="password" style="direction: ltr;" name="password" class="form-control" placeholder="'._PASSWORD.'" aria-describedby="basic-addon1"><br><br>';
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
		                  <input type="submit" name="login" value="'._LOGIN.'" class="btn btn-success btn-lg">
			            </form>
		            </div>
	            	<div class="col-md-2">
	            	</div>
	            </div>
	        </div>
	    </div>
	</section>
	<!-- /container -->
';

}
require_once 'footer.php';
 ?>