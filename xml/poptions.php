<?php
    session_start();
	require 'mysql_classes.php';
	$uid= $_SESSION['uid'];
	$pid=$_POST['name'];
	
	echo "<div class='bubble'>";
	
		if(strpos($_POST['name'],'-')== false && is_numeric($pid)){
		$id= new postUserId($pid);
		$id=$id->id;
		$ano=($id['user_id']==0)?"a":"";
		if($id['user_id']==$uid || $id['user_id']==0){
		echo "<ul><li class='edit' name='".$pid.$ano."'>edit</li><li class='delete' name='".$pid.$ano."'>delete</li></ul>";
		}	
		}else{
			$ids=explode("-", $_POST['name']);
			if(count($ids) == 2){
				$id=new commentUserId($ids[0], $ids[1]);
				$id=$id->id;
				$ano=($id['user_id']==0)?"a":"";
				if($id['user_id']==$uid || $id['user_id']==0){
				echo "<ul><li class='edit' name='".$pid.$ano."'>edit</li><li class='delete' name='".$pid.$ano."'>delete</li></ul>";
				}
			}elseif(count($ids) == 3){
				
			}
		}
	
	echo "</div>";
?>