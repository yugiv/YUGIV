$(".up").on('click', function(){
	var y =$(".down").attr('src');
	var x=$(this).attr('src');
	var name= $(this).attr('name');
	var d = name.substring(0, name.length - 1)+"d";
	var d2= $(".down[name="+d+"] img");
	var currentclassname= $(".up[name="+name+"] img");
	var currentclasscolor= currentclassname.attr('src');
	var dc= d+"c";
	var uc= name+"c";
	$.post('http://localhost/YUGIV/xml/postupvote.php', {name: name}, function(data){
		if(data=="upvote"){
			currentclassname.attr('src',"http://localhost/YUGIV/icons/greenuparrow.png");
			if (d2.attr('src')=="http://localhost/YUGIV/icons/reddownarrow.png") {
				d2.attr('src',"http://localhost/YUGIV/icons/greydownarrow.png");
			}
		}else{
			currentclassname.attr('src',"http://localhost/YUGIV/icons/greyuparrow.png");
		}
		$.post('http://localhost/YUGIV/xml/postupcount.php',{name: name}, function(ddata){
		$(".upcount[name="+uc+"]").html(ddata);	
	});
	$.post('http://localhost/YUGIV/xml/postdowncount.php', {name: name}, function(ddata){
		$(".downcount[name="+dc+"]").html(ddata);
	});
	});
	});
$(".down").on('click', function(){
	var y =$(".up").attr('src');
	var x=$(this).attr('src');
	var name= $(this).attr('name');
	var u = name.substring(0, name.length - 1)+"u";
	var u2 = $(".up[name="+u+"] img");
	var currentclassname= $(".down[name="+name+"] img");
	var currentclasscolor= currentclassname.attr('src');
	var uc= u+"c";
	var dc= name+"c";
	$.post('http://localhost/YUGIV/xml/postdownvote.php', {name: name}, function(data){
		if(data=="downvote"){
			currentclassname.attr('src',"http://localhost/YUGIV/icons/reddownarrow.png");
			if (u2.attr('src')=="http://localhost/YUGIV/icons/greenuparrow.png") {
				u2.attr('src',"http://localhost/YUGIV/icons/greyuparrow.png");
			}
		}else{
			currentclassname.attr('src',"http://localhost/YUGIV/icons/greydownarrow.png");
		}
		$.post('http://localhost/YUGIV/xml/postdowncount.php', {name: name}, function(ddata){
		$(".downcount[name="+dc+"]").html(ddata);
	});
	$.post('http://localhost/YUGIV/xml/postupcount.php',{name: name}, function(ddata){
		$(".upcount[name="+uc+"]").html(ddata);	
	});
	});
});
$(document).on('click', '.commentcontainer.notclick', function() {
	var name= $(this).attr('name');
	var fname= name.substring(0, name.length - 1);
	var s=name.substring(0, name.length - 1)+"s";
	$(this).removeClass("notclick").addClass("isclick");
	$(".speech[name="+s+"] img").attr('src','http://localhost/YUGIV/icons/bluespeech.png');
	$(".postbox[name='"+fname+"']").append("<tr class='containcbox' name='"+fname+"'><td class='commentsblock' name='"+fname+"'></td></tr>");
	var writebar = "<textarea class='cwriter' placeholder='comment here' name='"+fname+"'></textarea><br/><label><input type='checkbox' name='"+fname+"' class='anonymous' value='anonymous'/>anonymity?</label><button class='ccomment button' name='"+fname+"'>post</button><br>";
	$(".commentsblock[name='"+fname+"']").append(writebar);
	$(".commentsblock[name='"+fname+"']").append("<img class='loading' src='http://localhost/YUGIV/images/ajax-loader.gif'/>");
	$.post('http://localhost/YUGIV/xml/commentsload.php',{name: fname}, function(data) {
		if(data!=""){
		$(".commentsblock[name='"+fname+"'] .loading").remove();
		$(".commentsblock[name='"+fname+"']").append(data);
		}else{
		$(".commentsblock[name='"+fname+"'] .loading").remove();
		$(".commentsblock[name='"+fname+"']").append("<p>no comments.</p>");	
		}
	});
});
$(document).on('click', '.commentcontainer.isclick', function(){
	var name= $(this).attr('name');
	var fname= name.substring(0, name.length - 1);
	var s=name.substring(0, name.length - 1)+"s";
	$(this).removeClass("isclick").addClass("notclick");
	$(".speech[name="+s+"] img").attr('src','http://localhost/YUGIV/icons/greyspeech.png');
	$(".containcbox[name='"+fname+"']").remove();
});
$(document).on('click', '.ccomment', function(){
	var name= $(this).attr('name');
	var writebar = "<textarea class='cwriter' placeholder='comment here' name='"+name+"'></textarea><br/><label><input type='checkbox' name='"+name+"' class='anonymous' value='anonymous'/>anonymity?</label><button class='ccomment button' name='"+name+"'>post</button><br>";
	var content= $(".cwriter[name='"+name+"']").val().replace(/\r\n|\r|\n/g,"<br />");
	var afterr = $(".ccomment[name='"+name+"']");
	var anonymous= $(".anonymous[name='"+name+"']:checked").val();
	$(".commentsblock[name='"+name+"'] .commentbox").remove();
	$(".commentsblock[name='"+name+"'] p").remove();
	$(".commentsblock[name='"+name+"']").append("<img class='loading' src='http://localhost/YUGIV/icons/ajax-loader.gif'/>");
	$.post('http://localhost/YUGIV/xml/commentwrite.php',{ name: name,content: content, anonymous: anonymous }, function(data){
		if(data != ""){
			$(".commentsblock[name='"+name+"'] .loading").remove();
			$(".cwriter[name='"+name+"']").val("");
			$(".commentsblock[name='"+name+"']").append(data);
		}else{
			$(".commentsblock[name='"+name+"'] .loading").remove();
			$(".commentsblock[name='"+name+"']").append("error");
		}
	});
});
$.fn.tipsy.defaults = {
    delayIn: 0,      // delay before showing tooltip (ms)
    delayOut: 0,     // delay before hiding tooltip (ms)
    fade: false,     // fade tooltips in/out?
    fallback: '',    // fallback text to use when no tooltip text
    gravity: 'n',    // gravity
    html: true,     // is tooltip content HTML?
    live: false,     // use live event support?
    offset: 0,       // pixel offset of tooltip from element
    opacity: 1,    // opacity of tooltip
    title: 'title',  // attribute/callback containing tooltip text
    trigger: 'hover' // how tooltip is triggered - hover | focus | manual
};

