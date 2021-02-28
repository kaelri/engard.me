<?php
class kaelriBlocks {

	public static $path;
	public static $url;

	// SETUP
	// -----

	public static function setup() {

		// Set variables for this module’s URL and local file paths.
		self::$path = plugin_dir_path ( __FILE__ );
		self::$url  = plugin_dir_url  ( __FILE__ );

		add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'register_block_styles'     ]        );
		add_filter( 'block_categories',            [ __CLASS__, 'register_block_categories' ], 10, 2 );
		add_action( 'acf/init',                    [ __CLASS__, 'register_blocks'           ]        );

	}

	public static function register_block_styles() {

		wp_enqueue_script(
			'kaelri-admin-block-editor-styles',
			self::$url . '/blocks-admin.js',
			[ 'wp-blocks', 'wp-dom' ],
			filemtime( self::$path . 'blocks-admin.js' ),
			true
		);

		wp_enqueue_style(
			'kaelri-admin-block-editor-styles',
			self::$url . '/blocks-admin.css',
			filemtime( self::$path . 'blocks-admin.css' ),
			true
		);

	}

	public static function register_block_categories( $categories, $post ) {

		$categories[] = [
			'slug'  => 'kaelri',
			'title' => 'Kaelri.com',
		];

		return $categories;

	}

	public static function register_blocks() {

		acf_register_block_type([
			'name'              => 'kaelri-callout',
			'title'             => 'Callout',
			'description'       => 'A box that contains other content.',
			'render_callback'   => [ __CLASS__, 'render_callout' ],
			'category'          => 'kaelri',
			'icon'              => 'images-alt2',
			'keywords'          => ['custom'],
			'supports'          => [
                'align' => true,
                'mode'  => false,
                'jsx'   => true
			],
		]);

	}

	// RENDERERS
	// ---------

	public static function render_callout( $block ) {

		?><section class="block-callout">

			<div class="block-callout-inner">

				<InnerBlocks />

			</div>

		</section><?php

	}

}
