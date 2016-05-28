<?php
require 'mysql_classes.php';
    $output= new searchUsersByName($_POST['data']);
	$output= $output->output;
	foreach ($output as $key) {
		if($key['name']!="Anonymous")
		echo "<a href='".$key['profile']."'><img class='profilepicture' src='".$key['profile_picture']."'/><div class='searchname'>".$key['name']."</div><div class='searchusername'>@".$key['username']."</div></a>";
	}
?>