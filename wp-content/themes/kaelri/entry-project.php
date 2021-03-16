<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

	<!-- HEADER -->
	<?php if ( get_post_format() != 'image' ) { ?>
	<header class="entry-header">

		<!-- TITLE -->
		<h1 class="entry-title"><a href="<?=get_the_permalink()?>"><?php the_title(); ?></a></h1>

		<!-- META -->
		<section class="entry-meta">

			<!-- SUBTITLE -->
			<span class="entry-subtitle"><?=get_field('post_subtitle')?></span>

			<!-- TAGS -->
			<?php get_template_part( 'meta', 'tags' ); ?>

		</section>
		
	</header>
	<?php } ?>

	<!-- BODY -->
	<section class="entry-content">

		<?php get_template_part( 'entry', 'image' ); ?>

		<?php get_template_part( 'project', 'links' ); ?>

		<?php the_content(); ?>

	</section>

</article>
