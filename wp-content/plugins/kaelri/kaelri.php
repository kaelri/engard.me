<?php
 
/*
Plugin Name: Custom Site Plugin
Plugin URI: https://www.kaelri.com/
Version: 1.0
Author: Michael Engard
Author URI: https://www.kaelri.com
Description: Site-specific plugin for <a href="https://www.kaelri.com">Kaelri.com</a>.
License: All rights reserved.
License URI: https://www.kaelri.com/
Text Domain: kaelri
*/

// CLASSES
// Automatically loads and initializes this plugin’s classes as they appear.
spl_autoload_register(function ($class_name) {
	$class_filename = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $class_name ) );
	$path = sprintf( '%s%s/%s.php', plugin_dir_path( __FILE__ ), $class_filename, $class_filename );
	if ( file_exists($path) ) require_once $path;
});

kaelriCore::setup( __FILE__, [
	'kaelriLibraries',
	'kaelriMedia',
	'kaelriBlocks',
	'kaelriProject',
	'kaelriTags',
	// 'Portal',
]);
