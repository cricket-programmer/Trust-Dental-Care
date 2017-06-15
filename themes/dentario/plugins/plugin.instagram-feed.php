<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('dentario_instagram_feed_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_instagram_feed_theme_setup', 1 );
	function dentario_instagram_feed_theme_setup() {
		if (dentario_exists_instagram_feed()) {
			if (is_admin()) {
				add_filter( 'dentario_filter_importer_options',				'dentario_instagram_feed_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'dentario_filter_importer_required_plugins',		'dentario_instagram_feed_importer_required_plugins', 10, 2 );
			add_filter( 'dentario_filter_required_plugins',					'dentario_instagram_feed_required_plugins' );
		}
	}
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'dentario_exists_instagram_feed' ) ) {
	function dentario_exists_instagram_feed() {
		return defined('SBIVER');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'dentario_instagram_feed_required_plugins' ) ) {
	//add_filter('dentario_filter_required_plugins',	'dentario_instagram_feed_required_plugins');
	function dentario_instagram_feed_required_plugins($list=array()) {
		if (in_array('instagram_feed', dentario_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> 'Instagram Feed',
					'slug' 		=> 'instagram-feed',
					'required' 	=> false
				);
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Instagram Feed in the required plugins
if ( !function_exists( 'dentario_instagram_feed_importer_required_plugins' ) ) {
	//add_filter( 'dentario_filter_importer_required_plugins',	'dentario_instagram_feed_importer_required_plugins', 10, 2 );
	function dentario_instagram_feed_importer_required_plugins($not_installed='', $list='') {
		//if (in_array('instagram_feed', dentario_storage_get('required_plugins')) && !dentario_exists_instagram_feed() )
		if (dentario_strpos($list, 'instagram_feed')!==false && !dentario_exists_instagram_feed() )
			$not_installed .= '<br>Instagram Feed';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'dentario_instagram_feed_importer_set_options' ) ) {
	//add_filter( 'dentario_filter_importer_options',	'dentario_instagram_feed_importer_set_options' );
	function dentario_instagram_feed_importer_set_options($options=array()) {
		if ( in_array('instagram_feed', dentario_storage_get('required_plugins')) && dentario_exists_instagram_feed() ) {
			$options['additional_options'][] = 'sb_instagram_settings';		// Add slugs to export options for this plugin
		}
		return $options;
	}
}
?>