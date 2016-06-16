<?php
session_start();
    require 'mysql_classes.php';
	$array= new follow_info();
	$array= $array->selectFollowing((int)$_SESSION['uid']);
	foreach ($array as $key) {
		$friend =new users();
		$friend= $friend->userInfoById((int)$key['followed_id']);
		echo "<div class='plist unselectable'><a href='".$friend['profile']."'><img class='profilepicture' src='".$friend['profile_picture']."'/><div class='searchname'>".$friend['name']."</div><div class='searchusername'>@".$friend['username']."</div></a></div>";
	}
?>