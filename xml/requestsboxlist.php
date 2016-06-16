<?php
    require 'mysql_classes.php';
	$us= new users();
	$id= $us->userInfoByUsername($_POST['username']);
	$array= new friend_requests(0,$id['id']);
	$array= $array->receivedFriendRequests();
	foreach ($array as $key) {
		$friend= $us->userInfoById($key['sending']);
		echo "<div class='plistr unselectable' data='".$friend['username']."'><a href='".$friend['profile']."'><img class='profilepicture' src='".$friend['profile_picture']."'/><div class='searchname'>".$friend['name']."</div></a><div class='buttons'><button data='".$friend['username']."' class='button requestaccept'>accept</button><button data='".$friend['username']."' class='button requestrefuse'>decline</button></div></div>";
		echo "<br />";
	}
?>