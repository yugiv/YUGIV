<?php
require '../require.php';
require 'functions.php';
$tmp= $_FILES['image']['tmp_name'];
function imageUploader($tmp){
	global $originallink;
	$oname= new SplFileInfo($_FILES['image']['name']);
	if($oname->getExtension()==('jpg' || 'png' || 'jpeg' || 'jfif' || 'tiff' || 'tif')){
	$oname= ".".$oname->getExtension();
	$name= generateRandomString();
	if(file_exists($name)==FALSE){
		$destination= '../images/';
		if(move_uploaded_file($tmp, $destination.$name.$oname)){
			echo $originallink.'images/'.$name.$oname;
		}
	}else{
		imageUploader($tmp);
	}
}else{
	echo "enough rom!";
}
}
imageUploader($tmp);
?>