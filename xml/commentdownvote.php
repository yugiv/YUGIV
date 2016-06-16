<?php
session_start();
require "mysql_classes.php";
	$uid= $_SESSION['uid'];
	$arr= explode('-',$_POST['name']);
	$pid= $arr[0];
	$cid= substr_replace($arr[1] ,"",-2);
	$vo= new votes($pid,$cid,0);
	$vote= $vote->vote;
	$f=new comments();
	if ($vote=="downvote") {
		$vo->voteDelete($uid);
		$f->commentDownvotesUpdate($pid,$cid,-1);
		echo "none";
	}elseif ($vote=="upvote") {
		$vo->voteUpdate("downvote",$uid);
		$f->commentUpvotesUpdate($pid,$cid,-1);
		$f->commentDownvotesUpdate($pid,$cid,1);
		echo "downvote";
	}else{
		$vo->voteInsert("downvote",$uid);
		$f->commentDownvotesUpdate($pid,$cid,1);
		echo "downvote";
	}
?>