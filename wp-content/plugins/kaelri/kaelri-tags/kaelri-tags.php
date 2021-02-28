<?php

class kaelriTags {

	public static $path;
	public static $url;

	// SETUP
	// -----

	public static function setup() {

		// Set variables for this module’s URL and local file paths.
		self::$path = plugin_dir_path ( __FILE__ );
		self::$url  = plugin_dir_url  ( __FILE__ );

		add_action( 'wp_head',      [ __CLASS__, 'do_header_tags'        ]    );
		add_action( 'wp_body_open', [ __CLASS__, 'do_body_tags'          ]    );
		add_action( 'wp_footer',    [ __CLASS__, 'do_footer_tags'        ]    );

	}

	public static function do_header_tags() {

		if (have_rows('kaelri_pixels_header_tags', 'option')) { while (have_rows('kaelri_pixels_header_tags', 'option')) {  the_row();

			if ( !get_sub_field('enabled') ) continue;

			?>

			<!-- <?=strtoupper( get_sub_field('label') )?> -->
			<?=get_sub_field('html')?>

		<?php }}

	}

	public static function do_body_tags() {

		if (have_rows('kaelri_pixels_body_tags', 'option')) { while (have_rows('kaelri_pixels_body_tags', 'option')) {  the_row();

			if ( !get_sub_field('enabled') ) continue;

			?>

			<!-- <?=strtoupper( get_sub_field('label') )?> -->
			<?=get_sub_field('html')?>

		<?php }}

	}

	public static function do_footer_tags() {

		if (have_rows('kaelri_pixels_footer_tags', 'option')) { while (have_rows('kaelri_pixels_footer_tags', 'option')) {  the_row();

			if ( !get_sub_field('enabled') ) continue;

			?>

			<!-- <?=strtoupper( get_sub_field('label') )?> -->
			<?=get_sub_field('html')?>

		<?php }}

	}

}
