<?php

namespace engard;

class Entry extends Module {

	public static function new( $post = null ) {

		$source = get_post( $post );

		if ( empty($source) ) return new \WP_Error('no-source-post');

		switch ( $source->post_type ) {
			case 'post':
				return new Post( $source );
				break;
			case 'page':
				return new Page( $source );
				break;
			case 'attachment':
				return new Media( $source );
				break;
			case 'event':
				return new Event( $source );
				break;
			case 'profile':
				return new Profile( $source );
				break;
			default:
				return new \WP_Error('unsupported-source-post-type');
				break;
		}

	}

	// INSTANCE
	public $id;
	public $post;

	function __construct( $source_post = null ) {

		// Find source post. Accept post object or ID. Default to global $post.
		$source_post = get_post( $source_post );
		if ( !$source_post ) return new \WP_Error('no-source-post');

		$this->id   = (int) $source_post->ID;
		$this->post = $source_post;

	}

	public function get_title() {
		return get_the_title( $this->post );
	}

	public function get_display_title() {
		return get_the_title( $this->post );
	}

	public function get_url() {
		return get_the_permalink( $this->post );
	}

	public function get_content( string $more_link_text = null, bool $strip_teaser = false ) {
		return get_the_content( $more_link_text, $strip_teaser, $this->post );
	}

	public function get_excerpt() {
		
		// return get_the_excerpt( $this->post );

		$excerpt = wp_trim_excerpt( $this->post->post_content );
		$excerpt = wp_strip_all_tags( $excerpt );
		$excerpt = substr($excerpt, 0, 200);
		if ( !empty($excerpt) ) $excerpt .= '…';

		return $excerpt;

	}

	public function get_image_url( $size = 'full' ) {

		$image_id = get_post_thumbnail_id( $this->post );
		if ( empty($image_id) ) return null;

		$image     = wp_get_attachment_image_src( $image_id, $size );
		$image_url = $image[0];

		return $image_url;

	}

	public function has_shortcode( string $shortcode = '' ) {
		return has_shortcode( $this->post->post_content, $shortcode );
	}

	public function get_tags( string $taxonomy = 'post_tag' ) {
		return get_the_terms( $this->id, $taxonomy );
	}

	public function get_tile() {

		$tile = [];

		$tile['title']       = $this->get_display_title();
		$tile['meta']        = $this->get_archive_meta();
		$tile['description'] = $this->get_excerpt();
		$tile['url']         = $this->get_url();
		$tile['target']      = '';
		$tile['image_url']   = $this->get_image_url('large');

		return $tile;
		
	}

	public function get_archive_meta() {

		$meta_parts  = [];
		$meta_sep    = ' <span class="archive-meta-sep">•</span> ';

		$meta = implode( $meta_sep, $meta_parts );

		return (string) $meta;

	}

}
