<?php
    session_start();
    require '../xml/mysql_classes.php';
	$username = new userId($_POST['username']);
	$username= $username->uid;
	new unfriend($_SESSION['uid'],$username);
	echo 'done';
?>