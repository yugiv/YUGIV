<?php
if(!preg_match('/\s/',$_POST['name'])){
?>
<div id="post" class="big blog_post">
<p>Entry Title: <input value="<?=$_POST['title']?>" name="title" id="title" type="text" size="80" maxlength="80" /></p>
<textarea id="blogtext" name="blogtext"></textarea>
<input name="<?=$_POST['name']?>" class="button" id="blogsubmit" type="button" value="update"/><input name="submit" class="button" id="blogcancel" type="button" value="cancel"/>
<script>
CKEDITOR.replace( 'blogtext' );
	function CKupdate(){
    for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
	}
	$(document).on('click', '#blogsubmit', function(){
		CKupdate();
		var content= CKEDITOR.instances.blogtext.getData();
		var view_option= $(".view").val();
		var ano = $(".anobox").is(":checked");
		var title= $("#title").val();
		$.post('postupload.php', {title:title,post: content, view_option: view_option,anonymous:ano, type: "blog post"}, function(data){
		$("#post").remove();
		});
	});
	$(document).on('click', '#blogcancel', function(){
		$("#post").remove();
	});
</script>
</div>
<?php
}
?>