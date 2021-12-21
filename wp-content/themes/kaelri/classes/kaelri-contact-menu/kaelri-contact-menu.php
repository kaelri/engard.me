<?php

class kaelriContactMenu extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$li_attributes = [];
		
		$li_attributes['id'] = sprintf( 'menu-item-%s', $item->ID );
		
		$classes             = !empty( $item->classes ) ? (array) $item->classes : [];
		$li_attributes['class'] = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	
		$li_attributes_strings = [];
		foreach ( $li_attributes as $key => $value ) $li_attributes_strings[] = sprintf( ' %s="%s"', $key, $value );

		$output .= sprintf( '<li %s>', join( '', $li_attributes_strings ) );
	
		$title = $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

		$icon        = '';
		$icon_map    = [
			'about'     => 'fas fa-user',
			'email'     => 'far fa-envelope',
			'twitter'   => 'fab fa-twitter',
			'tumblr'    => 'fab fa-tumblr',
			'github'    => 'fab fa-github',
			'feed'      => 'fas fa-rss',
			'portfolio' => 'fas fa-images',
			'blog'      => 'fas fa-book-open',
			'uses'      => 'fas fa-tools',
			'instagram' => 'fab fa-instagram',
			'coffee'    => 'fas fa-coffee'
		];

		foreach ($icon_map as $icon_id => $font_awesome_id) {
			if ( in_array($icon_id, $classes) ) {
				$icon = '<span class="menu-item-icon" title="'.esc_attr($title).'"><i class="'.$font_awesome_id.'"></i></span>';
				break;
			}
		}
	
		$a_attributes = [];
		if ( !empty( $item->attr_title ) ) $a_attributes['title']  = $item->attr_title;
		if ( !empty( $item->target ) )     $a_attributes['target'] = $item->target;
		if ( !empty( $item->xfn ) )        $a_attributes['rel']    = $item->xfn;
		if ( !empty( $item->url ) )        $a_attributes['href']   = $item->url;
		$a_attributes_strings = [];
		foreach ( $a_attributes as $key => $value ) $a_attributes_strings[] = sprintf( ' %s="%s"', $key, $value );

		$item_output  = $args->before;
		$item_output .= sprintf( '<a %s>', join( '', $a_attributes_strings ) );
		$item_output .= $icon;
		$item_output .= '<span class="menu-item-title">'.$title.'</span>';
		$item_output .= '<br /><span class="menu-item-description">' . $item->description . '</span>';
		$item_output .= '</a>';
		$item_output .= $args->after;
	
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}
