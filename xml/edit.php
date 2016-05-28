<?php
if(preg_match('/^[^a-zA-Z]*$/', $_POST['name'])){
session_start();
$documentroot="C:/xampp/htdocs/YUGIV/";
require $documentroot."xml/mysql_classes.php";
$uid = $_SESSION['uid'];
$name = $_POST['name'];
if(strpos($name,'-')== false){
	$ch= new checkIfPostExists($uid,$name);
	$exis= $ch->bool;
	if($exis){
		$out= new selectPostById($name);
		$out= $out->array;
		echo $out['type'];
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