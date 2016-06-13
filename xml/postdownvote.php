<?php
session_start();
require "mysql_classes.php";
	$uid= $_SESSION['uid'];
	$pid= substr_replace($_POST['name'] ,"",-1);
	$vot= new votes($pid,0,0);
	$vote =$vot->userVote($uid);
	$f=new posts();
	if ($vote=="downvote") {
		$vot->voteDelete($uid,$pid,0,0);
		$f->postDownvotesUpdate($pid,-1);
		echo "none";
	}elseif ($vote=="upvote") {
		$vot->voteUpdate($uid, "downvote");
		$f->postDownvotesUpdate($pid,1);
		$f->postUpvotesUpdate($pid,-1);
		echo "downvote";
	}else{
	$vot->voteInsert($uid, "downvote");
	$f->postDownvotesUpdate($pid,1);
		echo "downvote";
	}
?>