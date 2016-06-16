<?php
require 'mysql_classes.php';
    $output= new users();
	$output= $output->searchUsersByName($_POST['data']);
	foreach ($output as $key) {
		if($key['name']!="Anonymous")
		echo "<a href='".$key['profile']."'><img class='profilepicture' src='".$key['profile_picture']."'/><div class='searchname'>".$key['name']."</div><div class='searchusername'>@".$key['username']."</div></a>";
	}
?>