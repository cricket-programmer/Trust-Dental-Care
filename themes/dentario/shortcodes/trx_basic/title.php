<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_title_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_title_theme_setup' );
	function dentario_sc_title_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_title_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_title_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_title id="unique_id" style='regular|iconed' icon='' image='' background="on|off" type="1-6"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_title]
*/

if (!function_exists('dentario_sc_title')) {	
	function dentario_sc_title($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "1",
			"style" => "regular",
			"align" => "",
			"font_weight" => "",
			"font_size" => "",
			"color" => "",
			"icon" => "",
			"image" => "",
			"picture" => "",
			"image_size" => "small",
			"position" => "left",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . dentario_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= dentario_get_css_dimensions_from_values($width)
			.($align && $align!='none' && !dentario_param_is_inherit($align) ? 'text-align:' . esc_attr($align) .';' : '')
			.($color ? 'color:' . esc_attr($color) .';' : '')
			.($font_weight && !dentario_param_is_inherit($font_weight) ? 'font-weight:' . esc_attr($font_weight) .';' : '')
			.($font_size   ? 'font-size:' . esc_attr($font_size) .';' : '')
			;
		$type = min(6, max(1, $type));
		if ($picture > 0) {
			$attach = wp_get_attachment_image_src( $picture, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$picture = $attach[0];
		}
		$pic = $style!='iconed' 
			? '' 
			: '<span class="sc_title_icon sc_title_icon_'.esc_attr($position).'  sc_title_icon_'.esc_attr($image_size).($icon!='' && $icon!='none' ? ' '.esc_attr($icon) : '').'"'.'>'
				.($picture ? '<img src="'.esc_url($picture).'" alt="" />' : '')
				.(empty($picture) && $image && $image!='none' ? '<img src="'.esc_url(dentario_strpos($image, 'http:')!==false ? $image : dentario_get_file_url('images/icons/'.($image).'.png')).'" alt="" />' : '')
				.'</span>';
		$output = '<h' . esc_attr($type) . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_title sc_title_'.esc_attr($style)
					.($align && $align!='none' && !dentario_param_is_inherit($align) ? ' sc_align_' . esc_attr($align) : '')
					.(!empty($class) ? ' '.esc_attr($class) : '')
					.'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
				. '>'
					. ($pic)
					. ($style=='divider' ? '<span class="sc_title_divider_before"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
					. do_shortcode($content) 
					. ($style=='divider' ? '<span class="sc_title_divider_after"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
				. '</h' . esc_attr($type) . '>';
		return apply_filters('dentario_shortcode_output', $output, 'trx_title', $atts, $content);
	}
	dentario_require_shortcode('trx_title', 'dentario_sc_title');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_title_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_title_reg_shortcodes');
	function dentario_sc_title_reg_shortcodes() {
	
		dentario_sc_map("trx_title", array(
			"title" => esc_html__("Title", 'dentario'),
			"desc" => wp_kses_data( __("Create header tag (1-6 level) with many styles", 'dentario') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Title content", 'dentario'),
					"desc" => wp_kses_data( __("Title content", 'dentario') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"type" => array(
					"title" => esc_html__("Title type", 'dentario'),
					"desc" => wp_kses_data( __("Title type (header level)", 'dentario') ),
					"divider" => true,
					"value" => "1",
					"type" => "select",
					"options" => array(
						'1' => esc_html__('Header 1', 'dentario'),
						'2' => esc_html__('Header 2', 'dentario'),
						'3' => esc_html__('Header 3', 'dentario'),
						'4' => esc_html__('Header 4', 'dentario'),
						'5' => esc_html__('Header 5', 'dentario'),
						'6' => esc_html__('Header 6', 'dentario'),
					)
				),
				"style" => array(
					"title" => esc_html__("Title style", 'dentario'),
					"desc" => wp_kses_data( __("Title style", 'dentario') ),
					"value" => "regular",
					"type" => "select",
					"options" => array(
						'regular' => esc_html__('Regular', 'dentario'),
						'underline' => esc_html__('Underline', 'dentario'),
						'divider' => esc_html__('Divider', 'dentario'),
						'iconed' => esc_html__('With icon (image)', 'dentario')
					)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'dentario'),
					"desc" => wp_kses_data( __("Title text alignment", 'dentario') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => dentario_get_sc_param('align')
				), 
				"font_size" => array(
					"title" => esc_html__("Font_size", 'dentario'),
					"desc" => wp_kses_data( __("Custom font size. If empty - use theme default", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", 'dentario'),
					"desc" => wp_kses_data( __("Custom font weight. If empty or inherit - use theme default", 'dentario') ),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'inherit' => esc_html__('Default', 'dentario'),
						'100' => esc_html__('Thin (100)', 'dentario'),
						'300' => esc_html__('Light (300)', 'dentario'),
						'400' => esc_html__('Normal (400)', 'dentario'),
						'600' => esc_html__('Semibold (600)', 'dentario'),
						'700' => esc_html__('Bold (700)', 'dentario'),
						'900' => esc_html__('Black (900)', 'dentario')
					)
				),
				"color" => array(
					"title" => esc_html__("Title color", 'dentario'),
					"desc" => wp_kses_data( __("Select color for the title", 'dentario') ),
					"value" => "",
					"type" => "color"
				),
				"icon" => array(
					"title" => esc_html__('Title font icon',  'dentario'),
					"desc" => wp_kses_data( __("Select font icon for the title from Fontello icons set (if style=iconed)",  'dentario') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "icons",
					"options" => dentario_get_sc_param('icons')
				),
				"image" => array(
					"title" => esc_html__('or image icon',  'dentario'),
					"desc" => wp_kses_data( __("Select image icon for the title instead icon above (if style=iconed)",  'dentario') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "images",
					"size" => "small",
					"options" => dentario_get_sc_param('images')
				),
				"picture" => array(
					"title" => esc_html__('or URL for image file', 'dentario'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site (if style=iconed)", 'dentario') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"image_size" => array(
					"title" => esc_html__('Image (picture) size', 'dentario'),
					"desc" => wp_kses_data( __("Select image (picture) size (if style='iconed')", 'dentario') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "small",
					"type" => "checklist",
					"options" => array(
						'small' => esc_html__('Small', 'dentario'),
						'medium' => esc_html__('Medium', 'dentario'),
						'large' => esc_html__('Large', 'dentario')
					)
				),
				"position" => array(
					"title" => esc_html__('Icon (image) position', 'dentario'),
					"desc" => wp_kses_data( __("Select icon (image) position (if style=iconed)", 'dentario') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "left",
					"type" => "checklist",
					"options" => array(
						'top' => esc_html__('Top', 'dentario'),
						'left' => esc_html__('Left', 'dentario')
					)
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
if ( !function_exists( 'dentario_sc_title_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_title_reg_shortcodes_vc');
	function dentario_sc_title_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_title",
			"name" => esc_html__("Title", 'dentario'),
			"description" => wp_kses_data( __("Create header tag (1-6 level) with many styles", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_title',
			"class" => "trx_sc_single trx_sc_title",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Title content", 'dentario'),
					"description" => wp_kses_data( __("Title content", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Title type", 'dentario'),
					"description" => wp_kses_data( __("Title type (header level)", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Header 1', 'dentario') => '1',
						esc_html__('Header 2', 'dentario') => '2',
						esc_html__('Header 3', 'dentario') => '3',
						esc_html__('Header 4', 'dentario') => '4',
						esc_html__('Header 5', 'dentario') => '5',
						esc_html__('Header 6', 'dentario') => '6'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Title style", 'dentario'),
					"description" => wp_kses_data( __("Title style: only text (regular) or with icon/image (iconed)", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Regular', 'dentario') => 'regular',
						esc_html__('Underline', 'dentario') => 'underline',
						esc_html__('Divider', 'dentario') => 'divider',
						esc_html__('With icon (image)', 'dentario') => 'iconed'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'dentario'),
					"description" => wp_kses_data( __("Title text alignment", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'dentario'),
					"description" => wp_kses_data( __("Custom font size. If empty - use theme default", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", 'dentario'),
					"description" => wp_kses_data( __("Custom font weight. If empty or inherit - use theme default", 'dentario') ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'dentario') => 'inherit',
						esc_html__('Thin (100)', 'dentario') => '100',
						esc_html__('Light (300)', 'dentario') => '300',
						esc_html__('Normal (400)', 'dentario') => '400',
						esc_html__('Semibold (600)', 'dentario') => '600',
						esc_html__('Bold (700)', 'dentario') => '700',
						esc_html__('Black (900)', 'dentario') => '900'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Title color", 'dentario'),
					"description" => wp_kses_data( __("Select color for the title", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Title font icon", 'dentario'),
					"description" => wp_kses_data( __("Select font icon for the title from Fontello icons set (if style=iconed)", 'dentario') ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'dentario'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => dentario_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("or image icon", 'dentario'),
					"description" => wp_kses_data( __("Select image icon for the title instead icon above (if style=iconed)", 'dentario') ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'dentario'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => dentario_get_sc_param('images'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "picture",
					"heading" => esc_html__("or select uploaded image", 'dentario'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site (if style=iconed)", 'dentario') ),
					"group" => esc_html__('Icon &amp; Image', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "image_size",
					"heading" => esc_html__("Image (picture) size", 'dentario'),
					"description" => wp_kses_data( __("Select image (picture) size (if style=iconed)", 'dentario') ),
					"group" => esc_html__('Icon &amp; Image', 'dentario'),
					"class" => "",
					"value" => array(
						esc_html__('Small', 'dentario') => 'small',
						esc_html__('Medium', 'dentario') => 'medium',
						esc_html__('Large', 'dentario') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "position",
					"heading" => esc_html__("Icon (image) position", 'dentario'),
					"description" => wp_kses_data( __("Select icon (image) position (if style=iconed)", 'dentario') ),
					"group" => esc_html__('Icon &amp; Image', 'dentario'),
					"class" => "",
					"std" => "left",
					"value" => array(
						esc_html__('Top', 'dentario') => 'top',
						esc_html__('Left', 'dentario') => 'left'
					),
					"type" => "dropdown"
				),
				dentario_get_vc_param('id'),
				dentario_get_vc_param('class'),
				dentario_get_vc_param('animation'),
				dentario_get_vc_param('css'),
				dentario_get_vc_param('margin_top'),
				dentario_get_vc_param('margin_bottom'),
				dentario_get_vc_param('margin_left'),
				dentario_get_vc_param('margin_right')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Title extends DENTARIO_VC_ShortCodeSingle {}
	}
}
?>