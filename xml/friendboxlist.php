<?php
session_start();
    require 'mysql_classes.php';
	$array= new selectFriends($_SESSION['uid']);
	$array= $array->array;
	foreach ($array as $key) {
		$frien= ($key['friend_id']== $_SESSION['uid'])?$key['user_id']:$key['friend_id'];
		$friend =new userInfo($frien);
		$friend= $friend->user;
		echo "<div class='plist unselectable'><a href='".$friend['profile']."'><img class='profilepicture' src='".$friend['profile_picture']."'/><div class='searchname'>".$friend['name']."</div><div class='searchusername'>@".$friend['username']."</div></a></div>";
	}
?>