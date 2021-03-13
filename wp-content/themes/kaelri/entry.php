<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

	<!-- HEADER -->
	<header class="entry-header">

		<!-- TITLE -->
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<!-- META -->
		<section class="entry-meta">

		</section>

	</header>

	<!-- BODY -->
	<section class="entry-content">
		<?php the_content(); ?>
	</section>

</article>
