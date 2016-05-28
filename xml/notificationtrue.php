<?php
session_start();
    require "mysql_classes.php";
	new readNotification($_SESSION['uid']);
