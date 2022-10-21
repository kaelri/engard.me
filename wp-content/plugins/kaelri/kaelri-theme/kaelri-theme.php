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
		add_action( 'after_setup_theme',           [ __CLASS__, 'add_theme_supports'          ]     );
		add_action( 'after_setup_theme',           [ __CLASS__, 'register_menus'              ]     );

		// CSS & JS
		add_action( 'wp_enqueue_scripts',          [ __CLASS__, 'load_fonts'                  ]     );
		add_action( 'wp_enqueue_scripts',          [ __CLASS__, 'load_main_css'               ]     );
		add_action( 'wp_enqueue_scripts',          [ __CLASS__, 'load_main_js'                ]     );
		add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_admin_scripts'       ]     );

		// CONTENT CUSTOMIZATION & FILTERS
		add_filter( 'body_class',                  [ __CLASS__, 'filter_body_classes'         ]     );
		add_filter( 'wp_title',                    [ __CLASS__, 'filter_wp_title'             ], 20 );
		add_filter( 'the_title',                   [ __CLASS__, 'filter_the_title'            ]     );
		add_filter( 'excerpt_length',              [ __CLASS__, 'filter_excerpt_length'       ]     );
		add_filter( 'excerpt_more',                [ __CLASS__, 'filter_excerpt_readmore'     ]     );
		add_filter( 'the_content_more_link',       [ __CLASS__, 'filter_content_readmore'     ]     );
		add_filter( 'pre_get_posts',               [ __CLASS__, 'add_projects_to_tag_archive' ]     );

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

		add_theme_support( 'post-formats', [ 'image', 'quote' ] );

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

		wp_enqueue_style( 'dashicons' );

	}

	public static function load_main_css() {

		wp_enqueue_style (
			'theme',
			get_stylesheet_directory_uri() . '/css/main.css',
			false,
			filemtime(get_stylesheet_directory() . '/css/main.css')
		);

	}

	public static function load_main_js() {

		wp_enqueue_script (
			'theme',
			get_stylesheet_directory_uri() . '/js/main.min.js',
			[],
			filemtime(get_stylesheet_directory() . '/js/main.min.js'),
			true
		);

	}

	public static function enqueue_admin_scripts() {

		wp_enqueue_style(
			'kaelri-admin-block-editor-styles',
			get_stylesheet_directory_uri() . '/css/admin.css',
			[],
			filemtime( get_stylesheet_directory() . '/css/admin.css' )
		);

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
	
	public static function filter_excerpt_length( $length ) {
		return 20;
	}

	public static function filter_excerpt_readmore( $more ) {
		return '…';
	}

	public static function filter_content_readmore( $more ) {

		return sprintf( '<p class="archive-read-more"><a href="%s">Read more&nbsp;&rarr;</a></p>', get_the_permalink() );

	}

	public static function add_projects_to_tag_archive( $query ) {

		if ( !is_tag() || !empty( $query->query_vars['suppress_filters'] ) ) return $query;
		 
		$query->set( 'post_type', [ 'post', 'project' ] );

		return $query;

	}

	public static function get_archive_title() {

		if ( is_tag() || is_category() ) {
			
			$tag  = get_queried_object();
			$icon = self::get_tag_icon($tag);
			$name = single_tag_title('', false);

			return sprintf( '%s&nbsp;%s', $icon, $name );

		}

		if ( is_search() ) {
			$search = get_search_query();
			return sprintf( '<i class="fas fa-search"></i>&nbsp;“%s”', $search );
		}

		if ( is_day() ) {
			$day =  get_the_time( get_option( 'date_format' ) );
			return sprintf( '<i class="fas fa-calendar"></i>&nbsp;%s', $day );
		}
		
		if ( is_month() ) {
			$month = get_the_time( 'F Y' );
			return sprintf( '<i class="fas fa-calendar"></i>&nbsp;%s', $month );
		}
		
		if ( is_year() ) {
			$year = get_the_time( 'Y' );
			return sprintf( '<i class="fas fa-calendar"></i>&nbsp;%s', $year );
		}

		if ( is_author() ) {
			$name = get_the_author_link();
			return sprintf( '<i class="fas fa-user"></i>&nbsp;%s', $name );
		}

		if ( is_404() ) {
			return '<i class="fas fa-times"></i>&nbsp;404';
		}

		if ( is_post_type_archive() ) {
			$post_type = get_queried_object();
			return $post_type->label;
		}
		
		return 'Archive'; // default

	}

	public static function get_tag_icon( $tag ) {

		$map = [
			'code'    => 'fas fa-fw fa-code-branch',
			'design'  => 'fas fa-fw fa-paint-brush',
			'photos'  => 'fas fa-fw fa-camera',
			'likes'   => 'fas fa-fw fa-heart',
			'myst'    => 'fas fa-fw fa-book-open',
			'writing' => 'fas fa-fw fa-pen-fancy',
		];

		$icon = $map[ $tag->slug ] ?? 'fas fa-fw fa-tag';

		return sprintf( '<i class="%s"></i>', $icon );

	}

}
