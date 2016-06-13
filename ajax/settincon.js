function closesettcontain(){
	$(".settcontain.isclick").removeAttr('original-title');
	$(".settcontain.isclick").removeAttr('title');
	$(".settcontain.isclick").tipsy({trigger: 'manual'});
	$(".settcontain.isclick img").rotate({animateTo:-720, duration:300});
    $(".settcontain.isclick").tipsy("hide");
}
$(document).on('click', '.settcontain.notclick', function(){
	var name = $(this).attr('name');
	$.post('http://localhost/YUGIV/xml/poptions.php',{name: name}, function(data) {
		$(".settcontain[name='"+name+"']").attr('title',data);
	});
	$(".settcontain[name='"+name+"']").tipsy({trigger: 'manual'});
	$(".settcontain[name='"+name+"'] img").rotate({animateTo:720, duration:300});
	setTimeout( function(){ 
    $(".settcontain[name='"+name+"']").tipsy("show");
  	}  , 300 );
	$(this).removeClass("notclick").addClass("isclick").addClass("cooling").delay(50).queue(function(){
    $(this).removeClass("cooling").dequeue();
});
});

$(document).on('click',function() {
    if($(".settcontain.isclick").length !=0 && $(".settcontain.isclick.cooling").length == 0){
    	closesettcontain();
		$(".settcontain.isclick").removeClass("isclick").addClass("notclick");
    }
});
$(document).on('click','.bubble li.edit', function(){
	var name = $(this).attr('name');
	var content= $("table[name='"+name.replace(/\D/g,'')+"'] .content").html().replace(/\<br>/g,'\n');
	var title= $("table[name='"+name.replace(/\D/g,'')+"'] .ptitle").html();
	closesettcontain();
	$.post('http://localhost/YUGIV/xml/edit.php',{name: name,title: title}, function(data){
		alert(data);
		if(data.indexOf("post") > -1){
			var linker= data.slice(0, -4);
			alert(linker);
			$.post('http://localhost/YUGIV/xml/edit_post.php',{type: linker}, function(ddata){
				if(data!=""){
					$.post(ddata,{title:title,name: name,content:content}, function(dddata){
						if(dddata!=""){
						$("#post").remove();
						$('body').append(dddata);
						}
					});
				}else{
					alert(ddata);
				}
			});
		}else if(data.indexOf("comment") > -1){
			$("table[name='"+name+"'] .content").replaceWith("<div name='"+name+"' class='cedit'><textarea name='"+name+"' class='cwriter'>"+content+"</textarea><br/><button name='"+name+"' class='button update'>update</button><button name='"+name+"' class='button cancel'>cancel</button></div>");
		}else{
			alert(data);
		}
	});
});
$(document).on('click','.commentsblock table .update', function(){
	var cname =$(this).attr('name');
	var content= $(".cwriter[name='"+cname+"']").val().replace(/\r\n|\r|\n/g,"<br />");
	$.post('http://localhost/YUGIV/xml/commentupdate.php',{post:content, name: cname}, function(data){
		$(".cedit[name='"+cname+"']").replaceWith("<article class='content' name='"+cname+"'>"+data+"</article>");
	});
});
$(document).on('click','.bubble li.delete', function(){
	var name = $(this).attr('name');
	var toDel = $("table[name='"+name+"']");
	closesettcontain();
	$.post('http://localhost/YUGIV/xml/deleter.php',{name: name}, function(data){
		if(data=="post"){
			toDel.remove();
		}else if(data=="comment"){
			p = name.split("-");
			toDel.remove();
			if($(".commentsblock[name='"+p[0]+"']").text()=="anonymity?post"){
				$(".commentsblock[name='"+p[0]+"']").append("<p>no comments.</p>");
			}
		}else{
			alert('fuck you hacker!');
		}
	});
});
