<?php
if (!preg_match('/\s/',$_POST['name'])){
?>
<div id="post" class="small regular_post">
	<p>Entry Title: <input value="<?=$_POST['title']?>" name="title" id="title" type="text" size="80" maxlength="80" /></p>
	<textarea class="writer" name="post" form="postform"><?=$_POST['content']?></textarea>
	<input type="button" value="update" name="<?=$_POST['name']?>" class="button" id="regularpost" /><input name="cancel" class="button" id="regularcancel" type="button" value="cancel"/>
<script>
	$(document).on('click', '#regularpost', function(){
		var post=$(".writer").val().replace(/\r\n|\r|\n/g,"<br />");
		var name = $("#regularpost").attr("name");
		var title= $("#title").val();
		$.post('http://localhost/YUGIV/post_update.php', {title:title,name:name,post: post}, function(data){
			if(data!=""){
			$(".postbox[name='"+name+"'] .ptitle").html(title);
			$(".postbox[name='"+name+"'] .content").html(post);
			$("#post").remove();
			}else{
				alert("fuk u hacker!");
			}
		});
	});
	$(document).on('click', '#regularcancel', function(){
		$("#post").remove();
	});
</script>
</div>
<?php
}
?>