<?php get_header(); ?>

<main class="main">

	<?php if ( is_search() ) { ?>
	<header class="archive-header">

		<h1 class="archive-title"><i class="fas fa-search"></i>&nbsp;“<?=get_search_query()?>”</h1>

	</header>
	<?php } ?>

	<section class="archive">
	<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>

		<!-- ENTRY -->
		<?php get_template_part( 'entry', get_post_type() ); ?>

	<?php }} else { ?>

		<p>No results.</p>

	<?php } ?>
	</section>

	<!-- PAGINATION -->
	<?php global $wp_query; if ( $wp_query->max_num_pages > 1 ) { ?>
	<nav class="archive-nav">

		<div class="archive-nav-previous"><?php next_posts_link(sprintf( '%s older', '<span class="meta-nav">&larr;</span>' ) ) ?></div>
		
		<div class="archive-nav-next"><?php previous_posts_link(sprintf( 'newer %s', '<span class="meta-nav">&rarr;</span>' ) ) ?></div>

	</nav>
	<?php } ?>

</main>

<?php get_footer();
