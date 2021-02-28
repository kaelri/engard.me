<?php

// CLASSES
// Automatically loads and initializes this plugin’s classes as they appear.
spl_autoload_register(function ($class_name) {
	$class_filename = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $class_name ) );
	$path = sprintf( '%s/classes/%s/%s.php', get_stylesheet_directory(), $class_filename, $class_filename );
	if ( file_exists($path) ) require_once $path;
});

kaelriTheme::setup();
