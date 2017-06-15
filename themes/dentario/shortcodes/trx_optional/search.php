<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_search_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_search_theme_setup' );
	function dentario_sc_search_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_search_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_search_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_search id="unique_id" open="yes|no"]
*/

if (!function_exists('dentario_sc_search')) {	
	function dentario_sc_search($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "regular",
			"state" => "fixed",
			"scheme" => "original",
			"ajax" => "",
			"title" => esc_html__('Search', 'dentario'),
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
		if (empty($ajax)) $ajax = dentario_get_theme_option('use_ajax_search');
		// Load core messages
		dentario_enqueue_messages();
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') . ' class="search_wrap search_style_'.esc_attr($style).' search_state_'.esc_attr($state)
						. (dentario_param_is_on($ajax) ? ' search_ajax' : '')
						. ($class ? ' '.esc_attr($class) : '')
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
					. '>
						<div class="search_form_wrap">
							<form role="search" method="get" class="search_form" action="' . esc_url(home_url('/')) . '">
								<input type="text" class="search_field" placeholder="' . esc_attr($title) . '" value="' . esc_attr(get_search_query()) . '" name="s" />
								<button type="submit" class="search_submit icon-magnifying-glass-2" title="' . ($state=='closed' ? esc_attr__('Open search', 'dentario') : esc_attr__('Start search', 'dentario')) . '"></button>
							</form>
						</div>
						<div class="search_results widget_area' . ($scheme && !dentario_param_is_off($scheme) && !dentario_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') . '"><a class="search_results_close icon-cancel"></a><div class="search_results_content"></div></div>
				</div>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_search', $atts, $content);
	}
	dentario_require_shortcode('trx_search', 'dentario_sc_search');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_search_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_search_reg_shortcodes');
	function dentario_sc_search_reg_shortcodes() {
	
		dentario_sc_map("trx_search", array(
			"title" => esc_html__("Search", 'dentario'),
			"desc" => wp_kses_data( __("Show search form", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", 'dentario'),
					"desc" => wp_kses_data( __("Select style to display search field", 'dentario') ),
					"value" => "regular",
					"options" => array(
						"regular" => esc_html__('Regular', 'dentario'),
						"rounded" => esc_html__('Rounded', 'dentario')
					),
					"type" => "checklist"
				),
				"state" => array(
					"title" => esc_html__("State", 'dentario'),
					"desc" => wp_kses_data( __("Select search field initial state", 'dentario') ),
					"value" => "fixed",
					"options" => array(
						"fixed"  => esc_html__('Fixed',  'dentario'),
						"opened" => esc_html__('Opened', 'dentario'),
						"closed" => esc_html__('Closed', 'dentario')
					),
					"type" => "checklist"
				),
				"title" => array(
					"title" => esc_html__("Title", 'dentario'),
					"desc" => wp_kses_data( __("Title (placeholder) for the search field", 'dentario') ),
					"value" => esc_html__("Search &hellip;", 'dentario'),
					"type" => "text"
				),
				"ajax" => array(
					"title" => esc_html__("AJAX", 'dentario'),
					"desc" => wp_kses_data( __("Search via AJAX or reload page", 'dentario') ),
					"value" => "yes",
					"options" => dentario_get_sc_param('yes_no'),
					"type" => "switch"
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
if ( !function_exists( 'dentario_sc_search_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_search_reg_shortcodes_vc');
	function dentario_sc_search_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_search",
			"name" => esc_html__("Search form", 'dentario'),
			"description" => wp_kses_data( __("Insert search form", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_search',
			"class" => "trx_sc_single trx_sc_search",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", 'dentario'),
					"description" => wp_kses_data( __("Select style to display search field", 'dentario') ),
					"class" => "",
					"value" => array(
						esc_html__('Regular', 'dentario') => "regular",
						esc_html__('Flat', 'dentario') => "flat"
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "state",
					"heading" => esc_html__("State", 'dentario'),
					"description" => wp_kses_data( __("Select search field initial state", 'dentario') ),
					"class" => "",
					"value" => array(
						esc_html__('Fixed', 'dentario')  => "fixed",
						esc_html__('Opened', 'dentario') => "opened",
						esc_html__('Closed', 'dentario') => "closed"
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'dentario'),
					"description" => wp_kses_data( __("Title (placeholder) for the search field", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => esc_html__("Search &hellip;", 'dentario'),
					"type" => "textfield"
				),
				array(
					"param_name" => "ajax",
					"heading" => esc_html__("AJAX", 'dentario'),
					"description" => wp_kses_data( __("Search via AJAX or reload page", 'dentario') ),
					"class" => "",
					"value" => array(esc_html__('Use AJAX search', 'dentario') => 'yes'),
					"type" => "checkbox"
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
		
		class WPBakeryShortCode_Trx_Search extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>