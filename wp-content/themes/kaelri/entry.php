<?php

// PARAMETERS
$args = wp_parse_args( $args, [
	'post' => get_post()
]);

$post = $args['post'];

?><article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

	<!-- HEADER -->
	<header class="entry-header">

		<!-- TITLE -->
		<?php if ( !in_array( get_post_format( $post->ID ), [ 'image', 'quote' ] ) ) { ?>
		<h1 class="entry-title"><a href="<?=get_the_permalink( $post->ID )?>"><?=get_the_title( $post->ID )?></a></h1>
		<?php } ?>

		<!-- META -->
		<section class="entry-meta">
			
			<?php switch ( get_post_type( $post->ID ) ) {
				case 'post':
					?>

					<!-- DATE -->
					<time class="entry-date" pubdate><a href="<?=get_the_permalink( $post->ID )?>"><?php the_time( get_option( 'date_format' ) ); ?></a></time>

					<?php
				case 'page':
				case 'project':
					?>

					<!-- SUBTITLE -->
					<span class="entry-subtitle"><?=get_field( 'post_subtitle', $post->ID )?></span>

					<?php
				default:
			} ?>

			<!-- TAGS -->
			<?php get_template_part( 'meta', 'tags', [ 'post' => $post ] ); ?>

		</section>
		
	</header>

	<!-- BODY -->
	<section class="entry-content">

		<?php the_content(); ?>
		
	</section>

</article>
