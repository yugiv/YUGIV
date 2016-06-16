<?php
session_start();
require 'mysql_classes.php';
$u= new users;
$user= $u->userInfoByUsername($_POST['username']);
$check= new follow_info;
$check=$check->checkFollow((int)$_SESSION['uid'],(int)$user['id']);
if($check){
	echo "following";
}else{
	echo "follow?";
}
