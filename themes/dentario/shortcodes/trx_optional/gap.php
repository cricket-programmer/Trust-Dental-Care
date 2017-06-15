<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_gap_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_gap_theme_setup' );
	function dentario_sc_gap_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_gap_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_gap_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_gap]Fullwidth content[/trx_gap]

if (!function_exists('dentario_sc_gap')) {	
	function dentario_sc_gap($atts, $content = null) {
		if (dentario_in_shortcode_blogger()) return '';
		$output = dentario_gap_start() . do_shortcode($content) . dentario_gap_end();
		return apply_filters('dentario_shortcode_output', $output, 'trx_gap', $atts, $content);
	}
	dentario_require_shortcode("trx_gap", "dentario_sc_gap");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_gap_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_gap_reg_shortcodes');
	function dentario_sc_gap_reg_shortcodes() {
	
		dentario_sc_map("trx_gap", array(
			"title" => esc_html__("Gap", 'dentario'),
			"desc" => wp_kses_data( __("Insert gap (fullwidth area) in the post content. Attention! Use the gap only in the posts (pages) without left or right sidebar", 'dentario') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Gap content", 'dentario'),
					"desc" => wp_kses_data( __("Gap inner content", 'dentario') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_gap_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_gap_reg_shortcodes_vc');
	function dentario_sc_gap_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_gap",
			"name" => esc_html__("Gap", 'dentario'),
			"description" => wp_kses_data( __("Insert gap (fullwidth area) in the post content", 'dentario') ),
			"category" => esc_html__('Structure', 'dentario'),
			'icon' => 'icon_trx_gap',
			"class" => "trx_sc_collection trx_sc_gap",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"params" => array(

			)
		) );
		
		class WPBakeryShortCode_Trx_Gap extends DENTARIO_VC_ShortCodeCollection {}
	}
}
?>