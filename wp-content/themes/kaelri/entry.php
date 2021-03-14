<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

	<!-- HEADER -->
	<header class="entry-header">

		<!-- TITLE -->
		<h1 class="entry-title"><a href="<?=get_the_permalink()?>"><?php the_title(); ?></a></h1>

		<!-- META -->
		<section class="entry-meta">

		</section>

	</header>

	<!-- BODY -->
	<section class="entry-content">
		<?php the_content(); ?>
	</section>

</article>
