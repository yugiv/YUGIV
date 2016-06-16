<?php
    require 'mysql_classes.php';
	require 'functions.php';
	$pid= (is_numeric($_POST['pid']))?$_POST['pid']:0;
	$name=htmlentities($_POST['name']);
	$name=coder($name);
	$password= password($_POST['password']);
	$check= new anonymous_posts();
	$check=$check->checkAno($pid,$name,$password);
	if($check=="true"){
		$post= new posts();
		$post= $post->simpleSelect("post_id", $pid);
		$tool= new selectToolProperties($post['type']);
		$tool=$tool->array;
		echo $tool['edit'];
	}
?>