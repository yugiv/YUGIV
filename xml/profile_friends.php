<?php
$url= $_SERVER['PHP_SELF'];
	$url=substr($url, 16);
	$url=substr($url,0,-4);
	$us= new users();
	$user_id= $us->userInfoByUsername($username);
    $friends= new friends;
	$friends= $friends->selectFriends($user_id['id']);
	echo "<div id='profileboxfriends'>";
	if(!empty($friends)){
	foreach ($friends as $key) {
		if($key['user_id']!= $user_id['id']){
			$user= $us->userInfoById($key['friend']);
		}else{
			$user= $us->userInfoById($key['user_id']);
		}
		echo "<div class='plist unselectable'><a href='".$user['profile']."'><img class='profilepicture' src='".$user['profile_picture']."'/><span class='profilename'>".$user['name']."</span></a></div>";
	}
	}else{
		echo "no friends....     FOREVER ALONE!!!";
	}
	echo "</div>";
