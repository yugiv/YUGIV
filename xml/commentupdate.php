<?php
session_start();
$documentroot="C:/xampp/htdocs/YUGIV/";
require $documentroot.'xml/mysql_classes.php';
require $documentroot.'xml/functions.php';
if(isset($_POST['post']) && isset($_POST['name'])){
	$ids=explode("-", $_POST['name']);
	if(is_numeric($ids[0])&& is_numeric($ids[1])){
	$check= new selectCommentById($ids[0],$ids[1]);
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
		new updateCommentById($ids[0],$ids[1],$content);
		echo $content;
	}
	}
}
