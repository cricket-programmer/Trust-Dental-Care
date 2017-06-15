<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_popup_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_popup_theme_setup' );
	function dentario_sc_popup_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_popup_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_popup_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_popup id="unique_id" class="class_name" style="css_styles"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_popup]
*/

if (!function_exists('dentario_sc_popup')) {	
	function dentario_sc_popup($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
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
		dentario_enqueue_popup('magnific');
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_popup mfp-with-anim mfp-hide' . ($class ? ' '.esc_attr($class) : '') . '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>' 
				. do_shortcode($content) 
				. '</div>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_popup', $atts, $content);
	}
	dentario_require_shortcode('trx_popup', 'dentario_sc_popup');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_popup_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_popup_reg_shortcodes');
	function dentario_sc_popup_reg_shortcodes() {
	
		dentario_sc_map("trx_popup", array(
			"title" => esc_html__("Popup window", 'dentario'),
			"desc" => wp_kses_data( __("Container for any html-block with desired class and style for popup window", 'dentario') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Container content", 'dentario'),
					"desc" => wp_kses_data( __("Content for section container", 'dentario') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
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
if ( !function_exists( 'dentario_sc_popup_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_popup_reg_shortcodes_vc');
	function dentario_sc_popup_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_popup",
			"name" => esc_html__("Popup window", 'dentario'),
			"description" => wp_kses_data( __("Container for any html-block with desired class and style for popup window", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_popup',
			"class" => "trx_sc_collection trx_sc_popup",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				dentario_get_vc_param('id'),
				dentario_get_vc_param('class'),
				dentario_get_vc_param('css'),
				dentario_get_vc_param('margin_top'),
				dentario_get_vc_param('margin_bottom'),
				dentario_get_vc_param('margin_left'),
				dentario_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Popup extends DENTARIO_VC_ShortCodeCollection {}
	}
}
?>