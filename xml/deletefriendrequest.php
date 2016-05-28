<?php
    session_start();
    require '../xml/mysql_classes.php';
	$username = new userId($_POST['username']);
	$username= $username->uid;
	new deleteFriendRequest($_SESSION['uid'],$username);
	echo "done";
?>