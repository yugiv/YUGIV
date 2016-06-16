<?php
	require 'functions.php';
	$content=htmlentities($_GET['user']);
	$content=coder($content);
	$us= new users();
	$usid=$us->userInfoByUsername($content);
    $friends= new follow_info();
	$friends= $friends->selectUserFollowers($usid['id']);
	echo "<div id='profileboxfollowers'>";
	if(!empty($friends)){
	foreach($friends as $key) {
			$user= $us->userInfoById($key['user_id']);
		echo "<div class='plist unselectable'><a href='".$user['profile']."'><img class='profilepicture' src='".$user['profile_picture']."'/><span class='profilename'>".$user['name']."</span></a></div>";
	}
	}else{
		echo "no followers....     FOREVER ALONE!!!";
	}
	echo "</div>";
