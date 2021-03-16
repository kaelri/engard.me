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
			'show_in_rest'        => true,
			'taxonomies'          => ['post_tag'],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-format-image',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'rewrite'             => ['slug' => 'projects'],
			'labels'              => [
				'name'                => 'Projects',
				'singular_name'       => 'Project',
				'menu_name'           => 'Projects',
				'parent_item_colon'   => 'Parent Project:',
				'all_items'           => 'All Projects',
				'view_item'           => 'View Projects',
				'add_new_item'        => 'Add New Project',
				'add_new'             => 'New Project',
				'edit_item'           => 'Edit Project',
				'update_item'         => 'Update Project',
				'search_items'        => 'Search Projects',
				'not_found'           => 'No Projects Found',
				'not_found_in_trash'  => 'No Projects Found in Trash',
			],
		]);

	}

	// INSTANCE
	// --------

	public $id;
	public $post;
	public $tags = [];

	function __construct( $source_post = null ) {

		// Find source post. Accept post object or ID. Default to global $post.
		$source_post = get_post( $source_post );
		if ( !$source_post ) return new WP_Error('missing-source-post');

		$this->post = $source_post;

		// ID
		$this->id = $this->post->ID;

	}

	public function fetch_basics() {

		// TAGS
		$terms = get_the_terms( $this->id, 'post_tag' );

		if ( !empty($terms) ) { foreach ( $terms as $term ) {

			$this->tags[] = [
				'id'   => $term->term_id,
				'name' => $term->name,
			];

		}}

	}

}
