<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_infobox_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_infobox_theme_setup' );
	function dentario_sc_infobox_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_infobox_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_infobox_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_infobox id="unique_id" style="regular|info|success|error|result" static="0|1"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_infobox]
*/

if (!function_exists('dentario_sc_infobox')) {	
	function dentario_sc_infobox($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "regular",
			"closeable" => "no",
			"icon" => "",
			"color" => "",
			"bg_color" => "",
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
		$css .= ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
			. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) .';' : '');
		if (empty($icon)) {
			if ($icon=='none')
				$icon = '';
			else if ($style=='regular')
				$icon = 'icon-cog';
			else if ($style=='success')
				$icon = 'icon-check';
			else if ($style=='error')
				$icon = 'icon-attention';
			else if ($style=='info')
				$icon = 'icon-info';
		}
		$content = do_shortcode($content);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_infobox sc_infobox_style_' . esc_attr($style) 
					. (dentario_param_is_on($closeable) ? ' sc_infobox_closeable' : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '') 
					. ($icon!='' && !dentario_param_is_inherit($icon) ? ' sc_infobox_iconed '. esc_attr($icon) : '') 
					. '"'
				. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>'
				. trim($content)
				. '</div>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_infobox', $atts, $content);
	}
	dentario_require_shortcode('trx_infobox', 'dentario_sc_infobox');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_infobox_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_infobox_reg_shortcodes');
	function dentario_sc_infobox_reg_shortcodes() {
	
		dentario_sc_map("trx_infobox", array(
			"title" => esc_html__("Infobox", 'dentario'),
			"desc" => wp_kses_data( __("Insert infobox into your post (page)", 'dentario') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", 'dentario'),
					"desc" => wp_kses_data( __("Infobox style", 'dentario') ),
					"value" => "regular",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => array(
						'regular' => esc_html__('Regular', 'dentario'),
						'info' => esc_html__('Info', 'dentario'),
						'success' => esc_html__('Success', 'dentario'),
						'error' => esc_html__('Error', 'dentario')
					)
				),
				"closeable" => array(
					"title" => esc_html__("Closeable box", 'dentario'),
					"desc" => wp_kses_data( __("Create closeable box (with close button)", 'dentario') ),
					"value" => "no",
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				),
				"icon" => array(
					"title" => esc_html__("Custom icon",  'dentario'),
					"desc" => wp_kses_data( __('Select icon for the infobox from Fontello icons set. If empty - use default icon',  'dentario') ),
					"value" => "",
					"type" => "icons",
					"options" => dentario_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Text color", 'dentario'),
					"desc" => wp_kses_data( __("Any color for text and headers", 'dentario') ),
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'dentario'),
					"desc" => wp_kses_data( __("Any background color for this infobox", 'dentario') ),
					"value" => "",
					"type" => "color"
				),
				"_content_" => array(
					"title" => esc_html__("Infobox content", 'dentario'),
					"desc" => wp_kses_data( __("Content for infobox", 'dentario') ),
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
				"animation" => dentario_get_sc_param('animation'),
				"css" => dentario_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_infobox_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_infobox_reg_shortcodes_vc');
	function dentario_sc_infobox_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_infobox",
			"name" => esc_html__("Infobox", 'dentario'),
			"description" => wp_kses_data( __("Box with info or error message", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_infobox',
			"class" => "trx_sc_container trx_sc_infobox",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", 'dentario'),
					"description" => wp_kses_data( __("Infobox style", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
							esc_html__('Regular', 'dentario') => 'regular',
							esc_html__('Info', 'dentario') => 'info',
							esc_html__('Success', 'dentario') => 'success',
							esc_html__('Error', 'dentario') => 'error',
							esc_html__('Result', 'dentario') => 'result'
						),
					"type" => "dropdown"
				),
				array(
					"param_name" => "closeable",
					"heading" => esc_html__("Closeable", 'dentario'),
					"description" => wp_kses_data( __("Create closeable box (with close button)", 'dentario') ),
					"class" => "",
					"value" => array(esc_html__('Close button', 'dentario') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Custom icon", 'dentario'),
					"description" => wp_kses_data( __("Select icon for the infobox from Fontello icons set. If empty - use default icon", 'dentario') ),
					"class" => "",
					"value" => dentario_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", 'dentario'),
					"description" => wp_kses_data( __("Any color for the text and headers", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'dentario'),
					"description" => wp_kses_data( __("Any background color for this infobox", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				dentario_get_vc_param('id'),
				dentario_get_vc_param('class'),
				dentario_get_vc_param('animation'),
				dentario_get_vc_param('css'),
				dentario_get_vc_param('margin_top'),
				dentario_get_vc_param('margin_bottom'),
				dentario_get_vc_param('margin_left'),
				dentario_get_vc_param('margin_right')
			),
			'js_view' => 'VcTrxTextContainerView'
		) );
		
		class WPBakeryShortCode_Trx_Infobox extends DENTARIO_VC_ShortCodeContainer {}
	}
}
?>