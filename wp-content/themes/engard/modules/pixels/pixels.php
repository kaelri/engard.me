<?php

namespace engard;

class Pixels extends Module {

	public static function init() {

		self::register_fields([ 'group_5ab8e50c9003f' ]);

		add_action( 'acf/init',     [ __CLASS__, 'register_options_page' ] );
		add_action( 'wp_head',      [ __CLASS__, 'do_header_tags'        ] );
		add_action( 'wp_body_open', [ __CLASS__, 'do_body_tags'          ] );
		add_action( 'wp_footer',    [ __CLASS__, 'do_footer_tags'        ] );

	}

	public static function register_options_page() {

		if ( !current_user_can('administrator') || !function_exists('acf_add_options_page') ) return;

		acf_add_options_page([
			'page_title'  => 'Pixels',
			'menu_title'  => 'Pixels',
			'parent_slug' => 'options-general.php',
			'menu_slug'   => __NAMESPACE__ . '-pixels',
			'capability'  => 'edit_posts',
		]);

	}

	public static function do_header_tags() {

		$gtm_id = get_field( 'gtm_id', 'option' );

		if ( !empty($gtm_id) ) {

			?>

			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?=esc_attr($gtm_id)?>');</script>
			<!-- End Google Tag Manager -->

			<?php

		}

		if ( have_rows( 'header_tags', 'option' ) ) { while ( have_rows( 'header_tags', 'option' ) ) {  the_row();

			if ( !get_sub_field('enabled') ) continue;

			?>

			<!-- <?=strtoupper( get_sub_field('label') )?> -->
			<?=get_sub_field('html')?>

		<?php }}

	}

	public static function do_body_tags() {

		$gtm_id = get_field( 'gtm_id', 'option' );

		if ( !empty($gtm_id) ) {

			?>

			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?=esc_attr($gtm_id)?>"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->

			<?php

		}

		if ( have_rows( 'body_tags', 'option' ) ) { while ( have_rows( 'body_tags', 'option' ) ) {  the_row();

			if ( !get_sub_field('enabled') ) continue;

			?>

			<!-- <?=strtoupper( get_sub_field('label') )?> -->
			<?=get_sub_field('html')?>

		<?php }}

	}

	public static function do_footer_tags() {

		if ( have_rows( 'footer_tags', 'option' ) ) { while ( have_rows( 'footer_tags', 'option' ) ) {  the_row();

			if ( !get_sub_field('enabled') ) continue;

			?>

			<!-- <?=strtoupper( get_sub_field('label') )?> -->
			<?=get_sub_field('html')?>

		<?php }}

	}

}
