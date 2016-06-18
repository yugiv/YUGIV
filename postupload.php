<?php
session_start();
require 'xml/mysql_classes.php';
require 'xml/functions.php';
if (isset($_POST['post'])) {
	$us= new users;
	$username= $us->userInfoById($_SESSION['uid']);
	$username=$username['username'];
	$view=$_POST['view_option'];
	$cont=$_POST['post'];
	if ($_POST['type']!="blog") {
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
	$p =new posts;
	$id=$p->latestPostId() +1;
	if ($_POST['type']=="video") {
		$content="<video width='580' height='240' controls><source src='".$content."' type='video/mp4'>Your browser does not support HTML5 video.</video>";
	}
	if($_POST['anonymous']=="true" && isset($_POST['aname'],$_POST['apass']) && $_POST['aname']!="" && $_POST['apass']!=""){
		$aname=htmlentities($_POST['aname']);
		$apass= password($_POST['apass']);
		echo $id.$anouser.$aname.$apass;
		$a=new anonymous_posts();
		$a->newAnoUser($id,$anouser,$aname,$apass);
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
			$placement= $plo->placement +1;
			new insertIntoWall($username, $placement, $id);
			foreach($follower->follower as $key){
				$pl = new lastPlacementInUserWall($key[0]);
				$placement= $pl->placement +1;
				new insertIntoWall($key[0], $placement, $id);
			}
		}
	}else{
    	if($_POST['view_option'] == "personal"){
			$p->submitPost($id,$_SESSION['uid'],$title,$view,$_POST['type'],$content);
			$w = new walls();
			$placement= $w->lastPlacementInUserWall($username); +1;
			$w->insertIntoWall($username, $placement, $id);
		}elseif($_POST['view_option'] == "friends"){
			$p->submitPost($id,$_SESSION['uid'],$title,$view,$_POST['type'],$content);
			$fr= new friends();
			$fr = $fr->selectUserFriends($username);
			$w= new walls();
			$placment= $w->lastPlacementInUserWall($username) +1;
			$w->insertIntoWall($username, $placment, $id);
			foreach($fr->friends as $key){
				$placement= $w->lastPlacementInUserWall($key[0]) +1;
				$w->insertIntoWall($key[0], $placement, $id);
			}
		}elseif($_POST['view_option'] == "global"){
			$p->submitPost($id,$_SESSION['uid'],$title,$view,$_POST['type'],$content);
			$w= new walls();
			$fo= new follow_info();
			$follower= $fo->selectUserFollowers($username);
			$placment= $w->lastPlacementInUserWall($username) +1;
			$w->insertIntoWall($username, $placment, $id);
			foreach($follower->follower as $key){
				$placement= $w->lastPlacementInUserWall($key[0]) +1;
				$w->insertIntoWall($key[0], $placement, $id);
			}
		}
	}
}
?>