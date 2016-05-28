<?php
session_start();
require 'mysql_classes.php';
	$uid= $_SESSION['uid'];
	$pid= substr_replace($_POST['name'] ,"",-1);
	$uv= new userVote($uid,$pid,0,0);
	$vote= $uv->vote;
	if ($vote=="upvote") {
	new voteDelete($uid,$pid,0,0);
	new postUpvotesUpdate($pid,-1);
		echo "none";
	}elseif ($vote=="downvote") {
	new voteUpdate("upvote",$uid,$pid,0,0);
	new postUpvotesUpdate($pid,1);
	new postDownvotesUpdate($pid,-1);
		echo "upvote";
	}else{
	new voteInsert("upvote",$uid,$pid,0,0);
	new postUpvotesUpdate($pid,1);
		echo "upvote";
	}
		
	
?>