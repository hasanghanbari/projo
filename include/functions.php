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
	return date("Y-m-d",$timestamp);
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
		<span class="fas fa-exclamation-sign" aria-hidden="true"></span>
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
	<a class="btn btn-primary" href="'.$message.'" role="button">
		<i class="fas fa-pen" aria-hidden="true"></i>
		'._NEW.'
	</a>
	';
}
function ListLogo($message)
{
	echo'
	<a class="btn btn-primary" href="'.$message.'" role="button">
		<i class="fas fa-th-list" aria-hidden="true"></i>
		'._LIST.'
	</a>
	';
}
function ChartLogo($message)
{
	echo'
	<a class="btn btn-primary" href="'.$message.'" role="button">
		<i class="fas fa-th-large" aria-hidden="true"></i>
		'._CHART.'
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


function Toast($type, $title, $message, $position='top-left', $text_align='right', $showHideTransition='slide')
{
	echo'
		<script>
			$.toast({
                heading: "'. $title .'",
                text: "'. $message .'",
                icon: "'. $type .'",
                position: "'.$position.'",
                textAlign: "'.$text_align.'",
                showHideTransition: "'.$showHideTransition.'"
            });
		</script>
	';
}
function PrintR($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
 ?>