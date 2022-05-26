<?php

class kaelriFeeds {

	public static $path;
	public static $url;

	// SETUP
	// -----

	public static function setup() {

		// Set variables for this module’s URL and local file paths.
		self::$path = plugin_dir_path ( __FILE__ );
		self::$url  = plugin_dir_url  ( __FILE__ );

		add_action( 'pre_get_posts', function() {
			if ( is_feed() ) {
				header( 'Access-Control-Allow-Origin: *' );
			}
		});

	}

}
