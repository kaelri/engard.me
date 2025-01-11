<?php

namespace engard;

class Core {

	public static function init() {

		// DEPENDENCIES
		self::setup_config();
		// self::setup_composer();
		self::setup_acf();
		// self::setup_gravity_forms();
		self::setup_modules();

		// THEME CAPABILITIES
		add_action( 'after_setup_theme',           [ __CLASS__, 'set_theme_supports' ] );
		add_action( 'after_setup_theme',           [ __CLASS__, 'register_menus' ] );

		// CSS & JS
		add_action( 'init',                        [ __CLASS__, 'register_scripts' ] );
		add_action( 'wp_enqueue_scripts',          [ __CLASS__, 'enqueue_frontend_scripts' ] );
		add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_backend_scripts' ] );

		// BLOCKS
		add_action( 'block_categories_all',        [ __CLASS__, 'register_block_categories' ], 10, 2 );
		add_action( 'init',                        [ __CLASS__, 'register_blocks' ] );
		add_action( 'init',                        [ __CLASS__, 'register_block_styles' ] );
		add_action( 'init',                        [ __CLASS__, 'register_block_patterns' ], 0 );

		// CONTENT CUSTOMIZATION & FILTERS
		add_filter( 'body_class',                  [ __CLASS__, 'filter_body_classes' ] );
		add_filter( 'document_title',              [ __CLASS__, 'filter_html_title' ], 20 );
		add_filter( 'the_title',                   [ __CLASS__, 'filter_display_title' ] );
		add_filter( 'excerpt_length',              [ __CLASS__, 'filter_excerpt_length' ] );
		add_filter( 'excerpt_more',                [ __CLASS__, 'filter_excerpt_readmore' ] );
		add_filter( 'the_content_more_link',       [ __CLASS__, 'filter_content_readmore' ] );
		add_filter( 'oembed_response_data',        [ __CLASS__, 'filter_oembed_response_data' ] );

		// DISABLE AUTOMATIC UPDATES
		add_filter( 'auto_update_plugin',          '__return_false' );
		add_filter( 'auto_update_theme',           '__return_false' );
		add_filter( 'themes_auto_update_enabled',  '__return_false' );
		add_filter( 'plugins_auto_update_enabled', '__return_false' );

	}

	public static function setup_config() {

		define( __NAMESPACE__ . '\CONFIG', [
			'modules' => [
				'Media'    => [],
				'Project'  => [],
				'Pixels'   => [],
				'Feeds'    => [],
				// 'Activity' => [],
			]
		]);

	}

	public static function setup_composer() {

		require_once get_stylesheet_directory() . '/vendor/autoload.php';

	}

	public static function setup_acf() {

		// Load ACF field groups from the default location under `common`.
		add_filter( 'acf/settings/load_json', function ( $paths ) {
			$paths[] = get_common_path( 'fields' );
			return $paths;
		});

		// Save ACF field groups to the default location under `common`. (This gets overridden for module-specific field groups.)
		add_filter( 'acf/settings/save_json', function ( $path ) {
			return get_common_path( 'fields' );
		});

		// Remove wrapper element from <InnerBlocks/>.
		add_filter( 'acf/blocks/wrap_frontend_innerblocks', '__return_false', 10, 2 );

		// Options page.
		add_action( 'acf/init', function(){
			if ( current_user_can('administrator') && function_exists('acf_add_options_page') ) {
				acf_add_options_page([
					'page_title' 	=> 'Core Options',
					'menu_title'    => 'Core',
					'parent_slug' 	=> 'options-general.php',
					'menu_slug' 	=> 'engard-settings',
				]);
			}
		} );

	}

	public static function setup_gravity_forms() {

		// Disable Gravity Forms’ built-in CSS.
		add_filter( 'gform_disable_form_theme_css', '__return_true' );

	}

	public static function setup_modules() {

		// Load parent classes.
		require_once get_common_path( 'classes/module.php' );
		require_once get_common_path( 'classes/entry.php' );
		require_once get_common_path( 'classes/contact-menu.php' );

		$module_names = array_keys( CONFIG['modules'] );

		if ( !empty( $module_names ) ) { foreach ( $module_names as $module_name ) {

			$module_slug = get_module_slug( $module_name );

			require_once get_stylesheet_directory() . "/modules/$module_slug/$module_slug.php";

			$module_class = __NAMESPACE__ . '\\' . $module_name;

			if ( call_user_func( "$module_class::module_is_enabled" ) ) {
				call_user_func( "$module_class::init" );
			}

		}}

	}

	// THEME CAPABILITIES
	// ------------------

	public static function set_theme_supports() {

		add_theme_support( 'title-tag' );

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

	public static function register_scripts() {

		wp_register_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap', [], null );

		wp_register_script ( 'font-awesome-5', '//use.fontawesome.com/releases/v5.15.4/js/all.js' );

		wp_register_script ( 'fslightbox', get_common_url('lib/fslightbox-basic-3.3.1/fslightbox.js'), null, null, true );

		wp_register_style  ( 'prism', get_common_url('lib/prism/prism.css') );
		wp_register_script ( 'prism', get_common_url('lib/prism/prism.js'), null, null, true );

		wp_register_style (
			__NAMESPACE__ . '-theme',
			geT_common_url('css/main.css'),
			[ 'google-fonts', 'prism', 'dashicons' ],
			filemtime( get_common_path('css/main.css') )
		);

		wp_register_style (
			__NAMESPACE__ . '-admin',
			geT_common_url('css/admin.css'),
			[ 'google-fonts', 'prism', 'dashicons' ],
			filemtime( get_common_path('css/admin.css') )
		);

		wp_register_script (
			__NAMESPACE__ . '-theme',
			geT_common_url('js/main.min.js'),
			[ 'font-awesome-5', 'fslightbox', 'prism' ],
			filemtime( get_common_path('js/main.min.js') ),
			true
		);

	}

	public static function enqueue_frontend_scripts() {
		wp_enqueue_style  ( __NAMESPACE__ . '-theme'  );
		wp_enqueue_script ( __NAMESPACE__ . '-theme'  );
	}

	public static function enqueue_backend_scripts() {

		wp_enqueue_style  ( __NAMESPACE__ . '-admin' );

	}

	// BLOCKS

	public static function register_block_categories( $categories ) {

		$categories[] = [
			'slug'  => __NAMESPACE__,
			'title' => wp_get_theme()['Name'],
		];

		return $categories;

	}

	public static function register_blocks() {
	}

	public static function register_block_styles() {

		register_block_style(
			'core/paragraph', [
				'name'  => 'subtitle',
				'label' => 'Subtitle',
				'inline_style' => 'p.is-style-subtitle {
					margin-block-start: 0;
					font-size: var(--wp--preset--font-size--60);
					line-height: 1.5;
				}'
			]
		);

		register_block_style(
			'core/paragraph', [
				'name'  => 'flush',
				'label' => 'Flush',
				'inline_style' => 'p.is-style-flush {
					margin-block-start: 0;
				}'
			]
		);

		register_block_style(
			'core/list', [
				'name'  => 'no-bullets',
				'label' => 'No Bullets',
				'inline_style' => 'ul.is-style-no-bullets, ol.is-style-no-bullets {
					list-style-type: none;
				}'
			]
		);

		register_block_style(
			'core/list', [
				'name'  => 'wide',
				'label' => 'Wide',
				'inline_style' => 'ul.is-style-wide li + li, ol.is-style-wide li + li {
					margin-top: var(--wp--custom--spacing--gap);
				}'
			]
		);

		register_block_style(
			'core/list', [
				'name'  => 'columns',
				'label' => 'Columns',
				'inline_style' => 'ul.is-style-columns {
					columns: auto 12em;
					column-gap: var(--wp--custom--spacing--gap);
				}'
			]
		);

		register_block_style(
			'core/button', [
				'name'  => 'arrow',
				'label' => 'Arrow',
				'inline_style' => '.wp-block-button.is-style-arrow .wp-block-button__link::after {
						display: inline;
						content: " →";
				}'
			]
		);

		register_block_style(
			'core/image', [
				'name'  => 'full-width',
				'label' => 'Full Width',
				'inline_style' => '.wp-block-image.is-style-full-width {
					display: block;
					width: 100%;
				}

				.wp-block-image.is-style-full-width img {
					display: block;
					width: 100%;
					max-width: 100%;
					height: auto;
					object-position: 50% 50%;
				}
					
				.wp-block-image.is-style-full-width img[style*="object-fit:contain"] {
					object-fit: scale-down !important;
				}'
			]
		);

		register_block_style(
			'core/columns', [
				'name'  => 'center',
				'label' => 'Centered',
				'inline_style' => '.wp-block-columns.is-style-center {
					align-items: center !important;
				}'
			]
		);

		register_block_style(
			'core/columns', [
				'name'  => 'stretch',
				'label' => 'Stretch',
				'inline_style' => '.wp-block-columns.is-style-stretch {
					align-items: stretch;
				}

				.wp-block-columns.is-style-stretch > .wp-block-column {
				    flex: 1;
					display: flex;
					align-items: stretch;
				}

				.wp-block-columns.is-style-stretch > .wp-block-column > * {
					flex: 1;
				}'
			]
		);

		register_block_style(
			'core/column', [
				'name'  => 'full-cover-image',
				'label' => 'Full-Cover Image',
				'inline_style' => '.wp-block-column.is-style-full-cover-image {
					position: relative;
					min-height: clamp(0px, 50vw, 50vh);
				}

				.wp-block-column.is-style-full-cover-image .components-resizable-box__container,
				.wp-block-column.is-style-full-cover-image .wp-block-image {
					position: absolute;
					width: 100%;
					height: 100%;
				}

				.wp-block-column.is-style-full-cover-image .wp-block-image img {
					position: absolute;
					width: 100%;
					height: 100%;
					object-fit: cover;
				}

				.wp-block-column.is-style-full-cover-image .components-resizable-box__container {
					width: 100% !important;
					height: 100% !important;
				}'
			]
		);

		register_block_style(
			'core/quote', [
				'name'  => 'full-width',
				'label' => 'Full Width',
				'inline_style' => '.wp-block-quote.is-style-full-width {
					padding: 0;
					margin-inline: 0;
				}'
			]
		);

	}

	public static function register_block_patterns() {

		register_block_pattern_category( __NAMESPACE__, [
			'label'       => wp_get_theme()['Name'],
			'description' => '',
		]);

	}

	// CONTENT CUSTOMIZATION & FILTERS
	public static function filter_body_classes( $classes ) {

		if ( is_singular() && has_block('engard/section') ) {
			$classes[] = 'has-sections';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( !is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;

	}

	public static function filter_html_title( $title = '' ) {

		$page_title = null; // default
		$separator  = '•';
		$site_name  = esc_attr( get_bloginfo( 'name' ) );

		if ( is_singular() && !is_front_page() ) {
			$page_title = get_the_title();
		} elseif ( is_tax() ) {
			$term  = get_queried_object();
			$page_title = $term->name;
		} elseif ( is_404() ) {
			$page_title = 'Page not found';
		}

		if ( $page_title ) {
			return sprintf( '%s %s %s', $page_title, $separator, $site_name );
		} else {
			return $site_name;
		}

	}

	public static function filter_display_title( $title ) {
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

	public static function filter_oembed_response_data( $data ) {
		unset($data['author_url']);
		unset($data['author_name']);
		return $data;
	}
	  
	// TEMPLATE FUNCTIONS
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

// FUNCTIONS

/**
 * Get the local path to a file in the common directory.
 */
function get_common_path( string $subpath = '' ) {
	if ( !empty($subpath) && strpos( $subpath, '/' ) === 0 ) $subpath = substr( $subpath, 1 );
	return (string) get_stylesheet_directory() . '/common/' . $subpath;
}

/**
 * Get the public URL of a file in the common directory.
 */
function get_common_url( string $subpath = '' ) {
	if ( !empty($subpath) && strpos( $subpath, '/' ) === 0 ) $subpath = substr( $subpath, 1 );
	return (string) get_stylesheet_directory_uri() . '/common/' . $subpath;
}

/**
 * Get the ”slug” version of a capitalized module name, to be used in the folder and file name of a module.
 */
function get_module_slug( string $module_name ) {

	return strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $module_name ) );

}

/**
 * Display a placeholder block in the editor.
 */
function do_block_admin_placeholder( $text ) {

	?><p class="<?=__NAMESPACE__?>-block-editor-placeholder"><?=esc_html( (string) $text )?></p><?php

}

/**
 * Get the class attribute for a block, combining a fixed class name from code with the editor field value.
 */
function get_block_class( $block, $main_class = '' ) {

	$classes = [];

	if ( !empty($main_class) ) {
		$classes[] = $main_class;
	}

	if ( !empty($block['className']) ) {
		$classes[] = $block['className'];
	}

	return (string) implode( ' ', $classes );

}

/**
 * Get the ID attribute for a block, using the anchor field if available, or generating a unique ID.
 */
function get_block_id( $block, string $prefix = '' ) {

	$id = '';

	if ( !empty($block['anchor']) ) {
		$id = $block['anchor'];
	} else {
		$id = uniqid( $prefix );
	}

	return (string) $id;

}

/**
 * Take a start date-time, and optionally an end date-time, and format them for display.
 */
function get_formatted_event_date( $data = [] ) {

	$start     = $data['start']   ?? false;
	$end       = $data['end']     ?? false;
	$all_day   = $data['all_day'] ?? false;
	$no_date   = $data['no_date'] ?? false;

	if ( !$start ) return;

	if ( $end ) {

		if ( is_string($end) ) {
			$end = \DateTime::createFromFormat( 'Y-m-d H:i:s', $end );
		}

		$same_year  = dates_match( $start, $end, 'Y' );
		$same_month = dates_match( $start, $end, 'Y-m' );
		$same_day   = dates_match( $start, $end, 'Y-m-d' );
		$same_apm   = dates_match( $start, $end, 'Y-m-d A' );
		$same_time  = dates_match( $start, $end, 'Y-m-d H:i' );

	}

	// Determine how to format start & end.
	if ( !$end || $same_time ) {

		if ( $all_day ) {
			$start_format = 'F j, Y';
		} elseif ( $no_date ) {
			$start_format = 'g:i A';
		} else {
			$start_format = 'F j, Y, g:i A';
		}
		$end_format       = false;

	} else {

		if ( $all_day ) {

			if ( $same_day ) {
				$start_format = 'F j, Y';
				$end_format   = false;
			} elseif ( $same_month ) {
				$start_format = 'F j';
				$end_format   = 'j, Y';
			} elseif ( $same_year ) {
				$start_format = 'F j';
				$end_format   = 'F j, Y';
			} else {
				$start_format = 'F j, Y';
				$end_format   = 'F j, Y';
			}

		} elseif ( $no_date ) {

			if ( $same_apm ) {
				$start_format = 'g:i';
				$end_format   = 'g:i A';
			} else {
				$start_format = 'g:i A';
				$end_format   = 'g:i A';
			}

		} else {

			if ( $same_apm ) {
				$start_format = 'F j, Y, g:i';
				$end_format   = 'g:i A';
			} elseif ( $same_day ) {
				$start_format = 'F j, Y, g:i A';
				$end_format   = 'g:i A';
			} else {
				$start_format = 'F j, Y, g:i A';
				$end_format   = 'F j, Y, g:i A';
			}

		}

	}

	// FINISH
	$output = '';

	if ( $end && $end_format ) {
		$output = sprintf( '%s – %s', $start->format( $start_format ), $end->format( $end_format ) );
	} else {
		$output = $start->format( $start_format );
	}

	$output = preg_replace( '/ (a|p)m/', ' \1.m.', $output );

	return $output;

}

/**
 * Check if two date-times match, given a format.
 */
function dates_match( \DateTime $start, \DateTime $end, string $format = 'c' ) {
	return ( $start->format($format) == $end->format($format) );
}

/**
 * Log an arbitrary value or values to the debug log.
 */
function log( ...$args ) {

	// Run only in debug mode.
	if ( !defined("WP_DEBUG") || !WP_DEBUG ) return;

	error_log( any_to_text( ...$args ) );

}

/**
 * Log an arbitrary value or values to the WP CLI output, and (if available) the debug log.
 */
function line ( ...$args ) {

	if ( class_exists('WP_CLI') ) {
		\WP_CLI::line( any_to_text( ...$args ) );
	}

	// Copy to the log as well.
	log( ...$args );

}

/**
 * Get a text-loggable version of any value or values.
 */
function any_to_text( ...$args ) {

	switch ( count($args) ) {

		case 0:

			return '';

		case 1:

			$var = $args[0];

			if ( is_string($var) || is_int($var) || is_float($var) ) {
				return $var;
			} else {
				return var_export($var, true);
			}

		default:

			return var_export( $args, true );

	}

}

/**
 * Convert any value to an array (if it is not an array already). Optionally recursive, to a given depth.
 */
function any_to_array( $input, int $depth = 0 ) {

	$array = is_array($input) ? $input : [ $input ];

	if ( $depth > 0 ) {
		foreach ( $array as $key => $value ) {
			$array[ $key ] = any_to_array( $value, $depth - 1 );
		}
	}

	return $array;

}

/**
 * Get the display value for a number of bytes.
 * http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
 */
function get_display_file_size( $bytes, $decimals = 2 ) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

Core::init();
