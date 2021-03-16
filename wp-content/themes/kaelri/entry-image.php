<?php

$image_id  = get_post_thumbnail_id();
if ( empty($image_id) ) return;

$large     = wp_get_attachment_image_src( $image_id, 'large' );
$large_url = $large[0];

$full     = wp_get_attachment_image_src( $image_id, 'full' );
$full_url = $full[0];

?>

<figure class="entry-image">
	<a href="<?=$full_url?>" data-lightbox="post-<?=$image_id?>">
		<img loading="lazy" src="<?=$large_url?>" alt="Featured image" class="wp-image-<?=$image_id?>">
	</a>
</figure>
