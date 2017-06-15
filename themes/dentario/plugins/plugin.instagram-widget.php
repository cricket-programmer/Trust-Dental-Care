<?php
/* Instagram Widget support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('dentario_instagram_widget_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_instagram_widget_theme_setup', 1 );
	function dentario_instagram_widget_theme_setup() {
		if (dentario_exists_instagram_widget()) {
			add_action( 'dentario_action_add_styles', 						'dentario_instagram_widget_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'dentario_filter_importer_required_plugins',		'dentario_instagram_widget_importer_required_plugins', 10, 2 );
			add_filter( 'dentario_filter_required_plugins',					'dentario_instagram_widget_required_plugins' );
		}
	}
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'dentario_exists_instagram_widget' ) ) {
	function dentario_exists_instagram_widget() {
		return function_exists('wpiw_init');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'dentario_instagram_widget_required_plugins' ) ) {
	//add_filter('dentario_filter_required_plugins',	'dentario_instagram_widget_required_plugins');
	function dentario_instagram_widget_required_plugins($list=array()) {
		if (in_array('instagram_widget', dentario_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> 'Instagram Widget',
					'slug' 		=> 'wp-instagram-widget',
					'required' 	=> false
				);
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'dentario_instagram_widget_frontend_scripts' ) ) {
	//add_action( 'dentario_action_add_styles', 'dentario_instagram_widget_frontend_scripts' );
	function dentario_instagram_widget_frontend_scripts() {
		if (file_exists(dentario_get_file_dir('css/plugin.instagram-widget.css')))
			dentario_enqueue_style( 'dentario-plugin.instagram-widget-style',  dentario_get_file_url('css/plugin.instagram-widget.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Instagram Widget in the required plugins
if ( !function_exists( 'dentario_instagram_widget_importer_required_plugins' ) ) {
	//add_filter( 'dentario_filter_importer_required_plugins',	'dentario_instagram_widget_importer_required_plugins', 10, 2 );
	function dentario_instagram_widget_importer_required_plugins($not_installed='', $list='') {
		//if (in_array('instagram_widget', dentario_storage_get('required_plugins')) && !dentario_exists_instagram_widget() )
		if (dentario_strpos($list, 'instagram_widget')!==false && !dentario_exists_instagram_widget() )
			$not_installed .= '<br>WP Instagram Widget';
		return $not_installed;
	}
}
?>