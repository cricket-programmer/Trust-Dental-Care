<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_number_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_number_theme_setup' );
	function dentario_sc_number_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_number_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_number_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_number id="unique_id" value="400"]
*/

if (!function_exists('dentario_sc_number')) {	
	function dentario_sc_number($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"value" => "",
			"align" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . dentario_get_css_position_as_classes($top, $right, $bottom, $left);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_number' 
					. (!empty($align) ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '') 
					. '"'
				. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>';
		for ($i=0; $i < dentario_strlen($value); $i++) {
			$output .= '<span class="sc_number_item">' . trim(dentario_substr($value, $i, 1)) . '</span>';
		}
		$output .= '</div>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_number', $atts, $content);
	}
	dentario_require_shortcode('trx_number', 'dentario_sc_number');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_number_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_number_reg_shortcodes');
	function dentario_sc_number_reg_shortcodes() {
	
		dentario_sc_map("trx_number", array(
			"title" => esc_html__("Number", 'dentario'),
			"desc" => wp_kses_data( __("Insert number or any word as set separate characters", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"value" => array(
					"title" => esc_html__("Value", 'dentario'),
					"desc" => wp_kses_data( __("Number or any word", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"align" => array(
					"title" => esc_html__("Align", 'dentario'),
					"desc" => wp_kses_data( __("Select block alignment", 'dentario') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => dentario_get_sc_param('align')
				),
				"top" => dentario_get_sc_param('top'),
				"bottom" => dentario_get_sc_param('bottom'),
				"left" => dentario_get_sc_param('left'),
				"right" => dentario_get_sc_param('right'),
				"id" => dentario_get_sc_param('id'),
				"class" => dentario_get_sc_param('class'),
				"animation" => dentario_get_sc_param('animation'),
				"css" => dentario_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_number_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_number_reg_shortcodes_vc');
	function dentario_sc_number_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_number",
			"name" => esc_html__("Number", 'dentario'),
			"description" => wp_kses_data( __("Insert number or any word as set of separated characters", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			"class" => "trx_sc_single trx_sc_number",
			'icon' => 'icon_trx_number',
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "value",
					"heading" => esc_html__("Value", 'dentario'),
					"description" => wp_kses_data( __("Number or any word to separate", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'dentario'),
					"description" => wp_kses_data( __("Select block alignment", 'dentario') ),
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('align')),
					"type" => "dropdown"
				),
				dentario_get_vc_param('id'),
				dentario_get_vc_param('class'),
				dentario_get_vc_param('animation'),
				dentario_get_vc_param('css'),
				dentario_get_vc_param('margin_top'),
				dentario_get_vc_param('margin_bottom'),
				dentario_get_vc_param('margin_left'),
				dentario_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Number extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>