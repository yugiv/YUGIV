<?php
require '../require.php';
?>
<div id="alert">
	Do you sure you want to be friends with ?
	<br />
	<button class="yes">YES</button>
	<button class="no">NO</button>
	<script>
		$('.yes').on('click', function(){
		var url = window.location.href;
		var username = url.split("profiles/");
		username= username[1].split("/");
		username= username[0];
			$.post('<?=$originallink?>xml/acceptfriendrequest.php', {username: username}, function(data){
				if(data=="done")
				$('.friendstuff').text("friend");
				else
				alert(data);
				});
			$.magnificPopup.close();
		});
		$('.no').on('click', function(){
			$.magnificPopup.close();
		});
	</script>
</div>