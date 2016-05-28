<?php
$documentroot="C:/xampp/htdocs/YUGIV/";
session_start();
require $documentroot."xml/mysql_classes.php";
	$uid= $_SESSION['uid'];
	$arr= explode('-',$_POST['name']);
	$pid= $arr[0];
	$cid= substr_replace($arr[1] ,"",-2);
	$vote= new userVote($uid,$pid,$cid,0);
	$vote=$vote->vote;
	if ($vote=="upvote") {
	new voteDelete($uid,$pid,$cid,0);
		new commentUpvotesUpdate($pid,$cid,-1);
		echo "none";
	}elseif ($vote=="downvote") {
	new voteUpdate("upvote",$uid,$pid,$cid,0);
	new commentUpvotesUpdate($pid,$cid,1);
	new commentDownvotesUpdate($pid,$cid,-1);
		echo "upvote";
	}else{
	new voteInsert("upvote",$uid,$pid,$cid,0);
	new commentUpvotesUpdate($pid,$cid,1);
		echo "upvote";
	}
	
		
	
?>