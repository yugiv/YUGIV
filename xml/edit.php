<?php
if(ctype_alnum($_POST['name'])){
session_start();
require "mysql_classes.php";
$uid = $_SESSION['uid'];
$name = $_POST['name'];
if(strpos($name,'-')== false){
	if(strpos($name,'a')== false){
	$ch= new checkIfPostExists($uid,$name);
	$exis= $ch->bool;
	if($exis){
		$out= new postsSelect();
		$out= $out->regularPosts("post_id", $name);
		echo $out['type']."post";
	}
	}else{
		$ch= new checkIfPostExists(0,$name);
		$exis= $ch->bool;
		$name=(int)$name;
		if($exis){
			$out= new postsSelect();
			$out= $out->regularPosts("post_id", $name);
			echo $out['type']."post";
		}
	}
}else{
	$ids=explode("-", $name);
	if(count($ids) == 2){
		$ch= new checkIfCommentExists($uid,$ids[0],$ids[1]);
		$exis=$ch->bool;
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