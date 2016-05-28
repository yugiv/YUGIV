<?php
session_start();
    require 'mysql_classes.php';
	$array= new selectFollowing($_SESSION['uid']);
	$array= $array->array;
	foreach ($array as $key) {
		$friend =new userInfo($key['followed_id']);
		$friend= $friend->user;
		echo "<div class='plist unselectable'><a href='".$friend['profile']."'><img class='profilepicture' src='".$friend['profile_picture']."'/><div class='searchname'>".$friend['name']."</div><div class='searchusername'>@".$friend['username']."</div></a></div>";
	}
?>