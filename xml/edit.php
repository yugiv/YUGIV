<?php
if(ctype_alnum($_POST['name'])){
session_start();
require "mysql_classes.php";
$uid = (int)$_SESSION['uid'];
$name = (int)$_POST['name'];
if(strpos($name,'-')== false){
	if(strpos($name,'a')== false){
	$ch= new posts;
	$exis= $ch->checkIfPostExists($uid,$name);;
	if($exis){
		$out= $ch->simpleSelect("post_id", $name);
		echo $out['type']."post";
	}
	}else{
		$ch= new posts;
		$exis= $ch->checkIfPostExists(0,$name);
		$name=(int)$name;
		if($exis){
			$out= $ch->simpleSelect("post_id", $name);
			echo $out['type']."post";
		}
	}
}else{
	$ids=explode("-", $name);
	if(count($ids) == 2){
		$ch= new comments();
		$exis=$ch->checkIfCommentExists($uid,(int)$ids[0],(int)$ids[1]);
		if($exis){
			
			echo "comment";
		}
	}elseif(count($ids) == 3){
		
	}
}
}else{
	echo "hi";
}
?>