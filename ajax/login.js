$(document).on("click","#log",function() {
	var username=$('.log[name="username"]').val();
	var password=$('.log[name="password"]').val();
	$.post('loger.php', {username: username, password: password}, function(data){
		alert(data);
		if(data=="done"){
			window.location=window.location.href;
		}else{
				alert("username or password may be wrong!");
		}
	});
});
$(document).on("keydown",".log", function(e){
	var code =e.which;
	if(code == 13) {
		var username=$('.log[name="username"]').val();
		var password=$('.log[name="password"]').val();
		$.post('loger.php', {username: username, password: password}, function(data){
			if(data=="done"){
				window.location=window.location.href;
			}else{
				alert("username or password may be wrong!");
			}
		});
	}
});
