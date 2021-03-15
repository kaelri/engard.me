<section class="entry-meta">

	<!-- DATE -->
	<time class="entry-date" pubdate><?php the_time( get_option( 'date_format' ) ); ?></time>

	<!-- TAGS -->
	<?php if ( has_tag() ) { ?><span class="entry-tags"><?php the_tags(); ?></span><?php } ?>

</section>
