<?php

namespace engard;

class Feeds extends Module {

	// SETUP
	// -----

	public static function init() {

		add_action( 'pre_get_posts', function() {
			if ( is_feed() ) {
				header( 'Access-Control-Allow-Origin: *' );
			}
		});

	}

}
