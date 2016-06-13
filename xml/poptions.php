<?php
    session_start();
	require 'mysql_classes.php';
	$uid= $_SESSION['uid'];
	$pid=$_POST['name'];
	
	echo "<div class='bubble'>";
	
		if(strpos($_POST['name'],'-')== false && is_numeric($pid)){
		$id= new posts();
		$id=$id->simpleSelect("post_id",$pid);
		$ano=(empty($id['user_id']) && is_int($id['user_id']))?"a":"";
		if($id['user_id']==$uid || (empty($id['user_id']) && is_int($id['user_id']))){
		echo "<ul><li class='edit' name='".$pid.$ano."'>edit</li><li class='delete' name='".$pid.$ano."'>delete</li></ul>";
		}	
		}else{
			$ids=explode("-", $_POST['name']);
			if(count($ids) == 2){
				$id=new comments();
				$id=$id->commentUserId($ids[0], $ids[1]);
				$ano=(empty($id['user_id']) && is_int($id['user_id']))?"a":"";
				if($id['user_id']==$uid || (empty($id['user_id']) && is_int($id['user_id']))){
				echo "<ul><li class='edit' name='".$pid.$ano."'>edit</li><li class='delete' name='".$pid.$ano."'>delete</li></ul>";
				}
			}elseif(count($ids) == 3){
				
			}
		}
	
	echo "</div>";
?>