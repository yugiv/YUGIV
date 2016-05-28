<?php
    session_start();
	require "mysql_classes.php";
	$up= new userToolPreferences($_SESSION['uid']);
	$up=$up->array;
	$i=0;
	foreach($up as $key){
		if(!is_numeric($key)){
		$a= new toolInfo($key);
		$a= $a->array;
		$array[$i][0]=$a['post_type'];
		$array[$i][1]=$a['icon'];
		$array[$i][2]=$a['tool_bubble'];
		$i++;
		}
	}
	echo json_encode($array);