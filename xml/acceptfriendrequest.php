<?php
    require '../require.php';
	$userinfo = new userInfo($_SESSION['uid']);
	$userinfo= $userinfo->user;
	$userid= new userId($_POST['username']);
	$userid=$userid->uid;
	$senderinfo= new userInfo($userid);
	$senderinfo=$senderinfo->user;
	new acceptFriendRequest($_SESSION['uid'],$userid);
	new deleteFriendRequest($_SESSION['uid'],$userid);
	$fcheck= new checkFollow($_SESSION['uid'],$userid);
	$fcheck= $fcheck->check;
	if(!$fcheck){
	new insertFollow($_SESSION['uid'],$userid);
	}
	new insertNotification($senderinfo['id'],$userinfo['name'],$userinfo['profile_picture'],$userinfo['profile'],"accepted your friend request.");
	echo "done";