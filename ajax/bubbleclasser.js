function getmeth (type,change) {
	var finalurl=window.location.href;
	if(window.location.href.slice(-1)!="/" && window.location.href.slice(-1)!="]" && window.location.href.slice(-1)!="@"){
		finalurl+="/";
	}
	var f= window.location.href.indexOf("[!"+type);
	var s = window.location.href.indexOf("]",f);
	var tochange=window.location.href.substring(f, s+1);
	if(change==undefined || change==""){
		finalurl= finalurl.replace(tochange,'');
		return finalurl;
	}
	var change= change.slice(0,-1);
	var gettype= "[!"+type+"!"+change+"]";
	if(window.location.href.indexOf(type)!=-1){
		finalurl=finalurl.replace(tochange,"");
		arr=gettype.split("!");
		arr[2]= change;
		changed="";
		var i =0;
		while (i<=2) {
			if(i!=2){
		    changed+=arr[i]+"!";
		   	}else{
		   	changed+=arr[i]+"]";
		   	}
		    i++;
		}
		return finalurl+changed;
	}else{
		 return finalurl+gettype;
	}
}
$(document).on('click',"#classerbubble.notclick", function() {
    $( "#classerbubble" ).animate({
    	opacity: 0.25
	}, 100);
	$( "#classerbubble" ).animate({
    	opacity: 1
	}, 100, function() {
    	$( "body" ).append( "<div id='firstclasserbubble' style='opacity:0;height:0px;width:0px;top:115px;'><img src='http://localhost/YUGIV/icons/main.png' class='classerbubbleicon'/></div>" );
    	$( "body" ).append( "<div id='secondclasserbubble' style='opacity:0;height:0px;width:0px;top:335px;'>not comming soon</div>" );
    	$( "#firstclasserbubble" ).animate({
    		opacity: 1,
    		height: '60px',
    		width:'60px',
    		top:'165px'
		}, 100, function(){
		});
		$( "#secondclasserbubble" ).animate({
		    	opacity: 1,
		    	height: '60px',
		    	width:'60px',
		    	top:'245px'
			}, 100, function(){
		});
  });
  $(this).removeClass("notclick").addClass("isclick").addClass("cooling").delay(100).queue(function(){
    $(this).removeClass("cooling").dequeue();
});
});
function closeclasserbubble(){
	$( "#classerbubble" ).animate({
    	opacity: 0.25
	}, 100);
	$( "#classerbubble" ).animate({
    	opacity: 1
	}, 100, function(){
			$( "#secondclasserbubble" ).animate({
	    		opacity: 0,
	    		height: '0px',
	    		width:'0px'
			}, 100, function(){
				$( "#secondclasserbubble" ).remove();
			});
			$( "#firstclasserbubble" ).animate({
		    	opacity: 0,
		    	height: '0px',
		    	width:'0px'
			}, 100,function(){
	  				$( "#firstclasserbubble" ).remove();
			});
		});
}
$(document).click(function() {
    if($("#classerbubble.isclick").length !=0 && $("#classerbubble.isclick.cooling").length == 0){
    	closeclasserbubble();
		$("#classerbubble.isclick").removeClass("isclick").addClass("notclick");
    }
});
$(document).on('click', '#firstclasserbubble', function(){
	closeclasserbubble();
		$.post("http://localhost/YUGIV/classer_bubble_html/main.php",{url: window.location.href},function(data){
			$( "body" ).append(data);
			$.magnificPopup.open({
  				items: {
			    src: $(data),
			    type: 'inline'
				},
				closeBtnInside: false,
				callbacks: {
					
					afterClose: function() {
						$( "#classerbox" ).remove();
					}
  				}
			});
		});
	$("#classerbubble").removeClass("isclick").addClass("notclick");
});