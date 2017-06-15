<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_anchor_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_anchor_theme_setup' );
	function dentario_sc_anchor_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_anchor_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_anchor_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_anchor id="unique_id" description="Anchor description" title="Short Caption" icon="icon-class"]
*/

if (!function_exists('dentario_sc_anchor')) {	
	function dentario_sc_anchor($atts, $content = null) {
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"description" => '',
			"icon" => '',
			"url" => "",
			"separator" => "no",
			// Common params
			"id" => ""
		), $atts)));
		$output = $id 
			? '<a id="'.esc_attr($id).'"'
				. ' class="sc_anchor"' 
				. ' title="' . ($title ? esc_attr($title) : '') . '"'
				. ' data-description="' . ($description ? esc_attr(dentario_strmacros($description)) : ''). '"'
				. ' data-icon="' . ($icon ? $icon : '') . '"' 
				. ' data-url="' . ($url ? esc_attr($url) : '') . '"' 
				. ' data-separator="' . (dentario_param_is_on($separator) ? 'yes' : 'no') . '"'
				. '></a>'
			: '';
		return apply_filters('dentario_shortcode_output', $output, 'trx_anchor', $atts, $content);
	}
	dentario_require_shortcode("trx_anchor", "dentario_sc_anchor");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_anchor_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_anchor_reg_shortcodes');
	function dentario_sc_anchor_reg_shortcodes() {
	
		dentario_sc_map("trx_anchor", array(
			"title" => esc_html__("Anchor", 'dentario'),
			"desc" => wp_kses_data( __("Insert anchor for the TOC (table of content)", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"icon" => array(
					"title" => esc_html__("Anchor's icon",  'dentario'),
					"desc" => wp_kses_data( __('Select icon for the anchor from Fontello icons set',  'dentario') ),
					"value" => "",
					"type" => "icons",
					"options" => dentario_get_sc_param('icons')
				),
				"title" => array(
					"title" => esc_html__("Short title", 'dentario'),
					"desc" => wp_kses_data( __("Short title of the anchor (for the table of content)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"description" => array(
					"title" => esc_html__("Long description", 'dentario'),
					"desc" => wp_kses_data( __("Description for the popup (then hover on the icon). You can use:<br>'{{' and '}}' - to make the text italic,<br>'((' and '))' - to make the text bold,<br>'||' - to insert line break", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"url" => array(
					"title" => esc_html__("External URL", 'dentario'),
					"desc" => wp_kses_data( __("External URL for this TOC item", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"separator" => array(
					"title" => esc_html__("Add separator", 'dentario'),
					"desc" => wp_kses_data( __("Add separator under item in the TOC", 'dentario') ),
					"value" => "no",
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				),
				"id" => dentario_get_sc_param('id')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_anchor_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_anchor_reg_shortcodes_vc');
	function dentario_sc_anchor_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_anchor",
			"name" => esc_html__("Anchor", 'dentario'),
			"description" => wp_kses_data( __("Insert anchor for the TOC (table of content)", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_anchor',
			"class" => "trx_sc_single trx_sc_anchor",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Anchor's icon", 'dentario'),
					"description" => wp_kses_data( __("Select icon for the anchor from Fontello icons set", 'dentario') ),
					"class" => "",
					"value" => dentario_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Short title", 'dentario'),
					"description" => wp_kses_data( __("Short title of the anchor (for the table of content)", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Long description", 'dentario'),
					"description" => wp_kses_data( __("Description for the popup (then hover on the icon). You can use:<br>'{{' and '}}' - to make the text italic,<br>'((' and '))' - to make the text bold,<br>'||' - to insert line break", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("External URL", 'dentario'),
					"description" => wp_kses_data( __("External URL for this TOC item", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "separator",
					"heading" => esc_html__("Add separator", 'dentario'),
					"description" => wp_kses_data( __("Add separator under item in the TOC", 'dentario') ),
					"class" => "",
					"value" => array("Add separator" => "yes" ),
					"type" => "checkbox"
				),
				dentario_get_vc_param('id')
			),
		) );
		
		class WPBakeryShortCode_Trx_Anchor extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>