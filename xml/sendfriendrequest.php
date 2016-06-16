<?php
session_start();
    require '../xml/mysql_classes.php';
	$us = new users();
	$username= $us->userInfoByUsername($_POST['username']);
	$re=new friend_requests($_SESSION['uid'],$username['id']);
	$re->send();
	$f= new follow_info();
	$fcheck= $f->checkFollow($_SESSION['uid'],$username['id']);
	if(!$fcheck){
		$f->insertFollow($_SESSION['uid'],$username['id']);
	}
	echo 'done';
	
?>