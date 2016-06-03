<div id="anobox" pid="<?=$_POST['pid']?>">
	<label><input type="text" id="anonymousFirst"/></label><br />
	<label><input type="password" id="anonymousSecond"/></label><br />
	<button>submit</button>
	<script>
		$('#anobox button').on('click', function(){
			var name=$("#anonymousFirst").val();
			var password=$("#anonymousSecond").val();
			$("#post").attr('aname',name);
			$("#post").attr('apass',password);
			$.magnificPopup.close();
			$( "#anobox" ).remove();
		});
	</script>
</div>