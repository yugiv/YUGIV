<?php
session_start();
    require 'mysql_classes.php';
	$check= new friend_requests();
	$check= $check->selectFriendRequests($_SESSION['uid']);
	if(!empty($check)){
		echo "true";
	}
