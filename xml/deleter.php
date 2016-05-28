<?php
if(preg_match('/[^a-zA-Z]+/', $_POST['name'])){
session_start();
$documentroot="C:/xampp/htdocs/YUGIV/";
require $documentroot."xml/mysql_classes.php";
$uid = $_SESSION['uid'];
$name = $_POST['name'];
if(strpos($name,'-')== false){
	$ch= new checkIfPostExists($uid,$name);
	$exis= $ch->bool;
	if($exis){
		new deleteUserPost($uid,$name);
		new votePostDelete($name);
		new deleteAllComments($name);
		echo "post";
	}
}else{
	$ids=explode("-", $name);
	if(count($ids) == 2){
		$ch= new checkIfCommentExists($uid,$ids[0],$ids[1]);
		$exis=$ch->bool;
		if($exis){
			new deleteUserComment($uid,$ids[0],$ids[1]);
			new voteCommentDelete($ids[0],$ids[1]);
			echo "comment";
		}
	}elseif(count($ids) == 3){
		
	}
}
}