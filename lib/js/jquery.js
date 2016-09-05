// JavaScript Document
$(document).ready(function() {
		$('.sqlconfirm').append('<div class="rightfloat sqlx" style="width:20px; height:20px; margin-right:20px;"><img src="lib/img/delete.png" style="width:20px; height:20px;" alt="delete from favorite"/></div>');	 
		$('.sqlerror').append('<div class="rightfloat sqlx" style="width:20px; height:20px;"><img src="lib/img/delete.png" style="width:20px; height:20px;" alt="delete from favorite"/></div>');	 
	  $('.sqlx').click(function(){
				$(this).parent().fadeOut('slow');
	  });
		$('input.clear').each(function() {
		$(this)
		  .data('default', $(this).val())
		  .addClass('inactive')
		  .focus(function() {
			$(this).removeClass('inactive');
			if($(this).val() === $(this).data('default') || $(this).val() === '') {
			  $(this).val('');
			}
		  })
		  .blur(function() {
			if($(this).val() === '') {
			  $(this).addClass('inactive').val($(this).data('default'));
			}
		  });
	  });
	  
	$("a.lightbox").fancybox({
			'hideOnContentClick': false,
			'showNavArrows' :false
	});
	
	  $('.favoritedelete').click(function(){
				$(this).parent().toggle('slow');
				jQuery.ajax({
					url: "deletefromfavorite.php",
					type: "POST",
					data: {"recipeid": jQuery(this).children('a')[0].href.split('#')[1]}
				})
					  
	});
	
		  $('.addslideshow').click(function(){
				$(this).attr('class', 'deleteslideshow');
				jQuery.ajax({
					url: "slideshowxml.php",
					type: "POST",
					data: {
						"recipeid": jQuery(this).children('a')[0].href.split('#')[1],
						"action": "add"
						}
				})
					  
	});


	  $('.deleteslideshow').click(function(){
				$(this).attr('class', 'addslideshow');
				jQuery.ajax({
					url: "slideshowxml.php",
					type: "POST",
					data: {
						"recipeid": jQuery(this).children('a')[0].href.split('#')[1],
						"action": "delete"
						}
				})
					  
	});
	
$('.deletebutton').click(function(e){
var ans = confirm('Are you sure you want to continue?');
if(!ans) {
e.preventDefault();
}
}); 
		
});