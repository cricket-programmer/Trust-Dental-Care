<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_emailer_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_emailer_theme_setup' );
	function dentario_sc_emailer_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_emailer_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_emailer_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_emailer group=""]

if (!function_exists('dentario_sc_emailer')) {	
	function dentario_sc_emailer($atts, $content = null) {
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"group" => "",
			"open" => "yes",
			"align" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => "",
			"width" => "",
			"height" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . dentario_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= dentario_get_css_dimensions_from_values($width, $height);
		// Load core messages
		dentario_enqueue_messages();
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
					. ' class="sc_emailer' . ($align && $align!='none' ? ' align' . esc_attr($align) : '') . (dentario_param_is_on($open) ? ' sc_emailer_opened' : '') . (!empty($class) ? ' '.esc_attr($class) : '') . '"' 
					. ($css ? ' style="'.esc_attr($css).'"' : '') 
					. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
					. '>'
				. '<form class="sc_emailer_form">'
				. '<input type="text" class="sc_emailer_input" name="email" value="" placeholder="'.esc_attr__('Please, enter you email address.', 'dentario').'">'
				. '<a href="#" class="sc_emailer_button icon-mail" title="'.esc_attr__('Submit', 'dentario').'" data-group="'.esc_attr($group ? $group : esc_html__('E-mailer subscription', 'dentario')).'"></a>'
				. '</form>'
			. '</div>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_emailer', $atts, $content);
	}
	dentario_require_shortcode("trx_emailer", "dentario_sc_emailer");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_emailer_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_emailer_reg_shortcodes');
	function dentario_sc_emailer_reg_shortcodes() {
	
		dentario_sc_map("trx_emailer", array(
			"title" => esc_html__("E-mail collector", 'dentario'),
			"desc" => wp_kses_data( __("Collect the e-mail address into specified group", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"group" => array(
					"title" => esc_html__("Group", 'dentario'),
					"desc" => wp_kses_data( __("The name of group to collect e-mail address", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"open" => array(
					"title" => esc_html__("Open", 'dentario'),
					"desc" => wp_kses_data( __("Initially open the input field on show object", 'dentario') ),
					"divider" => true,
					"value" => "yes",
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'dentario'),
					"desc" => wp_kses_data( __("Align object to left, center or right", 'dentario') ),
					"divider" => true,
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => dentario_get_sc_param('align')
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
if ( !function_exists( 'dentario_sc_emailer_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_emailer_reg_shortcodes_vc');
	function dentario_sc_emailer_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_emailer",
			"name" => esc_html__("E-mail collector", 'dentario'),
			"description" => wp_kses_data( __("Collect e-mails into specified group", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_emailer',
			"class" => "trx_sc_single trx_sc_emailer",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "group",
					"heading" => esc_html__("Group", 'dentario'),
					"description" => wp_kses_data( __("The name of group to collect e-mail address", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "open",
					"heading" => esc_html__("Opened", 'dentario'),
					"description" => wp_kses_data( __("Initially open the input field on show object", 'dentario') ),
					"class" => "",
					"value" => array(esc_html__('Initially opened', 'dentario') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'dentario'),
					"description" => wp_kses_data( __("Align field to left, center or right", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('align')),
					"type" => "dropdown"
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
			)
		) );
		
		class WPBakeryShortCode_Trx_Emailer extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>