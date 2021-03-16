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

?><article class="preview-item">

	<a href="<?=get_the_permalink( $post->ID )?>">

		<div class="preview-thumb-container">

			<?php if ( !empty($image_id) ) { ?>
			<div class="preview-thumb" style="background-image: url(<?=$image_url?>);"></div>
			<?php } else { ?>
			<div class="preview-thumb-placeholder"><span><i class="fas fa-sticky-note"></i></span></div>
			<?php } ?>

		</div>

		<div class="preview-caption">
			<div class="preview-caption-inner">

				<h2 class="preview-title"><?=get_the_title( $post->ID )?></h2>

				<div class="preview-meta">
					
					<!-- TAGS -->
					<?php get_template_part( 'meta', 'tags', [ 'post' => $post, 'link' => false ]  ); ?>
				
					<!-- DATE -->
					<time class="preview-date" pubdate><?php the_time( get_option( 'date_format' ) ); ?></time>

				</div>

				<div class="preview-excerpt"><?=get_the_excerpt($post->ID)?></div>

			</div>
		</div>

	</a>

</article>