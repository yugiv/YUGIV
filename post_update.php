<?php
session_start();
require 'xml/mysql_classes.php';
require 'xml/functions.php';
if (isset($_POST['post']) && isset($_POST['name']) && is_numeric($_POST['name'])){
	$check= new selectPostById($_POST['name']);
	$check= $check->array;
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
		new updatePostById($_POST['name'],$title,$content);
		echo $content;
	}
}
