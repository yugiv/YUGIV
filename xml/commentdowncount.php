<?php
$documentroot="C:/xampp/htdocs/YUGIV/";
require $documentroot."xml/mysql_classes.php";
$arr= explode('-',$_POST['name']);
	$pid= $arr[0];
	$cid= substr_replace($arr[1] ,"",-2);
	$ncount= new selectCommentById($pid,$cid);
	$ncount= $ncount->array;
	echo $ncount['downvotes'];