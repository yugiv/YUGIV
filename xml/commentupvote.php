<?php
session_start();
require "mysql_classes.php";
	$uid= $_SESSION['uid'];
	$arr= explode('-',$_POST['name']);
	$pid= $arr[0];
	$cid= substr_replace($arr[1] ,"",-2);
	$vote= new votes($pid,$cid,0);
	$vote=$vote->userVote($uid);
	$f=comments();
	if ($vote=="upvote") {
		$vote->voteDelete($uid,$pid,$cid,0);
		$f->commentUpvotesUpdate($pid,$cid,-1);
		echo "none";
	}elseif ($vote=="downvote") {
		$vote->voteUpdate("upvote",$uid,$pid,$cid,0);
		$f->commentUpvotesUpdate($pid,$cid,1);
		$f->commentDownvotesUpdate($pid,$cid,-1);
		echo "upvote";
	}else{
		$vote->voteInsert("upvote",$uid,$pid,$cid,0);
		$f->commentUpvotesUpdate($pid,$cid,1);
		echo "upvote";
	}
	
		
	
?>