<?php
session_start();
require 'mysql_classes.php';
$user= new userId($_POST['username']);
$user= $user->uid;
$check= new checkFollow($_SESSION['uid'],$user);
$check=$check->check;
if($check){
	echo "following";
}else{
	echo "follow?";
}
