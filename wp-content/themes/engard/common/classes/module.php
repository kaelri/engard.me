<?php

namespace engard;

class Module {

	const FIELD_KEYS = [];

	public static function get_module_name() {

		$module_name_parts = explode('\\', static::class );
		array_shift( $module_name_parts );
		$module_name = implode( '\\', $module_name_parts );

		return $module_name;

	}

	public static function get_module_path( string $subpath = '' ) {
		if ( !empty($subpath) && strpos( $subpath, '/' ) === 0 ) $subpath = substr( $subpath, 1 );
		return (string) get_stylesheet_directory() . static::get_module_fragment( static::get_module_name() ) . $subpath;
	}

	public static function get_module_url( string $subpath = '' ) {
		if ( !empty($subpath) && strpos( $subpath, '/' ) === 0 ) $subpath = substr( $subpath, 1 );
		return (string) get_stylesheet_directory_uri() . static::get_module_fragment( static::get_module_name() ) . $subpath;
	}

	public static function get_module_slug() {
		return get_module_slug( static::get_module_name() );
	}

	public static function get_module_fragment() {

		$module_slug     = get_module_slug( static::get_module_name() );
		$module_fragment = "/modules/$module_slug/";

		return (string) $module_fragment;

	}

	public static function get_module_svg( string $subpath ) {
		$path    = static::get_module_path( $subpath );
		$content = file_get_contents( $path );
		$svg     = str_replace( '<?xml version="1.0" encoding="UTF-8"?>', '', $content );
		return $svg;
	}

	public static function module_is_enabled() {
		
		$module_key = static::get_module_name();

		$module_is_enabled = (bool) (
			// The module is included in plugin.json…
			array_key_exists( $module_key, CONFIG['modules'] ) 
			&&
			// …the module has a valid configuration value, i.e. an array…
			is_array( CONFIG['modules'][ $module_key ] )
			&&
			// …and the module is not explicitly disabled:
			(
				!array_key_exists( 'disabled', CONFIG['modules'][ $module_key ] )
				||
				!CONFIG['modules'][ $module_key ]['disabled']
			)
			);

			return $module_is_enabled;

	}

	public static function get_module_config( string $config_key = null ) {

		$module_key = static::get_module_name();

		if ( !static::module_is_enabled() ) {
			return new \WP_Error('module-not-enabled');
		}

		// If requesting the complete config:
		if ( empty($config_key) ) {

			return CONFIG['modules'][ $module_key ];

		} else {

			if ( !array_key_exists( $config_key, CONFIG['modules'][ $module_key ] ) ) {
				return new \WP_Error('config-key-not-found');
			}

			return CONFIG['modules'][ $module_key ][ $config_key ];
	
		}

	}

	public static function module_has_config( string $key = null ) {
		return (bool) !is_wp_error( static::get_module_config( $key ) );
	}

	public static function register_fields( $field_group_ids = [] ) {

		$field_group_ids = any_to_array( $field_group_ids );

		if ( !empty($field_group_ids) ) { 

			add_filter( 'acf/settings/load_json', function( $paths ) {

				$paths[] =  static::get_module_path('fields/');

				return $paths;

			});

			foreach ( $field_group_ids as $field_group_id ) {

				add_filter( "acf/settings/save_json/key=$field_group_id", function() {

					$path = static::get_module_path('fields/');

					if ( !file_exists($path) ) mkdir( $path );

					return static::get_module_path('fields/');

				});

			}
		}

	}

	public static function get_field_key( string $field_name ) {

		if ( !array_key_exists( $field_name, static::FIELD_KEYS ) ) {
			return new \WP_Error( 'field-key-not-found' );
		}

		return 'field_' . static::FIELD_KEYS[ $field_name ];

	}

	public static function save_field( $field_name, $field_value, $target_id = null ) {

		$field_key = static::get_field_key( $field_name );

		return update_field( $field_key, $field_value, $target_id );

	}

}
