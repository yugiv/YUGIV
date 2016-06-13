<?php
require 'mysql_classes.php';
require 'functions.php';
	$pid= substr_replace($_POST['name'] ,"",-1);
	$pcount= new postsSelect();
	$pcount= $pcount->regularPosts('post_id',$pid);
	$pcount= bignumberkiller($pcount['upvotes']);
	echo $pcount;