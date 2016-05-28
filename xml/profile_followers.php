<?php
	require 'functions.php';
	$content=htmlentities($_GET['user']);
	$content=coder($content);
	$usid= new userId($content);
	$usid=$usid->uid;
    $friends= new selectUserFollowers($usid);
	$friends= $friends->follower;
	echo "<div id='profileboxfollowers'>";
	if(!empty($friends)){
	foreach($friends as $key) {
			$user= new userInfo($key['user_id']);
			$user= $user->user;
		echo "<div class='plist unselectable'><a href='".$user['profile']."'><img class='profilepicture' src='".$user['profile_picture']."'/><span class='profilename'>".$user['name']."</span></a></div>";
	}
	}else{
		echo "no followers....     FOREVER ALONE!!!";
	}
	echo "</div>";
