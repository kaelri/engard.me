<?php 

if ( !have_rows('project_links' ) ) return;

?><section class="project-links">

	<ul class="menu">
	<?php while ( have_rows('project_links' ) ) { the_row();

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

</section>
