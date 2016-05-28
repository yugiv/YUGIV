$(".friendstuff").on("click", function () {
	var url = window.location.href;
	var username = url.split("profiles/");
	username= username[1].split("/");
	username= username[0];
	$.post('http://localhost/YUGIV/xml/friendbuttondetecter.php',{username:username},function(ddata){
		if(ddata!=""){
		$.get(ddata, function(data){
			$( "body" ).append(data);
			$.magnificPopup.open({
  				items: {
			    src: $(data),
			    type: 'inline'
				},
				closeOnBgClick: false,
				closeBtnInside: false,
				callbacks: {
					afterClose: function() {
						$( "#alert" ).remove();
						$.post('http://localhost/YUGIV/xml/follow_status.php',{username: username},function(data){
							if(data=="following" || data=="follow?"){
							$('.followstuff').text(data);
							}else{
							alert(data);
							}
						});
					}
  				}
			});
		});
		}else{
			alert("fak u dolan");
		}	
	});
});
$('.followstuff').on('click', function () {
	var url = window.location.href;
	var username = url.split("profiles/");
	username= username[1].split("/");
	username= username[0];
		$.post('http://localhost/YUGIV/xml/change_follow.php',{username: username},function(data){
			if(data=="following" || data=="follow?"){
			$('.followstuff').text(data);
			}else{
			alert(data);
			}
		});
});
$('.plist').on('click',function(){
	window.location=$(this).find("a").attr("href");
	return false;
});
$('#profile_edit').on('click', function(){
	var url = window.location.href;
	var username = url.split("profiles/");
	username= username[1].split("/");
	username= username[0];
	$.get('http://localhost/YUGIV/profile_htm/profilepicture.php', function(data){
			$( "body" ).append(data);
			$.magnificPopup.open({
  				items: {
			    src: $(data),
			    type: 'inline'
				},
				closeOnBgClick: false,
				closeBtnInside: false,
				callbacks: {
					afterClose: function() {
						$( "#alert" ).remove();
					}
  				}
			});
		});
});
