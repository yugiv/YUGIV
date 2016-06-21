<?php
require '../xml/mysql_classes.php';
require '../xml/functions.php';
if(isset($_POST['title'],$_POST['content'],$_POST['name'])){
	$pid=(int)$_POST['name'];
	$check= new posts();
	$check= $check->simpleSelect("post_id", (int)$_POST['name']);
	$aname="";
	if(empty($check['user_id']) && is_int($check['user_id'])){
		$ano= new anoInfo($pid);
		$ano= $ano->array;
		$aname="paname='".$ano['name']."'";
	}
?>
<div id="post" class="small regular_post" <?=$aname?>>
	<p>Entry Title: <input name="title" id="title" type="text" size="80" maxlength="80" /></p>
	<textarea class="writer" name="post" form="postform"></textarea>
	<select style="margin-left: 6px;" name="view_option" class="view">
		<option>global</option>
		<option>friends</option>
		<option>personal</option>
	</select>
	<label><input type="checkbox" class="anobox" name="anonymous" value="anonymous"/>anonymity?</label>
	<input type="button" value="update" name="<?=$pid?>" class="button" id="regularpost" /><input name="cancel" class="button" id="regularcancel" type="button" value="cancel"/>
<script>
	$(document).on('click', '#regularpost', function(){
		alert("hi");
		var post=$(".writer").val().replace(/\r\n|\r|\n/g,"<br />");
		var name = $("#regularpost").attr("name");
		var view_option= $(".view").val();
		var ano = $(".anobox").is(":checked");
		var title= $("#title").val();
		if(ano==true){
			alert("jjhsj");
			$.get("http://localhost/YUGIV/xml/anonymous.html",function(data){
				$( "body" ).append(data);
				$.magnificPopup.open({
	  				items: {
				    src: $(data),
				    type: 'inline'
					},
					closeBtnInside: false,
					callbacks: {
						
						afterClose: function() {
							$( "#anobox" ).remove();
							$.post('http://localhost/YUGIV/xml/anonymousedit.php',{pid: name, aname: $("#post").attr("aname")}, function(data){				$( "body" ).append(data);
								$.magnificPopup.open({
					  				items: {
								    src: $(data),
								    type: 'inline'
									},
									closeBtnInside: false,
									callbacks: {
										
										afterClose: function() {
				 							$.post('http://localhost/YUGIV/post_update.php', {title:title,name:name,post: post, paname,ppassword,caname,cpassword}, function(data){
												if(data!=""){
													$(".postbox[name='"+name+"'] .ptitle").html(title);
													$(".postbox[name='"+name+"'] .content").html(post);
													$("#post").remove();
												}else{
													alert("fuk u hacker!");
												}
					  						});
										}
									}
								});
							});
						}
	  				}
				});
			});
		}else{
			$.post('http://localhost/YUGIV/xml/anonymousedit.php',{pid: name, aname: $("#post").attr("aname")}, function(data){				$( "body" ).append(data);
				var paname= $("#post").attr("paname");
				var ppassword= $("#post").attr("papassword");
				$.magnificPopup.open({
	  				items: {
				    src: $(data),
				    type: 'inline'
					},
					closeBtnInside: false,
					callbacks: {
						
						afterClose: function() {
							alert("hide biatch");
							$.post('http://localhost/YUGIV/post_update.php', {title:title,name:name,post: post, paname: paname,ppassword:ppassword,caname:"",cpassword:""}, function(data){
								if(data!=""){
									$(".postbox[name='"+name+"'] .ptitle").html(title);
									$(".postbox[name='"+name+"'] .content").html(post);
									$("#post").remove();
								}else{
									alert("fuk u hacker!");
								}
	  						});
						}
					}
				});
			});
		}
	});
	$(document).on('click', '#regularcancel', function(){
		$("#post").remove();
	});
</script>
</div>
<?php
}
?>