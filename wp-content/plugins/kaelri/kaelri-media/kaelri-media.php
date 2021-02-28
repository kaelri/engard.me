<?php

class kaelriMedia {

	public static function setup() {
		add_filter( 'upload_mimes', [ __CLASS__, 'enable_upload_file_types' ] );
		// add_filter( 'jpeg_quality', [ __CLASS__, 'maximize_image_quality'   ] );
	}

	public static function enable_upload_file_types($mimes) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['webm'] = 'image/webm';
		return $mimes;
	}
	
	public static function maximize_image_quality() {
		return 100;
	}
	
}
