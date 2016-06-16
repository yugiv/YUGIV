<?php
    session_start();
    require '../xml/mysql_classes.php';
	$username = new users();
	$username= $username->userInfoByUsername($_POST['username']);
	$f=new friend_requests($_SESSION['uid'],(int)$username['id']);
	$f->delete();
	echo "done";
?>