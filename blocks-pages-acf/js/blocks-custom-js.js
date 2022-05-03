jQuery(document).ready(function(){

	jQuery('.slug').click(function(){
		jQuery(this).find('.pages').toggleClass('open');
		jQuery(this).toggleClass('active');
		jQuery('.pages').removeClass('closed');
	})

	jQuery('.close-all').click(function(){
		jQuery('.pages').addClass('closed');
		jQuery('.pages').removeClass('open');
		jQuery('.slug').removeClass('active');
	})
})