<?php
require '../require.php';
$array =new users();
$array= $array->userInfoByUsername($_POST['username']);
	$fr= new friends();
	$friend= $fr->checkFriend($array['id'],$_SESSION['uid']);
	$re=new friend_requests($_SESSION['uid'],$array['id']);
	$frequest= $re->checkFriendRequests();
	$ore=new friend_requests($array['id'],$_SESSION['uid']);
	$ofrequest= $ore->checkFriendRequests();
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
