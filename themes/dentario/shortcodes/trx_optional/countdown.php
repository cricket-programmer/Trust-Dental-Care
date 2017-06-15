<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_countdown_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_countdown_theme_setup' );
	function dentario_sc_countdown_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_countdown_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_countdown_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_countdown date="" time=""]

if (!function_exists('dentario_sc_countdown')) {	
	function dentario_sc_countdown($atts, $content = null) {
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"date" => "",
			"time" => "",
			"style" => "1",
			"align" => "center",
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
		if (empty($id)) $id = "sc_countdown_".str_replace('.', '', mt_rand());
		$class .= ($class ? ' ' : '') . dentario_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= dentario_get_css_dimensions_from_values($width, $height);
		if (empty($interval)) $interval = 1;
		dentario_enqueue_script( 'dentario-jquery-plugin-script', dentario_get_file_url('js/countdown/jquery.plugin.js'), array('jquery'), null, true );	
		dentario_enqueue_script( 'dentario-countdown-script', dentario_get_file_url('js/countdown/jquery.countdown.js'), array('jquery'), null, true );	
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
			. ' class="sc_countdown sc_countdown_style_' . esc_attr(max(1, min(2, $style))) . (!empty($align) && $align!='none' ? ' align'.esc_attr($align) : '') . (!empty($class) ? ' '.esc_attr($class) : '') .'"'
			. ($css ? ' style="'.esc_attr($css).'"' : '')
			. ' data-date="'.esc_attr(empty($date) ? date('Y-m-d') : $date).'"'
			. ' data-time="'.esc_attr(empty($time) ? '00:00:00' : $time).'"'
			. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
			. '>'
				. ($align=='center' ? '<div class="sc_countdown_inner">' : '')
				. '<div class="sc_countdown_item sc_countdown_days">'
					. '<span class="sc_countdown_digits"><span></span><span></span><span></span></span>'
					. '<span class="sc_countdown_label">'.esc_html__('Days', 'dentario').'</span>'
				. '</div>'
				. '<div class="sc_countdown_separator">:</div>'
				. '<div class="sc_countdown_item sc_countdown_hours">'
					. '<span class="sc_countdown_digits"><span></span><span></span></span>'
					. '<span class="sc_countdown_label">'.esc_html__('Hours', 'dentario').'</span>'
				. '</div>'
				. '<div class="sc_countdown_separator">:</div>'
				. '<div class="sc_countdown_item sc_countdown_minutes">'
					. '<span class="sc_countdown_digits"><span></span><span></span></span>'
					. '<span class="sc_countdown_label">'.esc_html__('Minutes', 'dentario').'</span>'
				. '</div>'
				. '<div class="sc_countdown_separator">:</div>'
				. '<div class="sc_countdown_item sc_countdown_seconds">'
					. '<span class="sc_countdown_digits"><span></span><span></span></span>'
					. '<span class="sc_countdown_label">'.esc_html__('Seconds', 'dentario').'</span>'
				. '</div>'
				. '<div class="sc_countdown_placeholder hide"></div>'
				. ($align=='center' ? '</div>' : '')
			. '</div>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_countdown', $atts, $content);
	}
	dentario_require_shortcode("trx_countdown", "dentario_sc_countdown");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_countdown_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_countdown_reg_shortcodes');
	function dentario_sc_countdown_reg_shortcodes() {
	
		dentario_sc_map("trx_countdown", array(
			"title" => esc_html__("Countdown", 'dentario'),
			"desc" => wp_kses_data( __("Insert countdown object", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"date" => array(
					"title" => esc_html__("Date", 'dentario'),
					"desc" => wp_kses_data( __("Upcoming date (format: yyyy-mm-dd)", 'dentario') ),
					"value" => "",
					"format" => "yy-mm-dd",
					"type" => "date"
				),
				"time" => array(
					"title" => esc_html__("Time", 'dentario'),
					"desc" => wp_kses_data( __("Upcoming time (format: HH:mm:ss)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"style" => array(
					"title" => esc_html__("Style", 'dentario'),
					"desc" => wp_kses_data( __("Countdown style", 'dentario') ),
					"value" => "1",
					"type" => "checklist",
					"options" => dentario_get_list_styles(1, 2)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'dentario'),
					"desc" => wp_kses_data( __("Align counter to left, center or right", 'dentario') ),
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
if ( !function_exists( 'dentario_sc_countdown_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_countdown_reg_shortcodes_vc');
	function dentario_sc_countdown_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_countdown",
			"name" => esc_html__("Countdown", 'dentario'),
			"description" => wp_kses_data( __("Insert countdown object", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_countdown',
			"class" => "trx_sc_single trx_sc_countdown",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "date",
					"heading" => esc_html__("Date", 'dentario'),
					"description" => wp_kses_data( __("Upcoming date (format: yyyy-mm-dd)", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "time",
					"heading" => esc_html__("Time", 'dentario'),
					"description" => wp_kses_data( __("Upcoming time (format: HH:mm:ss)", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", 'dentario'),
					"description" => wp_kses_data( __("Countdown style", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(dentario_get_list_styles(1, 2)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'dentario'),
					"description" => wp_kses_data( __("Align counter to left, center or right", 'dentario') ),
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
		
		class WPBakeryShortCode_Trx_Countdown extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>