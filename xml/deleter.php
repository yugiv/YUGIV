<?php
if(preg_match('/[^a-zA-Z]+/', $_POST['name'])){
session_start();
require "mysql_classes.php";
$uid = (int)$_SESSION['uid'];
$name = (int)$_POST['name'];
if(strpos($name,'-')== false){
	$ch= new posts();
	$exis= $ch->checkIfPostExists($uid,$name);
	if($exis){
		$ch->deleteUserPost($uid,$name);
		$ch->votePostDelete($name);
		$c= new comments();
		$c->deleteAllComments($name);
		echo "post";
	}
}else{
	$ids=explode("-", $name);
	if(count($ids) == 2){
		$c=new comments();
		$exis=$c->checkIfCommentExists($uid,$ids[0],$ids[1]);
		if($exis){
			$c->deleteUserComment($uid,$ids[0],$ids[1]);
			$c->voteCommentDelete($ids[0],$ids[1]);
			echo "comment";
		}
	}elseif(count($ids) == 3){
		
	}
}
}