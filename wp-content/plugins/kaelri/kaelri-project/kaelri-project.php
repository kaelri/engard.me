<?php

class kaelriProject {

	public static $path;
	public static $url;

	// SETUP
	// -----

	public static function setup() {

		// Set variables for this module’s URL and local file paths.
		self::$path = plugin_dir_path ( __FILE__ );
		self::$url  = plugin_dir_url  ( __FILE__ );

		add_action( 'init', [ __CLASS__, 'register_post_type' ], 0 );

	}

	public static function register_post_type() {

		register_post_type( 'project', [
			'supports'            => [ 'title', 'editor', 'thumbnail' ],
			'taxonomies'          => [ 'post_tag' ],
			'show_in_rest'        => true,
			'hierarchical'        => false,
			'public'              => true,
			'has_archive'         => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-format-image',
			'labels'              => [
				'name'                => 'Projects',
				'singular_name'       => 'Project',
			],
			'show_in_graphql'     => true,
			'graphql_plural_name' => 'Projects',
			'graphql_single_name' => 'Project',
		]);

	}

}
