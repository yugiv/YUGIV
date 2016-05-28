<?php
session_start();
    require 'mysql_classes.php';
	$check= new checkNotification($_SESSION['uid']);
	echo $check->bool;
