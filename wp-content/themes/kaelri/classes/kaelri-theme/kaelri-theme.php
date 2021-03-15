<?php

class kaelriTheme {

	// This module’s paths.
	public static $path;
	public static $url;

	public static function setup() {

		// Set variables for this module’s URL and local file paths.
		self::$path = plugin_dir_path ( __FILE__ );
		self::$url  = plugin_dir_url  ( __FILE__ );

		// THEME CAPABILITIES
		add_action( 'after_setup_theme',  [ __CLASS__, 'add_theme_supports'           ]     );
		add_action( 'after_setup_theme',  [ __CLASS__, 'register_menus'               ]     );

		// CSS & JS
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'load_fonts'                   ]     );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'load_main_css'                ]     );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'load_main_js'                 ]     );

		// CONTENT CUSTOMIZATION & FILTERS
		add_filter( 'body_class',         [ __CLASS__, 'filter_body_classes'          ]     );
		add_filter( 'wp_title',           [ __CLASS__, 'filter_wp_title'              ], 20 );
		add_filter( 'the_title',          [ __CLASS__, 'filter_the_title'             ]     );

		// Show Portal plugin’s loading spinner.
		if ( class_exists('Portal') ) Portal::enable_spinner();

	}

	// FIELDS
	// ------

	// THEME CAPABILITIES
	// ------------------

	public static function add_theme_supports() {

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'post-formats', ['image'] );

	}

	public static function register_menus() {

		register_nav_menus([
			'main'    => 'Main',
			'contact' => 'Contact',
		]);

	}

	// CSS & JS
	// --------

	public static function load_fonts() {

		wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap', [], null );

	}

	public static function load_main_css() {

		$css_mod_time = filemtime(get_stylesheet_directory() . '/css/main.css');
		wp_enqueue_style ( 'main', get_stylesheet_directory_uri() . '/css/main.css', false, $css_mod_time );

	}

	public static function load_main_js() {

		$js_mod_time = filemtime(get_stylesheet_directory() . '/js/main.js');
		wp_enqueue_script ( 'main', get_stylesheet_directory_uri() . '/js/main.js', ['jquery'], $js_mod_time, true );

	}

	// CONTENT CUSTOMIZATION & FILTERS
	// -------------------------------

	public static function filter_body_classes( $classes ) {

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;

	}

	public static function filter_wp_title( $title, $sep = ' | ' ) {

		$site_name = esc_attr( get_bloginfo( 'name' ) );

		if ( is_front_page() ) return $site_name;

		if ( is_tax() ) {
			$term  = get_queried_object();
			$title = $term->name;
		}

		return $title . $site_name;

	}

	public static function filter_the_title( $title ) {
		if ( $title == '' ) {
			return '&rarr;';
		} else {
			return $title;
		}
	}

}
