<?php
session_start();
require "mysql_classes.php";
$uid=(int)$_SESSION['uid'];
$pid=(int)$_POST['name'];
$c= new comments();
$carray= $c->commentsLoad($pid);
foreach ($carray as $key) {
	$vote= new votes($pid, (int)$key['comment_id'],(int)0);
	$vote=$vote->userVote($uid);
	$pcount= $key['upvotes'];
	$ncount= $key['downvotes'];
	$user= new users();
	$user=$user->userInfo((int)$key['user_id']);
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
?>