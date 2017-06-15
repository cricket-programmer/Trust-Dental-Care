<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_hide_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_hide_theme_setup' );
	function dentario_sc_hide_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_hide_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_hide selector="unique_id"]
*/

if (!function_exists('dentario_sc_hide')) {	
	function dentario_sc_hide($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"selector" => "",
			"hide" => "on",
			"delay" => 0
		), $atts)));
		$selector = trim(chop($selector));
		$output = $selector == '' ? '' : 
			'<script type="text/javascript">
				jQuery(document).ready(function() {
					'.($delay>0 ? 'setTimeout(function() {' : '').'
					jQuery("'.esc_attr($selector).'").' . ($hide=='on' ? 'hide' : 'show') . '();
					'.($delay>0 ? '},'.($delay).');' : '').'
				});
			</script>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_hide', $atts, $content);
	}
	dentario_require_shortcode('trx_hide', 'dentario_sc_hide');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_hide_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_hide_reg_shortcodes');
	function dentario_sc_hide_reg_shortcodes() {
	
		dentario_sc_map("trx_hide", array(
			"title" => esc_html__("Hide/Show any block", 'dentario'),
			"desc" => wp_kses_data( __("Hide or Show any block with desired CSS-selector", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"selector" => array(
					"title" => esc_html__("Selector", 'dentario'),
					"desc" => wp_kses_data( __("Any block's CSS-selector", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"hide" => array(
					"title" => esc_html__("Hide or Show", 'dentario'),
					"desc" => wp_kses_data( __("New state for the block: hide or show", 'dentario') ),
					"value" => "yes",
					"size" => "small",
					"options" => dentario_get_sc_param('yes_no'),
					"type" => "switch"
				)
			)
		));
	}
}
?>