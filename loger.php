<?php
session_start();
require 'xml/mysql_classes.php';
require 'xml/functions.php';
if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username']!=="" && $_POST['password']!==""){
	$username=$_POST['username'];
	$password=password($_POST['password']);
	$uid= new users();
	$uid= $uid->checkLog($username,$password);
	if(!empty($uid)){
		$_SESSION['uid']=$uid['id'];
		echo "done";
	}
}