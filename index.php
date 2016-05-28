<?php
require "require.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>yugiv</title>
		<meta charset="utf-8">
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
		<script>
			$.fn.preload = function() {
    			this.each(function(){
			        $('<img/>')[0].src = this;
			    });
			}

			// Usage:
			
			$(['alexblattner/profile_picture/surf.jpg']).preload();
		</script>
	</head>
<body>
	<header><div id="profilecontainer"><img id='profilepictureheader' src="<?=$picture?>"/>
	<span class="ctext"><?= $name?><img src="<?=$originallink?>icons/notification.png" class="notification hide"/></span></div></header>
	<div id="mainlist" class="hide">
		<a href="<?=$profile?>"><div class="op">profile</div></a>
		<div id="notification" class="op">notifications<img src="<?=$originallink?>icons/notification.png" id="notificationbubble" class="notification hide"/></div>
		<div class="op" onclick="signout()">sign out</div>
	</div>
	<div id="toolbubble" class="notclick"><img src="<?=$originallink?>icons/tool.png" id="toolbubbleicon" /></div>
	<div id="socialbubble" class="notclick"><img src="<?=$originallink?>icons/social.png" id="socialbubbleicon" /><img src="<?=$originallink?>icons/notification.png" id="notificationsocial" class="notification hide"/></div>
	<div id="classerbubble" class="notclick"><img src="<?=$originallink?>icons/class.png" id="classbubbleicon" /></div>
	<?php
	require "postload.php";
	?>
	<script type="text/javascript" src="<?=$originallink?>src/autogrow.min.js"></script>
	<script type="text/javascript" src="<?=$originallink?>src/rotate.js"></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/postbuttons.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/commentsbuttons.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/settincon.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/bubbletool.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/bubblesocial.js'></script>	
	<script type='text/javascript' src='<?=$originallink?>ajax/bubbleclasser.js'></script>
	<script type='text/javascript' src='<?=$originallink?>ajax/profilelister.js'></script>
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
	})
	$('textarea').autogrow({animate: false});
		function signout(){
			window.location.href = "http://localhost/YUGIV/logout.php";	
		}
	</script>
</body>
</html>