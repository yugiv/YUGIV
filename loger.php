<?php
session_start();
require 'xml/mysql_classes.php';
if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username']!=="" && $_POST['password']!==""){
	$username=$_POST['username'];
	$password=$_POST['password'];
	$password= sha1($password);
	$salt='d0be2dc421be4fcd0172e5afceea3970e2f3d940';
	$new='';
	$d=0;
	for($i=0;$i < strlen($password); $i++) {
	    $new .= $password[$d].$salt[$i];
		$d++;
	}
	$password=$new;
	$uid= new users;
	$uid= $uid->checkLog($username,$password);
	if(!empty($uid)){
		$_SESSION['uid']=$uid['id'];
		echo "done";
	}
}