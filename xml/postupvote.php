<?php
session_start();
require 'mysql_classes.php';
	$uid= $_SESSION['uid'];
	$pid= substr_replace($_POST['name'] ,"",-1);
	$uv= new votes($pid,0,0);
	$vote= $uv->userVote($uid);
	$f=new posts();
	if ($vote=="upvote") {
		$uv->voteDelete($uid);
		$f->postUpvotesUpdate($pid,-1);
		echo "none";
	}elseif ($vote=="downvote") {
		$uv->voteUpdate($uid, "upvote");
		$f->postUpvotesUpdate($pid,1);
		$f->postDownvotesUpdate($pid,-1);
		echo "upvote";
	}else{
		$uv->voteInsert($uid, "upvote");
		$f->postUpvotesUpdate($pid,1);
		echo "upvote";
	}
		
	
?>