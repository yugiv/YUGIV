<?php
if (!preg_match('/\s/',$_POST['name'])){
?>
<div id="post" class="medium video_post">
<p>Entry Title: <input name="title" value="<?=$_POST['title']?>" id="title" type="text" size="80" maxlength="80" /></p>
<div class="pcontent"><?=$_POST['content']?></div>
<input class="button" type="button" value="update" name="<?=$_POST['name']?>" id="videopost" /><input name="cancel" class="button" id="videocancel" type="button" value="cancel"/>
	<script>
		$(document).on('click','#videopost',function(){
			var name= $(this).attr('name');
			var title= $("#title").val();
			var video=$('.pcontent').html();
			alert("hi");
			$.post('http://localhost/YUGIV/post_update.php', {title:title,name:name,post: video}, function(){
				$(".postbox[name='"+name+"'] .ptitle").html(title);
				$(".postbox[name='"+name+"'] .content").html(video);
				$("#post").remove();
			});
		});
		$(document).on('click', '#videocancel', function(){
			$("#post").remove();
		});
	</script>
</div>
<?php
}
?>