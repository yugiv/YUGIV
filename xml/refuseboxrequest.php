<?php
    session_start();
    require 'mysql_classes.php';
	$username = new users();
	$username= $username->userInfoByUsername($_POST['username']);
	$fr= new friend_requests($username['id'],$_SESSION['uid']);
	$fr->delete();
	echo 'done';
?>