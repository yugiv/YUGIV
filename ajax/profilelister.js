$(document).on('click','#profilecontainer', function(){
	if($("#mainlist.show").length !=0 && $("#mainlist.show.cooling").length == 0){
		$("#mainlist").removeClass("show").addClass("hide");
    }else{
	$("#mainlist").removeClass("hide");
	$("#mainlist").removeClass("hide").addClass("show").addClass("cooling").delay(50).queue(function(){
    	$("#mainlist").removeClass("cooling").dequeue();
	});
	}
});
$(document).click(function() {
    if($("#mainlist.show").length !=0 && $("#mainlist.show.cooling").length == 0){
		$("#mainlist").removeClass("show").addClass("hide");
    }
});