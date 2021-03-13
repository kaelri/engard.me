<?php get_header(); ?>

<main class="main">

	<section class="archive">
	<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>

		<!-- ENTRY -->
		<?php get_template_part( 'entry', get_post_type() ); ?>

	<?php }} ?>
	</section>

</main>

<?php get_footer();
