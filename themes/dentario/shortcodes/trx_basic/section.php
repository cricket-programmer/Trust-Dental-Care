<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('dentario_sc_section_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_section_theme_setup' );
	function dentario_sc_section_theme_setup() {
		add_action('dentario_action_shortcodes_list', 		'dentario_sc_section_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_sc_section_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_section id="unique_id" class="class_name" style="css-styles" dedicated="yes|no"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_section]
*/

dentario_storage_set('sc_section_dedicated', '');

if (!function_exists('dentario_sc_section')) {	
	function dentario_sc_section($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"dedicated" => "no",
			"align" => "none",
			"columns" => "none",
			"pan" => "no",
			"scroll" => "no",
			"scroll_dir" => "horizontal",
			"scroll_controls" => "hide",
			"color" => "",
			"scheme" => "",
			"bg_color" => "",
			"bg_image" => "",
			"bg_overlay" => "",
			"bg_texture" => "",
			"bg_tile" => "no",
			"bg_padding" => "no",
			"font_size" => "",
			"font_weight" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'dentario'),
			"link" => '',
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
	
		if ($bg_image > 0) {
			$attach = wp_get_attachment_image_src( $bg_image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$bg_image = $attach[0];
		}
	
		if ($bg_overlay > 0) {
			if ($bg_color=='') $bg_color = dentario_get_scheme_color('bg');
			$rgb = dentario_hex2rgb($bg_color);
		}
	
		$class .= ($class ? ' ' : '') . dentario_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= ($color !== '' ? 'color:' . esc_attr($color) . ';' : '')
			.($bg_color !== '' && $bg_overlay==0 ? 'background-color:' . esc_attr($bg_color) . ';' : '')
			.($bg_image !== '' ? 'background-image:url(' . esc_url($bg_image) . ');'.(dentario_param_is_on($bg_tile) ? 'background-repeat:repeat;' : 'background-repeat:no-repeat;background-size:cover;') : '')
			.(!dentario_param_is_off($pan) ? 'position:relative;' : '')
			.($font_size != '' ? 'font-size:' . esc_attr(dentario_prepare_css_value($font_size)) . '; line-height: 1.3em;' : '')
			.($font_weight != '' && !dentario_param_is_inherit($font_weight) ? 'font-weight:' . esc_attr($font_weight) . ';' : '');
		$css_dim = dentario_get_css_dimensions_from_values($width, $height);
		if ($bg_image == '' && $bg_color == '' && $bg_overlay==0 && $bg_texture==0 && dentario_strlen($bg_texture)<2) $css .= $css_dim;
		
		$width  = dentario_prepare_css_value($width);
		$height = dentario_prepare_css_value($height);
	
		if ((!dentario_param_is_off($scroll) || !dentario_param_is_off($pan)) && empty($id)) $id = 'sc_section_'.str_replace('.', '', mt_rand());
	
		if (!dentario_param_is_off($scroll)) dentario_enqueue_slider();
	
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_section' 
					. ($class ? ' ' . esc_attr($class) : '') 
					. ($scheme && !dentario_param_is_off($scheme) && !dentario_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($columns) && $columns!='none' ? ' column-'.esc_attr($columns) : '') 
					. (dentario_param_is_on($scroll) && !dentario_param_is_off($scroll_controls) ? ' sc_scroll_controls sc_scroll_controls_'.esc_attr($scroll_dir).' sc_scroll_controls_type_'.esc_attr($scroll_controls) : '')
					. '"'
				. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
				. ($css!='' || $css_dim!='' ? ' style="'.esc_attr($css.$css_dim).'"' : '')
				.'>' 
				. '<div class="sc_section_inner">'
					. ($bg_image !== '' || $bg_color !== '' || $bg_overlay>0 || $bg_texture>0 || dentario_strlen($bg_texture)>2
						? '<div class="sc_section_overlay'.($bg_texture>0 ? ' texture_bg_'.esc_attr($bg_texture) : '') . '"'
							. ' style="' . ($bg_overlay>0 ? 'background-color:rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.min(1, max(0, $bg_overlay)).');' : '')
								. (dentario_strlen($bg_texture)>2 ? 'background-image:url('.esc_url($bg_texture).');' : '')
								. '"'
								. ($bg_overlay > 0 ? ' data-overlay="'.esc_attr($bg_overlay).'" data-bg_color="'.esc_attr($bg_color).'"' : '')
								. '>'
								. '<div class="sc_section_content' . (dentario_param_is_on($bg_padding) ? ' padding_on' : ' padding_off') . '"'
									. ' style="'.esc_attr($css_dim).'"'
									. '>'
						: '')
					. (dentario_param_is_on($scroll) 
						? '<div id="'.esc_attr($id).'_scroll" class="sc_scroll sc_scroll_'.esc_attr($scroll_dir).' swiper-slider-container scroll-container"'
							. ' style="'.($height != '' ? 'height:'.esc_attr($height).';' : '') . ($width != '' ? 'width:'.esc_attr($width).';' : '').'"'
							. '>'
							. '<div class="sc_scroll_wrapper swiper-wrapper">' 
							. '<div class="sc_scroll_slide swiper-slide">' 
						: '')
					. (dentario_param_is_on($pan) 
						? '<div id="'.esc_attr($id).'_pan" class="sc_pan sc_pan_'.esc_attr($scroll_dir).'">' 
						: '')
							. (!empty($subtitle) ? '<h6 class="sc_section_subtitle sc_item_subtitle">' . trim(dentario_strmacros($subtitle)) . '</h6>' : '')
							. (!empty($title) ? '<h2 class="sc_section_title sc_item_title">' . trim(dentario_strmacros($title)) . '</h2>' : '')
							. (!empty($description) ? '<div class="sc_section_descr sc_item_descr">' . trim(dentario_strmacros($description)) . '</div>' : '')
							. do_shortcode($content)
							. (!empty($link) ? '<div class="sc_section_button sc_item_button">'.dentario_do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
					. (dentario_param_is_on($pan) ? '</div>' : '')
					. (dentario_param_is_on($scroll) 
						? '</div></div><div id="'.esc_attr($id).'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_'.esc_attr($scroll_dir).' '.esc_attr($id).'_scroll_bar"></div></div>'
							. (!dentario_param_is_off($scroll_controls) ? '<div class="sc_scroll_controls_wrap"><a class="sc_scroll_prev" href="#"></a><a class="sc_scroll_next" href="#"></a></div>' : '')
						: '')
					. ($bg_image !== '' || $bg_color !== '' || $bg_overlay > 0 || $bg_texture>0 || dentario_strlen($bg_texture)>2 ? '</div></div>' : '')
					. '</div>'
				. '</div>';
		if (dentario_param_is_on($dedicated)) {
			if (dentario_storage_get('sc_section_dedicated')=='') {
				dentario_storage_set('sc_section_dedicated', $output);
			}
			$output = '';
		}
		return apply_filters('dentario_shortcode_output', $output, 'trx_section', $atts, $content);
	}
	dentario_require_shortcode('trx_section', 'dentario_sc_section');
	dentario_require_shortcode('trx_block', 'dentario_sc_section');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_section_reg_shortcodes' ) ) {
	//add_action('dentario_action_shortcodes_list', 'dentario_sc_section_reg_shortcodes');
	function dentario_sc_section_reg_shortcodes() {
	
		$sc = array(
			"title" => esc_html__("Block container", 'dentario'),
			"desc" => wp_kses_data( __("Container for any block ([section] analog - to enable nesting)", 'dentario') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"title" => array(
					"title" => esc_html__("Title", 'dentario'),
					"desc" => wp_kses_data( __("Title for the block", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"subtitle" => array(
					"title" => esc_html__("Subtitle", 'dentario'),
					"desc" => wp_kses_data( __("Subtitle for the block", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"description" => array(
					"title" => esc_html__("Description", 'dentario'),
					"desc" => wp_kses_data( __("Short description for the block", 'dentario') ),
					"value" => "",
					"type" => "textarea"
				),
				"link" => array(
					"title" => esc_html__("Button URL", 'dentario'),
					"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"link_caption" => array(
					"title" => esc_html__("Button caption", 'dentario'),
					"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"dedicated" => array(
					"title" => esc_html__("Dedicated", 'dentario'),
					"desc" => wp_kses_data( __("Use this block as dedicated content - show it before post title on single page", 'dentario') ),
					"value" => "no",
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				),
				"align" => array(
					"title" => esc_html__("Align", 'dentario'),
					"desc" => wp_kses_data( __("Select block alignment", 'dentario') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => dentario_get_sc_param('align')
				),
				"columns" => array(
					"title" => esc_html__("Columns emulation", 'dentario'),
					"desc" => wp_kses_data( __("Select width for columns emulation", 'dentario') ),
					"value" => "none",
					"type" => "checklist",
					"options" => dentario_get_sc_param('columns')
				), 
				"pan" => array(
					"title" => esc_html__("Use pan effect", 'dentario'),
					"desc" => wp_kses_data( __("Use pan effect to show section content", 'dentario') ),
					"divider" => true,
					"value" => "no",
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				),
				"scroll" => array(
					"title" => esc_html__("Use scroller", 'dentario'),
					"desc" => wp_kses_data( __("Use scroller to show section content", 'dentario') ),
					"divider" => true,
					"value" => "no",
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				),
				"scroll_dir" => array(
					"title" => esc_html__("Scroll and Pan direction", 'dentario'),
					"desc" => wp_kses_data( __("Scroll and Pan direction (if Use scroller = yes or Pan = yes)", 'dentario') ),
					"dependency" => array(
						'pan' => array('yes'),
						'scroll' => array('yes')
					),
					"value" => "horizontal",
					"type" => "switch",
					"size" => "big",
					"options" => dentario_get_sc_param('dir')
				),
				"scroll_controls" => array(
					"title" => esc_html__("Scroll controls", 'dentario'),
					"desc" => wp_kses_data( __("Show scroll controls (if Use scroller = yes)", 'dentario') ),
					"dependency" => array(
						'scroll' => array('yes')
					),
					"value" => "hide",
					"type" => "checklist",
					"options" => dentario_get_sc_param('controls')
				),
				"scheme" => array(
					"title" => esc_html__("Color scheme", 'dentario'),
					"desc" => wp_kses_data( __("Select color scheme for this block", 'dentario') ),
					"value" => "",
					"type" => "checklist",
					"options" => dentario_get_sc_param('schemes')
				),
				"color" => array(
					"title" => esc_html__("Fore color", 'dentario'),
					"desc" => wp_kses_data( __("Any color for objects in this section", 'dentario') ),
					"divider" => true,
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'dentario'),
					"desc" => wp_kses_data( __("Any background color for this section", 'dentario') ),
					"value" => "",
					"type" => "color"
				),
				"bg_image" => array(
					"title" => esc_html__("Background image URL", 'dentario'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site for the background", 'dentario') ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"bg_tile" => array(
					"title" => esc_html__("Tile background image", 'dentario'),
					"desc" => wp_kses_data( __("Do you want tile background image or image cover whole block?", 'dentario') ),
					"value" => "no",
					"dependency" => array(
						'bg_image' => array('not_empty')
					),
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				),
				"bg_overlay" => array(
					"title" => esc_html__("Overlay", 'dentario'),
					"desc" => wp_kses_data( __("Overlay color opacity (from 0.0 to 1.0)", 'dentario') ),
					"min" => "0",
					"max" => "1",
					"step" => "0.1",
					"value" => "0",
					"type" => "spinner"
				),
				"bg_texture" => array(
					"title" => esc_html__("Texture", 'dentario'),
					"desc" => wp_kses_data( __("Predefined texture style from 1 to 11. 0 - without texture.", 'dentario') ),
					"min" => "0",
					"max" => "11",
					"step" => "1",
					"value" => "0",
					"type" => "spinner"
				),
				"bg_padding" => array(
					"title" => esc_html__("Paddings around content", 'dentario'),
					"desc" => wp_kses_data( __("Add paddings around content in this section (only if bg_color or bg_image enabled).", 'dentario') ),
					"value" => "yes",
					"dependency" => array(
						'compare' => 'or',
						'bg_color' => array('not_empty'),
						'bg_texture' => array('not_empty'),
						'bg_image' => array('not_empty')
					),
					"type" => "switch",
					"options" => dentario_get_sc_param('yes_no')
				),
				"font_size" => array(
					"title" => esc_html__("Font size", 'dentario'),
					"desc" => wp_kses_data( __("Font size of the text (default - in pixels, allows any CSS units of measure)", 'dentario') ),
					"value" => "",
					"type" => "text"
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", 'dentario'),
					"desc" => wp_kses_data( __("Font weight of the text", 'dentario') ),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'100' => esc_html__('Thin (100)', 'dentario'),
						'300' => esc_html__('Light (300)', 'dentario'),
						'400' => esc_html__('Normal (400)', 'dentario'),
						'700' => esc_html__('Bold (700)', 'dentario')
					)
				),
				"_content_" => array(
					"title" => esc_html__("Container content", 'dentario'),
					"desc" => wp_kses_data( __("Content for section container", 'dentario') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
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
		);
		dentario_sc_map("trx_block", $sc);
		$sc["title"] = esc_html__("Section container", 'dentario');
		$sc["desc"] = esc_html__("Container for any section ([block] analog - to enable nesting)", 'dentario');
		dentario_sc_map("trx_section", $sc);
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_sc_section_reg_shortcodes_vc' ) ) {
	//add_action('dentario_action_shortcodes_list_vc', 'dentario_sc_section_reg_shortcodes_vc');
	function dentario_sc_section_reg_shortcodes_vc() {
	
		$sc = array(
			"base" => "trx_block",
			"name" => esc_html__("Block container", 'dentario'),
			"description" => wp_kses_data( __("Container for any block ([section] analog - to enable nesting)", 'dentario') ),
			"category" => esc_html__('Content', 'dentario'),
			'icon' => 'icon_trx_block',
			"class" => "trx_sc_collection trx_sc_block",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "dedicated",
					"heading" => esc_html__("Dedicated", 'dentario'),
					"description" => wp_kses_data( __("Use this block as dedicated content - show it before post title on single page", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(esc_html__('Use as dedicated content', 'dentario') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'dentario'),
					"description" => wp_kses_data( __("Select block alignment", 'dentario') ),
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "columns",
					"heading" => esc_html__("Columns emulation", 'dentario'),
					"description" => wp_kses_data( __("Select width for columns emulation", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('columns')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'dentario'),
					"description" => wp_kses_data( __("Title for the block", 'dentario') ),
					"admin_label" => true,
					"group" => esc_html__('Captions', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "subtitle",
					"heading" => esc_html__("Subtitle", 'dentario'),
					"description" => wp_kses_data( __("Subtitle for the block", 'dentario') ),
					"group" => esc_html__('Captions', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Description", 'dentario'),
					"description" => wp_kses_data( __("Description for the block", 'dentario') ),
					"group" => esc_html__('Captions', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Button URL", 'dentario'),
					"description" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'dentario') ),
					"group" => esc_html__('Captions', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_caption",
					"heading" => esc_html__("Button caption", 'dentario'),
					"description" => wp_kses_data( __("Caption for the button at the bottom of the block", 'dentario') ),
					"group" => esc_html__('Captions', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "pan",
					"heading" => esc_html__("Use pan effect", 'dentario'),
					"description" => wp_kses_data( __("Use pan effect to show section content", 'dentario') ),
					"group" => esc_html__('Scroll', 'dentario'),
					"class" => "",
					"value" => array(esc_html__('Content scroller', 'dentario') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "scroll",
					"heading" => esc_html__("Use scroller", 'dentario'),
					"description" => wp_kses_data( __("Use scroller to show section content", 'dentario') ),
					"group" => esc_html__('Scroll', 'dentario'),
					"admin_label" => true,
					"class" => "",
					"value" => array(esc_html__('Content scroller', 'dentario') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "scroll_dir",
					"heading" => esc_html__("Scroll direction", 'dentario'),
					"description" => wp_kses_data( __("Scroll direction (if Use scroller = yes)", 'dentario') ),
					"admin_label" => true,
					"class" => "",
					"group" => esc_html__('Scroll', 'dentario'),
					"value" => array_flip(dentario_get_sc_param('dir')),
					'dependency' => array(
						'element' => 'scroll',
						'not_empty' => true
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "scroll_controls",
					"heading" => esc_html__("Scroll controls", 'dentario'),
					"description" => wp_kses_data( __("Show scroll controls (if Use scroller = yes)", 'dentario') ),
					"class" => "",
					"group" => esc_html__('Scroll', 'dentario'),
					'dependency' => array(
						'element' => 'scroll',
						'not_empty' => true
					),
					"value" => array_flip(dentario_get_sc_param('controls')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", 'dentario'),
					"description" => wp_kses_data( __("Select color scheme for this block", 'dentario') ),
					"group" => esc_html__('Colors and Images', 'dentario'),
					"class" => "",
					"value" => array_flip(dentario_get_sc_param('schemes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Fore color", 'dentario'),
					"description" => wp_kses_data( __("Any color for objects in this section", 'dentario') ),
					"group" => esc_html__('Colors and Images', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'dentario'),
					"description" => wp_kses_data( __("Any background color for this section", 'dentario') ),
					"group" => esc_html__('Colors and Images', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_image",
					"heading" => esc_html__("Background image URL", 'dentario'),
					"description" => wp_kses_data( __("Select background image from library for this section", 'dentario') ),
					"group" => esc_html__('Colors and Images', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "bg_tile",
					"heading" => esc_html__("Tile background image", 'dentario'),
					"description" => wp_kses_data( __("Do you want tile background image or image cover whole block?", 'dentario') ),
					"group" => esc_html__('Colors and Images', 'dentario'),
					"class" => "",
					'dependency' => array(
						'element' => 'bg_image',
						'not_empty' => true
					),
					"std" => "no",
					"value" => array(esc_html__('Tile background image', 'dentario') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "bg_overlay",
					"heading" => esc_html__("Overlay", 'dentario'),
					"description" => wp_kses_data( __("Overlay color opacity (from 0.0 to 1.0)", 'dentario') ),
					"group" => esc_html__('Colors and Images', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "bg_texture",
					"heading" => esc_html__("Texture", 'dentario'),
					"description" => wp_kses_data( __("Texture style from 1 to 11. Empty or 0 - without texture.", 'dentario') ),
					"group" => esc_html__('Colors and Images', 'dentario'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "bg_padding",
					"heading" => esc_html__("Paddings around content", 'dentario'),
					"description" => wp_kses_data( __("Add paddings around content in this section (only if bg_color or bg_image enabled).", 'dentario') ),
					"group" => esc_html__('Colors and Images', 'dentario'),
					"class" => "",
					'dependency' => array(
						'element' => array('bg_color','bg_texture','bg_image'),
						'not_empty' => true
					),
					"std" => "yes",
					"value" => array(esc_html__('Disable padding around content in this block', 'dentario') => 'no'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'dentario'),
					"description" => wp_kses_data( __("Font size of the text (default - in pixels, allows any CSS units of measure)", 'dentario') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", 'dentario'),
					"description" => wp_kses_data( __("Font weight of the text", 'dentario') ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'dentario') => 'inherit',
						esc_html__('Thin (100)', 'dentario') => '100',
						esc_html__('Light (300)', 'dentario') => '300',
						esc_html__('Normal (400)', 'dentario') => '400',
						esc_html__('Bold (700)', 'dentario') => '700'
					),
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
		);
		
		// Block
		vc_map($sc);
		
		// Section
		$sc["base"] = 'trx_section';
		$sc["name"] = esc_html__("Section container", 'dentario');
		$sc["description"] = wp_kses_data( __("Container for any section ([block] analog - to enable nesting)", 'dentario') );
		$sc["class"] = "trx_sc_collection trx_sc_section";
		$sc["icon"] = 'icon_trx_section';
		vc_map($sc);
		
		class WPBakeryShortCode_Trx_Block extends DENTARIO_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_Section extends DENTARIO_VC_ShortCodeCollection {}
	}
}
?>