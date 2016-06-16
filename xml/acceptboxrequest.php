<?php
    require '../require.php';
	$us= new users();
	$receiverinfo= $us->userInfoByUsername($_POST['username']);
	$senderinfo=$us->userInfoById((int)$_SESSION['uid']);
	$re=new friend_requests($receiverinfo['id'],(int)$_SESSION['uid']);
	$fr=new friends();
	$fr->addFriend($receiverinfo['id'], (int)$_SESSION['uid']);
	$re->delete();
	$fo= new follow_info();
	$fcheck= $fo->checkFollow((int)$_SESSION['uid'],$_POST['username']);
	if(!$fcheck){
	$fo->insertFollow($_SESSION['uid'],$receiverinfo['id']);
	}
	new insertNotification($receiverinfo['id'],$senderinfo['name'],$senderinfo['profile_picture'],$senderinfo['profile'],"accepted your friend request.");
	echo 'done';
