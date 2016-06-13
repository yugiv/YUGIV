<?php
session_start();
require 'xml/mysql_classes.php';
require 'xml/functions.php';
if (isset($_POST['post']) && isset($_POST['name']) && is_numeric($_POST['name'])){
	$check= new posts();
	$check= $check->simpleSelect("post_id", $_POST['name']);
	$pid= (int)$_POST['name'];
	$uid=$_SESSION['uid'];
	if(empty($check['user_id'])&& is_numeric($check['user_id'])){
		if(isset($_POST['paname'],$_POST['ppassword'])){
			$ano= new anoInfo($pid);
			$ano=$ano->array;
			$ppass=password($_POST['ppassword']);
			if($ppass!=$ano['password'] || $_POST['paname']!=$ano['name']){
				exit;
			}
		}else{
			exit;
		}
	}
	if(!empty($check) && $_SESSION['uid']==$check['user_id']){
		$cont=$_POST['post'];
		if (strpos($cont, '<br />')) {
	    	$cont=explode( "<br />",$cont);
			$content="";
			foreach ($cont as $key){
				$key=htmlentities($key);
				$content .=$key."<br />";
			}
			$content=coder($content);
			$content=substr_replace($content, '', -6);
		}else{
			$content=coder($cont);
		}
		$title= coder(htmlentities($_POST['title']));
		if(isset($_POST['caname'],$_POST['cpassword'])){
			$uid=0;
			$aname=coder($_POST['caname']);
			new updateAno($pid,$aname,$password);
		}
		new updatePostById($pid,$uid,$title,$content);
		echo $content;
	}
}
