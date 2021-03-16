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

	<?php if ( get_post_format() == 'image' ) { ?>
	<header class="entry-header-min">
		<a href="<?=get_the_permalink()?>"><time class="entry-date" pubdate><?php the_time( get_option( 'date_format' ) ); ?></time></a>
	</header>
	<?php } ?>

	<!-- BODY -->
	<section class="entry-content">
		<?php the_content(); ?>
	</section>

</article>