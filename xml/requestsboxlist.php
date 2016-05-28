<?php
    require 'mysql_classes.php';
	$id= new userId($_POST['username']);
	$id= $id->uid;
	$array= new selectFriendRequests($id);
	$array= $array->array;
	foreach ($array as $key) {
		$friend =new userInfo($key['sending']);
		$friend= $friend->user;
		echo "<div class='plistr unselectable' data='".$friend['username']."'><a href='".$friend['profile']."'><img class='profilepicture' src='".$friend['profile_picture']."'/><div class='searchname'>".$friend['name']."</div></a><div class='buttons'><button data='".$friend['username']."' class='button requestaccept'>accept</button><button data='".$friend['username']."' class='button requestrefuse'>decline</button></div></div>";
		echo "<br />";
	}
?>