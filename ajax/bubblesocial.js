$(document).on('click',"#socialbubble.notclick", function() {
	var fn='';
	$.get("http://localhost/YUGIV/xml/friend_request_check.php",function(data){
				if(data != "true"){
				  	fn="hide";
				}
			});
    $( "#socialbubble" ).animate({
    	opacity: 0.25
	}, 100);
	$( "#socialbubble" ).animate({
    	opacity: 1
	}, 100, function() {
    	$( "body" ).append( "<div id='firstsocialbubble' class='socialbubble' style='opacity:0;'><img src='http://localhost/YUGIV/icons/people.png' class='socialbubbleicon'/><img src='http://localhost/YUGIV/icons/notification.png' class='notification "+fn+"'/></div>" );
    	$( "body" ).append( "<div id='secondsocialbubble' class='socialbubble' style='opacity:0;'><img src='http://localhost/YUGIV/icons/group.png' class='socialbubbleicon'/></div>" );
    	$( "body" ).append( "<div id='thirdsocialbubble' class='socialbubble' style='opacity:0;'><img src='http://localhost/YUGIV/icons/page.png' class='socialbubbleicon'/></div>" );
    	$( "body" ).append( "<div id='tipsysocialfirst' style='opacity:0;'>people</div>");
    	$( "body" ).append( "<div id='tipsysocialsecond' style='opacity:0;'>groups</div>");
    	$( "body" ).append( "<div id='tipsysocialthird' style='opacity:0;'>pages</div>");
    	$( "#firstsocialbubble" ).animate({
    		opacity: 1
		}, 100, function(){
			$( "#secondsocialbubble" ).animate({
		    	opacity: 1
			}, 100, function(){
				$( "#thirdsocialbubble" ).animate({
		    		opacity: 1
				}, 100);
			});
		});
  });
  $(this).removeClass("notclick").addClass("isclick").addClass("cooling").delay(100).queue(function(){
    $(this).removeClass("cooling").dequeue();
});
});
function closesocialbubble(){
	$( "#socialbubble" ).animate({
    	opacity: 0.25
	}, 100);
	$( "#socialbubble" ).animate({
    	opacity: 1
	}, 100, function() {
		$("#thirdsocialbubble").animate({
			opacity: 0
		}, 100, function(){
			$( "#secondsocialbubble" ).animate({
	    		opacity: 0
			}, 100, function(){
				$( "#firstsocialbubble" ).animate({
		    		opacity: 0
				}, 100,function(){
					$( "#thirdsocialbubble" ).remove();
					$( "#secondsocialbubble" ).remove();
	  				$( "#firstsocialbubble" ).remove();
				});
		});
		});
	});
}
$(document).click(function() {
    if($("#socialbubble.isclick").length !=0 && $("#socialbubble.isclick.cooling").length == 0){
    	closesocialbubble();
		$("#socialbubble.isclick").removeClass("isclick").addClass("notclick");
    }
});
$(document).on('click', '#firstsocialbubble', function(){
		$.get("http://localhost/YUGIV/social_bubble_html/people.html",function(data){
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
						$( "#peoplebox" ).remove();
					}
  				}
			});
		});
	closesocialbubble();
	$("#socialbubble").removeClass("isclick").addClass("notclick");
});
$(document).on('mouseenter', '#firstsocialbubble', function(){
	$("#tipsysocialfirst").animate({
		    		opacity: 1
				}, 200,function(){
				});
});
$(document).on('mouseleave', '#firstsocialbubble', function(){
	$("#tipsysocialfirst").animate({
		    		opacity: 0
				}, 50,function(){
				});
});
$(document).on('click', '#lightboxclose', function(){
	$.magnificPopup.close();
	$( "#peoplebox" ).remove();
});
$(document).on('mouseenter', '#secondsocialbubble', function(){
	$("#tipsysocialsecond").animate({
		    		opacity: 1
				}, 200,function(){
				});
});
$(document).on('mouseleave', '#secondsocialbubble', function(){
	$("#tipsysocialsecond").animate({
		    		opacity: 0
				}, 50,function(){
				});
});
$(document).on('mouseenter', '#thirdsocialbubble', function(){
	$("#tipsysocialthird").animate({
		    		opacity: 1
				}, 200,function(){
				});
});
$(document).on('mouseleave', '#thirdsocialbubble', function(){
	$("#tipsysocialthird").animate({
		    		opacity: 0
				}, 50,function(){
				});
});