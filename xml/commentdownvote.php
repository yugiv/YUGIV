<?php
session_start();
require "mysql_classes.php";
	$uid= $_SESSION['uid'];
	$arr= explode('-',$_POST['name']);
	$pid= $arr[0];
	$cid= substr_replace($arr[1] ,"",-2);
	$vote= new userVote($uid,$pid,$cid,0);
	$vote= $vote->vote;
	$f=new comments();
	if ($vote=="downvote") {
		$vote->voteDelete($uid,$pid,$cid,0);
		$f->commentDownvotesUpdate($pid,$cid,-1);
		echo "none";
	}elseif ($vote=="upvote") {
		$vote->voteUpdate("downvote",$uid,$pid,$cid,0);
		$f->commentUpvotesUpdate($pid,$cid,-1);
		$f->commentDownvotesUpdate($pid,$cid,1);
		echo "downvote";
	}else{
		$vote->voteInsert("downvote",$uid,$pid,$cid,0);
		$f->commentDownvotesUpdate($pid,$cid,1);
		echo "downvote";
	}
?>