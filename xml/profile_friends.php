<?php
$url= $_SERVER['PHP_SELF'];
	$url=substr($url, 16);
	$url=substr($url,0,-4);
    $friends= new selectFriends($url);
	$friends= $friends->array;
	echo "<div id='profileboxfriends'>";
	if(!empty($friends)){
	foreach ($friends as $key) {
		if($key['username']== $username){
			$id= new userId($key['friend']);
			$id= $id->uid;
			$user= new userInfo($id);
			$user= $user->user;
		}else{
			$id= new userId($key['username']);
			$id= $id->uid;
			$user= new userInfo($id);
			$user= $user->user;
		}
		echo "<div class='plist unselectable'><a href='".$user['profile']."'><img class='profilepicture' src='".$user['profile_picture']."'/><span class='profilename'>".$user['name']."</span></a></div>";
	}
	}else{
		echo "no friends....     FOREVER ALONE!!!";
	}
	echo "</div>";
