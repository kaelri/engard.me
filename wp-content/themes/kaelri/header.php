<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<?php if ( is_attachment() ) { ?>
	<meta name="robots" content="noindex">
	<?php } ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<title><?php wp_title( ' | ', true, 'right' ); ?></title>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div class="site-container">

		<div class="header-container">

			<header class="header">

				<h1 class="header-title">
					<a href="<?=esc_url( home_url( '/' ) )?>" title="<?=esc_attr( get_bloginfo( 'name' ))?>" rel="home"><?=esc_html( get_bloginfo( 'name' ) )?></a>
				</h1>

				<div class="header-description">
					<?php bloginfo( 'description' ); ?>
				</div>

				<nav class="header-contact">
					<?php wp_nav_menu([
						'theme_location' => 'contact',
						'walker'         => new kaelriContactMenu
					]); ?>
				</nav>

				<nav class="header-menu">
					<?php wp_nav_menu( [ 'theme_location' => 'main' ] ); ?>
				</nav>

			</header>

		</div>

		<div class="main-container">
