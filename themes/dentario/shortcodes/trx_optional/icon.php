<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_icon_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_icon_theme_setup' );
	function dentario_sc_icon_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_icon_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_icon_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_icon id="unique_id" style='round|square' icon='' color="" bg_color="" size="" weight=""]
*/

if (!function_exists('dentario_sc_icon')) {	
	function dentario_sc_icon($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			"bg_shape" => "",
			"font_size" => "",
			"font_weight" => "",
			"align" => "",
			"link" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . dentario_get_css_position_as_classes($top, $right, $bottom, $left);
		$css2 = ($font_weight != '' && !dentario_is_inherit_option($font_weight) ? 'font-weight:'. esc_attr($font_weight).';' : '')
			. ($font_size != '' ? 'font-size:' . esc_attr(dentario_prepare_css_value($font_size)) . '; line-height: ' . (!$bg_shape || dentario_param_is_inherit($bg_shape) ? '1' : '1.2') . 'em;' : '')
			. ($color != '' ? 'color:'.esc_attr($color).';' : '')
			. ($bg_color != '' ? 'background-color:'.esc_attr($bg_color).';border-color:'.esc_attr($bg_color).';' : '')
		;
		$output = $icon!='' 
			? ($link ? '<a href="'.esc_url($link).'"' : '<span') . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_icon '.esc_attr($icon)
					. ($bg_shape && !dentario_param_is_inherit($bg_shape) ? ' sc_icon_shape_'.esc_attr($bg_shape) : '')
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '')
				.'"'
				.($css || $css2 ? ' style="'.($class ? 'display:block;' : '') . ($css) . ($css2) . '"' : '')
				.'>'
				.($link ? '</a>' : '</span>')
			: '';
		return apply_filters('dentario_shortcode_output', $output, 'trx_icon', $atts, $content);
	}
	dentario_require_shortcode('trx_icon', 'dentario_sc_icon');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_icon_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_icon_reg_shortcodes');
	function dentario_sc_icon_reg_shortcodes() {
	
		dentario_sc_map("trx_icon", array(
			"title" => esc_html__("Icon", 'dentario'),
			"desc" => wp_kses_data( __("Insert icon", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"icon" => array(
					"title" => esc_html__('Icon',  'dentario'),
					"desc" => wp_kses_data( __('Select font icon from the Fontello icons set',  'dentario') ),
					"value" => "",
					"type" => "icons",
					"options" => dentario_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Icon's color", 'dentario'),
					"desc" => wp_kses_data( __("Icon's color", 'dentario') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "color"
				),
				"bg_shape" => array(
					"title" => esc_html__("Background shape", 'dentario'),
					"desc" => wp_kses_data( __("Shape of the icon background", 'dentario') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "none",
					"type" => "radio",
					"options" => array(
						'none' => esc_html__('None', 'dentario'),
						'round' => esc_html__('Round', 'dentario'),
						'square' => esc_html__('Square', 'dentario')
					)
				),
				"bg_color" => array(
					"title" => esc_html__("Icon's background color", 'dentario'),
					"desc" => wp_kses_data( __("Icon's background color", 'dentario') ),
					"dependency" => array(
						'icon' => array('not_empty'),
						'background' => array('round','square')
					),
					"value" => "",
					"type" => "color"
				),
				"font_size" => array(
					"title" => esc_html__("Font size", 'dentario'),
					"desc" => wp_kses_data( __("Icon's font size", 'dentario') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "spinner",
					"min" => 8,
					"max" => 240
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", 'dentario'),
					"desc" => wp_kses_data( __("Icon font weight", 'dentario') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'100' => esc_html__('Thin (100)', 'dentario'),
						'300' => esc_html__('Light (300)', 'dentario'),
						'400' => esc_html__('Normal (400)', 'dentario'),
						'700' => esc_html__('Bold (700)', 'dentario')
					)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'dentario'),
					"desc" => wp_kses_data( __("Icon text alignment", 'dentario') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => dentario_get_sc_param('align')
				), 
				"link" => array(
					"title" => esc_html__("Link URL", 'dentario'),
					"desc" => wp_kses_data( __("Link URL from this icon (if not empty)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"top" => dentario_get_sc_param('top'),
				"bottom" => dentario_get_sc_param('bottom'),
				"left" => dentario_get_sc_param('left'),
				"right" => dentario_get_sc_param('right'),
				"id" => dentario_get_sc_param('id'),
				"class" => dentario_get_sc_param('class'),
				"css" => dentario_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_icon_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_icon_reg_shortcodes_vc');
	function dentario_sc_icon_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_icon",
			"name" => esc_html__("Icon", 'dentario'),
			"description" => wp_kses_data( __("Insert the icon", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_icon',
			"class" => "trx_sc_single trx_sc_icon",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Icon", 'dentario'),
					"description" => wp_kses_data( __("Select icon class from Fontello icons set", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => dentario_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", 'dentario'),
					"description" => wp_kses_data( __("Icon's color", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'dentario'),
					"description" => wp_kses_data( __("Background color for the icon", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_shape",
					"heading" => esc_html__("Background shape", 'dentario'),
					"description" => wp_kses_data( __("Shape of the icon background", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('None', 'dentario') => 'none',
						esc_html__('Round', 'dentario') => 'round',
						esc_html__('Square', 'dentario') => 'square'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'dentario'),
					"description" => wp_kses_data( __("Icon's font size", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", 'dentario'),
					"description" => wp_kses_data( __("Icon's font weight", 'dentario') ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'dentario') => 'inherit',
						esc_html__('Thin (100)', 'dentario') => '100',
						esc_html__('Light (300)', 'dentario') => '300',
						esc_html__('Normal (400)', 'dentario') => '400',
						esc_html__('Bold (700)', 'dentario') => '700'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Icon's alignment", 'dentario'),
					"description" => wp_kses_data( __("Align icon to left, center or right", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'dentario'),
					"description" => wp_kses_data( __("Link URL from this icon (if not empty)", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				dentario_get_vc_param('id'),
				dentario_get_vc_param('class'),
				dentario_get_vc_param('css'),
				dentario_get_vc_param('margin_top'),
				dentario_get_vc_param('margin_bottom'),
				dentario_get_vc_param('margin_left'),
				dentario_get_vc_param('margin_right')
			),
		) );
		
		class WPBakeryShortCode_Trx_Icon extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>