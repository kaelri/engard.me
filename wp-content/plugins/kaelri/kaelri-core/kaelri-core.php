<?php

class kaelriCore {

	// Top-level plugin paths.
	public static $plugin_path;
	public static $plugin_url;

	// This module’s paths.
	public static $path;
	public static $url;

	// SETUP
	// -----

	// Start. Everything this plugin does flows from this method.
	public static function setup( string $file, array $modules = [] ) {

		// Stops the plugin setup and creates a warning message if the Advanced Custom Fields plugin is not active.
		if ( ! self::check_acf_is_active() ) return;

		// PATHS
		// Sets variables for the plugin’s URL and local file paths.
		self::$plugin_path = plugin_dir_path ( $file );
		self::$plugin_url  = plugin_dir_url  ( $file );

		// Set variables for this module’s URL and local file paths.
		self::$path = plugin_dir_path ( __FILE__ );
		self::$url  = plugin_dir_url  ( __FILE__ );

		// FIELDS
		add_action( 'init',                   [ __CLASS__, 'set_acf_options_page'   ], 0 );
		add_filter( 'acf/settings/load_json', [ __CLASS__, 'set_acf_json_load_path' ]    );
		add_filter( 'acf/settings/save_json', [ __CLASS__, 'set_acf_json_save_path' ]    );

		// MODULES
		if ( !empty($modules) ) { foreach ( $modules as $module ) {
			call_user_func( [ $module, 'setup' ] );
		}}

	}

	// FIELDS
	// ------

	// This plugin depends on Advanced Custom Fields Pro. If that plugin is not installed & activated, display a warning on the WP admin pages and stop loading this plugin.
	public static function check_acf_is_active() {

		// If ACF is installed and active, carry on.
		if ( class_exists( 'ACF' ) ) return true;

		// If not, display a warning and stop loading.
		add_action( 'admin_notices', function (){

			?><div class="error notice">
				<p>kaelriCore requires the <a href="https://www.advancedcustomfields.com/" target="_blank">Advanced Custom Fields PRO</a> plugin to be installed and activated. <a href="<?=admin_url('plugins.php')?>">Go to Plugins &raquo;</a></p>
			</div><?php

		});

		return false;

	}

	public static function set_acf_options_page() {

		if ( current_user_can('administrator') && function_exists('acf_add_options_page') ) {

			// acf_add_options_page([
			// 	'page_title' 	=> 'Core Options',
			// 	'menu_title'    => 'Core',
			// 	'menu_slug' 	=> 'kaelri-core-settings',
			// 	'capability'    => 'edit_posts',
			// 	'redirect'  	=> true
			// ]);

			acf_add_options_page([
				'page_title' 	=> 'Core Options',
				'menu_title'    => 'Core',
				'parent_slug' 	=> 'options-general.php',
				// 'parent_slug' 	=> 'kaelri-core-settings',
				'menu_slug' 	=> 'kaelri-core-settings-general',
			]);

		}

	}

	public static function set_acf_json_load_path( $paths ) {

		unset($paths[0]);

		$paths[] = self::$path . 'fields';

		return $paths;

	}

	public static function set_acf_json_save_path( $path ) {

		$path = self::$path . 'fields';

		return $path;

	}

	// HELPERS
	// -------

    public static function log( ...$args ) {

		// Run only in debug mode.
		if ( !defined("WP_DEBUG") || !WP_DEBUG ) return;

		switch ( count($args) ) {

			case 0:

				break;

			case 1:

				$var = $args[0];

				if ( is_string($var) || is_int($var) || is_float($var) ) {
					error_log( $var );
				} else {
					error_log(var_export($var, true));
				}

				break;

			default:

				error_log( var_export( $args, true ) );

				break;

		}

	}

}

// FUNCTIONS
// ---------

function kaelog( ...$args ) {
	return kaelriCore::log( ...$args );
}
