<?php
if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST['type'])){
    session_start();
	require "mysql_classes.php";
	$uid = $_SESSION['uid'];
	$tool= new selectToolProperties($_POST['type']);
	$tool=$tool->array;
	echo $tool['edit'];
}