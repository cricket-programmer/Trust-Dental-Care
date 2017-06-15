<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_br_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_br_theme_setup' );
	function dentario_sc_br_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_br_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_br_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_br clear="left|right|both"]
*/

if (!function_exists('dentario_sc_br')) {	
	function dentario_sc_br($atts, $content = null) {
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			"clear" => ""
		), $atts)));
		$output = in_array($clear, array('left', 'right', 'both', 'all')) 
			? '<div class="clearfix" style="clear:' . str_replace('all', 'both', $clear) . '"></div>'
			: '<br />';
		return apply_filters('dentario_shortcode_output', $output, 'trx_br', $atts, $content);
	}
	dentario_require_shortcode("trx_br", "dentario_sc_br");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_br_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_br_reg_shortcodes');
	function dentario_sc_br_reg_shortcodes() {
	
		dentario_sc_map("trx_br", array(
			"title" => esc_html__("Break", 'dentario'),
			"desc" => wp_kses_data( __("Line break with clear floating (if need)", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"clear" => 	array(
					"title" => esc_html__("Clear floating", 'dentario'),
					"desc" => wp_kses_data( __("Clear floating (if need)", 'dentario') ),
					"value" => "",
					"type" => "checklist",
					"options" => array(
						'none' => esc_html__('None', 'dentario'),
						'left' => esc_html__('Left', 'dentario'),
						'right' => esc_html__('Right', 'dentario'),
						'both' => esc_html__('Both', 'dentario')
					)
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_br_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_br_reg_shortcodes_vc');
	function dentario_sc_br_reg_shortcodes_vc() {

	}
}
?>