jQuery('.post_format-post-format-image').each(function(){
	var id = jQuery(this).attr('id');
	var caption = jQuery(this).find('figcaption').html();
	jQuery(this).find('.wp-block-image > a').attr( 'data-lightbox', id ).attr('data-title', caption);
});
