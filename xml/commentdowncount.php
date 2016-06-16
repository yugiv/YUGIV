<?php
require "mysql_classes.php";
$arr= explode('-',$_POST['name']);
	$pid= $arr[0];
	$cid= substr_replace($arr[1] ,"",-2);
	$ncount= new comments();
	$ncount= $ncount->selectCommentById($pid,$cid);
	echo $ncount['downvotes'];