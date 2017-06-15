<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_tooltip_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_tooltip_theme_setup' );
	function dentario_sc_tooltip_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_tooltip_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_tooltip id="unique_id" title="Tooltip text here"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/tooltip]
*/

if (!function_exists('dentario_sc_tooltip')) {	
	function dentario_sc_tooltip($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_tooltip_parent'. (!empty($class) ? ' '.esc_attr($class) : '').'"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. '>'
						. do_shortcode($content)
						. '<span class="sc_tooltip">' . ($title) . '</span>'
					. '</span>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_tooltip', $atts, $content);
	}
	dentario_require_shortcode('trx_tooltip', 'dentario_sc_tooltip');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_tooltip_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_tooltip_reg_shortcodes');
	function dentario_sc_tooltip_reg_shortcodes() {
	
		dentario_sc_map("trx_tooltip", array(
			"title" => esc_html__("Tooltip", 'dentario'),
			"desc" => wp_kses_data( __("Create tooltip for selected text", 'dentario') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"title" => array(
					"title" => esc_html__("Title", 'dentario'),
					"desc" => wp_kses_data( __("Tooltip title (required)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Tipped content", 'dentario'),
					"desc" => wp_kses_data( __("Highlighted content with tooltip", 'dentario') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"id" => dentario_get_sc_param('id'),
				"class" => dentario_get_sc_param('class'),
				"css" => dentario_get_sc_param('css')
			)
		));
	}
}
?>