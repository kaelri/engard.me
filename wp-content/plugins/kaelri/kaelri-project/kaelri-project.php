<?php

class kaelriProject {

	public static function setup() {
		add_action( 'init',     [ __CLASS__, 'register_post_type' ], 0 );
		add_action( 'acf/init', [ __CLASS__, 'register_blocks'    ]    );
	}

	public static function register_post_type() {

		register_post_type( 'project', [
			'supports'            => [ 'title', 'editor', 'thumbnail' ],
			'taxonomies'          => [ 'post_tag' ],
			'show_in_rest'        => true,
			'hierarchical'        => false,
			'public'              => true,
			'has_archive'         => true,
			'rewrite'             => ['slug' => 'projects'],
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

	public static function register_blocks() {

		acf_register_block_type([
			'name'            => 'kaelri-project-links',
			'title'           => 'Project Links',
			'description'     => 'Links for projects.',
			'render_callback' => [ __CLASS__, 'render' ],
			'category'        => 'kaelri',
			'icon'            => 'images-alt2',
			'keywords'        => [ 'custom' ],
			'supports'        => [
				'align'           => true,
				'mode'            => true,
				'anchor'          => true,
				'jsx'             => true,
			],
		]);

	}

	public static function render( $acf_block ) {

		if ( is_admin() ) {
			?><div class="project-links">Project Links</div><?php // +Replace “New” with your new block’s name.
			return;
		}

		if ( !have_rows( 'project_links', get_the_ID() ) ) return;

		?><section class="project-links">
		
			<ul class="menu">
			<?php while ( have_rows('project_links', get_the_ID() ) ) { the_row();
		
				$link = get_sub_field('url');
				$icon = get_sub_field('icon');
		
				$icon_map = [
					'web'        => 'fas fa-globe',
					'email'      => 'far fa-envelope',
					'twitter'    => 'fab fa-twitter',
					'github'     => 'fab fa-github',
					'instagram'  => 'fab fa-instagram',
					'feed'       => 'fab fa-rss',
					'deviantart' => 'fab fa-deviantart',
				];
		
				if ( isset($icon_map[$icon]) ) {
					$icon_code = $icon_map[$icon]; 
				}
		
				?>
		
				<li class="menu-item <?=$icon?>">
		
					<a href="<?=$link['url']?>" target="<?=$link['target']?>" title="<?=$link['title']?>">
						<span class="menu-item-icon"><i class="<?=$icon_code?>"></i></span>
						<span class="menu-item-title"><?=$link['title']?></span>
					</a>
		
				</li>
		
			<?php } ?>
			</ul>
		
		</section><?php
		
	}

}
