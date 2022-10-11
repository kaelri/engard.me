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

		// if ( !is_admin() ) wp_deregister_script( 'jquery' );

		wp_enqueue_script ( 'font-awesome-5', '//use.fontawesome.com/releases/v5.15.4/js/all.js' );

		wp_enqueue_script ( 'fslightbox', self::$url . 'fslightbox-basic-3.3.1/fslightbox.js', null, null, true );

		wp_enqueue_style  ( 'prism', self::$url . 'prism/prism.css' );
		wp_enqueue_script ( 'prism', self::$url . 'prism/prism.js', null, null, true );

	}

}
