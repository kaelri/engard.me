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

		<header class="site-header">

		</header>

		<div class="main-container">
