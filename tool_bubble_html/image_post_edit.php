<?php
if (!preg_match('/\s/',$_POST['name'])){
?>
<div id="post" class="medium image_post">
<p>Entry Title: <input name="title" value="<?=$_POST['title']?>" id="title" type="text" size="80" maxlength="80" /></p>
<div class="pcontent"><?=$_POST['content']?></div>
<input class="button" type="button" value="update" name="<?=$_POST['name']?>" id="imagepost" /><input name="cancel" class="button" id="imagecancel" type="button" value="cancel"/>
	<script>
		$(document).on('click','#imagepost',function(){
			var name= $(this).attr('name');
			var title= $("#title").val();
			var image=$('.pcontent').html();
			$.post('http://localhost/YUGIV/imageupload.php', {title:title,name:name,post: image}, function(){
				$(".postbox[name='"+name+"'] .ptitle").html(title);
				$(".postbox[name='"+name+"'] .content").html(image);
				$("#post").remove();
			});
		});
		$(document).on('click', '#imagecancel', function(){
			$("#post").remove();
		});
	</script>
</div>
<?php
}
?>