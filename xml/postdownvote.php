<?php
session_start();
require "xml/mysql_classes.php";
	$uid= $_SESSION['uid'];
	$pid= substr_replace($_POST['name'] ,"",-1);
	$vote= new userVote($uid,$pid,0,0);
	$vote =$vote->vote;
	if ($vote=="downvote") {
	new voteDelete($uid,$pid,0,0);
		new postDownvotesUpdate($pid,-1);
		echo "none";
	}elseif ($vote=="upvote") {
		new voteUpdate("downvote",$uid,$pid,0,0);
		new postDownvotesUpdate($pid,1);
		new postUpvotesUpdate($pid,-1);
		echo "downvote";
	}else{
	new voteInsert("downvote",$uid,$pid,0,0);
	new postDownvotesUpdate($pid,1);
		echo "downvote";
	}
?>