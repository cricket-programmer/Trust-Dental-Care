<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_image_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_image_theme_setup' );
	function dentario_sc_image_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_image_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_image_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_image id="unique_id" src="image_url" width="width_in_pixels" height="height_in_pixels" title="image's_title" align="left|right"]
*/

if (!function_exists('dentario_sc_image')) {	
	function dentario_sc_image($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"align" => "",
			"shape" => "square",
			"src" => "",
			"url" => "",
			"icon" => "",
			"link" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => "",
			"width" => "",
			"height" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . dentario_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= dentario_get_css_dimensions_from_values($width, $height);
		$src = $src!='' ? $src : $url;
		if ($src > 0) {
			$attach = wp_get_attachment_image_src( $src, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$src = $attach[0];
		}
		if (!empty($width) || !empty($height)) {
			$w = !empty($width) && strlen(intval($width)) == strlen($width) ? $width : null;
			$h = !empty($height) && strlen(intval($height)) == strlen($height) ? $height : null;
			if ($w || $h) $src = dentario_get_resized_image_url($src, $w, $h);
		}
		if (trim($link)) dentario_enqueue_popup();
		$output = empty($src) ? '' : ('<figure' . ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ' class="sc_image ' . ($align && $align!='none' ? ' align' . esc_attr($align) : '') . (!empty($shape) ? ' sc_image_shape_'.esc_attr($shape) : '') . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
			. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>'
				. (trim($link) ? '<a href="'.esc_url($link).'">' : '')
				. '<img src="'.esc_url($src).'" alt="" />'
				. (trim($link) ? '</a>' : '')
				. (trim($title) || trim($icon) ? '<figcaption><span'.($icon ? ' class="'.esc_attr($icon).'"' : '').'></span> ' . ($title) . '</figcaption>' : '')
			. '</figure>');
		return apply_filters('dentario_shortcode_output', $output, 'trx_image', $atts, $content);
	}
	dentario_require_shortcode('trx_image', 'dentario_sc_image');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_image_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_image_reg_shortcodes');
	function dentario_sc_image_reg_shortcodes() {
	
		dentario_sc_map("trx_image", array(
			"title" => esc_html__("Image", 'dentario'),
			"desc" => wp_kses_data( __("Insert image into your post (page)", 'dentario') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"url" => array(
					"title" => esc_html__("URL for image file", 'dentario'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site", 'dentario') ),
					"readonly" => false,
					"value" => "",
					"type" => "media",
					"before" => array(
						'sizes' => true		// If you want allow user select thumb size for image. Otherwise, thumb size is ignored - image fullsize used
					)
				),
				"title" => array(
					"title" => esc_html__("Title", 'dentario'),
					"desc" => wp_kses_data( __("Image title (if need)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"icon" => array(
					"title" => esc_html__("Icon before title",  'dentario'),
					"desc" => wp_kses_data( __('Select icon for the title from Fontello icons set',  'dentario') ),
					"value" => "",
					"type" => "icons",
					"options" => dentario_get_sc_param('icons')
				),
				"align" => array(
					"title" => esc_html__("Float image", 'dentario'),
					"desc" => wp_kses_data( __("Float image to left or right side", 'dentario') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => dentario_get_sc_param('float')
				), 
				"shape" => array(
					"title" => esc_html__("Image Shape", 'dentario'),
					"desc" => wp_kses_data( __("Shape of the image: square (rectangle) or round", 'dentario') ),
					"value" => "square",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => array(
						"square" => esc_html__('Square', 'dentario'),
						"round" => esc_html__('Round', 'dentario')
					)
				), 
				"link" => array(
					"title" => esc_html__("Link", 'dentario'),
					"desc" => wp_kses_data( __("The link URL from the image", 'dentario') ),
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
if ( !function_exists( 'dentario_sc_image_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_image_reg_shortcodes_vc');
	function dentario_sc_image_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_image",
			"name" => esc_html__("Image", 'dentario'),
			"description" => wp_kses_data( __("Insert image", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_image',
			"class" => "trx_sc_single trx_sc_image",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "url",
					"heading" => esc_html__("Select image", 'dentario'),
					"description" => wp_kses_data( __("Select image from library", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Image alignment", 'dentario'),
					"description" => wp_kses_data( __("Align image to left or right side", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('float')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "shape",
					"heading" => esc_html__("Image shape", 'dentario'),
					"description" => wp_kses_data( __("Shape of the image: square or round", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Square', 'dentario') => 'square',
						esc_html__('Round', 'dentario') => 'round'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'dentario'),
					"description" => wp_kses_data( __("Image's title", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Title's icon", 'dentario'),
					"description" => wp_kses_data( __("Select icon for the title from Fontello icons set", 'dentario') ),
					"class" => "",
					"value" => dentario_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link", 'dentario'),
					"description" => wp_kses_data( __("The link URL from the image", 'dentario') ),
					"admin_label" => true,
					"class" => "",
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
			)
		) );
		
		class WPBakeryShortCode_Trx_Image extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>