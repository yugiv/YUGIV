$(document).on('click', '.sup', function(){
	var y =$(".sdown").attr('src');
	var x=$(this).attr('src');
	var name= $(this).attr('name');
	var d = name.substring(0, name.length - 2)+"sd";
	var d2= $(".sdown[name="+d+"] img");
	var currentclassname= $(".sup[name="+name+"] img");
	var currentclasscolor= currentclassname.attr('src');
	var dc= d+"c";
	var uc= name+"c";
	$.post('http://localhost/YUGIV/xml/commentupvote.php', {name: name}, function(data){
		if(data=="upvote"){
			currentclassname.attr('src',"http://localhost/YUGIV/icons/greenuparrow.png");
			if (d2.attr('src')=="http://localhost/YUGIV/icons/reddownarrow.png") {
				d2.attr('src',"http://localhost/YUGIV/icons/greydownarrow.png");
			}
		}else{
			currentclassname.attr('src',"http://localhost/YUGIV/icons/greyuparrow.png");
		}
		$.post('http://localhost/YUGIV/xml/commentupcount.php',{name: name}, function(ddata){
		$(".supcount[name="+uc+"]").text(ddata);	
	});
	$.post('http://localhost/YUGIV/xml/commentdowncount.php', {name: name}, function(dddata){
		$(".sdowncount[name="+dc+"]").text(dddata);
	});
	});
});

$(document).on('click', '.sdown', function(){
	var y =$(".sup").attr('src');
	var x=$(this).attr('src');
	var name= $(this).attr('name');
	var u = name.substring(0, name.length - 2)+"su";
	var u2 = $(".sup[name="+u+"] img");
	var currentclassname= $(".sdown[name="+name+"] img");
	var currentclasscolor= currentclassname.attr('src');
	var uc= u+"c";
	var dc= name+"c";
	$.post('http://localhost/YUGIV/xml/commentdownvote.php', {name: name}, function(data){
		if(data=="downvote"){
			currentclassname.attr('src',"http://localhost/YUGIV/icons/reddownarrow.png");
			if (u2.attr('src')=="http://localhost/YUGIV/icons/greenuparrow.png") {
				u2.attr('src',"http://localhost/YUGIV/icons/greyuparrow.png");
			}
		}else{
			currentclassname.attr('src',"http://localhost/YUGIV/icons/greydownarrow.png");
		}
		$.post('http://localhost/YUGIV/xml/commentdowncount.php', {name: name}, function(dddata){
		var sdc= $(".sdowncount[name='"+dc+"']").text(dddata);
		});
	$.post('http://localhost/YUGIV/xml/commentupcount.php',{name: name}, function(ddata){
		var sup= $(".supcount[name="+uc+"]").text(ddata);
	});
	});
	});
