<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

	<!-- HEADER -->
	<header class="entry-header">

		<!-- TITLE -->
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<!-- META -->
		<section class="entry-meta">

			<!-- DATE -->
			<time class="entry-date" pubdate><?php the_time( get_option( 'date_format' ) ); ?></time>

			<!-- TAGS -->
			<?php if ( has_tag() ) { ?><span class="entry-tags"><?php the_tags(); ?></span><?php } ?>

		</section>

	</header>

	<!-- BODY -->
	<section class="entry-content">
		<?php the_content(); ?>
	</section>

</article>
