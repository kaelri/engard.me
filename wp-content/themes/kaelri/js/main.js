jQuery('.post_format-post-format-image, .type-project').each(function(){

	var id = jQuery(this).attr('id');

	jQuery(this).find('.wp-block-image').each(function(){

		var caption = jQuery(this).find('figcaption').html();

		jQuery(this).find('img').closest('a').attr( 'data-lightbox', id ).attr( 'data-title', caption );
		
	});

});
