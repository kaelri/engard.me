<?php

namespace engard;

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<?php if ( is_attachment() ) { ?>
	<meta name="robots" content="noindex">
	<?php } ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div class="site-container">

		<div class="header-container">

			<header class="header">

				<div class="header-avatar">

					<img class="header-photo" src="<?=get_common_url('images/photo.png')?>" alt="Author photo">

					<h1 class="header-title"><a href="<?=esc_url( home_url( '/' ) )?>" title="<?=esc_attr( get_bloginfo( 'name' ))?>" rel="home"><?=esc_html( get_bloginfo( 'name' ) )?></a></h1>
					
				</div>

				<div class="header-description">
					<?php bloginfo( 'description' ); ?>
				</div>

				<nav class="header-contact">
					<?php wp_nav_menu([
						'theme_location' => 'contact',
						'walker'         => new contactMenu
					]); ?>
				</nav>

				<nav class="header-menu">
					<?php wp_nav_menu( [ 'theme_location' => 'main' ] ); ?>
				</nav>

			</header>

		</div>

		<div class="main-container">
