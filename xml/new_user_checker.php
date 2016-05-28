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
	$usern= new autoUsernameGenerator($username);
	$username= $usern->username;
	$password= $fpass;
	$password= sha1($password);
	$salt='d0be2dc421be4fcd0172e5afceea3970e2f3d940';
	$new='';
	$d=0;
	for($i=0;$i < strlen($password); $i++) {
	    $new .= $password[$d].$salt[$i];
		$d++;
	}
	$password=$new;
	$birth= $_POST['year']."-".$_POST['month']."-".$_POST['day'];
	if($fpass==$spass && $username!="" && $name!="" && $birth !=""){
		$tname=$username+"_wall";
		$id= new latestUserId;
		$id= $id->id;
		new createNewUser($id,$username,$name,$password,$birth);
		new createNewWall($username);
		$id= new userId($username);
		$id=$id->uid;
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