<?php
    session_start();
	$uid= $_SESSION['uid'];
	$db = new PDO('mysql:host=localhost;dbname=yugiv;charset=utf8', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$pid=$_POST['name'];
	
	echo "<div class='bubble'>";
	
		if(strpos($_POST['name'],'-')== false){
		$query="SELECT user_id FROM `posts` WHERE post_id=?";
		$dd =$db->prepare($query);
		$dd->execute(array($pid));
		$key=$dd->fetch(PDO::FETCH_ASSOC);
		if($key['user_id']==$uid){
		echo "<ul><li class='edit' name='".$pid."'>edit</li><li class='delete' name='".$pid."'>delete</li></ul>";
		}	
		}else{
			$ids=explode("-", $_POST['name']);
			if(count($ids) == 2){
				$query="SELECT user_id FROM `comments` WHERE post_id=? AND comment_id=?";
				$dd =$db->prepare($query);
				$dd->execute(array($ids[0], $ids[1]));
				$key=$dd->fetch(PDO::FETCH_ASSOC);
				if($key['user_id']==$uid){
				echo "<ul><li class='edit' name='".$pid."'>edit</li><li class='delete' name='".$pid."'>delete</li></ul>";
				}
			}elseif(count($ids) == 3){
				
			}
		}
	
	echo "</div>";
?>