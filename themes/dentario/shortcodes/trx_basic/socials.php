<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_socials_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_socials_theme_setup' );
	function dentario_sc_socials_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_socials_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_socials_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_socials id="unique_id" size="small"]
	[trx_social_item name="facebook" url="profile url" icon="path for the icon"]
	[trx_social_item name="twitter" url="profile url"]
[/trx_socials]
*/

if (!function_exists('dentario_sc_socials')) {	
	function dentario_sc_socials($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"size" => "small",		// tiny | small | medium | large
			"shape" => "square",	// round | square
			"type" => dentario_get_theme_setting('socials_type'),	// icons | images
			"socials" => "",
			"custom" => "no",
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
		dentario_storage_set('sc_social_data', array(
			'icons' => false,
            'type' => $type
            )
        );
		if (!empty($socials)) {
			$allowed = explode('|', $socials);
			$list = array();
			for ($i=0; $i<count($allowed); $i++) {
				$s = explode('=', $allowed[$i]);
				if (!empty($s[1])) {
					$list[] = array(
						'icon'	=> $type=='images' ? dentario_get_socials_url($s[0]) : 'icon-'.trim($s[0]),
						'url'	=> $s[1]
						);
				}
			}
			if (count($list) > 0) dentario_storage_set_array('sc_social_data', 'icons', $list);
		} else if (dentario_param_is_off($custom))
			$content = do_shortcode($content);
		if (dentario_storage_get_array('sc_social_data', 'icons')===false) dentario_storage_set_array('sc_social_data', 'icons', dentario_get_custom_option('social_icons'));
		$output = dentario_prepare_socials(dentario_storage_get_array('sc_social_data', 'icons'));
		$output = $output
			? '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_socials sc_socials_type_' . esc_attr($type) . ' sc_socials_shape_' . esc_attr($shape) . ' sc_socials_size_' . esc_attr($size) . (!empty($class) ? ' '.esc_attr($class) : '') . '"' 
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
				. '>' 
				. ($output)
				. '</div>'
			: '';
		return apply_filters('dentario_shortcode_output', $output, 'trx_socials', $atts, $content);
	}
	dentario_require_shortcode('trx_socials', 'dentario_sc_socials');
}


if (!function_exists('dentario_sc_social_item')) {	
	function dentario_sc_social_item($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"name" => "",
			"url" => "",
			"icon" => ""
		), $atts)));
		if (!empty($name) && empty($icon)) {
			$type = dentario_storage_get_array('sc_social_data', 'type');
			if ($type=='images') {
				if (file_exists(dentario_get_socials_dir($name.'.png')))
					$icon = dentario_get_socials_url($name.'.png');
			} else
				$icon = 'icon-'.esc_attr($name);
		}
		if (!empty($icon) && !empty($url)) {
			if (dentario_storage_get_array('sc_social_data', 'icons')===false) dentario_storage_set_array('sc_social_data', 'icons', array());
			dentario_storage_set_array2('sc_social_data', 'icons', '', array(
				'icon' => $icon,
				'url' => $url
				)
			);
		}
		return '';
	}
	dentario_require_shortcode('trx_social_item', 'dentario_sc_social_item');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_socials_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_socials_reg_shortcodes');
	function dentario_sc_socials_reg_shortcodes() {
	
		dentario_sc_map("trx_socials", array(
			"title" => esc_html__("Social icons", 'dentario'),
			"desc" => wp_kses_data( __("List of social icons (with hovers)", 'dentario') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"type" => array(
					"title" => esc_html__("Icon's type", 'dentario'),
					"desc" => wp_kses_data( __("Type of the icons - images or font icons", 'dentario') ),
					"value" => dentario_get_theme_setting('socials_type'),
					"options" => array(
						'icons' => esc_html__('Icons', 'dentario'),
						'images' => esc_html__('Images', 'dentario')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Icon's size", 'dentario'),
					"desc" => wp_kses_data( __("Size of the icons", 'dentario') ),
					"value" => "small",
					"options" => dentario_get_sc_param('sizes'),
					"type" => "checklist"
				), 
				"shape" => array(
					"title" => esc_html__("Icon's shape", 'dentario'),
					"desc" => wp_kses_data( __("Shape of the icons", 'dentario') ),
					"value" => "square",
					"options" => dentario_get_sc_param('shapes'),
					"type" => "checklist"
				), 
				"socials" => array(
					"title" => esc_html__("Manual socials list", 'dentario'),
					"desc" => wp_kses_data( __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebook.com/my_profile. If empty - use socials from Theme options.", 'dentario') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"custom" => array(
					"title" => esc_html__("Custom socials", 'dentario'),
					"desc" => wp_kses_data( __("Make custom icons from inner shortcodes (prepare it on tabs)", 'dentario') ),
					"divider" => true,
					"value" => "no",
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
			),
			"children" => array(
				"name" => "trx_social_item",
				"title" => esc_html__("Custom social item", 'dentario'),
				"desc" => wp_kses_data( __("Custom social item: name, profile url and icon url", 'dentario') ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"name" => array(
						"title" => esc_html__("Social name", 'dentario'),
						"desc" => wp_kses_data( __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", 'dentario') ),
						"value" => "",
						"type" => "text"
					),
					"url" => array(
						"title" => esc_html__("Your profile URL", 'dentario'),
						"desc" => wp_kses_data( __("URL of your profile in specified social network", 'dentario') ),
						"value" => "",
						"type" => "text"
					),
					"icon" => array(
						"title" => esc_html__("URL (source) for icon file", 'dentario'),
						"desc" => wp_kses_data( __("Select or upload image or write URL from other site for the current social icon", 'dentario') ),
						"readonly" => false,
						"value" => "",
						"type" => "media"
					)
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_socials_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_socials_reg_shortcodes_vc');
	function dentario_sc_socials_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_socials",
			"name" => esc_html__("Social icons", 'dentario'),
			"description" => wp_kses_data( __("Custom social icons", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_socials',
			"class" => "trx_sc_collection trx_sc_socials",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"as_parent" => array('only' => 'trx_social_item'),
			"params" => array_merge(array(
				array(
					"param_name" => "type",
					"heading" => esc_html__("Icon's type", 'dentario'),
					"description" => wp_kses_data( __("Type of the icons - images or font icons", 'dentario') ),
					"class" => "",
					"std" => dentario_get_theme_setting('socials_type'),
					"value" => array(
						esc_html__('Icons', 'dentario') => 'icons',
						esc_html__('Images', 'dentario') => 'images'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Icon's size", 'dentario'),
					"description" => wp_kses_data( __("Size of the icons", 'dentario') ),
					"class" => "",
					"std" => "small",
					"value" => array_flip(dentario_get_sc_param('sizes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "shape",
					"heading" => esc_html__("Icon's shape", 'dentario'),
					"description" => wp_kses_data( __("Shape of the icons", 'dentario') ),
					"class" => "",
					"std" => "square",
					"value" => array_flip(dentario_get_sc_param('shapes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "socials",
					"heading" => esc_html__("Manual socials list", 'dentario'),
					"description" => wp_kses_data( __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebook.com/my_profile. If empty - use socials from Theme options.", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "custom",
					"heading" => esc_html__("Custom socials", 'dentario'),
					"description" => wp_kses_data( __("Make custom icons from inner shortcodes (prepare it on tabs)", 'dentario') ),
					"class" => "",
					"value" => array(esc_html__('Custom socials', 'dentario') => 'yes'),
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
			))
		) );
		
		
		vc_map( array(
			"base" => "trx_social_item",
			"name" => esc_html__("Custom social item", 'dentario'),
			"description" => wp_kses_data( __("Custom social item: name, profile url and icon url", 'dentario') ),
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => false,
			'icon' => 'icon_trx_social_item',
			"class" => "trx_sc_single trx_sc_social_item",
			"as_child" => array('only' => 'trx_socials'),
			"as_parent" => array('except' => 'trx_socials'),
			"params" => array(
				array(
					"param_name" => "name",
					"heading" => esc_html__("Social name", 'dentario'),
					"description" => wp_kses_data( __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("Your profile URL", 'dentario'),
					"description" => wp_kses_data( __("URL of your profile in specified social network", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("URL (source) for icon file", 'dentario'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site for the current social icon", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				)
			)
		) );
		
		class WPBakeryShortCode_Trx_Socials extends DENTARIO_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_Social_Item extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>