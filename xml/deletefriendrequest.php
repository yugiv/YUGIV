<?php
    session_start();
    require '../xml/mysql_classes.php';
	$username = new users();
	$username= $username->userId($_POST['username']);
	$f=new friend_requests();
	$f->delete($_SESSION['uid'],$username);
	echo "done";
?>