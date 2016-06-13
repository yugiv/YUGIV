<?php
    require 'mysql_classes.php';
	require 'functions.php';
	$pid= (is_numeric($_POST['pid']))?$_POST['pid']:0;
	$name=htmlentities($_POST['name']);
	$name=coder($name);
	$password= sha1($_POST['password']);
		$salt='d0be2dc421be4fcd0172e5afceea3970e2f3d940';
		$new='';
		$d=0;
		for($i=0;$i < strlen($password); $i++) {
		    $new .= $salt[$i].$password[$d];
			$d++;
		}
		$password=$new;
	$check= new checkAno($pid,$name,$password);
	$check=$check->check;
	if($check=="true"){
		$post= new selectPostById($pid);
		$post= $post->array;
		$tool= new selectToolProperties($post['type']);
		$tool=$tool->array;
		echo $tool['edit'];
	}
?>