<?php
require '../require.php';
$array =new userId($_POST['username']);
$array= $array->uid;
if($array['username'] != $_POST['username']){
	$friend= new checkFriend($array,$_SESSION['uid']);
	$friend= $friend->check;
	$frequest= new checkFriendRequests($_SESSION['uid'],$array);
	$frequest= $frequest->check;
	$ofrequest= new checkFriendRequests($array,$_SESSION['uid']);
	$ofrequest= $ofrequest->check;
	if ($friend==TRUE) {
		$fbutton=$originallink."profile_html/unfriend.php";
	}elseif($frequest==TRUE){
		$fbutton=$originallink.'profile_html/cancelfriendrequest.php';
	}elseif($ofrequest==TRUE){
		$fbutton=$originallink."profile_html/acceptfriendrequest.php";
	}else{
		$fbutton=$originallink."profile_html/sendfriendrequest.php";
	}
	echo $fbutton;
}