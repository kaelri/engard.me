<?php

// PARAMETERS
$args = wp_parse_args( $args, [
	'post' => get_post()
]);

$post = $args['post'];

$image_id  = get_post_thumbnail_id( $post->ID );
if ( !empty($image_id) ) {
	$image     = wp_get_attachment_image_src( $image_id, 'medium' );
	$image_url = $image[0];
}

?><article id="post-<?php the_ID(); ?>" <?php post_class('preview'); ?>>

	<a href="<?=get_the_permalink( $post->ID )?>">

		<?php if ( !empty($image_id) ) { ?>
		<div class="preview-thumb-container">
			<div class="preview-thumb" style="background-image: url(<?=$image_url?>);"></div>
		</div>
		<?php } ?>

		<div class="preview-caption">
			<div class="preview-caption-inner">

				<h1 class="preview-title"><?=get_the_title( $post->ID )?></h1>

				<div class="preview-meta">
					
					<!-- TAGS -->
					<?php get_template_part( 'meta', 'tags', [ 'post' => $post, 'link' => false ]  ); ?>
				
					<!-- SUBTITLE -->
					<span class="preview-subtitle"><?=get_field( 'post_subtitle', $post->ID )?></span>

				</div>

				<div class="preview-excerpt"><?=get_the_excerpt($post->ID)?></div>

			</div>
		</div>

	</a>

</article>