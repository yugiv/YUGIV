<?php
    require '../require.php';
	$us = new users();
	$userinfo= $us->userInfoById($_SESSION['uid']);
	$senderinfo=$us->userInfoByUsername($_POST['username']);
	$re= new friend_requests($_SESSION['uid'],$senderinfo['id']);
	$re->delete();
	$fr= new friends();
	$fr->addFriend($_SESSION['uid'],$senderinfo['id']);
	$fcheck= new follow_info();
	$fcheck= $fcheck->checkFollow($_SESSION['uid'],$senderinfo['id']);
	if(!$fcheck){
	$fcheck->insertFollow($_SESSION['uid'],$senderinfo['id']);
	}
	new insertNotification($senderinfo['id'],$userinfo['name'],$userinfo['profile_picture'],$userinfo['profile'],"accepted your friend request.");
	echo "done";