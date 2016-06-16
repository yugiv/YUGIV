<?php
    session_start();
    require '../xml/mysql_classes.php';
	$userid = new users();
	$user= $userid->userInfoByUsername($_POST['username']);
	$fo= new follow_info();
	$follow= $fo->checkFollow($_SESSION['uid'],$user['id']);
	if($follow){
		$fo->deleteFollow($_SESSION['uid'],$user['id']);
		echo "follow?";
	}else{
		$fo->insertFollow($_SESSION['uid'],$user['id']);
		echo "following";
	}
