<?php

// LIBRARIES
// =========

class kaelriLibraries {

	public static $path;
	public static $url;

	// SETUP
	// -----

	public static function setup() {

		// Set variables for this module’s URL and local file paths.
		self::$path = plugin_dir_path ( __FILE__ );
		self::$url  = plugin_dir_url  ( __FILE__ );

		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

	}

	public static function enqueue_scripts() {

		wp_enqueue_script ( 'jquery' );
		
		wp_enqueue_script ( 'font-awesome-5', '//use.fontawesome.com/releases/v5.15.2/js/all.js' );

		wp_enqueue_style  ( 'lightbox', self::$url . 'lightbox/css/lightbox.css' );
		wp_enqueue_script ( 'lightbox', self::$url . 'lightbox/js/lightbox.js', null, null, true );

		wp_enqueue_style  ( 'prism', self::$url . 'prism/prism.css' );
		wp_enqueue_script ( 'prism', self::$url . 'prism/prism.js', null, null, true );

	}

}
