<?php
session_start();
require 'mysql_classes.php';
require 'functions.php';
$fname= preg_replace('/\P{L}+/u', '', $_POST['fname']);
$lname= preg_replace('/\P{L}+/u', '', $_POST['lname']);
$fpass = coder($_POST['fpass']);
$spass = coder($_POST['spass']);
	$name=ucfirst(strtolower($fname)).' '.ucfirst(strtolower($lname));
	$username=strtolower($fname.$lname);
	$usern= new users();
	$username= $usern->autoUsernameGenerator($username);
	$password= $fpass;
	$password= password($password);
	$birth= $_POST['year']."-".$_POST['month']."-".$_POST['day'];
	if($fpass==$spass && $username!="" && $name!="" && $birth !=""){
		$tname=$username+"_wall";
		$id= new latestUserId;
		$id= $id->id;
		$usern->createNewUser($id,$username,$name,$password,$birth);
		$z=new walls();
		$z->createNewWall($username);
		$id=$usern->userId($username);
		$_SESSION['uid']= $id;
		if(is_numeric($_POST['phone']) && $_POST['phone'] != ""){
			new insertPhonenumber($_SESSION['uid'],$_POST['phone']);
		}
		new newUserPreferences($id);
		echo $username;
		
	}else{
		echo "fuck you hacker";
	}
?>