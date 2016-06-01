<?php
require 'xml/functions.php';
	$uid= $_SESSION['uid'];
	$un = new userInfo($uid);
	$username= $un->user;
	$username=$username['username'];
	$rules="";
	if (isset($_GET['filter'])) {
		$cleanget=classer($_GET['filter']);
			if(isset($cleanget['main']['pointscheck'])){
				$carr= explode('_', $cleanget['main']['pointscheck']);
				echo (empty($carr[0]) && !is_numeric($carr[0]))?"hi":"bye$carr[0]";
				if(empty($carr[0]) && !is_numeric($carr[0])){
					$rules.=" AND (posts.upvotes-posts.downvotes)<=".$carr[1];
				}elseif(empty($carr[1]) && !is_numeric($carr[1])){
					$rules.=" AND (posts.upvotes-posts.downvotes)>=".$carr[0];
				}else{
					$rules.=" AND (posts.upvotes-posts.downvotes)>=".$carr[0]." AND (posts.upvotes-posts.downvotes)<=".$carr[1];
				}
			}
			if(isset($cleanget['main']['upvotescheck'])){
				$pcarr= explode('_', $cleanget['main']['upvotescheck']);
				if(empty($pcarr[0]) && !is_numeric($pcarr[0])){
					$rules.=" AND posts.upvotes<=".$pcarr[1];
				}elseif(empty($pcarr[1]) && !is_numeric($pcarr[1])){
					$rules.=" AND posts.upvotes>=".$pcarr[0];
				}else{
					$rules.=" AND posts.upvotes>=".$pcarr[0]." AND posts.upvotes<=".$pcarr[1];
				}
			}	
			if(isset($cleanget['main']['downvotescheck'])){
				$ncarr= explode('_', $cleanget['main']['downvotescheck']);
				if(empty($ncarr[0]) && !is_numeric($ncarr[0])){
					$rules.=" AND posts.downvotes<=".$ncarr[1];
				}elseif(empty($ncarr[1]) && !is_numeric($ncarr[1])){
					$rules.=" AND posts.downvotes>=".$ncarr[0];
				}else{
					$rules.=" AND posts.downvotes>=".$ncarr[0]." AND posts.downvotes<=".$ncarr[1];
				}
			}
			if(isset($cleanget['main']['global'])){
				$rules.=" AND posts.view_option!='global'";
			}
			if(isset($cleanget['main']['friends'])){
				$rules.=" AND posts.view_option!='friends'";
			}
			if(isset($cleanget['main']['personal'])){
				$rules.=" AND posts.view_option!='personal'";
			}
	}
	if(!empty($username)){
		if(!isset($cleanget['main']['postchoice'])){
			echo $rules;
			$ps = new selectWallPosts($username,"time",$rules);
			$parray= $ps->array;
		}else{
			$rules.=" AND (posts.view_option='global'";
			if(!isset($cleanget['main']['friends'])){
				$rules.=" OR (posts.view_option='friends' AND (friends.friend_id=".$_SESSION['uid']." AND (friends.user_id=posts.user_id OR posts.user_id=".$_SESSION['uid'].") ) OR (friends.user_id=".$_SESSION['uid']." AND (friends.friend_id=posts.user_id OR posts.user_id=".$_SESSION['uid'].")))";
			}
			if(!isset($cleanget['main']['personal'])){
				$rules.=" OR (posts.view_option='personal' AND posts.user_id=".$_SESSION['uid'].")";
			}
			$rules.=")";
			$ps = new selectAllPosts("time",$rules);
			$parray= $ps->array;
			
		}
		echo "<div id='posts'>";
		
		foreach($parray as $key){
			$permition= true;
			$uv = new userVote($uid,$key['post_id'],0,0);
			$uservote = $uv->vote;
			$pcount= $key['upvotes'];
			$ncount= $key['downvotes'];
			$us= new userInfo($key['user_id']);
			$user= $us->user;
			$profile= ($user['id']==0)?"":$user['id'];
			if($user['id']==0){
				$ano= new anoInfo($key['post_id']);
				$ano=$ano->array;
				$name=$ano['name'];
			}else{
				$name=$user['name'];
			}
			$com = new commentsCount($key['post_id']);
			$ccount = $com->ccount;
			$c= new bigNumbersKiller($pcount);
			$pcount= $c->result;
			$d= new bigNumbersKiller($ncount);
			$ncount= $d->result;
			if($key['view_option'] == "global"){
				echo "<table class='postbox' name='".$key['post_id']."'>
						<tr style='width:100%;'>
							<td>
								<a href='".$profile."'><img class='profilepicture' src='".$user['profile_picture']."'/><span class='profilename'>".$name."</span></a>
							</td>
							<td style='width:21px;'>
								<div name='".$key['post_id']."' class='settcontain notclick'><img name='".$key['post_id']."' class='settings' src='".$originallink."icons/settings.png'/></div>
							</td>
						</tr>
						<tr style='width:100%;'>
							<td style='width:100%;' colspan='2'><h2 class='ptitle' style='text-align: center; font-size:30pt;'>".$key['title']."</h2><p class='content'>".$key['content']."</p></td>
						</tr>
						<tr style='width:100%;'>
							<td style='width:100%;' colspan='2'>
								<table class='linecontainer'>
									<tr>
										<td style='width:32%;'>
											<div class='likecontainer unselectable'>
											<div class='upcount' name='".$key['post_id']."uc'>".$pcount."</div>
											<div class='up img' name='".$key['post_id']."u' ><img height='16px' width='22px' 
											src='";
											if($uservote=='upvote') {
												echo $originallink."icons/greenuparrow.png";
											} else {
												echo $originallink."icons/greyuparrow.png";
											};
											echo"'/></div>
											<div class='downcount' name='".$key['post_id']."dc'>".$ncount."</div>
											<div class='down img' name='".$key['post_id']."d' ><img height='16px' width='22px' src='";
											if ($uservote=='downvote') {
												echo $originallink."icons/reddownarrow.png";
											} else {
												echo $originallink."icons/greydownarrow.png";
											};
											echo"'/></div>
											</div>
										</td>
										<td style='width:32%;'>
											<table class='commentcontainer unselectable notclick' style='float:right' name='".$key['post_id']."c'><tr>
												<td>".$ccount."</td><td>comment(s)</td><td><div class='speech' name='".$key['post_id']."s'>
												<img class='img' height='16px' width='20px' src='".$originallink."icons/greyspeech.png'/></div></td></tr></table>
											</td><td style='width:32%;'>
											<div class='sharecontainer unselectable' name='".$key['post_id']."h'>share <div class='share' name='".$key['post_id']."s'>
											<img class='img' height='16px' width='20px' src='".$originallink."icons/blackshare.png'/></div>
											</div>
											</div>
										</td>
									</tr>
								</table>
								</tbody>
						</table>";
			}else{
				echo "<table class='postbox' name='".$key['post_id']."'>
						<tr>
							<td>
								<a href='".$user['profile']."'><img class='profilepicture' src='".$user['profile_picture']."'/>".$user['name']."</a>
							</td>
							<td>
								<div name='".$key['post_id']."' class='settcontain notclick'><img name='".$key['post_id']."' class='settings' src='".$originallink."icons/settings.png'/></div>
							</td>
						</tr>
						<tr>
							<td style='width:100%;' colspan='2'><h2 class='ptitle' style='text-align: center; font-size:30pt;'>".$key['title']."</h2><p class='content'>".$key['content']."</p></td>
						</tr>
						<tr>
							<td style='width:100%;' colspan='2'>
								<table class='linecontainer'>
									<tr>
										<td style='width:48%;'>
											<div class='likecontainer'>
											<div class='upcount' name='".$key['post_id']."uc'>".$pcount."</div>
											<div class='up img' name='".$key['post_id']."u' ><img height='16px' width='22px' 
											src='";
											if($uservote=='upvote') {
												echo $originallink."icons/greenuparrow.png";
											} else {
												echo $originallink."icons/greyuparrow.png";
											};
											echo"'/></div>
											<div class='downcount' name='".$key['post_id']."dc'>".$ncount."</div>
											<div class='down img' name='".$key['post_id']."d' ><img height='16px' width='22px' src='";
											if ($uservote=='downvote') {
												echo $originallink."icons/reddownarrow.png";
											} else {
												echo $originallink."icons/greydownarrow.png";
											};
											echo"'/></div>
											</div>
										</td>
										<td style='width:48%;'>
											<table class='commentcontainer notclick' name='".$key['post_id']."c'><tr>
											<td>".$ccount."</td><td>comment(s)</td><td><div class='speech' name='".$key['post_id']."s'>
											<img class='img' src='".$originallink."icons/greyspeech.png'/></div></td></tr></table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>";
			}
		}
	echo "</div>";
}