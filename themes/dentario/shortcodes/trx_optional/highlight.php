<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_highlight_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_highlight_theme_setup' );
	function dentario_sc_highlight_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_highlight_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_highlight_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_highlight id="unique_id" color="fore_color's_name_or_#rrggbb" backcolor="back_color's_name_or_#rrggbb" style="custom_style"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_highlight]
*/

if (!function_exists('dentario_sc_highlight')) {	
	function dentario_sc_highlight($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"color" => "",
			"bg_color" => "",
			"font_size" => "",
			"type" => "1",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		$css .= ($color != '' ? 'color:' . esc_attr($color) . ';' : '')
			.($bg_color != '' ? 'background-color:' . esc_attr($bg_color) . ';' : '')
			.($font_size != '' ? 'font-size:' . esc_attr(dentario_prepare_css_value($font_size)) . '; line-height: 1em;' : '');
		$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_highlight'.($type>0 ? ' sc_highlight_style_'.esc_attr($type) : ''). (!empty($class) ? ' '.esc_attr($class) : '').'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>' 
				. do_shortcode($content) 
				. '</span>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_highlight', $atts, $content);
	}
	dentario_require_shortcode('trx_highlight', 'dentario_sc_highlight');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_highlight_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_highlight_reg_shortcodes');
	function dentario_sc_highlight_reg_shortcodes() {
	
		dentario_sc_map("trx_highlight", array(
			"title" => esc_html__("Highlight text", 'dentario'),
			"desc" => wp_kses_data( __("Highlight text with selected color, background color and other styles", 'dentario') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"type" => array(
					"title" => esc_html__("Type", 'dentario'),
					"desc" => wp_kses_data( __("Highlight type", 'dentario') ),
					"value" => "1",
					"type" => "checklist",
					"options" => array(
						0 => esc_html__('Custom', 'dentario'),
						1 => esc_html__('Type 1', 'dentario'),
						2 => esc_html__('Type 2', 'dentario'),
						3 => esc_html__('Type 3', 'dentario')
					)
				),
				"color" => array(
					"title" => esc_html__("Color", 'dentario'),
					"desc" => wp_kses_data( __("Color for the highlighted text", 'dentario') ),
					"divider" => true,
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'dentario'),
					"desc" => wp_kses_data( __("Background color for the highlighted text", 'dentario') ),
					"value" => "",
					"type" => "color"
				),
				"font_size" => array(
					"title" => esc_html__("Font size", 'dentario'),
					"desc" => wp_kses_data( __("Font size of the highlighted text (default - in pixels, allows any CSS units of measure)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Highlighting content", 'dentario'),
					"desc" => wp_kses_data( __("Content for highlight", 'dentario') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"id" => dentario_get_sc_param('id'),
				"class" => dentario_get_sc_param('class'),
				"css" => dentario_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_highlight_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_highlight_reg_shortcodes_vc');
	function dentario_sc_highlight_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_highlight",
			"name" => esc_html__("Highlight text", 'dentario'),
			"description" => wp_kses_data( __("Highlight text with selected color, background color and other styles", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_highlight',
			"class" => "trx_sc_single trx_sc_highlight",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "type",
					"heading" => esc_html__("Type", 'dentario'),
					"description" => wp_kses_data( __("Highlight type", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
							esc_html__('Custom', 'dentario') => 0,
							esc_html__('Type 1', 'dentario') => 1,
							esc_html__('Type 2', 'dentario') => 2,
							esc_html__('Type 3', 'dentario') => 3
						),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", 'dentario'),
					"description" => wp_kses_data( __("Color for the highlighted text", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'dentario'),
					"description" => wp_kses_data( __("Background color for the highlighted text", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'dentario'),
					"description" => wp_kses_data( __("Font size for the highlighted text (default - in pixels, allows any CSS units of measure)", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Highlight text", 'dentario'),
					"description" => wp_kses_data( __("Content for highlight", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				dentario_get_vc_param('id'),
				dentario_get_vc_param('class'),
				dentario_get_vc_param('css')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Highlight extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>