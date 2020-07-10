<?php 
require_once 'jdf.php';
function G2J($date)
{
	$time_zone="UTC";
	$d = explode(' ',$date);
	$d_date = explode('-',$d[0]); //date
	$d_time = explode(':',$d[1]); //time
	$year = $d_date[0];
	$month = $d_date[1];
	$day = $d_date[2];
	$hour=$d_time[0];
	$minute=$d_time[1];
	$second=$d_time[2];
	$Jd = gregorian_to_jalali($year,$month,$day);
	if ($Jd[1]<=6)
		$timestamp =gmmktime($hour,$minute,$second,$month,$day,$year)+16200;
	else
		$timestamp =gmmktime($hour,$minute,$second,$month,$day,$year)+12600;
	return jdate("Y/m/d H:i:s",$timestamp,$none='',$time_zone);
}

function J2G($date)
{
	// require_once 'jdf.php';
	$time_zone="UTC";
	$d = explode(' ',$date);
	$d_date = explode('/',$d[0]); //date
	$d_time = explode(':',$d[1]); //time
	$year = $d_date[0];
	$month = $d_date[1];
	$day = $d_date[2];
	$hour=$d_time[0];
	$minute=$d_time[1];
	$second=$d_time[2];
	$Jd = jalali_to_gregorian($year,$month,$day,' - ');
	if ($Jd[1]<=6)
		$timestamp =jmktime($hour,$minute,$second,$month,$day,$year)+16200;
	else
		$timestamp =jmktime($hour,$minute,$second,$month,$day,$year)+12600;
	return date("Y/m/d H:i:s",$timestamp,$none='',$time_zone);
}
function G2JD($date)
{
	// require_once 'jdf.php';
	$time_zone="UTC";
	$d = explode(' ',$date);
	$d_date = explode('-',$d[0]); //date
	// $d_time = explode(':',$d[1]); //time
	$year = $d_date[0];
	$month = $d_date[1];
	$day = $d_date[2];
	$hour=0;
	$minute=0;
	$second=0;
	$Jd = gregorian_to_jalali($year,$month,$day);
	if ($Jd[1]<=6)
		$timestamp =gmmktime($hour,$minute,$second,$month,$day,$year)+16200;
	else
		$timestamp =gmmktime($hour,$minute,$second,$month,$day,$year)+12600;
	return jdate("Y/m/d",$timestamp,$none='',$time_zone);
}

function J2GD($date)
{
	// require_once 'jdf.php';
	$time_zone="UTC";
	$d = explode(' ',$date);
	$d_date = explode('/',$date); //date
	// $d_time = explode(':',$d[1]); //time
	$year = $d_date[0];
	$month = $d_date[1];
	$day = $d_date[2];
	$hour=12;
	$minute=0;
	$second=0;
	$Jd = jalali_to_gregorian($year,$month,$day);
	if ($Jd[1]<=6)
		$timestamp =jmktime($hour,$minute,$second,$month,$day,$year)+16200;
	else
		$timestamp =jmktime($hour,$minute,$second,$month,$day,$year)+12600;
	// print_r($timestamp);
	return date("Y/m/d",$timestamp,$none='',$time_zone);
}
function Success($message)
{
	echo '
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		'.$message.'
	</div>
	';
}
function Info($message)
{
	echo '
	<div class="alert alert-info" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
		'.$message.'
	</div>
	';
}
function Failure($message)
{
	echo '
	<div class="alert alert-danger" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		<span class="sr-only">Error:</span>
		'.$message.'
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	</div>
	';
}
function AddLogo($message)
{
	echo'
	<a class="btn btn-default" href="'.$message.'" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"> '._NEW.'</span> 
	</a>
	';
}
function ListLogo($message)
{
	echo'
	<a class="btn btn-default" href="'.$message.'" role="button"><span class="glyphicon glyphicon-th-list" aria-hidden="true"> '._LIST.'</span> 
	</a>
	';
}
function ChartLogo($message)
{
	echo'
	<a class="btn btn-default" href="'.$message.'" role="button"><span class="glyphicon glyphicon-th-large" aria-hidden="true"> '._CHART.'</span> 
	</a>
	';
}
function AddForm($message)
{
	echo '
		<button type="submit" name="'.$message.'" class="btn btn-success" style="width: 100px;">'._ADD.'</button>
	';
}
function UpdateForm($message)
{
	echo'<button type="submit" name="'.$message.'" class="btn btn-success" style="width: 100px;">'._UPDATE.'</button>';
}
function AddLogoChartNew()
{
	$settings_class = new ManageSettings();
	$system_settings = $settings_class->SystemSettings();
	$direction = $system_settings[0]["direction"];
	echo '
	<script>
	  $(document).ready(function () {
	      $(\'.material-button-toggle\').on("click", function () {
	          $(this).toggleClass(\'open\');
	          $(\'.option\').toggleClass(\'scale-on\');
	      });
	  });
	</script>
	<style>
		/*add logo new*/
		/*-------------------------
		Please follow me @maridlcrmn
		/*-------------------------*/

		.material-button-anim {
			direction: rtl;
			position: relative;
			padding: 0px 0px 0px;
			padding-bottom: 0px;
			text-align: center;
			max-width: 320px;
			margin: 0 auto 20px;
		}

		.material-button {
			position: relative;
			top: 0;
			z-index: 1;
			width: 40px;
			height: 40px;
			font-size: 1.5em;
			color: #fff;
			background: #2C98DE;
			border: none;
			border-radius: 50%;
			box-shadow: 0 3px 6px rgba(0,0,0,.275);
			outline: none;
		}
		.material-button-toggle {
		    z-index: 3;
		    width: 50px;
		    height: 50px;
		    margin: 0 auto;
		    margin-left: '.($direction==0?'-45':'').'px;
		}
		.material-button-toggle span {
		    -webkit-transform: none;
		    transform:         none;
		    -webkit-transition: -webkit-transform .175s cubic-bazier(.175,.67,.83,.67);
		    transition:         transform .175s cubic-bazier(.175,.67,.83,.67);
		}
		.material-button-toggle.open {
		    -webkit-transform: scale(1.3,1.3);
		    transform:         scale(1.3,1.3);
		    -webkit-animation: toggleBtnAnim .175s;
		    animation:         toggleBtnAnim .175s;
		}
		.material-button-toggle.open span {
		    -webkit-transform: rotate(45deg);
		    transform:         rotate(45deg);
		    -webkit-transition: -webkit-transform .175s cubic-bazier(.175,.67,.83,.67);
		    transition:         transform .175s cubic-bazier(.175,.67,.83,.67);
		}

		#options {
		  height: 15px;
		}
		.option {
		    position: relative;
		}
		.option .option1,
		.option .option2,
		.option .option3 {
		    filter: blur(5px);
		    -webkit-filter: blur(5px);
		    -webkit-transition: all .175s;
		    transition:         all .175s;
		}
		.option .option1 {
		    -webkit-transform: translate3d(-55px,30px,0) scale(.8,.8);
		    transform:         translate3d(-55px,30px,0) scale(.8,.8);
		}
		.option .option2 {
		    -webkit-transform: translate3d(0,30px,0) scale(.8,.8);
		    transform:         translate3d(0,30px,0) scale(.8,.8);
		}
		.option .option3 {
		    -webkit-transform: translate3d(55px,30px,0) scale(.8,.8);
		    transform:         translate3d(55px,30px,0) scale(.8,.8);
		}

		.option.scale-on .option1, 
		.option.scale-on .option2,
		.option.scale-on .option3 {
		    filter: blur(0);
		    -webkit-filter: blur(0);
		    -webkit-transform: none;
		    transform:         none;
		    -webkit-transition: all .175s;
		    transition:         all .175s;
		}
		.option.scale-on .option2 {
		    -webkit-transform: translateY(-28px) translateZ(0);
		    transform:         translateY(-28px) translateZ(0);
		    -webkit-transition: all .175s;
		    transition:         all .175s;
		}

		@keyframes toggleBtnAnim {
		    0% {
		        -webkit-transform: scale(1,1);
		        transform:         scale(1,1);
		    }
		    25% {
		        -webkit-transform: scale(1.4,1.4);
		        transform:         scale(1.4,1.4); 
		    }
		    75% {
		        -webkit-transform: scale(1.2,1.2);
		        transform:         scale(1.2,1.2);
		    }
		    100% {
		        -webkit-transform: scale(1.3,1.3);
		        transform:         scale(1.3,1.3);
		    }
		}
		@-webkit-keyframes toggleBtnAnim {
		    0% {
		        -webkit-transform: scale(1,1);
		        transform:         scale(1,1);
		    }
		    25% {
		        -webkit-transform: scale(1.4,1.4);
		        transform:         scale(1.4,1.4); 
		    }
		    75% {
		        -webkit-transform: scale(1.2,1.2);
		        transform:         scale(1.2,1.2);
		    }
		    100% {
		        -webkit-transform: scale(1.3,1.3);
		        transform:         scale(1.3,1.3);
		    }
		}
		#ads{
			'.($direction==1?'float: right; right: 0px; margin-right: -80px;':'').'
		}


		/*add logo new*/
	</style>
    <div class="material-button-anim" id="ads">
      <ul class="list-inline" id="options">
        <li class="option">
        	<a href="projects.php?op=add" title="'._PROJECT.'">
              <button class="material-button option1" type="button">
                <span class=" glyphicon glyphicon-list-alt" aria-hidden="true"></span>
              </button>
            </a>
        </li>
        <li class="option">
        	<a href="tasks.php?op=add" title="'._TASK.'">
              <button class="material-button option2" type="button">
                <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
              </button>
            </a>
        </li>
        <li class="option">
        	<a href="issues.php?op=add" title="'._ISSUE.'">
              <button class="material-button option3" type="button">
                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
              </button>
            </a>
        </li>
      </ul>
      <button class="material-button material-button-toggle" type="button" title="'._ADD.'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
      </button>
    </div>
	';
}

 ?>