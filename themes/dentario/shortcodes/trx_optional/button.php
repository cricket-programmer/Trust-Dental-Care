<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_button_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_button_theme_setup' );
	function dentario_sc_button_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_button_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_button_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_button id="unique_id" type="square|round" fullsize="0|1" style="global|light|dark" size="mini|medium|big|huge|banner" icon="icon-name" link='#' target='']Button caption[/trx_button]
*/

if (!function_exists('dentario_sc_button')) {	
	function dentario_sc_button($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "square",
			"style" => "filled",
			"size" => "small",
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			"link" => "",
			"target" => "",
			"align" => "",
			"rel" => "",
			"popup" => "no",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . dentario_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= dentario_get_css_dimensions_from_values($width, $height)
			. ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
			. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) . '; border-color:'. esc_attr($bg_color) .';' : '');
		if (dentario_param_is_on($popup)) dentario_enqueue_popup('magnific');
		$output = '<a href="' . (empty($link) ? '#' : $link) . '"'
			. (!empty($target) ? ' target="'.esc_attr($target).'"' : '')
			. (!empty($rel) ? ' rel="'.esc_attr($rel).'"' : '')
			. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
			. ' class="sc_button sc_button_' . esc_attr($type) 
					. ' sc_button_style_' . esc_attr($style) 
					. ' sc_button_size_' . esc_attr($size)
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($icon!='' ? '  sc_button_iconed '. esc_attr($icon) : '') 
					. (dentario_param_is_on($popup) ? ' sc_popup_link' : '') 
					. '"'
			. ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
			. do_shortcode($content)
			. '</a>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_button', $atts, $content);
	}
	dentario_require_shortcode('trx_button', 'dentario_sc_button');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_button_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_button_reg_shortcodes');
	function dentario_sc_button_reg_shortcodes() {
	
		dentario_sc_map("trx_button", array(
			"title" => esc_html__("Button", 'dentario'),
			"desc" => wp_kses_data( __("Button with link", 'dentario') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Caption", 'dentario'),
					"desc" => wp_kses_data( __("Button caption", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"type" => array(
					"title" => esc_html__("Button's shape", 'dentario'),
					"desc" => wp_kses_data( __("Select button's shape", 'dentario') ),
					"value" => "square",
					"size" => "medium",
					"options" => array(
						'square' => esc_html__('Square', 'dentario'),
						'round' => esc_html__('Round', 'dentario')
					),
					"type" => "switch"
				), 
				"style" => array(
					"title" => esc_html__("Button's style", 'dentario'),
					"desc" => wp_kses_data( __("Select button's style", 'dentario') ),
					"value" => "default",
					"dir" => "horizontal",
					"options" => array(
						'filled' => esc_html__('Filled', 'dentario'),
						'border' => esc_html__('Border', 'dentario')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Button's size", 'dentario'),
					"desc" => wp_kses_data( __("Select button's size", 'dentario') ),
					"value" => "small",
					"dir" => "horizontal",
					"options" => array(
						'small' => esc_html__('Small', 'dentario'),
						'medium' => esc_html__('Medium', 'dentario'),
						'large' => esc_html__('Large', 'dentario')
					),
					"type" => "checklist"
				), 
				"icon" => array(
					"title" => esc_html__("Button's icon",  'dentario'),
					"desc" => wp_kses_data( __('Select icon for the title from Fontello icons set',  'dentario') ),
					"value" => "",
					"type" => "icons",
					"options" => dentario_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Button's text color", 'dentario'),
					"desc" => wp_kses_data( __("Any color for button's caption", 'dentario') ),
					"std" => "",
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Button's backcolor", 'dentario'),
					"desc" => wp_kses_data( __("Any color for button's background", 'dentario') ),
					"value" => "",
					"type" => "color"
				),
				"align" => array(
					"title" => esc_html__("Button's alignment", 'dentario'),
					"desc" => wp_kses_data( __("Align button to left, center or right", 'dentario') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => dentario_get_sc_param('align')
				), 
				"link" => array(
					"title" => esc_html__("Link URL", 'dentario'),
					"desc" => wp_kses_data( __("URL for link on button click", 'dentario') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"target" => array(
					"title" => esc_html__("Link target", 'dentario'),
					"desc" => wp_kses_data( __("Target for link on button click", 'dentario') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"popup" => array(
					"title" => esc_html__("Open link in popup", 'dentario'),
					"desc" => wp_kses_data( __("Open link target in popup window", 'dentario') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "no",
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				), 
				"rel" => array(
					"title" => esc_html__("Rel attribute", 'dentario'),
					"desc" => wp_kses_data( __("Rel attribute for button's link (if need)", 'dentario') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"width" => dentario_shortcodes_width(),
				"height" => dentario_shortcodes_height(),
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
if ( !function_exists( 'dentario_sc_button_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_button_reg_shortcodes_vc');
	function dentario_sc_button_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_button",
			"name" => esc_html__("Button", 'dentario'),
			"description" => wp_kses_data( __("Button with link", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_button',
			"class" => "trx_sc_single trx_sc_button",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Caption", 'dentario'),
					"description" => wp_kses_data( __("Button caption", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Button's shape", 'dentario'),
					"description" => wp_kses_data( __("Select button's shape", 'dentario') ),
					"class" => "",
					"value" => array(
						esc_html__('Square', 'dentario') => 'square',
						esc_html__('Round', 'dentario') => 'round'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Button's style", 'dentario'),
					"description" => wp_kses_data( __("Select button's style", 'dentario') ),
					"class" => "",
					"value" => array(
						esc_html__('Filled', 'dentario') => 'filled',
						esc_html__('Border', 'dentario') => 'border'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Button's size", 'dentario'),
					"description" => wp_kses_data( __("Select button's size", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Small', 'dentario') => 'small',
						esc_html__('Medium', 'dentario') => 'medium',
						esc_html__('Large', 'dentario') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Button's icon", 'dentario'),
					"description" => wp_kses_data( __("Select icon for the title from Fontello icons set", 'dentario') ),
					"class" => "",
					"value" => dentario_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Button's text color", 'dentario'),
					"description" => wp_kses_data( __("Any color for button's caption", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Button's backcolor", 'dentario'),
					"description" => wp_kses_data( __("Any color for button's background", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Button's alignment", 'dentario'),
					"description" => wp_kses_data( __("Align button to left, center or right", 'dentario') ),
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'dentario'),
					"description" => wp_kses_data( __("URL for the link on button click", 'dentario') ),
					"class" => "",
					"group" => esc_html__('Link', 'dentario'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "target",
					"heading" => esc_html__("Link target", 'dentario'),
					"description" => wp_kses_data( __("Target for the link on button click", 'dentario') ),
					"class" => "",
					"group" => esc_html__('Link', 'dentario'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "popup",
					"heading" => esc_html__("Open link in popup", 'dentario'),
					"description" => wp_kses_data( __("Open link target in popup window", 'dentario') ),
					"class" => "",
					"group" => esc_html__('Link', 'dentario'),
					"value" => array(esc_html__('Open in popup', 'dentario') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "rel",
					"heading" => esc_html__("Rel attribute", 'dentario'),
					"description" => wp_kses_data( __("Rel attribute for the button's link (if need", 'dentario') ),
					"class" => "",
					"group" => esc_html__('Link', 'dentario'),
					"value" => "",
					"type" => "textfield"
				),
				dentario_get_vc_param('id'),
				dentario_get_vc_param('class'),
				dentario_get_vc_param('animation'),
				dentario_get_vc_param('css'),
				dentario_vc_width(),
				dentario_vc_height(),
				dentario_get_vc_param('margin_top'),
				dentario_get_vc_param('margin_bottom'),
				dentario_get_vc_param('margin_left'),
				dentario_get_vc_param('margin_right')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Button extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>