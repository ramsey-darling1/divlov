/*
 *Response wrap
 *@rdarling
 *
 */
$(document).ready(function(){
	$('#response_wrap').delay(8000).slideUp(800);
});


$(function(){
	
	$(".res_con .res_trig").click(function(){

		$(this).siblings('ul').slideToggle();
	
	});
	
		
});



/*
 *Loading
 *@rdarling
 *
 */

$(document).ready(function(){
	$("#upload_image_trigger").click(function(){
		$("#loading").addClass("loading");
		$("#upload_image_form").submit();	
	});
});



/*scroll down*/
$(window).scroll(function(){
	
	$("#back_to_top").fadeIn();
	
	$("#head_wrap").addClass("sticky");
	
	if ($(window).scrollTop() == 0){
		
		$("#back_to_top").fadeOut();
		
		$("#head_wrap").removeClass("sticky");
		
	}
	
});

/**
 *replacing image if it fails to load
 *
 */

$(function(){
	
	$("img").error(function(){
		
		var img_path = $(this).attr("src");
		
		img_path = img_path.replace('.jpg','.JPG');
		
		$(this).attr("src",img_path);
		
		$(this).error(function(){
		
			var img_path = $(this).attr("src");
		
			img_path = img_path.replace('.JPG','.jpeg');
		
			$(this).attr("src",img_path);
		
			return false;
		
		});
		
	});			

});