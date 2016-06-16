<?php
    session_start();
    require 'mysql_classes.php';
	$username = new users();
	$username= $username->userInfoByUsername($_POST['username']);
	$fr=new friends();
	$fr->unfriend($_SESSION['uid'],$username['id']);
	echo 'done';
?>