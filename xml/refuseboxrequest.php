<?php
    session_start();
    require 'mysql_classes.php';
	$username = new userId($_POST['username']);
	$username= $username->uid;
	new deleteFriendRequest($username,$_SESSION['uid']);
	echo 'done';
?>