<?php
session_start();
    require 'mysql_classes.php';
	$array= new friends();
	$array= $array->selectFriends($_SESSION['uid']);
	foreach ($array as $key) {
		$frien= ($key['friend_id']== $_SESSION['uid'])?$key['user_id']:$key['friend_id'];
		$friend =new users;
		$friend= $friend->userInfoById((int)$frien);
		echo "<div class='plist unselectable'><a href='".$friend['profile']."'><img class='profilepicture' src='".$friend['profile_picture']."'/><div class='searchname'>".$friend['name']."</div><div class='searchusername'>@".$friend['username']."</div></a></div>";
	}
?>