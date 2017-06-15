<?php
/**
 * Dentario Framework: Testimonial support
 *
 * @package	dentario
 * @since	dentario 1.0
 */

// Theme init
if (!function_exists('dentario_testimonial_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_testimonial_theme_setup', 1 );
	function dentario_testimonial_theme_setup() {
	
		// Add item in the admin menu
		add_action('add_meta_boxes',		'dentario_testimonial_add_meta_box');

		// Save data from meta box
		add_action('save_post',				'dentario_testimonial_save_data');

		// Register shortcodes [trx_testimonials] and [trx_testimonials_item]
		add_action('dentario_action_shortcodes_list',		'dentario_testimonials_reg_shortcodes');
		if (function_exists('dentario_exists_visual_composer') && dentario_exists_visual_composer())
			add_action('dentario_action_shortcodes_list_vc','dentario_testimonials_reg_shortcodes_vc');

		// Meta box fields
		dentario_storage_set('testimonial_meta_box', array(
			'id' => 'testimonial-meta-box',
			'title' => esc_html__('Testimonial Details', 'dentario'),
			'page' => 'testimonial',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				"testimonial_author" => array(
					"title" => esc_html__('Testimonial author',  'dentario'),
					"desc" => wp_kses_data( __("Name of the testimonial's author", 'dentario') ),
					"class" => "testimonial_author",
					"std" => "",
					"type" => "text"),
				"testimonial_position" => array(
					"title" => esc_html__("Author's position",  'dentario'),
					"desc" => wp_kses_data( __("Position of the testimonial's author", 'dentario') ),
					"class" => "testimonial_author",
					"std" => "",
					"type" => "text"),
				"testimonial_email" => array(
					"title" => esc_html__("Author's e-mail",  'dentario'),
					"desc" => wp_kses_data( __("E-mail of the testimonial's author - need to take Gravatar (if registered)", 'dentario') ),
					"class" => "testimonial_email",
					"std" => "",
					"type" => "text"),
				"testimonial_link" => array(
					"title" => esc_html__('Testimonial link',  'dentario'),
					"desc" => wp_kses_data( __("URL of the testimonial source or author profile page", 'dentario') ),
					"class" => "testimonial_link",
					"std" => "",
					"type" => "text")
				)
			)
		);
		
		// Add supported data types
		dentario_theme_support_pt('testimonial');
		dentario_theme_support_tx('testimonial_group');
		
	}
}


// Add meta box
if (!function_exists('dentario_testimonial_add_meta_box')) {
	//add_action('add_meta_boxes', 'dentario_testimonial_add_meta_box');
	function dentario_testimonial_add_meta_box() {
		$mb = dentario_storage_get('testimonial_meta_box');
		add_meta_box($mb['id'], $mb['title'], 'dentario_testimonial_show_meta_box', $mb['page'], $mb['context'], $mb['priority']);
	}
}

// Callback function to show fields in meta box
if (!function_exists('dentario_testimonial_show_meta_box')) {
	function dentario_testimonial_show_meta_box() {
		global $post;

		// Use nonce for verification
		echo '<input type="hidden" name="meta_box_testimonial_nonce" value="'.esc_attr(wp_create_nonce(admin_url())).'" />';
		
		$data = get_post_meta($post->ID, 'dentario_testimonial_data', true);
	
		$fields = dentario_storage_get_array('testimonial_meta_box', 'fields');
		?>
		<table class="testimonial_area">
		<?php
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) { 
				$meta = isset($data[$id]) ? $data[$id] : '';
				?>
				<tr class="testimonial_field <?php echo esc_attr($field['class']); ?>" valign="top">
					<td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
					<td><input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
						<br><small><?php echo esc_attr($field['desc']); ?></small></td>
				</tr>
				<?php
			}
		}
		?>
		</table>
		<?php
	}
}


// Save data from meta box
if (!function_exists('dentario_testimonial_save_data')) {
	//add_action('save_post', 'dentario_testimonial_save_data');
	function dentario_testimonial_save_data($post_id) {
		// verify nonce
		if ( !wp_verify_nonce( dentario_get_value_gp('meta_box_testimonial_nonce'), admin_url() ) )
			return $post_id;

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ($_POST['post_type']!='testimonial' || !current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		$data = array();

		$fields = dentario_storage_get_array('testimonial_meta_box', 'fields');

		// Post type specific data handling
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) { 
				if (isset($_POST[$id])) 
					$data[$id] = stripslashes($_POST[$id]);
			}
		}

		update_post_meta($post_id, 'dentario_testimonial_data', $data);
	}
}






// ---------------------------------- [trx_testimonials] ---------------------------------------

/*
[trx_testimonials id="unique_id" style="1|2|3"]
	[trx_testimonials_item user="user_login"]Testimonials text[/trx_testimonials_item]
	[trx_testimonials_item email="" name="" position="" photo="photo_url"]Testimonials text[/trx_testimonials]
[/trx_testimonials]
*/

if (!function_exists('dentario_sc_testimonials')) {
	function dentario_sc_testimonials($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "testimonials-1",
			"columns" => 1,
			"slider" => "yes",
			"slides_space" => 0,
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"align" => "",
			"custom" => "no",
			"ids" => "",
			"cat" => "",
			"count" => "3",
			"offset" => "",
			"orderby" => "date",
			"order" => "desc",
			"scheme" => "",
			"inverse" => 'no',
			"bg_color" => "",
			"bg_image" => "",
			"bg_overlay" => "",
			"bg_texture" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
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
	
		if (empty($id)) $id = "sc_testimonials_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && dentario_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);
	
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

		$ws = dentario_get_css_dimensions_from_values($width);
		$hs = dentario_get_css_dimensions_from_values('', $height);
		$css .= ($hs) . ($ws);

		$count = max(1, (int) $count);
		$columns = max(1, min(12, (int) $columns));
		if (dentario_param_is_off($custom) && $count < $columns) $columns = $count;
		
		dentario_storage_set('sc_testimonials_data', array(
			'id' => $id,
            'style' => $style,
            'columns' => $columns,
            'counter' => 0,
            'slider' => $slider,
            'css_wh' => $ws . $hs
            )
        );

		if (dentario_param_is_on($slider)) dentario_enqueue_slider('swiper');
	
		$output = ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || dentario_strlen($bg_texture)>2 || ($scheme && !dentario_param_is_off($scheme) && !dentario_param_is_inherit($scheme))
					? '<div class="sc_testimonials_wrap sc_section'
					        . ($scheme && !dentario_param_is_off($scheme) && !dentario_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '')
							. '"'
						.' style="'
							. ($bg_color !== '' && $bg_overlay==0 ? 'background-color:' . esc_attr($bg_color) . ';' : '')
							. ($bg_image !== '' ? 'background-image:url(' . esc_url($bg_image) . ');' : '')
							. '"'
						. (!dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
						. '>'
						. '<div class="sc_section_overlay'.($bg_texture>0 ? ' texture_bg_'.esc_attr($bg_texture) : '') . '"'
								. ' style="' . ($bg_overlay>0 ? 'background-color:rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.min(1, max(0, $bg_overlay)).');' : '')
									. (dentario_strlen($bg_texture)>2 ? 'background-image:url('.esc_url($bg_texture).');' : '')
									. '"'
									. ($bg_overlay > 0 ? ' data-overlay="'.esc_attr($bg_overlay).'" data-bg_color="'.esc_attr($bg_color).'"' : '')
									. '>' 
					: '')
				. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_testimonials sc_testimonials_style_'.esc_attr($style)
		            . ($inverse == "yes" ? ' sc_testimonials_inverse' : '')
 					. ' ' . esc_attr(dentario_get_template_property($style, 'container_classes'))
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
					. '"'
				. ($bg_color=='' && $bg_image=='' && $bg_overlay==0 && ($bg_texture=='' || $bg_texture=='0') && !dentario_param_is_off($animation) ? ' data-animation="'.esc_attr(dentario_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>'
			. (!empty($subtitle) ? '<h6 class="sc_testimonials_subtitle sc_item_subtitle">' . trim(dentario_strmacros($subtitle)) . '</h6>' : '')
			. (!empty($title) ? '<h2 class="sc_testimonials_title sc_item_title">' . trim(dentario_strmacros($title)) . '</h2>' : '')
			. (!empty($description) ? '<div class="sc_testimonials_descr sc_item_descr">' . trim(dentario_strmacros($description)) . '</div>' : '')
			. (dentario_param_is_on($slider) 
				? ('<div class="sc_slider_swiper swiper-slider-container'
								. ' ' . esc_attr(dentario_get_slider_controls_classes($controls))
								. (dentario_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
								. ($hs ? ' sc_slider_height_fixed' : '')
								. '"'
				. (!empty($width) && dentario_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
				. (!empty($height) && dentario_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
				. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
				. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
				. ($slides_space > 0 ? ' data-slides-space="' . esc_attr($slides_space) . '"' : '')
				. ' data-slides-min-width="250"'
			. '>'
					. '<div class="slides swiper-wrapper">')
				: ($columns > 1 
					? '<div class="sc_columns columns_wrap">' 
					: '')
				);
	
		$content = do_shortcode($content);
			
		if (dentario_param_is_on($custom) && $content) {
			$output .= $content;
		} else {
			global $post;
		
			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
			}
			
			$args = array(
				'post_type' => 'testimonial',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = dentario_query_add_sort_order($args, $orderby, $order);
			$args = dentario_query_add_posts_and_cats($args, $ids, 'testimonial', $cat, 'testimonial_group');
	
			$query = new WP_Query( $args );
	
			$post_number = 0;
				
			while ( $query->have_posts() ) { 
				$query->the_post();
				$post_number++;
				$args = array(
					'layout' => $style,
					'show' => false,
					'number' => $post_number,
					'posts_on_page' => ($count > 0 ? $count : $query->found_posts),
					"descr" => dentario_get_custom_option('post_excerpt_maxlength'.($columns > 1 ? '_masonry' : '')),
					"orderby" => $orderby,
					'content' => false,
					'terms_list' => false,
					'columns_count' => $columns,
					'slider' => $slider,
					'tag_id' => $id ? $id . '_' . $post_number : '',
					'tag_class' => '',
					'tag_animation' => '',
					'tag_css' => '',
					'tag_css_wh' => $ws . $hs
				);
				$post_data = dentario_get_post_data($args);
				$post_data['post_content'] = wpautop($post_data['post_content']);	// Add <p> around text and paragraphs. Need separate call because 'content'=>false (see above)
				$post_meta = get_post_meta($post_data['post_id'], 'dentario_testimonial_data', true);
				$thumb_sizes = dentario_get_thumb_sizes(array('layout' => $style));
				$args['author'] = $post_meta['testimonial_author'];
				$args['position'] = $post_meta['testimonial_position'];
				$args['link'] = !empty($post_meta['testimonial_link']) ? $post_meta['testimonial_link'] : '';	//$post_data['post_link'];
				$args['email'] = $post_meta['testimonial_email'];
				$args['photo'] = $post_data['post_thumb'];
				$mult = dentario_get_retina_multiplier();
				if (empty($args['photo']) && !empty($args['email'])) $args['photo'] = get_avatar($args['email'], $thumb_sizes['w']*$mult);
				$output .= dentario_show_post_layout($args, $post_data);
			}
			wp_reset_postdata();
		}
	
		if (dentario_param_is_on($slider)) {
			$output .= '</div>'
				. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '<div class="sc_slider_pagination_wrap"></div>'
				. '</div>';
		} else if ($columns > 1) {
			$output .= '</div>';
		}

		$output .= '</div>'
					. ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || dentario_strlen($bg_texture)>2
						?  '</div></div>'
						: '');
	
		// Add template specific scripts and styles
		do_action('dentario_action_blog_scripts', $style);

		return apply_filters('dentario_shortcode_output', $output, 'trx_testimonials', $atts, $content);
	}
	dentario_require_shortcode('trx_testimonials', 'dentario_sc_testimonials');
}
	
	
if (!function_exists('dentario_sc_testimonials_item')) {
	function dentario_sc_testimonials_item($atts, $content=null){	
		if (dentario_in_shortcode_blogger()) return '';
		extract(dentario_html_decode(shortcode_atts(array(
			// Individual params
			"author" => "",
			"position" => "",
			"link" => "",
			"photo" => "",
			"email" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
		), $atts)));

		dentario_storage_inc_array('sc_testimonials_data', 'counter');
	
		$id = $id ? $id : (dentario_storage_get_array('sc_testimonials_data', 'id') ? dentario_storage_get_array('sc_testimonials_data', 'id') . '_' . dentario_storage_get_array('sc_testimonials_data', 'counter') : '');
	
		$thumb_sizes = dentario_get_thumb_sizes(array('layout' => dentario_storage_get_array('sc_testimonials_data', 'style')));

		if (empty($photo)) {
			if (!empty($email))
				$mult = dentario_get_retina_multiplier();
				$photo = get_avatar($email, $thumb_sizes['w']*$mult);
		} else {
			if ($photo > 0) {
				$attach = wp_get_attachment_image_src( $photo, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$photo = $attach[0];
			}
			$photo = dentario_get_resized_image_tag($photo, $thumb_sizes['w'], $thumb_sizes['h']);
		}

		$post_data = array(
			'post_content' => do_shortcode($content)
		);
		$args = array(
			'layout' => dentario_storage_get_array('sc_testimonials_data', 'style'),
			'number' => dentario_storage_get_array('sc_testimonials_data', 'counter'),
			'columns_count' => dentario_storage_get_array('sc_testimonials_data', 'columns'),
			'slider' => dentario_storage_get_array('sc_testimonials_data', 'slider'),
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => '',
			'tag_css' => $css,
			'tag_css_wh' => dentario_storage_get_array('sc_testimonials_data', 'css_wh'),
			'author' => $author,
			'position' => $position,
			'link' => $link,
			'email' => $email,
			'photo' => $photo
		);
		$output = dentario_show_post_layout($args, $post_data);

		return apply_filters('dentario_shortcode_output', $output, 'trx_testimonials_item', $atts, $content);
	}
	dentario_require_shortcode('trx_testimonials_item', 'dentario_sc_testimonials_item');
}
// ---------------------------------- [/trx_testimonials] ---------------------------------------



// Add [trx_testimonials] and [trx_testimonials_item] in the shortcodes list
if (!function_exists('dentario_testimonials_reg_shortcodes')) {
	//add_filter('dentario_action_shortcodes_list',	'dentario_testimonials_reg_shortcodes');
	function dentario_testimonials_reg_shortcodes() {
		if (dentario_storage_isset('shortcodes')) {

			$testimonials_groups = dentario_get_list_terms(false, 'testimonial_group');
			$testimonials_styles = dentario_get_list_templates('testimonials');
			$controls = dentario_get_list_slider_controls();

			dentario_sc_map_before('trx_title', array(
			
				// Testimonials
				"trx_testimonials" => array(
					"title" => esc_html__("Testimonials", 'dentario'),
					"desc" => wp_kses_data( __("Insert testimonials into post (page)", 'dentario') ),
					"decorate" => true,
					"container" => false,
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
						"style" => array(
							"title" => esc_html__("Testimonials style", 'dentario'),
							"desc" => wp_kses_data( __("Select style to display testimonials", 'dentario') ),
							"value" => "testimonials-1",
							"type" => "select",
							"options" => $testimonials_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", 'dentario'),
							"desc" => wp_kses_data( __("How many columns use to show testimonials", 'dentario') ),
							"value" => 1,
							"min" => 1,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"slider" => array(
							"title" => esc_html__("Slider", 'dentario'),
							"desc" => wp_kses_data( __("Use slider to show testimonials", 'dentario') ),
							"value" => "yes",
							"type" => "switch",
							"options" => dentario_get_sc_param('yes_no')
						),
						"controls" => array(
							"title" => esc_html__("Controls", 'dentario'),
							"desc" => wp_kses_data( __("Slider controls style and position", 'dentario') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $controls
						),
						"slides_space" => array(
							"title" => esc_html__("Space between slides", 'dentario'),
							"desc" => wp_kses_data( __("Size of space (in px) between slides", 'dentario') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"step" => 10,
							"type" => "spinner"
						),
						"interval" => array(
							"title" => esc_html__("Slides change interval", 'dentario'),
							"desc" => wp_kses_data( __("Slides change interval (in milliseconds: 1000ms = 1s)", 'dentario') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"autoheight" => array(
							"title" => esc_html__("Autoheight", 'dentario'),
							"desc" => wp_kses_data( __("Change whole slider's height (make it equal current slide's height)", 'dentario') ),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => dentario_get_sc_param('yes_no')
						),
						"align" => array(
							"title" => esc_html__("Alignment", 'dentario'),
							"desc" => wp_kses_data( __("Alignment of the testimonials block", 'dentario') ),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => dentario_get_sc_param('align')
						),
						"custom" => array(
							"title" => esc_html__("Custom", 'dentario'),
							"desc" => wp_kses_data( __("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", 'dentario') ),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => dentario_get_sc_param('yes_no')
						),
						"cat" => array(
							"title" => esc_html__("Categories", 'dentario'),
							"desc" => wp_kses_data( __("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", 'dentario') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => dentario_array_merge(array(0 => esc_html__('- Select category -', 'dentario')), $testimonials_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of posts", 'dentario'),
							"desc" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'dentario') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", 'dentario'),
							"desc" => wp_kses_data( __("Skip posts before select next part.", 'dentario') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Post order by", 'dentario'),
							"desc" => wp_kses_data( __("Select desired posts sorting method", 'dentario') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "date",
							"type" => "select",
							"options" => dentario_get_sc_param('sorting')
						),
						"order" => array(
							"title" => esc_html__("Post order", 'dentario'),
							"desc" => wp_kses_data( __("Select desired posts order", 'dentario') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => dentario_get_sc_param('ordering')
						),
						"ids" => array(
							"title" => esc_html__("Post IDs list", 'dentario'),
							"desc" => wp_kses_data( __("Comma separated list of posts ID. If set - parameters above are ignored!", 'dentario') ),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "",
							"type" => "text"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", 'dentario'),
							"desc" => wp_kses_data( __("Select color scheme for this block", 'dentario') ),
							"value" => "",
							"type" => "checklist",
							"options" => dentario_get_sc_param('schemes')
						),"bg_color" => array(
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
					),
					"children" => array(
						"name" => "trx_testimonials_item",
						"title" => esc_html__("Item", 'dentario'),
						"desc" => wp_kses_data( __("Testimonials item (custom parameters)", 'dentario') ),
						"container" => true,
						"params" => array(
							"author" => array(
								"title" => esc_html__("Author", 'dentario'),
								"desc" => wp_kses_data( __("Name of the testimonmials author", 'dentario') ),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => esc_html__("Link", 'dentario'),
								"desc" => wp_kses_data( __("Link URL to the testimonmials author page", 'dentario') ),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => esc_html__("E-mail", 'dentario'),
								"desc" => wp_kses_data( __("E-mail of the testimonmials author (to get gravatar)", 'dentario') ),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => esc_html__("Photo", 'dentario'),
								"desc" => wp_kses_data( __("Select or upload photo of testimonmials author or write URL of photo from other site", 'dentario') ),
								"value" => "",
								"type" => "media"
							),
							"_content_" => array(
								"title" => esc_html__("Testimonials text", 'dentario'),
								"desc" => wp_kses_data( __("Current testimonials text", 'dentario') ),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => dentario_get_sc_param('id'),
							"class" => dentario_get_sc_param('class'),
							"css" => dentario_get_sc_param('css')
						)
					)
				)

			));
		}
	}
}


// Add [trx_testimonials] and [trx_testimonials_item] in the VC shortcodes list
if (!function_exists('dentario_testimonials_reg_shortcodes_vc')) {
	//add_filter('dentario_action_shortcodes_list_vc',	'dentario_testimonials_reg_shortcodes_vc');
	function dentario_testimonials_reg_shortcodes_vc() {

		$testimonials_groups = dentario_get_list_terms(false, 'testimonial_group');
		$testimonials_styles = dentario_get_list_templates('testimonials');
		$controls			 = dentario_get_list_slider_controls();
			
		// Testimonials			
		vc_map( array(
				"base" => "trx_testimonials",
				"name" => esc_html__("Testimonials", 'dentario'),
				"description" => wp_kses_data( __("Insert testimonials slider", 'dentario') ),
				"category" => esc_html__('Content', 'dentario'),
				'icon' => 'icon_trx_testimonials',
				"class" => "trx_sc_columns trx_sc_testimonials",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_testimonials_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Testimonials style", 'dentario'),
						"description" => wp_kses_data( __("Select style to display testimonials", 'dentario') ),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($testimonials_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", 'dentario'),
						"description" => wp_kses_data( __("Use slider to show testimonials", 'dentario') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'dentario'),
						"class" => "",
						"std" => "yes",
						"value" => array_flip(dentario_get_sc_param('yes_no')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", 'dentario'),
						"description" => wp_kses_data( __("Slider controls style and position", 'dentario') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'dentario'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"std" => "no",
						"value" => array_flip($controls),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides", 'dentario'),
						"description" => wp_kses_data( __("Size of space (in px) between slides", 'dentario') ),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'dentario'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Slides change interval", 'dentario'),
						"description" => wp_kses_data( __("Slides change interval (in milliseconds: 1000ms = 1s)", 'dentario') ),
						"group" => esc_html__('Slider', 'dentario'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "autoheight",
						"heading" => esc_html__("Autoheight", 'dentario'),
						"description" => wp_kses_data( __("Change whole slider's height (make it equal current slide's height)", 'dentario') ),
						"group" => esc_html__('Slider', 'dentario'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", 'dentario'),
						"description" => wp_kses_data( __("Alignment of the testimonials block", 'dentario') ),
						"class" => "",
						"value" => array_flip(dentario_get_sc_param('align')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", 'dentario'),
						"description" => wp_kses_data( __("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", 'dentario') ),
						"class" => "",
						"value" => array("Custom slides" => "yes" ),
						"type" => "checkbox"
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
						"param_name" => "cat",
						"heading" => esc_html__("Categories", 'dentario'),
						"description" => wp_kses_data( __("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", 'dentario') ),
						"group" => esc_html__('Query', 'dentario'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(dentario_array_merge(array(0 => esc_html__('- Select category -', 'dentario')), $testimonials_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'dentario'),
						"description" => wp_kses_data( __("How many columns use to show testimonials", 'dentario') ),
						"group" => esc_html__('Query', 'dentario'),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", 'dentario'),
						"description" => wp_kses_data( __("How many posts will be displayed? If used IDs - this parameter ignored.", 'dentario') ),
						"group" => esc_html__('Query', 'dentario'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", 'dentario'),
						"description" => wp_kses_data( __("Skip posts before select next part.", 'dentario') ),
						"group" => esc_html__('Query', 'dentario'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", 'dentario'),
						"description" => wp_kses_data( __("Select desired posts sorting method", 'dentario') ),
						"group" => esc_html__('Query', 'dentario'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"std" => "date",
						"class" => "",
						"value" => array_flip(dentario_get_sc_param('sorting')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", 'dentario'),
						"description" => wp_kses_data( __("Select desired posts order", 'dentario') ),
						"group" => esc_html__('Query', 'dentario'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"std" => "desc",
						"class" => "",
						"value" => array_flip(dentario_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("Post IDs list", 'dentario'),
						"description" => wp_kses_data( __("Comma separated list of posts ID. If set - parameters above are ignored!", 'dentario') ),
						"group" => esc_html__('Query', 'dentario'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
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
						"param_name" => "inverse",
						"heading" => esc_html__("Inverse color", 'dentario'),
						"description" => wp_kses_data( __("Make all elements white (for dark backgrounds)", 'dentario') ),
						"group" => esc_html__('Colors and Images', 'dentario'),
						"class" => "",
						"value" => array(esc_html__("Inverse color",'dentario') => "yes" ),
						"type" => "checkbox"
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
					dentario_vc_width(),
					dentario_vc_height(),
					dentario_get_vc_param('margin_top'),
					dentario_get_vc_param('margin_bottom'),
					dentario_get_vc_param('margin_left'),
					dentario_get_vc_param('margin_right'),
					dentario_get_vc_param('id'),
					dentario_get_vc_param('class'),
					dentario_get_vc_param('animation'),
					dentario_get_vc_param('css')
				),
				'js_view' => 'VcTrxColumnsView'
		) );
			
			
		vc_map( array(
				"base" => "trx_testimonials_item",
				"name" => esc_html__("Testimonial", 'dentario'),
				"description" => wp_kses_data( __("Single testimonials item", 'dentario') ),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_column_item trx_sc_testimonials_item",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_testimonials_item',
				"as_child" => array('only' => 'trx_testimonials'),
				"as_parent" => array('except' => 'trx_testimonials'),
				"params" => array(
					array(
						"param_name" => "author",
						"heading" => esc_html__("Author", 'dentario'),
						"description" => wp_kses_data( __("Name of the testimonmials author", 'dentario') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", 'dentario'),
						"description" => wp_kses_data( __("Link URL to the testimonmials author page", 'dentario') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "email",
						"heading" => esc_html__("E-mail", 'dentario'),
						"description" => wp_kses_data( __("E-mail of the testimonmials author", 'dentario') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => esc_html__("Photo", 'dentario'),
						"description" => wp_kses_data( __("Select or upload photo of testimonmials author or write URL of photo from other site", 'dentario') ),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					dentario_get_vc_param('id'),
					dentario_get_vc_param('class'),
					dentario_get_vc_param('css')
				),
				'js_view' => 'VcTrxColumnItemView'
		) );
			
		class WPBakeryShortCode_Trx_Testimonials extends DENTARIO_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Testimonials_Item extends DENTARIO_VC_ShortCodeCollection {}
		
	}
}
?>