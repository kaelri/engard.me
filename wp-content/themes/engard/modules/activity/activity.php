<?php

namespace engard;

class Activity extends Module {

	public static function init() {
		add_action( 'init',          [ __CLASS__, 'register_post_type'         ], 0 );
		add_action( 'pre_get_posts', [ __CLASS__, 'set_author_page_post_types' ]    );

	}

	public static function register_post_type() {

		register_post_type( 'activity', [
			'supports'            => [ 'title', 'editor', 'thumbnail' ],
			'taxonomies'          => [ 'post_tag' ],
			'show_in_rest'        => true,
			'hierarchical'        => false,
			'public'              => true,
			'has_archive'         => true,
			'rewrite'             => ['slug' => 'activities'],
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-groups',
			'labels'              => [
				'name'                => 'Activities',
				'singular_name'       => 'Activity',
			],
			'show_in_graphql'     => true,
			'graphql_plural_name' => 'Activities',
			'graphql_single_name' => 'Activity',
		]);

	}

	public static function set_author_page_post_types( $query ) {

		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}
	
		if ( is_author() ) {
			$query->set(
				'post_type', [
					'activity'
				]
			);
		}

	}

}
