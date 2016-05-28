<?php
session_start();
    require 'mysql_classes.php';
	$check= new selectFriendRequests($_SESSION['uid']);
	$check= $check->array;
	if(!empty($check)){
		echo "true";
	}
