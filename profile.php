<?php
if(isset($_GET['user'])){
	require "require.php";
	$usern= new users();
	$usern= $usern->userInfo($_GET['user']);
	$usern=$usern['id'];
	if(!empty($usern)){
	$puser= new users();
	$puser= $puser->userInfo($usern);
	$array =new users();
	$array= $array->userInfo($_SESSION['uid']);
	$fname= explode(" ", $array['name']);
	$fname= $fname[0];
	if(!isset($_GET['tag']) || (isset($_GET['tag']) && $_GET['tag'] != "folders" && $_GET['tag'] != "friends" && $_GET['tag'] != "followers" && $_GET['tag'] != "info")){
		$click="posts";
	}elseif(isset($_GET['tag']) && $_GET['tag'] == "folders"){
		$click="folders";
	}elseif(isset($_GET['tag']) && $_GET['tag'] == "friends"){
		$click="friends";
	}elseif(isset($_GET['tag']) && $_GET['tag'] == "followers"){
		$click="followers";
	}elseif(isset($_GET['tag']) && $_GET['tag'] == "info"){
		$click="info";
	}
	if($array['username'] != $puser['username']){
	$friend= new friends();
	$friend= $friend->checkFriend($puser['id'],$array['id']);
	$frequest= new friend_requests();
	$frequest= $frequest->checkFriendRequests($array['id'],$puser['id']);
	$ofrequest= new friend_requests();
	$ofrequest= $ofrequest->checkFriendRequests($puser['id'], $array['id']);
	if ($friend==TRUE) {
		$fbutton="friend";
	}elseif($frequest==TRUE){
		$fbutton="friend request sent";
	}elseif($ofrequest==TRUE){
		$fbutton="accept friend request";
	}else{
		$fbutton="send friend request";
	}
	$follow= new follow_info();
	$follow= $follow->checkFollow($_SESSION['uid'],$puser['id']);
	$follow= ($follow)?"following":"follow?";
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$puser['username']?>'s profile</title>
		<meta charset="utf8_unicode_ci">
		<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?=$originallink?>css/mystyle.css">
		<link rel="stylesheet" type="text/css" href="<?=$originallink?>css/magnific-popup.css">		
		<script type='text/javascript' src='<?=$originallink?>src/jquery-2.1.4.min.js'></script>
		<link rel="stylesheet" type="text/css" href="<?=$originallink?>css/tipsy.css">
		<script type="text/javascript" src="<?=$originallink?>src/jquery.tipsy.js"></script>
		<script src="<?=$originallink?>ckeditor/ckeditor.js"></script>
		<script type='text/javascript' src='<?=$originallink?>src/file_upload.js'></script>
		<script type='text/javascript' src='<?=$originallink?>src/jquery.magnific-popup.js'></script>
	</head>

<body>
	<header><div id="profilecontainer"><img id='profilepictureheader' src="<?=$array['profile_picture']?>"/>
	<span class="ctext"><?= $fname?><img src="<?=$originallink?>icons/notification.png" class="notification hide"/></span></div></header>
	<div id="socialbubble" class="notclick"><img src="<?=$originallink?>icons/social.png" id="socialbubbleicon" /><img src="<?=$originallink?>icons/notification.png" id="notificationsocial" class="notification hide"/></div>
	<div id="classerbubble" class="notclick"><img src="<?=$originallink?>icons/class.png" id="classbubbleicon" /></div>
	<div id="mainlist" class="hide">
		<a href="<?=$array['profile']?>"><div class="op">profile</div></a>
		<div id="notification" class="op">notifications<img src="<?=$originallink?>icons/notification.png" id="notificationbubble" class="notification hide"/></div>
		<div class="op" onclick="signout()">sign out</div>
	</div>
	<div id="mainprofilecontainer">
		<div><img id="profilepicture" src="<?=$puser['profile_picture']?>" />
			<div id="profile_name">
				<div style="font-size: 20pt;"><?=$puser['name']?></div><br>
				<div>@<?=$puser['username']?></div>
			</div>
	<?php
		if($array['username'] != $puser['username']){
	?>
	<div id="profileoptions">
		<ul style="list-style-type: none; text-align: center;">
			<li class="friendstuff unselectable"><?=$fbutton?></li>
			<li class="followstuff unselectable"><?=$follow?></li>
		</ul>
	</div>
	<?php
		}else{
	?>
	<div id="profile_edit" class="unselectable">choose profile picture</div>
	<?php
}?>
	</div>
	<ul id="profilebuttonscontainer">
		<li style="display: inline-block;">
			<a  class="profilebutton<?php if($click=="posts"){echo " isclick";}?>" href="<?=$originallink?>profiles/<?=$_GET['user']?>/posts">posts</a>
		</li>
		<li style="display: inline-block;">
			<a  class="profilebutton<?php if($click=="folders"){echo " isclick";}?>" href="<?=$originallink?>profiles/<?=$_GET['user']?>/folders">folders</a>
		</li>
		<li style="display: inline-block;">
			<a class="profilebutton<?php if($click=="friends"){echo " isclick";}?>" href="<?=$originallink?>profiles/<?=$_GET['user']?>/friends">friends</a>
		</li>
		<li style="display: inline-block;">
			<a  class="profilebutton<?php if($click=="followers"){echo " isclick";}?>" href="<?=$originallink?>profiles/<?=$_GET['user']?>/followers">followers</a>
		</li>
		<li style="display: inline-block;">
			<a class="profilebutton<?php if($click=="info"){echo " isclick";}?>" href="<?=$originallink?>/profiles/<?=$_GET['user']?>/info">info</a>
		</li>	
	</ul>
	
	<?php
	if($click =="posts"){
		require 'profile_loader.php';
	}elseif($click == "friends"){
		require 'xml/profile_friends.php';
	}elseif($click == "followers"){
		require 'xml/profile_followers.php';
	}
	?>
	</div>
	<script type="text/javascript" src="<?=$originallink?>src/autogrow.min.js"></script>
	<script type="text/javascript" src="<?=$originallink?>src/rotate.js"></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/postbuttons.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/commentsbuttons.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/settincon.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/bubbletool.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/bubblesocial.js'></script>	
	<script type='text/javascript' src='<?=$originallink?>ajax/bubbleclasser.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/profilelister.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/profilespecialbuttons.js'></script>
	<script>
	$(document).on('click',"#notification", function(){
		$.get("http://localhost/YUGIV/notificationbox.php",function(data){
			$( "body" ).append(data);
			$.get("http://localhost/YUGIV/xml/notificationtrue.php",function(data){
			});
			$.magnificPopup.open({
  				items: {
			    src: $(data),
			    type: 'inline'
				},
				closeBtnInside: false,
				callbacks: {
					
					afterClose: function() {
						$( "#notificationbox" ).remove();
						$("#notificationbubble").addClass("hide");
						$("#profilecontainer .notification").addClass("hide");
					}
  				}
			});
		});
	});
	setTimeout(function() {
    	notify();
  	}, 2000);
  	setTimeout(function() {
    	frequests();
  	}, 2000);
	function notify() {
		if($("#notificationbubble").hasClass("hide")){
			$.get("http://localhost/YUGIV/xml/notificationcheck.php",function(data){
				if(data == "true"){
					$(".notification").removeClass("hide");
				}else{
					setTimeout(function() {
				    	notify();
				  	}, 5000);
				}
			});
		}
	}
	function frequests() {
		if($("#notificationbubble").hasClass("hide")){
			$.get("http://localhost/YUGIV/xml/friend_request_check.php",function(data){
				if(data == "true"){
					$("#notificationsocial").removeClass("hide");
				}else{
				  	setTimeout(function() {
				    	notify();
				  	}, 2000);
				}
			});
		}
	}
	$(document).on('click',".socialbubble",function () {
		$("#notificationsocial").addClass("hide");
		setTimeout(function() {
    	notify();
  	}, 2000);
  	setTimeout(function() {
    	frequests();
  	}, 2000);
	});
	$('textarea').autogrow({animate: false});
		function signout(){
			window.location.href = "http://localhost/YUGIV/logout.php";	
		}
	</script>
</body>
</html>
<?php
}
}
?>