<?php
$documentroot="C:/xampp/htdocs/YUGIV/";
session_start();
require $documentroot."xml/mysql_classes.php";
$pid=$_POST['name'];
$content=wordwrap($_POST['content'],50,'<br>',TRUE);
$time=date('Y-m-d H:i:s');
$uid= $_SESSION['uid'];
if(!isset($_POST['anonymous'])){
	$id = new latestCommentID($pid);
	$id=$id->cid+1;
	new newCommentUpload($id,$pid,$uid,$time,$content);
	$cl= new commentsLoad($pid);
	$array = $cl->comments;
foreach ($array as $key) {
	$vote= new userVote($_SESSION['uid'], $_POST['name'], $key['comment_id'],0);
	$vote=$vote->vote;
	$pcount= $key['upvotes'];
	$ncount= $key['downvotes'];
	$user= new userInfo($key['user_id']);
	$user=$user->user;
	$uarrow= ($vote=="upvote")?"http://localhost/YUGIV/icons/greenuparrow.png":"http://localhost/YUGIV/icons/greyuparrow.png";
	$darrow= ($vote=="downvote")?"http://localhost/YUGIV/icons/reddownarrow.png":"http://localhost/YUGIV/icons/greydownarrow.png";
	echo "<table class='commentbox' name='".$key['post_id']."-".$key['comment_id']."'>
						<tr>
							<td>
								<a class='commentprofile' href=".$user['profile']."><img class='sprofilepicture' src='".$user['profile_picture']."'/><p class='stext'>".$user['name']."</p></a>
							</td>
							<td>
								<div name='".$key['post_id']."-".$key['comment_id']."' class='settcontain notclick'><img name='".$key['post_id']."' class='settings' src='http://localhost/YUGIV/icons/settings.png'/></div>
							</td>
						</tr>
						<tr>
							<td style='width:100%;' colspan='2'><article name='".$key['post_id']."-".$key['comment_id']."' class='content'>".$key['content']."</article></td>
						</tr>
						<tr>
							<td style='width:100%;' colspan='2'>
								<table class='slinecontainer'>
									<tr>
										<td style='width:48%;'>
											<div class='slikecontainer'>
											<div class='supcount' name='".$key['post_id']."-".$key['comment_id']."suc'>".$pcount."</div>
											<div class='sup imgs' name='".$key['post_id']."-".$key['comment_id']."su'><img height='10px' width='20px' type='image' src='".$uarrow."' /></div>
											<div class='sdowncount' name='".$key['post_id']."-".$key['comment_id']."sdc'>".$ncount."</div>
											<div class='sdown imgs' name='".$key['post_id']."-".$key['comment_id']."sd'><img height='10px' width='20px' type='image' src='".$darrow."' /></div>
											</div>
										</td>
										<td style='width:48%;'>
										comming soon, replies.
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>";
	
}
}else{
	$id = new latestCommentID($pid);
	$id=$id->cid+1;
	new newCommentUpload($id,$pid,0,$time,$content);
	$cl= new commentsLoad($pid);
	$array = $cl->comments;
foreach ($array as $key) {
	$vote= new userVote($_SESSION['uid'], $_POST['name'], $key['comment_id'],0);
	$vote=$vote->vote;
	$pcount= $key['upvotes'];
	$ncount= $key['downvotes'];
	$user= new userInfo($key['user_id']);
	$user=$user->user;
	$uarrow= ($vote=="upvote")?"http://localhost/YUGIV/icons/greenuparrow.png":"http://localhost/YUGIV/icons/greyuparrow.png";
	$darrow= ($vote=="downvote")?"http://localhost/YUGIV/icons/reddownarrow.png":"http://localhost/YUGIV/icons/greydownarrow.png";
	echo "<table class='commentbox' name='".$key['post_id']."-".$key['comment_id']."'>
						<tr>
							<td>
								<a class='commentprofile' href=".$user['profile']."><img class='sprofilepicture' src='".$user['profile_picture']."'/><p class='stext'>".$user['name']."</p></a>
							</td>
							<td>
								<div name='".$key['post_id']."-".$key['comment_id']."' class='settcontain notclick'><img name='".$key['post_id']."' class='settings' src='http://localhost/YUGIV/icons/settings.png'/></div>
							</td>
						</tr>
						<tr>
							<td style='width:100%;' colspan='2'><article name='".$key['post_id']."-".$key['comment_id']."' class='content'>".$key['content']."</article></td>
						</tr>
						<tr>
							<td style='width:100%;' colspan='2'>
								<table class='slinecontainer'>
									<tr>
										<td style='width:48%;'>
											<div class='slikecontainer'>
											<div class='supcount' name='".$key['post_id']."-".$key['comment_id']."suc'>".$pcount."</div>
											<div class='sup imgs' name='".$key['post_id']."-".$key['comment_id']."su'><img height='10px' width='20px' type='image' src='".$uarrow."' /></div>
											<div class='sdowncount' name='".$key['post_id']."-".$key['comment_id']."sdc'>".$ncount."</div>
											<div class='sdown imgs' name='".$key['post_id']."-".$key['comment_id']."sd'><img height='10px' width='20px' type='image' src='".$darrow."' /></div>
											</div>
										</td>
										<td style='width:48%;'>
										comming soon, replies.
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>";
	
}
}
?>