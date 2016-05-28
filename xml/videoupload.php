<?php
require '../require.php';
require 'functions.php';
$tmp= $_FILES['video']['tmp_name'];
function videoUploader($tmp){
	global $originallink;
	$oname= new SplFileInfo($_FILES['video']['name']);
	if($oname->getExtension()==('mp4' || 'ogg' || 'webm')){
	$oname= ".".$oname->getExtension();
	$name= generateRandomString();
	if(file_exists($name)==FALSE){
		$destination= '../videos/';
		if(move_uploaded_file($tmp, $destination.$name.$oname)){
			echo $originallink.'videos/'.$name.$oname;
		}
	}else{
		videoUploader($tmp);
	}
}else{
	echo "enough rom!";
}
}
videoUploader($tmp);
?>