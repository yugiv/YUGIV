<?php
require 'mysql_classes.php';
require 'functions.php';
	$pid= substr_replace($_POST['name'] ,"",-1);
	$ncount= new posts();
	$ncount= $ncount->simpleSelect('post_id',$pid);
	$ncount= bignumberkiller($ncount['downvotes']);
	echo $ncount;