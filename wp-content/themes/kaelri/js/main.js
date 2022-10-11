document.addEventListener('DOMContentLoaded', () => {

	document.querySelectorAll('.post_format-post-format-image, .type-project').forEach( (post) => {

		const lightboxID = post.id;

		post.querySelectorAll('.wp-block-image').forEach( (postImage) => {

			const postCaption     = postImage.querySelector('figcaption');
			const lightboxCaption = postCaption ? postCaption.innerHTML : '';

			const link = postImage.querySelector('img').closest('a');
			link.setAttribute( 'data-fslightbox', lightboxID      );
			link.setAttribute( 'data-caption',    lightboxCaption );
	
		});

	});

	refreshFsLightbox();

});
