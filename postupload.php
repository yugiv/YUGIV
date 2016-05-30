<?php
session_start();
require 'xml/mysql_classes.php';
require 'xml/functions.php';
if (isset($_POST['post'])) {
	$us= new userInfo($_SESSION['uid']);
	$username= $us->user;
	$username=$username['username'];
	$view=$_POST['view_option'];
	$cont=$_POST['post'];
	if ($_POST['type']!="blog post") {
		$title=coder(htmlentities($_POST['title']));
		if (strpos($cont, '<br />')!=FALSE) {
	    	$cont=explode( "<br />",$cont);
			$content="";
			foreach ($cont as $key){
				$key=htmlentities($key);
				$content .=$key."<br />";
			}
			$content=coder($content);
			$content=substr_replace($content, '', -6);
			$content=wordwrap(coder($content),240,"<br>");
		}else{
			$content=htmlentities($cont);
			$content=wordwrap(coder($content),240,"<br>");
		}
	}else{
		$title=$_POST['title'];
		$content=$_POST['post'];
	}
	$id =new latestPostId;
	$id=$id->id +1;
	if ($_POST['type']=="video post") {
		$content="<video width='580' height='240' controls><source src='".$content."' type='video/mp4'>Your browser does not support HTML5 video.</video>";
	}
	if($_POST['anonymous']=="true" && isset($_POST['aname'],$_POST['apass']) && $_POST['aname']!="" && $_POST['apass']!=""){
		$anouser= new lastAnoUser();
		$anouser= $anouser->placement+1;
		$aname=htmlentities($_POST['aname']);
		$password= sha1($_POST['apass']);
		$salt='d0be2dc421be4fcd0172e5afceea3970e2f3d940';
		$new='';
		$d=0;
		for($i=0;$i < strlen($password); $i++) {
		    $new .= $salt[$i].$password[$d];
			$d++;
		}
		$apass=$new;
		new newAnoUser($id,$anouser,$aname,$apass);
		if($_POST['view_option'] == "personal"){
			new submitPost($id,0,$title,$view,$_POST['type'],$content);
			$pl = new lastPlacementInUserWall($username);
			$placement= $pl->placement +1;
			new insertIntoWall($username, $placement, $id);
		}elseif($_POST['view_option'] == "friends"){
			new submitPost($id,0,$title,$view,$_POST['type'],$content);
			$fr = new selectUserFriends($username);
			$plo = new lastPlacementInUserWall($username);
			$placment= $pl->placement +1;
			new insertIntoWall($username, $placment, $id);
			foreach($fr->friends as $key){
				$pl = new lastPlacementInUserWall($key[0]);
				$placement= $pl->placement +1;
				new insertIntoWall($key[0], $placement, $id);
			}
		}elseif($_POST['view_option'] == "global"){
			new submitPost($id,0,$title,$view,$_POST['type'],$content);
			$follower= new selectUserFollowers($username);
			$plo = new lastPlacementInUserWall($username);
			$placment= $pl->placement +1;
			new insertIntoWall($username, $placment, $id);
			foreach($follower->follower as $key){
				$pl = new lastPlacementInUserWall($key[0]);
				$placement= $pl->placement +1;
				new insertIntoWall($key[0], $placement, $id);
			}
		}
	}else{
    	if($_POST['view_option'] == "personal"){
			new submitPost($id,$_SESSION['uid'],$title,$view,$_POST['type'],$content);
			$pl = new lastPlacementInUserWall($username);
			$placement= $pl->placement +1;
			new insertIntoWall($username, $placement, $id);
		}elseif($_POST['view_option'] == "friends"){
			new submitPost($id,$_SESSION['uid'],$title,$view,$_POST['type'],$content);
			$fr = new selectUserFriends($username);
			$plo = new lastPlacementInUserWall($username);
			$placment= $plo->placement +1;
			new insertIntoWall($username, $placment, $id);
			foreach($fr->friends as $key){
				$pl = new lastPlacementInUserWall($key[0]);
				$placement= $pl->placement +1;
				new insertIntoWall($key[0], $placement, $id);
			}
		}elseif($_POST['view_option'] == "global"){
			new submitPost($id,$_SESSION['uid'],$title,$view,$_POST['type'],$content);
			$follower= new selectUserFollowers($username);
			$plo = new lastPlacementInUserWall($username);
			$placment= $plo->placement +1;
			new insertIntoWall($username, $placment, $id);
			foreach($follower->follower as $key){
				$pl = new lastPlacementInUserWall($key[0]);
				$placement= $pl->placement +1;
				new insertIntoWall($key[0], $placement, $id);
			}
		}
	}
}
?>