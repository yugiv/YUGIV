<?php
session_start();
    require '../xml/mysql_classes.php';
	$username = new userId($_POST['username']);
	$username= $username->uid;
	new sendFriendRequest($_SESSION['uid'],$username);
	$fcheck= new checkFollow($_SESSION['uid'],$username);
	$fcheck= $fcheck->check;
	if(!$fcheck){
		new insertFollow($_SESSION['uid'],$username);
	}
	echo 'done';
	
?>