<?php
require 'mysql_classes.php';
	$pid= substr_replace($_POST['name'] ,"",-1);
	$pcount= new selectPostById($pid);
	$pcount= $pcount->array;
	$pcount= $pcount['upvotes'];
	$c= new bigNumbersKiller($pcount);
	$pcount= $c->result;
	echo $pcount;