$(document).on('click',"#toolbubble.notclick", function() {
	$.ajax({
            type: 'GET',
            url: 'http://localhost/YUGIV/xml/toolbubble.php',
            dataType: 'json',
            cache: false,
            success: function(data) {
               $( "#toolbubble" ).animate({
			    	opacity: 0.25
				}, 100);
				$( "#toolbubble" ).animate({
			    	opacity: 1
				}, 100, function() {
			    	$( "body" ).append( "<div id='firsttoolbubble' style='opacity:0;'><img src='"+data[0][1]+"' class='toolbubbleicon'/></div>" );
			    	$( "body" ).append( "<div id='secondtoolbubble' style='opacity:0;'><img src='"+data[1][1]+"' class='toolbubbleicon'/></div>" );
			    	$( "body" ).append( "<div id='thirdtoolbubble' style='opacity:0;'><img src='"+data[2][1]+"' class='toolbubbleicon'/></div>" );
			    	$( "body" ).append( "<div id='tipsytoolfirst' style='opacity:0;'>"+data[0][0]+"</div>");
			    	$( "body" ).append( "<div id='tipsytoolsecond' style='opacity:0;'>"+data[1][0]+"</div>");
			    	$( "body" ).append( "<div id='tipsytoolthird' style='opacity:0;'>"+data[2][0]+"</div>");
			    	$( "#firsttoolbubble" ).animate({
			    		opacity: 1
					}, 50, function(){
						$( "#secondtoolbubble" ).animate({
					    	opacity: 1
						}, 50, function(){
							$( "#thirdtoolbubble" ).animate({
					    		opacity: 1
							}, 50);
						});
					});
					$(this).removeClass("notclick").addClass("isclick").addClass("cooling").delay(50).queue(function(){
					    $(this).removeClass("cooling").dequeue();
					});
			  });
			  
			},
			});
});
function closetoolbubble(){
	$( "#toolbubble" ).animate({
    	opacity: 0.25
	}, 100);
	$( "#toolbubble" ).animate({
    	opacity: 1
	}, 100, function() {
		$("#thirdtoolbubble").animate({
			opacity: 0
		}, 50, function(){
			$( "#secondtoolbubble" ).animate({
	    		opacity: 0
			}, 50, function(){
				$( "#firsttoolbubble" ).animate({
		    		opacity: 0
				}, 50,function(){
					$( "#thirdtoolbubble" ).remove();
					$( "#secondtoolbubble" ).remove();
	  				$( "#firsttoolbubble" ).remove();
	  				$("#tipsytoolfirst").remove();
	  				$("#tipsytoolsecond").remove();
	  				$("#tipsytoolthird").remove();
				});
		});
		});
	});
}
$(document).click(function() {
    if($("#toolbubble.isclick").length !=0 && $("#toolbubble.isclick.cooling").length == 0){
    	closetoolbubble();
		$("#toolbubble.isclick").removeClass("isclick").addClass("notclick");
    }
});
function classCheckTool () {
	if($("#post").hasClass("small")){
		return "small";
	}else if($("#post").hasClass("medium")){
		return "medium";
	}else{
		return "big";
	}
}
$(document).on('click', '#firsttoolbubble', function(){
	$.get("http://localhost/YUGIV/tool_bubble_html/regular_post.html",function(data){
		var name = "regular_post";
		if($("#post").html()!= undefined){
			if($("#post").hasClass(name)){
				$("#post").remove();
			}else{
				$("#post").remove();
				$( "body" ).append(data);
			}
		}else{
			$( "body" ).append(data);
		}
	});
	closetoolbubble();
	$("#toolbubble").removeClass("isclick").addClass("notclick");
});
$(document).on('mouseenter', '#firsttoolbubble', function(){
	$("#tipsytoolfirst").animate({
		    		opacity: 1
				}, 200,function(){
				});
});
$(document).on('mouseleave', '#firsttoolbubble', function(){
	$("#tipsytoolfirst").animate({
		    		opacity: 0
				}, 50,function(){
				});
});
$(document).on('click', '#secondtoolbubble', function(){
	$.get("/YUGIV/tool_bubble_html/blog_post.html",function(data){
		var name = "blog_post";
		if($("#post").html()!= undefined){
			if($("#post").hasClass(name)){
				$("#post").remove();
			}else{
				$("#post").remove();
				$( "body" ).append(data);
			}
		}else{
			$( "body" ).append(data);
		}
	});
	closetoolbubble();
	$("#toolbubble").removeClass("isclick").addClass("notclick");
});
$(document).on('mouseenter', '#secondtoolbubble', function(){
	$("#tipsytoolsecond").animate({
		    		opacity: 1
				}, 200,function(){
				});
});
$(document).on('mouseleave', '#secondtoolbubble', function(){
	$("#tipsytoolsecond").animate({
		    		opacity: 0
				}, 50,function(){
				});
});
$(document).on('click', '#thirdtoolbubble', function(){
	$.get("/YUGIV/tool_bubble_html/video_post.html",function(data){
		var name = "video_post";
		if($("#post").html()!= undefined){
			if($("#post").hasClass(name)){
				$("#post").remove();
			}else{
				$("#post").remove();
				$( "body" ).append(data);
			}
		}else{
			$( "body" ).append(data);
		}
	});
	closetoolbubble();
	$("#toolbubble").removeClass("isclick").addClass("notclick");
});
$(document).on('mouseenter', '#thirdtoolbubble', function(){
	$("#tipsytoolthird").animate({
		    		opacity: 1
				}, 200,function(){
				});
});
$(document).on('mouseleave', '#thirdtoolbubble', function(){
	$("#tipsytoolthird").animate({
		    		opacity: 0
				}, 50,function(){
				});
});