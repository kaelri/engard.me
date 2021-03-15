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

		add_action( 'init',     [ __CLASS__, 'register_post_type' ], 0 );
		add_action( 'acf/init', [ __CLASS__, 'register_blocks'    ]    );

	}

	public static function register_post_type() {

		register_post_type( 'project', [
			'supports'            => [ 'title', 'editor', 'thumbnail' ],
			'show_in_rest'        => true,
			'taxonomies'          => [],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-format-image',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
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

		register_taxonomy( 'project_category', ['project'], [
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'show_in_rest'               => true,
			'rewrite'                    => ['slug' => 'project-category'],
			'labels'                     => [
				'name'                       => 'Project Categories',
				'singular_name'              => 'Project Category',
				'menu_name'                  => 'Categories',
				'all_items'                  => 'All Categories',
				'parent_item'                => 'Parent Category',
				'parent_item_colon'          => 'Parent Category:',
				'new_item_name'              => 'New Category',
				'add_new_item'               => 'Add New Category',
				'edit_item'                  => 'Edit Category',
				'update_item'                => 'Update Category',
				'separate_items_with_commas' => 'Separate Categories with Commas',
				'search_items'               => 'Search Categories',
				'add_or_remove_items'        => 'Add or Remove Categories',
				'choose_from_most_used'      => 'Choose from the most used Categories',
			],
		]);

	}

	public static function register_blocks() {

		acf_register_block_type([
			'name'            => 'portfolio',
			'title'           => 'Portfolio',
			'description'     => 'List all projects by category.',
			'render_callback' => [ __CLASS__, 'render_block_portfolio' ],
			'icon'            => 'images-alt2',
			'category'        => 'kaelri',
			'keywords'        => [ 'custom' ],
		]);

	}

	public static function render_block_portfolio( $block ) {

		// ADMIN
		if ( is_admin() ) {
			?><p class="block-preview-placeholder">Portfolio</p><?php
			return;
		}

		$project_posts = get_posts([
			'posts_per_page' => -1,
			'post_type'      => 'project',
			'post_status'    => 'publish',
		]);

		if ( count($project_posts) == 0 ) return;

		?><section class="portfolio">

			<ul>
			<?php foreach ( $project_posts as $project_post ) {

				$project = new self( $project_post );

				$title     = get_the_title( $project->id );
				$url       = get_the_permalink( $project->id );
				$subtitle  = get_field( 'project_subtitle', $project->id );
				
				$image_id  = get_post_thumbnail_id( $project );
				$image     = wp_get_attachment_image_src( $image_id, 'large' );
				$image_url = $image[0];
				
				?><li>

					<a href="<?=$url?>">

						<div class="portfolio-thumb-container">
							<div class="portfolio-thumb" style="background-image: url(<?=$image_url?>);"></div>
						</div>

						<div class="portfolio-caption">

							<div class="portfolio-title"><?=$title?></div>

							<?php if ( !empty($caption) ) { ?>
								<div class="portfolio-subtitle"><?=$subtitle?></div>
							<?php } ?>

						</div>

					</a>

				</li><?php
			
			} ?>
			</ul>	

		</section><?php

	}

	// INSTANCE
	// --------

	public $id;
	public $post;
	public $categories = [];

	function __construct( $source_post = null ) {

		// Find source post. Accept post object or ID. Default to global $post.
		$source_post = get_post( $source_post );
		if ( !$source_post ) return new WP_Error('missing-source-post');

		$this->post = $source_post;

		// ID
		$this->id = $this->post->ID;

	}

	public function fetch_basics() {

		// CATEGORIES
		$terms = get_the_terms( $this->id, 'project_category' );

		if ( !empty($terms) ) { foreach ( $terms as $term ) {

			$this->categories[] = [
				'id'   => $term->term_id,
				'name' => $term->name,
			];

		}}

	}

}
