<?php
/**
 * Dentario Framework: return lists
 *
 * @package dentario
 * @since dentario 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'dentario_get_list_styles' ) ) {
	function dentario_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'dentario'), $i);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'dentario_get_list_margins' ) ) {
	function dentario_get_list_margins($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'dentario'),
				'tiny'		=> esc_html__('Tiny',		'dentario'),
				'small'		=> esc_html__('Small',		'dentario'),
				'medium'	=> esc_html__('Medium',		'dentario'),
				'large'		=> esc_html__('Large',		'dentario'),
				'huge'		=> esc_html__('Huge',		'dentario'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'dentario'),
				'small-'	=> esc_html__('Small (negative)',	'dentario'),
				'medium-'	=> esc_html__('Medium (negative)',	'dentario'),
				'large-'	=> esc_html__('Large (negative)',	'dentario'),
				'huge-'		=> esc_html__('Huge (negative)',	'dentario')
				);
			$list = apply_filters('dentario_filter_list_margins', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'dentario_get_list_animations' ) ) {
	function dentario_get_list_animations($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'dentario'),
				'bounced'		=> esc_html__('Bounced',		'dentario'),
				'flash'			=> esc_html__('Flash',		'dentario'),
				'flip'			=> esc_html__('Flip',		'dentario'),
				'pulse'			=> esc_html__('Pulse',		'dentario'),
				'rubberBand'	=> esc_html__('Rubber Band',	'dentario'),
				'shake'			=> esc_html__('Shake',		'dentario'),
				'swing'			=> esc_html__('Swing',		'dentario'),
				'tada'			=> esc_html__('Tada',		'dentario'),
				'wobble'		=> esc_html__('Wobble',		'dentario')
				);
			$list = apply_filters('dentario_filter_list_animations', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'dentario_get_list_line_styles' ) ) {
	function dentario_get_list_line_styles($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'dentario'),
				'dashed'=> esc_html__('Dashed', 'dentario'),
				'dotted'=> esc_html__('Dotted', 'dentario'),
				'double'=> esc_html__('Double', 'dentario'),
				'image'	=> esc_html__('Image', 'dentario')
				);
			$list = apply_filters('dentario_filter_list_line_styles', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'dentario_get_list_animations_in' ) ) {
	function dentario_get_list_animations_in($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'dentario'),
				'bounceIn'			=> esc_html__('Bounce In',			'dentario'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'dentario'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'dentario'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'dentario'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'dentario'),
				'fadeIn'			=> esc_html__('Fade In',			'dentario'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'dentario'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'dentario'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'dentario'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'dentario'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'dentario'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'dentario'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'dentario'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'dentario'),
				'flipInX'			=> esc_html__('Flip In X',			'dentario'),
				'flipInY'			=> esc_html__('Flip In Y',			'dentario'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'dentario'),
				'rotateIn'			=> esc_html__('Rotate In',			'dentario'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','dentario'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'dentario'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'dentario'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','dentario'),
				'rollIn'			=> esc_html__('Roll In',			'dentario'),
				'slideInUp'			=> esc_html__('Slide In Up',		'dentario'),
				'slideInDown'		=> esc_html__('Slide In Down',		'dentario'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'dentario'),
				'slideInRight'		=> esc_html__('Slide In Right',		'dentario'),
				'zoomIn'			=> esc_html__('Zoom In',			'dentario'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'dentario'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'dentario'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'dentario'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'dentario')
				);
			$list = apply_filters('dentario_filter_list_animations_in', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'dentario_get_list_animations_out' ) ) {
	function dentario_get_list_animations_out($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',	'dentario'),
				'bounceOut'			=> esc_html__('Bounce Out',			'dentario'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'dentario'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',		'dentario'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',		'dentario'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'dentario'),
				'fadeOut'			=> esc_html__('Fade Out',			'dentario'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',			'dentario'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'dentario'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'dentario'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'dentario'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',		'dentario'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'dentario'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'dentario'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'dentario'),
				'flipOutX'			=> esc_html__('Flip Out X',			'dentario'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'dentario'),
				'hinge'				=> esc_html__('Hinge Out',			'dentario'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',		'dentario'),
				'rotateOut'			=> esc_html__('Rotate Out',			'dentario'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left',	'dentario'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right',		'dentario'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',		'dentario'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right',	'dentario'),
				'rollOut'			=> esc_html__('Roll Out',		'dentario'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'dentario'),
				'slideOutDown'		=> esc_html__('Slide Out Down',	'dentario'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',	'dentario'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'dentario'),
				'zoomOut'			=> esc_html__('Zoom Out',			'dentario'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'dentario'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',	'dentario'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',	'dentario'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',	'dentario')
				);
			$list = apply_filters('dentario_filter_list_animations_out', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('dentario_get_animation_classes')) {
	function dentario_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return dentario_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!dentario_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of categories
if ( !function_exists( 'dentario_get_list_categories' ) ) {
	function dentario_get_list_categories($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'dentario_get_list_terms' ) ) {
	function dentario_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = dentario_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = dentario_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'dentario_get_list_posts_types' ) ) {
	function dentario_get_list_posts_types($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_posts_types'))=='') {
			/* 
			// This way to return all registered post types
			$types = get_post_types();
			if (in_array('post', $types)) $list['post'] = esc_html__('Post', 'dentario');
			if (is_array($types) && count($types) > 0) {
				foreach ($types as $t) {
					if ($t == 'post') continue;
					$list[$t] = dentario_strtoproper($t);
				}
			}
			*/
			// Return only theme inheritance supported post types
			$list = apply_filters('dentario_filter_list_post_types', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'dentario_get_list_posts' ) ) {
	function dentario_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = dentario_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'dentario');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set($hash, $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'dentario_get_list_pages' ) ) {
	function dentario_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return dentario_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'dentario_get_list_users' ) ) {
	function dentario_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = dentario_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'dentario');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_users', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'dentario_get_list_sliders' ) ) {
	function dentario_get_list_sliders($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'dentario')
			);
			$list = apply_filters('dentario_filter_list_sliders', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'dentario_get_list_slider_controls' ) ) {
	function dentario_get_list_slider_controls($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'dentario'),
				'side'		=> esc_html__('Side', 'dentario'),
				'bottom'	=> esc_html__('Bottom', 'dentario'),
				'pagination'=> esc_html__('Pagination', 'dentario')
				);
			$list = apply_filters('dentario_filter_list_slider_controls', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'dentario_get_slider_controls_classes' ) ) {
	function dentario_get_slider_controls_classes($controls) {
		if (dentario_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'dentario_get_list_popup_engines' ) ) {
	function dentario_get_list_popup_engines($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'dentario'),
				"magnific"	=> esc_html__("Magnific popup", 'dentario')
				);
			$list = apply_filters('dentario_filter_list_popup_engines', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'dentario_get_list_menus' ) ) {
	function dentario_get_list_menus($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'dentario');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'dentario_get_list_sidebars' ) ) {
	function dentario_get_list_sidebars($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_sidebars'))=='') {
			if (($list = dentario_storage_get('registered_sidebars'))=='') $list = array();
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'dentario_get_list_sidebars_positions' ) ) {
	function dentario_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'dentario'),
				'left'  => esc_html__('Left',  'dentario'),
				'right' => esc_html__('Right', 'dentario')
				);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'dentario_get_sidebar_class' ) ) {
	function dentario_get_sidebar_class() {
		$sb_main = dentario_get_custom_option('show_sidebar_main');
		$sb_outer = dentario_get_custom_option('show_sidebar_outer');
		return (dentario_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (dentario_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_body_styles' ) ) {
	function dentario_get_list_body_styles($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'dentario'),
				'wide'	=> esc_html__('Wide',		'dentario')
				);
			if (dentario_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'dentario');
				$list['fullscreen']	= esc_html__('Fullscreen',	'dentario');
			}
			$list = apply_filters('dentario_filter_list_body_styles', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return skins list, prepended inherit
if ( !function_exists( 'dentario_get_list_skins' ) ) {
	function dentario_get_list_skins($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_skins'))=='') {
			$list = dentario_get_list_folders("skins");
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_skins', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return css-themes list
if ( !function_exists( 'dentario_get_list_themes' ) ) {
	function dentario_get_list_themes($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_themes'))=='') {
			$list = dentario_get_list_files("css/themes");
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_themes', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'dentario_get_list_templates' ) ) {
	function dentario_get_list_templates($mode='') {
		if (($list = dentario_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = dentario_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: dentario_strtoproper($v['layout'])
										);
				}
			}
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_templates_blog' ) ) {
	function dentario_get_list_templates_blog($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_templates_blog'))=='') {
			$list = dentario_get_list_templates('blog');
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_templates_blogger' ) ) {
	function dentario_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_templates_blogger'))=='') {
			$list = dentario_array_merge(dentario_get_list_templates('blogger'), dentario_get_list_templates('blog'));
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_templates_single' ) ) {
	function dentario_get_list_templates_single($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_templates_single'))=='') {
			$list = dentario_get_list_templates('single');
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_templates_header' ) ) {
	function dentario_get_list_templates_header($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_templates_header'))=='') {
			$list = dentario_get_list_templates('header');
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_templates_forms' ) ) {
	function dentario_get_list_templates_forms($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_templates_forms'))=='') {
			$list = dentario_get_list_templates('forms');
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_article_styles' ) ) {
	function dentario_get_list_article_styles($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'dentario'),
				"stretch" => esc_html__('Stretch', 'dentario')
				);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'dentario_get_list_post_formats_filters' ) ) {
	function dentario_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'dentario'),
				"thumbs"  => esc_html__('With thumbs', 'dentario'),
				"reviews" => esc_html__('With reviews', 'dentario'),
				"video"   => esc_html__('With videos', 'dentario'),
				"audio"   => esc_html__('With audios', 'dentario'),
				"gallery" => esc_html__('With galleries', 'dentario')
				);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'dentario_get_list_portfolio_filters' ) ) {
	function dentario_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'dentario'),
				"tags"		=> esc_html__('Tags', 'dentario'),
				"categories"=> esc_html__('Categories', 'dentario')
				);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_hovers' ) ) {
	function dentario_get_list_hovers($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'dentario');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'dentario');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'dentario');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'dentario');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'dentario');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'dentario');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'dentario');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'dentario');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'dentario');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'dentario');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'dentario');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'dentario');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'dentario');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'dentario');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'dentario');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'dentario');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'dentario');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'dentario');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'dentario');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'dentario');
			$list['square effect1']  = esc_html__('Square Effect 1',  'dentario');
			$list['square effect2']  = esc_html__('Square Effect 2',  'dentario');
			$list['square effect3']  = esc_html__('Square Effect 3',  'dentario');
	//		$list['square effect4']  = esc_html__('Square Effect 4',  'dentario');
			$list['square effect5']  = esc_html__('Square Effect 5',  'dentario');
			$list['square effect6']  = esc_html__('Square Effect 6',  'dentario');
			$list['square effect7']  = esc_html__('Square Effect 7',  'dentario');
			$list['square effect8']  = esc_html__('Square Effect 8',  'dentario');
			$list['square effect9']  = esc_html__('Square Effect 9',  'dentario');
			$list['square effect10'] = esc_html__('Square Effect 10',  'dentario');
			$list['square effect11'] = esc_html__('Square Effect 11',  'dentario');
			$list['square effect12'] = esc_html__('Square Effect 12',  'dentario');
			$list['square effect13'] = esc_html__('Square Effect 13',  'dentario');
			$list['square effect14'] = esc_html__('Square Effect 14',  'dentario');
			$list['square effect15'] = esc_html__('Square Effect 15',  'dentario');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'dentario');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'dentario');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'dentario');
			$list['square effect_more']  = esc_html__('Square Effect More',  'dentario');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'dentario');
			$list = apply_filters('dentario_filter_portfolio_hovers', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'dentario_get_list_blog_counters' ) ) {
	function dentario_get_list_blog_counters($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'dentario'),
				'likes'		=> esc_html__('Likes', 'dentario'),
				'rating'	=> esc_html__('Rating', 'dentario'),
				'comments'	=> esc_html__('Comments', 'dentario')
				);
			$list = apply_filters('dentario_filter_list_blog_counters', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'dentario_get_list_alter_sizes' ) ) {
	function dentario_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'dentario'),
					'1_2' => esc_html__('1x2', 'dentario'),
					'2_1' => esc_html__('2x1', 'dentario'),
					'2_2' => esc_html__('2x2', 'dentario'),
					'1_3' => esc_html__('1x3', 'dentario'),
					'2_3' => esc_html__('2x3', 'dentario'),
					'3_1' => esc_html__('3x1', 'dentario'),
					'3_2' => esc_html__('3x2', 'dentario'),
					'3_3' => esc_html__('3x3', 'dentario')
					);
			$list = apply_filters('dentario_filter_portfolio_alter_sizes', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'dentario_get_list_hovers_directions' ) ) {
	function dentario_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'dentario'),
				'right_to_left' => esc_html__('Right to Left',  'dentario'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'dentario'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'dentario'),
				'scale_up'      => esc_html__('Scale Up',  'dentario'),
				'scale_down'    => esc_html__('Scale Down',  'dentario'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'dentario'),
				'from_left_and_right' => esc_html__('From Left and Right',  'dentario'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'dentario')
			);
			$list = apply_filters('dentario_filter_portfolio_hovers_directions', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'dentario_get_list_label_positions' ) ) {
	function dentario_get_list_label_positions($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'dentario'),
				'bottom'	=> esc_html__('Bottom',		'dentario'),
				'left'		=> esc_html__('Left',		'dentario'),
				'over'		=> esc_html__('Over',		'dentario')
			);
			$list = apply_filters('dentario_filter_label_positions', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'dentario_get_list_bg_image_positions' ) ) {
	function dentario_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'dentario'),
				'center top'   => esc_html__("Center Top", 'dentario'),
				'right top'    => esc_html__("Right Top", 'dentario'),
				'left center'  => esc_html__("Left Center", 'dentario'),
				'center center'=> esc_html__("Center Center", 'dentario'),
				'right center' => esc_html__("Right Center", 'dentario'),
				'left bottom'  => esc_html__("Left Bottom", 'dentario'),
				'center bottom'=> esc_html__("Center Bottom", 'dentario'),
				'right bottom' => esc_html__("Right Bottom", 'dentario')
			);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'dentario_get_list_bg_image_repeats' ) ) {
	function dentario_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'dentario'),
				'repeat-x'	=> esc_html__('Repeat X', 'dentario'),
				'repeat-y'	=> esc_html__('Repeat Y', 'dentario'),
				'no-repeat'	=> esc_html__('No Repeat', 'dentario')
			);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'dentario_get_list_bg_image_attachments' ) ) {
	function dentario_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'dentario'),
				'fixed'		=> esc_html__('Fixed', 'dentario'),
				'local'		=> esc_html__('Local', 'dentario')
			);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'dentario_get_list_bg_tints' ) ) {
	function dentario_get_list_bg_tints($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'dentario'),
				'light'	=> esc_html__('Light', 'dentario'),
				'dark'	=> esc_html__('Dark', 'dentario')
			);
			$list = apply_filters('dentario_filter_bg_tints', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'dentario_get_list_field_types' ) ) {
	function dentario_get_list_field_types($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'dentario'),
				'textarea' => esc_html__('Text Area','dentario'),
				'password' => esc_html__('Password',  'dentario'),
				'radio'    => esc_html__('Radio',  'dentario'),
				'checkbox' => esc_html__('Checkbox',  'dentario'),
				'select'   => esc_html__('Select',  'dentario'),
				'date'     => esc_html__('Date','dentario'),
				'time'     => esc_html__('Time','dentario'),
				'button'   => esc_html__('Button','dentario')
			);
			$list = apply_filters('dentario_filter_field_types', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'dentario_get_list_googlemap_styles' ) ) {
	function dentario_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'dentario')
			);
			$list = apply_filters('dentario_filter_googlemap_styles', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'dentario_get_list_icons' ) ) {
	function dentario_get_list_icons($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_icons'))=='') {
			$list = dentario_parse_icons_classes(dentario_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'dentario_get_list_socials' ) ) {
	function dentario_get_list_socials($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_socials'))=='') {
			$list = dentario_get_list_files("images/socials", "png");
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return flags list
if ( !function_exists( 'dentario_get_list_flags' ) ) {
	function dentario_get_list_flags($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_flags'))=='') {
			$list = dentario_get_list_files("images/flags", "png");
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_flags', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'dentario_get_list_yesno' ) ) {
	function dentario_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'dentario'),
			'no'  => esc_html__("No", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'dentario_get_list_onoff' ) ) {
	function dentario_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'dentario'),
			"off" => esc_html__("Off", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'dentario_get_list_showhide' ) ) {
	function dentario_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'dentario'),
			"hide" => esc_html__("Hide", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'dentario_get_list_orderings' ) ) {
	function dentario_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'dentario'),
			"desc" => esc_html__("Descending", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'dentario_get_list_directions' ) ) {
	function dentario_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'dentario'),
			"vertical" => esc_html__("Vertical", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'dentario_get_list_shapes' ) ) {
	function dentario_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'dentario'),
			"square" => esc_html__("Square", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'dentario_get_list_sizes' ) ) {
	function dentario_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'dentario'),
			"small"  => esc_html__("Small", 'dentario'),
			"medium" => esc_html__("Medium", 'dentario'),
			"large"  => esc_html__("Large", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'dentario_get_list_controls' ) ) {
	function dentario_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'dentario'),
			"side" => esc_html__("Side", 'dentario'),
			"bottom" => esc_html__("Bottom", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'dentario_get_list_floats' ) ) {
	function dentario_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'dentario'),
			"left" => esc_html__("Float Left", 'dentario'),
			"right" => esc_html__("Float Right", 'dentario')
		);
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'dentario_get_list_alignments' ) ) {
	function dentario_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'dentario'),
			"left" => esc_html__("Left", 'dentario'),
			"center" => esc_html__("Center", 'dentario'),
			"right" => esc_html__("Right", 'dentario')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'dentario');
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'dentario_get_list_hpos' ) ) {
	function dentario_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'dentario');
		if ($center) $list['center'] = esc_html__("Center", 'dentario');
		$list['right'] = esc_html__("Right", 'dentario');
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'dentario_get_list_vpos' ) ) {
	function dentario_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'dentario');
		if ($center) $list['center'] = esc_html__("Center", 'dentario');
		$list['bottom'] = esc_html__("Bottom", 'dentario');
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'dentario_get_list_sortings' ) ) {
	function dentario_get_list_sortings($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'dentario'),
				"title" => esc_html__("Alphabetically", 'dentario'),
				"views" => esc_html__("Popular (views count)", 'dentario'),
				"comments" => esc_html__("Most commented (comments count)", 'dentario'),
				"author_rating" => esc_html__("Author rating", 'dentario'),
				"users_rating" => esc_html__("Visitors (users) rating", 'dentario'),
				"random" => esc_html__("Random", 'dentario')
			);
			$list = apply_filters('dentario_filter_list_sortings', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'dentario_get_list_columns' ) ) {
	function dentario_get_list_columns($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'dentario'),
				"1_1" => esc_html__("100%", 'dentario'),
				"1_2" => esc_html__("1/2", 'dentario'),
				"1_3" => esc_html__("1/3", 'dentario'),
				"2_3" => esc_html__("2/3", 'dentario'),
				"1_4" => esc_html__("1/4", 'dentario'),
				"3_4" => esc_html__("3/4", 'dentario'),
				"1_5" => esc_html__("1/5", 'dentario'),
				"2_5" => esc_html__("2/5", 'dentario'),
				"3_5" => esc_html__("3/5", 'dentario'),
				"4_5" => esc_html__("4/5", 'dentario'),
				"1_6" => esc_html__("1/6", 'dentario'),
				"5_6" => esc_html__("5/6", 'dentario'),
				"1_7" => esc_html__("1/7", 'dentario'),
				"2_7" => esc_html__("2/7", 'dentario'),
				"3_7" => esc_html__("3/7", 'dentario'),
				"4_7" => esc_html__("4/7", 'dentario'),
				"5_7" => esc_html__("5/7", 'dentario'),
				"6_7" => esc_html__("6/7", 'dentario'),
				"1_8" => esc_html__("1/8", 'dentario'),
				"3_8" => esc_html__("3/8", 'dentario'),
				"5_8" => esc_html__("5/8", 'dentario'),
				"7_8" => esc_html__("7/8", 'dentario'),
				"1_9" => esc_html__("1/9", 'dentario'),
				"2_9" => esc_html__("2/9", 'dentario'),
				"4_9" => esc_html__("4/9", 'dentario'),
				"5_9" => esc_html__("5/9", 'dentario'),
				"7_9" => esc_html__("7/9", 'dentario'),
				"8_9" => esc_html__("8/9", 'dentario'),
				"1_10"=> esc_html__("1/10", 'dentario'),
				"3_10"=> esc_html__("3/10", 'dentario'),
				"7_10"=> esc_html__("7/10", 'dentario'),
				"9_10"=> esc_html__("9/10", 'dentario'),
				"1_11"=> esc_html__("1/11", 'dentario'),
				"2_11"=> esc_html__("2/11", 'dentario'),
				"3_11"=> esc_html__("3/11", 'dentario'),
				"4_11"=> esc_html__("4/11", 'dentario'),
				"5_11"=> esc_html__("5/11", 'dentario'),
				"6_11"=> esc_html__("6/11", 'dentario'),
				"7_11"=> esc_html__("7/11", 'dentario'),
				"8_11"=> esc_html__("8/11", 'dentario'),
				"9_11"=> esc_html__("9/11", 'dentario'),
				"10_11"=> esc_html__("10/11", 'dentario'),
				"1_12"=> esc_html__("1/12", 'dentario'),
				"5_12"=> esc_html__("5/12", 'dentario'),
				"7_12"=> esc_html__("7/12", 'dentario'),
				"10_12"=> esc_html__("10/12", 'dentario'),
				"11_12"=> esc_html__("11/12", 'dentario')
			);
			$list = apply_filters('dentario_filter_list_columns', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'dentario_get_list_dedicated_locations' ) ) {
	function dentario_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'dentario'),
				"center"  => esc_html__('Above the text of the post', 'dentario'),
				"left"    => esc_html__('To the left the text of the post', 'dentario'),
				"right"   => esc_html__('To the right the text of the post', 'dentario'),
				"alter"   => esc_html__('Alternates for each post', 'dentario')
			);
			$list = apply_filters('dentario_filter_list_dedicated_locations', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'dentario_get_post_format_name' ) ) {
	function dentario_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'dentario') : esc_html__('galleries', 'dentario');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'dentario') : esc_html__('videos', 'dentario');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'dentario') : esc_html__('audios', 'dentario');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'dentario') : esc_html__('images', 'dentario');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'dentario') : esc_html__('quotes', 'dentario');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'dentario') : esc_html__('links', 'dentario');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'dentario') : esc_html__('statuses', 'dentario');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'dentario') : esc_html__('asides', 'dentario');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'dentario') : esc_html__('chats', 'dentario');
		else						$name = $single ? esc_html__('standard', 'dentario') : esc_html__('standards', 'dentario');
		return apply_filters('dentario_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'dentario_get_post_format_icon' ) ) {
	function dentario_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('dentario_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'dentario_get_list_fonts_styles' ) ) {
	function dentario_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','dentario'),
				'u' => esc_html__('U', 'dentario')
			);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'dentario_get_list_fonts' ) ) {
	function dentario_get_list_fonts($prepend_inherit=false) {
		if (($list = dentario_storage_get('list_fonts'))=='') {
			$list = array();
			$list = dentario_array_merge($list, dentario_get_list_font_faces());
			// Google and custom fonts list:
			//$list['Advent Pro'] = array(
			//		'family'=>'sans-serif',																						// (required) font family
			//		'link'=>'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
			//		'css'=>dentario_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
			//		);
			$list = dentario_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('dentario_filter_list_fonts', $list);
			if (dentario_get_theme_setting('use_list_cache')) dentario_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? dentario_array_merge(array('inherit' => esc_html__("Inherit", 'dentario')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'dentario_get_list_font_faces' ) ) {
	function dentario_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$list = array();
		$dir = dentario_get_folder_dir("css/font-face");
		if ( is_dir($dir) ) {
			$hdir = @ opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( ($dir) . '/' . ($file) );
					if ( substr($file, 0, 1) == '.' || ! is_dir( ($dir) . '/' . ($file) ) )
						continue;
					$css = file_exists( ($dir) . '/' . ($file) . '/' . ($file) . '.css' ) 
						? dentario_get_folder_url("css/font-face/".($file).'/'.($file).'.css')
						: (file_exists( ($dir) . '/' . ($file) . '/stylesheet.css' ) 
							? dentario_get_folder_url("css/font-face/".($file).'/stylesheet.css')
							: '');
					if ($css != '')
						$list[$file.' ('.esc_html__('uploaded font', 'dentario').')'] = array('css' => $css);
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}
?>