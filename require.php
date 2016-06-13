<?php
session_start();
require 'xml/mysql_classes.php';
$originallink="http://localhost/YUGIV/";
if (!isset($_SESSION['uid']) && !isset($_COOKIE['username'],$_COOKIE['password'])&& ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"!=$originallink."register")) {
	header("Location: ".$originallink."register");
		exit;
}
if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && !isset($_SESSION['uid'])) {
	$username=$_COOKIE['username'];
	$password=$_COOKIE['password'];			
	$uid= new users();
	$uid= $uid->checkLog($username,$password);
	echo $username.$password.$uid;
	$_SESSION['uid']=$uid['id'];
}
if(isset($_SESSION['uid']) && !isset($_COOKIE['username'],$_COOKIE['password'])){
	$t= new users();
	$t= $t->userInfo($_SESSION['uid']);
	$username=$t['username'];
	$password=$t['password'];
	setcookie('username',$username);
	setcookie('password',$password);
}
if(isset($_SESSION['uid']) && isset($_COOKIE['username'],$_COOKIE['password'])){
	$t= new users();
	$t= $t->userInfo($_SESSION['uid']);
	$username=$t['username'];
	$password=$t['password'];
	$name= explode(" ", $t['name']);
	$name= $name[0];
	$profile= $t['profile'];
	$picture=$t['profile_picture'];
}