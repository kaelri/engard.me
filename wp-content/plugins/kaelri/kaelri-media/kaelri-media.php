<?php

class kaelriMedia {

	public static function setup() {
		add_filter( 'upload_mimes', [ __CLASS__, 'enable_upload_file_types' ] );
	}

	public static function enable_upload_file_types($mimes) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['webm'] = 'image/webm';
		return $mimes;
	}
	
}
