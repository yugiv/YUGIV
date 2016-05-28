<?php
require '../require.php';
?>
<div id="alert">
	Choose a profile picture:
	<br />
	<div style="margin-left: 10px; width: 250px;"><div id="get_file">
<input type="file" name="image" id="file" />
	<p>click or drop file to choose profile picture</p>
</div>
<div id="customfileupload">Select a file</div>
<progress id="prog" style="visibility: hidden;" value="0" min="0" max="100"></progress></div>
	<div style="position: absolute; bottom: 0; left: 0;"><button class="yes button">upload</button>
	<button class="no button">cancel</button></div>
	
	<script>
		$('.yes').on('click', function(){
		var url = window.location.href;
		var username = url.split("profiles/");
		username= username[1].split("/");
		username= username[0];
			$("#file").upload('<?=$originallink?>xml/imageupload.php',function(data){
				alert(data);
				if(data != "" || data != "enough rom!"){
				$.post('<?=$originallink?>xml/update_profile.php', {image: data}, function(datta){
				$.magnificPopup.close();
				location.reload();
				});
			}else{
					alert("an error occured");
				}
			},$("#prog"));
		});	
		$('.no').on('click', function(){
			$.magnificPopup.close();
		});
		$(document).on('change','#file',function (e) {
			var file= $(this).val();
			var exts = ['jpg','png','jpeg','jfif','tiff','tif'];
		      if ( file ) {
		        var get_ext = file.split('.');
		        get_ext = get_ext.reverse();
		        if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
		          $('#customfileupload').html($(this).val());
		        } else if(get_ext[0].toLowerCase()=="gif"){
		          alert('gifs are not supported...');
		          $(this).val('');
		        }else{
		        	alert("please choose a picture.");
		        	$(this).val('');
		        }
			}
		});
	</script>
</div>