<?php

// Check if shortcodes settings are now used
if ( !function_exists( 'dentario_shortcodes_is_used' ) ) {
	function dentario_shortcodes_is_used() {
		return dentario_options_is_used() 															// All modes when Theme Options are used
			|| (is_admin() && isset($_POST['action']) 
					&& in_array($_POST['action'], array('vc_edit_form', 'wpb_show_edit_form')))		// AJAX query when save post/page
			|| (is_admin() && dentario_strpos($_SERVER['REQUEST_URI'], 'vc-roles')!==false)			// VC Role Manager
			|| (function_exists('dentario_vc_is_frontend') && dentario_vc_is_frontend());			// VC Frontend editor mode
	}
}

// Width and height params
if ( !function_exists( 'dentario_shortcodes_width' ) ) {
	function dentario_shortcodes_width($w="") {
		return array(
			"title" => esc_html__("Width", 'dentario'),
			"divider" => true,
			"value" => $w,
			"type" => "text"
		);
	}
}
if ( !function_exists( 'dentario_shortcodes_height' ) ) {
	function dentario_shortcodes_height($h='') {
		return array(
			"title" => esc_html__("Height", 'dentario'),
			"desc" => wp_kses_data( __("Width and height of the element", 'dentario') ),
			"value" => $h,
			"type" => "text"
		);
	}
}

// Return sc_param value
if ( !function_exists( 'dentario_get_sc_param' ) ) {
	function dentario_get_sc_param($prm) {
		return dentario_storage_get_array('sc_params', $prm);
	}
}

// Set sc_param value
if ( !function_exists( 'dentario_set_sc_param' ) ) {
	function dentario_set_sc_param($prm, $val) {
		dentario_storage_set_array('sc_params', $prm, $val);
	}
}

// Add sc settings in the sc list
if ( !function_exists( 'dentario_sc_map' ) ) {
	function dentario_sc_map($sc_name, $sc_settings) {
		dentario_storage_set_array('shortcodes', $sc_name, $sc_settings);
	}
}

// Add sc settings in the sc list after the key
if ( !function_exists( 'dentario_sc_map_after' ) ) {
	function dentario_sc_map_after($after, $sc_name, $sc_settings='') {
		dentario_storage_set_array_after('shortcodes', $after, $sc_name, $sc_settings);
	}
}

// Add sc settings in the sc list before the key
if ( !function_exists( 'dentario_sc_map_before' ) ) {
	function dentario_sc_map_before($before, $sc_name, $sc_settings='') {
		dentario_storage_set_array_before('shortcodes', $before, $sc_name, $sc_settings);
	}
}

// Compare two shortcodes by title
if ( !function_exists( 'dentario_compare_sc_title' ) ) {
	function dentario_compare_sc_title($a, $b) {
		return strcmp($a['title'], $b['title']);
	}
}



/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_shortcodes_settings_theme_setup' ) ) {
//	if ( dentario_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'dentario_action_before_init_theme', 'dentario_shortcodes_settings_theme_setup', 20 );
	else
		add_action( 'dentario_action_after_init_theme', 'dentario_shortcodes_settings_theme_setup' );
	function dentario_shortcodes_settings_theme_setup() {
		if (dentario_shortcodes_is_used()) {

			// Sort templates alphabetically
			$tmp = dentario_storage_get('registered_templates');
			ksort($tmp);
			dentario_storage_set('registered_templates', $tmp);

			// Prepare arrays 
			dentario_storage_set('sc_params', array(
			
				// Current element id
				'id' => array(
					"title" => esc_html__("Element ID", 'dentario'),
					"desc" => wp_kses_data( __("ID for current element", 'dentario') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				// Current element class
				'class' => array(
					"title" => esc_html__("Element CSS class", 'dentario'),
					"desc" => wp_kses_data( __("CSS class for current element (optional)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
			
				// Current element style
				'css' => array(
					"title" => esc_html__("CSS styles", 'dentario'),
					"desc" => wp_kses_data( __("Any additional CSS rules (if need)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
			
			
				// Switcher choises
				'list_styles' => array(
					'ul'	=> esc_html__('Unordered', 'dentario'),
					'ol'	=> esc_html__('Ordered', 'dentario'),
					'iconed'=> esc_html__('Iconed', 'dentario')
				),

				'yes_no'	=> dentario_get_list_yesno(),
				'on_off'	=> dentario_get_list_onoff(),
				'dir' 		=> dentario_get_list_directions(),
				'align'		=> dentario_get_list_alignments(),
				'float'		=> dentario_get_list_floats(),
				'hpos'		=> dentario_get_list_hpos(),
				'show_hide'	=> dentario_get_list_showhide(),
				'sorting' 	=> dentario_get_list_sortings(),
				'ordering' 	=> dentario_get_list_orderings(),
				'shapes'	=> dentario_get_list_shapes(),
				'sizes'		=> dentario_get_list_sizes(),
				'sliders'	=> dentario_get_list_sliders(),
				'controls'	=> dentario_get_list_controls(),
				'categories'=> dentario_get_list_categories(),
				'columns'	=> dentario_get_list_columns(),
				'images'	=> array_merge(array('none'=>"none"), dentario_get_list_files("images/icons", "png")),
				'icons'		=> array_merge(array("inherit", "none"), dentario_get_list_icons()),
				'locations'	=> dentario_get_list_dedicated_locations(),
				'filters'	=> dentario_get_list_portfolio_filters(),
				'formats'	=> dentario_get_list_post_formats_filters(),
				'hovers'	=> dentario_get_list_hovers(true),
				'hovers_dir'=> dentario_get_list_hovers_directions(true),
				'schemes'	=> dentario_get_list_color_schemes(true),
				'animations'		=> dentario_get_list_animations_in(),
				'margins' 			=> dentario_get_list_margins(true),
				'blogger_styles'	=> dentario_get_list_templates_blogger(),
				'forms'				=> dentario_get_list_templates_forms(),
				'posts_types'		=> dentario_get_list_posts_types(),
				'googlemap_styles'	=> dentario_get_list_googlemap_styles(),
				'field_types'		=> dentario_get_list_field_types(),
				'label_positions'	=> dentario_get_list_label_positions()
				)
			);

			// Common params
			dentario_set_sc_param('animation', array(
				"title" => esc_html__("Animation",  'dentario'),
				"desc" => wp_kses_data( __('Select animation while object enter in the visible area of page',  'dentario') ),
				"value" => "none",
				"type" => "select",
				"options" => dentario_get_sc_param('animations')
				)
			);
			dentario_set_sc_param('top', array(
				"title" => esc_html__("Top margin",  'dentario'),
				"divider" => true,
				"value" => "inherit",
				"type" => "select",
				"options" => dentario_get_sc_param('margins')
				)
			);
			dentario_set_sc_param('bottom', array(
				"title" => esc_html__("Bottom margin",  'dentario'),
				"value" => "inherit",
				"type" => "select",
				"options" => dentario_get_sc_param('margins')
				)
			);
			dentario_set_sc_param('left', array(
				"title" => esc_html__("Left margin",  'dentario'),
				"value" => "inherit",
				"type" => "select",
				"options" => dentario_get_sc_param('margins')
				)
			);
			dentario_set_sc_param('right', array(
				"title" => esc_html__("Right margin",  'dentario'),
				"desc" => wp_kses_data( __("Margins around this shortcode", 'dentario') ),
				"value" => "inherit",
				"type" => "select",
				"options" => dentario_get_sc_param('margins')
				)
			);

			dentario_storage_set('sc_params', apply_filters('dentario_filter_shortcodes_params', dentario_storage_get('sc_params')));

			// Shortcodes list
			//------------------------------------------------------------------
			dentario_storage_set('shortcodes', array());
			
			// Register shortcodes
			do_action('dentario_action_shortcodes_list');

			// Sort shortcodes list
			$tmp = dentario_storage_get('shortcodes');
			uasort($tmp, 'dentario_compare_sc_title');
			dentario_storage_set('shortcodes', $tmp);
		}
	}
}
?>