<?php
    require '../require.php';
	$userinfo = new userId($_POST['username']);
	$userid= $userinfo->uid;
	$senderinfo= new userInfo($_SESSION['uid']);
	$senderinfo=$senderinfo->user;
	new acceptFriendRequest($userid,$_SESSION['uid']);
	new deleteFriendRequest($userid,$_SESSION['uid']);
	$fcheck= new checkFollow($_SESSION['uid'],$_POST['username']);
	$fcheck= $fcheck->check;
	if(!$fcheck){
	new insertFollow($_SESSION['uid'],$userid);
	}
	new insertNotification($userid,$senderinfo['name'],$senderinfo['profile_picture'],$senderinfo['profile'],"accepted your friend request.");
	echo 'done';
