<?php
    session_start();
    require '../xml/mysql_classes.php';
	$userid = new userId($_POST['username']);
	$user= $userid->uid;
	$follow= new checkFollow($_SESSION['uid'],$user);
	$follow= $follow->check;
	if($follow){
		new deleteFollow($_SESSION['uid'],$user);
		echo "follow?";
	}else{
		new insertFollow($_SESSION['uid'],$user);
		echo "following";
	}
