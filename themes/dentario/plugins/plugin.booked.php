<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('dentario_booked_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_booked_theme_setup', 1 );
	function dentario_booked_theme_setup() {
		// Register shortcode in the shortcodes list
		if (dentario_exists_booked()) {
			add_action('dentario_action_add_styles', 					'dentario_booked_frontend_scripts');
			add_action('dentario_action_shortcodes_list',				'dentario_booked_reg_shortcodes');
			if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
				add_action('dentario_action_shortcodes_list_vc',		'dentario_booked_reg_shortcodes_vc');
			if (is_admin()) {
				add_filter( 'dentario_filter_importer_options',			'dentario_booked_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'dentario_filter_importer_required_plugins',	'dentario_booked_importer_required_plugins', 10, 2);
			add_filter( 'dentario_filter_required_plugins',				'dentario_booked_required_plugins' );
		}
	}
}


// Check if plugin installed and activated
if ( !function_exists( 'dentario_exists_booked' ) ) {
	function dentario_exists_booked() {
		return class_exists('booked_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'dentario_booked_required_plugins' ) ) {
	//add_filter('dentario_filter_required_plugins',	'dentario_booked_required_plugins');
	function dentario_booked_required_plugins($list=array()) {
		if (in_array('booked', dentario_storage_get('required_plugins'))) {
			$path = dentario_get_file_dir('plugins/install/booked.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> 'Booked',
					'slug' 		=> 'booked',
					'source'	=> $path,
					'required' 	=> false
					);
			}
		}
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'dentario_booked_frontend_scripts' ) ) {
	//add_action( 'dentario_action_add_styles', 'dentario_booked_frontend_scripts' );
	function dentario_booked_frontend_scripts() {
		if (file_exists(dentario_get_file_dir('css/plugin.booked.css')))
			dentario_enqueue_style( 'dentario-plugin.booked-style',  dentario_get_file_url('css/plugin.booked.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check in the required plugins
if ( !function_exists( 'dentario_booked_importer_required_plugins' ) ) {
	//add_filter( 'dentario_filter_importer_required_plugins',	'dentario_booked_importer_required_plugins', 10, 2);
	function dentario_booked_importer_required_plugins($not_installed='', $list='') {
		if (dentario_strpos($list, 'booked')!==false && !dentario_exists_booked() )
			$not_installed .= '<br>Booked Appointments';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'dentario_booked_importer_set_options' ) ) {
	//add_filter( 'dentario_filter_importer_options',	'dentario_booked_importer_set_options', 10, 1 );
	function dentario_booked_importer_set_options($options=array()) {
		if (in_array('booked', dentario_storage_get('required_plugins')) && dentario_exists_booked()) {
			$options['additional_options'][] = 'booked_%';		// Add slugs to export options for this plugin
		}
		return $options;
	}
}


// Lists
//------------------------------------------------------------------------

// Return booked calendars list, prepended inherit (if need)
if ( !function_exists( 'dentario_get_list_booked_calendars' ) ) {
	function dentario_get_list_booked_calendars($prepend_inherit=false) {
		return dentario_exists_booked() ? dentario_get_list_terms($prepend_inherit, 'booked_custom_calendars') : array();
	}
}



// Register plugin's shortcodes
//------------------------------------------------------------------------

// Register shortcode in the shortcodes list
if (!function_exists('dentario_booked_reg_shortcodes')) {
	//add_filter('dentario_action_shortcodes_list',	'dentario_booked_reg_shortcodes');
	function dentario_booked_reg_shortcodes() {
		if (dentario_storage_isset('shortcodes')) {

			$booked_cals = dentario_get_list_booked_calendars();

			dentario_sc_map('booked-appointments', array(
				"title" => esc_html__("Booked Appointments", 'dentario'),
				"desc" => esc_html__("Display the currently logged in user's upcoming appointments", 'dentario'),
				"decorate" => true,
				"container" => false,
				"params" => array()
				)
			);

			dentario_sc_map('booked-calendar', array(
				"title" => esc_html__("Booked Calendar", 'dentario'),
				"desc" => esc_html__("Insert booked calendar", 'dentario'),
				"decorate" => true,
				"container" => false,
				"params" => array(
					"calendar" => array(
						"title" => esc_html__("Calendar", 'dentario'),
						"desc" => esc_html__("Select booked calendar to display", 'dentario'),
						"value" => "0",
						"type" => "select",
						"options" => dentario_array_merge(array(0 => esc_html__('- Select calendar -', 'dentario')), $booked_cals)
					),
					"year" => array(
						"title" => esc_html__("Year", 'dentario'),
						"desc" => esc_html__("Year to display on calendar by default", 'dentario'),
						"value" => date("Y"),
						"min" => date("Y"),
						"max" => date("Y")+10,
						"type" => "spinner"
					),
					"month" => array(
						"title" => esc_html__("Month", 'dentario'),
						"desc" => esc_html__("Month to display on calendar by default", 'dentario'),
						"value" => date("m"),
						"min" => 1,
						"max" => 12,
						"type" => "spinner"
					)
				)
			));
		}
	}
}


// Register shortcode in the VC shortcodes list
if (!function_exists('dentario_booked_reg_shortcodes_vc')) {
	//add_filter('dentario_action_shortcodes_list_vc',	'dentario_booked_reg_shortcodes_vc');
	function dentario_booked_reg_shortcodes_vc() {

		$booked_cals = dentario_get_list_booked_calendars();

		// Booked Appointments
		vc_map( array(
				"base" => "booked-appointments",
				"name" => esc_html__("Booked Appointments", 'dentario'),
				"description" => esc_html__("Display the currently logged in user's upcoming appointments", 'dentario'),
				"category" => esc_html__('Content', 'dentario'),
				'icon' => 'icon_trx_booked',
				"class" => "trx_sc_single trx_sc_booked_appointments",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array()
			) );
			
		class WPBakeryShortCode_Booked_Appointments extends DENTARIO_VC_ShortCodeSingle {}

		// Booked Calendar
		vc_map( array(
				"base" => "booked-calendar",
				"name" => esc_html__("Booked Calendar", 'dentario'),
				"description" => esc_html__("Insert booked calendar", 'dentario'),
				"category" => esc_html__('Content', 'dentario'),
				'icon' => 'icon_trx_booked',
				"class" => "trx_sc_single trx_sc_booked_calendar",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "calendar",
						"heading" => esc_html__("Calendar", 'dentario'),
						"description" => esc_html__("Select booked calendar to display", 'dentario'),
						"admin_label" => true,
						"class" => "",
						"std" => "0",
						"value" => array_flip(dentario_array_merge(array(0 => esc_html__('- Select calendar -', 'dentario')), $booked_cals)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "year",
						"heading" => esc_html__("Year", 'dentario'),
						"description" => esc_html__("Year to display on calendar by default", 'dentario'),
						"admin_label" => true,
						"class" => "",
						"std" => date("Y"),
						"value" => date("Y"),
						"type" => "textfield"
					),
					array(
						"param_name" => "month",
						"heading" => esc_html__("Month", 'dentario'),
						"description" => esc_html__("Month to display on calendar by default", 'dentario'),
						"admin_label" => true,
						"class" => "",
						"std" => date("m"),
						"value" => date("m"),
						"type" => "textfield"
					)
				)
			) );
			
		class WPBakeryShortCode_Booked_Calendar extends DENTARIO_VC_ShortCodeSingle {}

	}
}
?>