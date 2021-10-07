<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

	<!-- HEADER -->
	<header class="entry-header">

		<!-- TITLE -->
		<?php if ( !in_array( get_post_format(), [ 'image', 'quote' ] ) ) { ?>
		<h1 class="entry-title"><a href="<?=get_the_permalink()?>"><?php the_title(); ?></a></h1>
		<?php } ?>

		<!-- META -->
		<section class="entry-meta">

			<!-- DATE -->
			<time class="entry-date" pubdate><a href="<?=get_the_permalink()?>"><?php the_time( get_option( 'date_format' ) ); ?></a></time>

			<!-- TAGS -->
			<?php get_template_part( 'meta', 'tags' ); ?>

		</section>

	</header>

	<!-- BODY -->
	<section class="entry-content">
		<?php the_content(); ?>
	</section>

</article>
