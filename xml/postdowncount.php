<?php
require 'mysql_classes.php';
	$pid= substr_replace($_POST['name'] ,"",-1);
	$ncount= new selectPostById($pid);
	$ncount= $ncount->array;
	$ncount= $ncount['downvotes'];
	$d= new bigNumbersKiller($ncount);
	$ncount= $d->result;
	echo $ncount;