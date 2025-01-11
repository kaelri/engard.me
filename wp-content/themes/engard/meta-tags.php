<?php

namespace engard;

// PARAMETERS
$args = wp_parse_args( $args, [
	'post' => get_post(),
	'link' => true,
]);

$entry_post = $args['post'];
$link_tags  = $args['link'];

// GET TAGS
$tags = get_the_terms( $entry_post->ID, 'post_tag' );
if ( empty($tags) ) return;

?><span class="entry-tags">

	<?php if ( !empty($tags) ) { foreach ( $tags as $tag ) {
		
		$name = $tag->name;
		$url  = get_term_link( $tag );
		$icon = Core::get_tag_icon( $tag );
		
		if ( !$icon ) continue;
		
		?><span class="entry-tag <?=$tag->slug?>" title="<?=$name?>">
			<?php if ( $link_tags ) { ?><a href="<?=$url?>"><?php } ?>
				<span class="entry-tag-icon"><?=$icon?></span>
				<span class="entry-tag-title"><?=$name?></span>
			<?php if ( $link_tags ) { ?></a><?php } ?>
		</span><?php

	}} ?>

</span>
