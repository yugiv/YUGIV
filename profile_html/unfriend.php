<?php
require '../require.php';
?>
<div id="alert">
	Are you sure you want to unfriend him?
	<br />
	<button class="yes">YES</button>
	<button class="no">NO</button>
	<script>
	$('.yes').on('click', function(){
		var url = window.location.href;
		var username = url.split("profiles/");
		username= username[1].split("/");
		username= username[0];
			$.post('<?=$originallink?>xml/unfriend.php', {username: username}, function(data){
				if(data=="done")
				$('.friendstuff').text("send friend request");
				else
				alert('fuk u hacker');
			});
		$.magnificPopup.close();
	});
	$('.no').on('click', function(){
		$.magnificPopup.close();
	});
	</script>
</div>