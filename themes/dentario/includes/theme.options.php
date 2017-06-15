<?php

/* Theme setup section
-------------------------------------------------------------------- */

// ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
// Framework settings

dentario_storage_set('settings', array(
	
	'less_compiler'		=> 'lessc',								// no|lessc|less - Compiler for the .less
																// lessc - fast & low memory required, but .less-map, shadows & gradients not supprted
																// less  - slow, but support all features
	'less_nested'		=> false,								// Use nested selectors when compiling less - increase .css size, but allow using nested color schemes
	'less_prefix'		=> '',									// any string - Use prefix before each selector when compile less. For example: 'html '
	'less_separator'	=> '/*---LESS_SEPARATOR---*/',			// string - separator inside .less file to split it when compiling to reduce memory usage
																// (compilation speed gets a bit slow)
	'less_map'			=> 'no',								// no|internal|external - Generate map for .less files. 
																// Warning! You need more then 128Mb for PHP scripts on your server! Supported only if less_compiler=less (see above)
	
	'customizer_demo'	=> true,								// Show color customizer demo (if many color settings) or not (if only accent colors used)

	'allow_fullscreen'	=> false,								// Allow fullscreen and fullwide body styles

	'socials_type'		=> 'icons',								// images|icons - Use this kind of pictograms for all socials: share, social profiles, team members socials, etc.
	'slides_type'		=> 'bg',								// images|bg - Use image as slide's content or as slide's background

	'add_image_size'	=> false,								// Add theme's thumb sizes into WP list sizes. 
																// If false - new image thumb will be generated on demand,
																// otherwise - all thumb sizes will be generated when image is loaded

	'use_list_cache'	=> true,								// Use cache for any lists (increase theme speed, but get 15-20K memory)
	'use_post_cache'	=> true,								// Use cache for post_data (increase theme speed, decrease queries number, but get more memory - up to 300K)

	'allow_profiler'	=> true,								// Allow to show theme profiler when 'debug mode' is on

	'admin_dummy_style' => 2									// 1 | 2 - Progress bar style when import dummy data
	)
);



// Default Theme Options
if ( !function_exists( 'dentario_options_settings_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_options_settings_theme_setup', 2 );	// Priority 1 for add dentario_filter handlers
	function dentario_options_settings_theme_setup() {
		
		// Clear all saved Theme Options on first theme run
		add_action('after_switch_theme', 'dentario_options_reset');

		// Settings 
		$socials_type = dentario_get_theme_setting('socials_type');
				
		// Prepare arrays 
		dentario_storage_set('options_params', apply_filters('dentario_filter_theme_options_params', array(
			'list_fonts'				=> array('$dentario_get_list_fonts' => ''),
			'list_fonts_styles'			=> array('$dentario_get_list_fonts_styles' => ''),
			'list_socials' 				=> array('$dentario_get_list_socials' => ''),
			'list_icons' 				=> array('$dentario_get_list_icons' => ''),
			'list_posts_types' 			=> array('$dentario_get_list_posts_types' => ''),
			'list_categories' 			=> array('$dentario_get_list_categories' => ''),
			'list_menus'				=> array('$dentario_get_list_menus' => ''),
			'list_sidebars'				=> array('$dentario_get_list_sidebars' => ''),
			'list_positions' 			=> array('$dentario_get_list_sidebars_positions' => ''),
			'list_skins'				=> array('$dentario_get_list_skins' => ''),
			'list_color_schemes'		=> array('$dentario_get_list_color_schemes' => ''),
			'list_bg_tints'				=> array('$dentario_get_list_bg_tints' => ''),
			'list_body_styles'			=> array('$dentario_get_list_body_styles' => ''),
			'list_header_styles'		=> array('$dentario_get_list_templates_header' => ''),
			'list_blog_styles'			=> array('$dentario_get_list_templates_blog' => ''),
			'list_single_styles'		=> array('$dentario_get_list_templates_single' => ''),
			'list_article_styles'		=> array('$dentario_get_list_article_styles' => ''),
			'list_blog_counters' 		=> array('$dentario_get_list_blog_counters' => ''),
			'list_animations_in' 		=> array('$dentario_get_list_animations_in' => ''),
			'list_animations_out'		=> array('$dentario_get_list_animations_out' => ''),
			'list_filters'				=> array('$dentario_get_list_portfolio_filters' => ''),
			'list_hovers'				=> array('$dentario_get_list_hovers' => ''),
			'list_hovers_dir'			=> array('$dentario_get_list_hovers_directions' => ''),
			'list_alter_sizes'			=> array('$dentario_get_list_alter_sizes' => ''),
			'list_sliders' 				=> array('$dentario_get_list_sliders' => ''),
			'list_bg_image_positions'	=> array('$dentario_get_list_bg_image_positions' => ''),
			'list_popups' 				=> array('$dentario_get_list_popup_engines' => ''),
			'list_gmap_styles'		 	=> array('$dentario_get_list_googlemap_styles' => ''),
			'list_yes_no' 				=> array('$dentario_get_list_yesno' => ''),
			'list_on_off' 				=> array('$dentario_get_list_onoff' => ''),
			'list_show_hide' 			=> array('$dentario_get_list_showhide' => ''),
			'list_sorting' 				=> array('$dentario_get_list_sortings' => ''),
			'list_ordering' 			=> array('$dentario_get_list_orderings' => ''),
			'list_locations' 			=> array('$dentario_get_list_dedicated_locations' => '')
			)
		));


		// Theme options array
		dentario_storage_set('options', array(

		
		//###############################
		//#### Customization         #### 
		//###############################
		'partition_customization' => array(
					"title" => esc_html__('Customization', 'dentario'),
					"start" => "partitions",
					"override" => "category,services_group,post,page,custom",
					"icon" => "iconadmin-cog-alt",
					"type" => "partition"
					),
		
		
		// Customization -> Body Style
		//-------------------------------------------------
		
		'customization_body' => array(
					"title" => esc_html__('Body style', 'dentario'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-picture',
					"start" => "customization_tabs",
					"type" => "tab"
					),
		
		'info_body_1' => array(
					"title" => esc_html__('Body parameters', 'dentario'),
					"desc" => wp_kses_data( __('Select body style, skin and color scheme for entire site. You can override this parameters on any page, post or category', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),
		
		'body_paddings' => array(
					"title" => esc_html__('Page paddings', 'dentario'),
					"desc" => wp_kses_data( __('Add paddings above and below the page content', 'dentario') ),
					"override" => "post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		'body_style' => array(
			"title" => esc_html__('Body style', 'dentario'),
			"desc" => wp_kses_data( __('Select body style:', 'dentario') )
			          . ' <br>'
			          . wp_kses_data( __('<b>boxed</b> - if you want use background color and/or image', 'dentario') )
			          . ',<br>'
			          . wp_kses_data( __('<b>wide</b> - page fill whole window with centered content', 'dentario') )
			          . (dentario_get_theme_setting('allow_fullscreen')
					? ',<br>' . wp_kses_data( __('<b>fullwide</b> - page content stretched on the full width of the window (with few left and right paddings)', 'dentario') )
					: '')
			          . (dentario_get_theme_setting('allow_fullscreen')
					? ',<br>' . wp_kses_data( __('<b>fullscreen</b> - page content fill whole window without any paddings', 'dentario') )
					: ''),
			"info" => true,
			"override" => "category,services_group,post,page,custom",
			"std" => "wide",
			"options" => dentario_get_options_param('list_body_styles'),
			"dir" => "horizontal",
			"type" => "hidden" //radio
		),

		'theme_skin' => array(
					"title" => esc_html__('Select theme skin', 'dentario'),
					"desc" => wp_kses_data( __('Select skin for the theme decoration', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "less",
					"options" => dentario_get_options_param('list_skins'),
					"type" => "select"
					),

		"body_scheme" => array(
					"title" => esc_html__('Color scheme', 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the entire page', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "hidden"), //checklist
		
		'body_filled' => array(
					"title" => esc_html__('Fill body', 'dentario'),
					"desc" => wp_kses_data( __('Fill the page background with the solid color or leave it transparend to show background image (or video background)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		'info_body_2' => array(
					"title" => esc_html__('Background color and image', 'dentario'),
					"desc" => wp_kses_data( __('Color and image for the site background', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'bg_custom' => array(
					"title" => esc_html__('Use custom background',  'dentario'),
					"desc" => wp_kses_data( __("Use custom color and/or image as the site background", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		'bg_color' => array(
					"title" => esc_html__('Background color',  'dentario'),
					"desc" => wp_kses_data( __('Body background color',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "#ffffff",
					"type" => "color"
					),

		'bg_pattern' => array(
					"title" => esc_html__('Background predefined pattern',  'dentario'),
					"desc" => wp_kses_data( __('Select theme background pattern (first case - without pattern)',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"options" => array(
						0 => dentario_get_file_url('images/spacer.png'),
						1 => dentario_get_file_url('images/bg/pattern_1.jpg'),
						2 => dentario_get_file_url('images/bg/pattern_2.jpg'),
						3 => dentario_get_file_url('images/bg/pattern_3.jpg'),
						4 => dentario_get_file_url('images/bg/pattern_4.jpg'),
						5 => dentario_get_file_url('images/bg/pattern_5.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_pattern_custom' => array(
					"title" => esc_html__('Background custom pattern',  'dentario'),
					"desc" => wp_kses_data( __('Select or upload background custom pattern. If selected - use it instead the theme predefined pattern (selected in the field above)',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'bg_image' => array(
					"title" => esc_html__('Background predefined image',  'dentario'),
					"desc" => wp_kses_data( __('Select theme background image (first case - without image)',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						0 => dentario_get_file_url('images/spacer.png'),
						1 => dentario_get_file_url('images/bg/image_1_thumb.jpg'),
						2 => dentario_get_file_url('images/bg/image_2_thumb.jpg'),
						3 => dentario_get_file_url('images/bg/image_3_thumb.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_image_custom' => array(
					"title" => esc_html__('Background custom image',  'dentario'),
					"desc" => wp_kses_data( __('Select or upload background custom image. If selected - use it instead the theme predefined image (selected in the field above)',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'bg_image_custom_position' => array( 
					"title" => esc_html__('Background custom image position',  'dentario'),
					"desc" => wp_kses_data( __('Select custom image position',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "left_top",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						'left_top' => "Left Top",
						'center_top' => "Center Top",
						'right_top' => "Right Top",
						'left_center' => "Left Center",
						'center_center' => "Center Center",
						'right_center' => "Right Center",
						'left_bottom' => "Left Bottom",
						'center_bottom' => "Center Bottom",
						'right_bottom' => "Right Bottom",
					),
					"type" => "select"
					),
		
		'bg_image_load' => array(
					"title" => esc_html__('Load background image', 'dentario'),
					"desc" => wp_kses_data( __('Always load background images or only for boxed body style', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "boxed",
					"size" => "medium",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						'boxed' => esc_html__('Boxed', 'dentario'),
						'always' => esc_html__('Always', 'dentario')
					),
					"type" => "switch"
					),

		
		'info_body_3' => array(
					"title" => esc_html__('Video background', 'dentario'),
					"desc" => wp_kses_data( __('Parameters of the video, used as site background', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "hidden" //info
					),

		'show_video_bg' => array(
					"title" => esc_html__('Show video background',  'dentario'),
					"desc" => wp_kses_data( __("Show video as the site background", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "hidden" //switch
					),

		'video_bg_youtube_code' => array(
					"title" => esc_html__('Youtube code for video bg',  'dentario'),
					"desc" => wp_kses_data( __("Youtube code of video", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"std" => "",
					"type" => "text"
					),

		'video_bg_url' => array(
					"title" => esc_html__('Local video for video bg',  'dentario'),
					"desc" => wp_kses_data( __("URL to video-file (uploaded on your site)", 'dentario') ),
					"readonly" =>false,
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"before" => array(	'title' => esc_html__('Choose video', 'dentario'),
										'action' => 'media_upload',
										'multiple' => false,
										'linked_field' => '',
										'type' => 'video',
										'captions' => array('choose' => esc_html__( 'Choose Video', 'dentario'),
															'update' => esc_html__( 'Select Video', 'dentario')
														)
								),
					"std" => "",
					"type" => "media"
					),

		'video_bg_overlay' => array(
					"title" => esc_html__('Use overlay for video bg', 'dentario'),
					"desc" => wp_kses_data( __('Use overlay texture for the video background', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		
		
		
		
		// Customization -> Header
		//-------------------------------------------------
		
		'customization_header' => array(
					"title" => esc_html__("Header", 'dentario'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		"info_header_1" => array(
					"title" => esc_html__('Top panel', 'dentario'),
					"desc" => wp_kses_data( __('Top panel settings. It include user menu area (with contact info, cart button, language selector, login/logout menu and user menu) and main menu area (with logo and main menu).', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"top_panel_style" => array(
					"title" => esc_html__('Top panel style', 'dentario'),
					"desc" => wp_kses_data( __('Select desired style of the page header', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "header_2",
					"options" => dentario_get_options_param('list_header_styles'),
					"style" => "list",
					"type" => "images"),

		"top_panel_image" => array(
					"title" => esc_html__('Top panel image', 'dentario'),
					"desc" => wp_kses_data( __('Select default background image of the page header (if not single post or featured image for current post is not specified)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'top_panel_style' => array('header_7')
					),
					"std" => "",
					"type" => "media"),
		
		"top_panel_position" => array( 
					"title" => esc_html__('Top panel position', 'dentario'),
					"desc" => wp_kses_data( __('Select position for the top panel with logo and main menu', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "above",
					"options" => array(
						'hide'  => esc_html__('Hide', 'dentario'),
						'above' => esc_html__('Above slider', 'dentario'),
						'below' => esc_html__('Below slider', 'dentario'),
						'over'  => esc_html__('Over slider', 'dentario')
					),
					"type" => "hidden"), //checklist

		"top_panel_scheme" => array(
					"title" => esc_html__('Top panel color scheme', 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the top panel', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "hidden"), //checklist

		"pushy_panel_scheme" => array(
					"title" => esc_html__('Push panel color scheme', 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the push panel (with logo, menu and socials)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'top_panel_style' => array('header_8')
					),
					"std" => "dark",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"show_page_title" => array(
					"title" => esc_html__('Show Page title', 'dentario'),
					"desc" => wp_kses_data( __('Show post/page/category title', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_breadcrumbs" => array(
					"title" => esc_html__('Show Breadcrumbs', 'dentario'),
					"desc" => wp_kses_data( __('Show path to current category (post, page)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"breadcrumbs_max_level" => array(
					"title" => esc_html__('Breadcrumbs max nesting', 'dentario'),
					"desc" => wp_kses_data( __("Max number of the nested categories in the breadcrumbs (0 - unlimited)", 'dentario') ),
					"dependency" => array(
						'show_breadcrumbs' => array('yes')
					),
					"std" => "0",
					"min" => 0,
					"max" => 100,
					"step" => 1,
					"type" => "spinner"),

		
		
		
		"info_header_2" => array( 
					"title" => esc_html__('Main menu style and position', 'dentario'),
					"desc" => wp_kses_data( __('Select the Main menu style and position', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"menu_main" => array( 
					"title" => esc_html__('Select main menu',  'dentario'),
					"desc" => wp_kses_data( __('Select main menu for the current page',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "default",
					"options" => dentario_get_options_param('list_menus'),
					"type" => "select"),
		
		"menu_attachment" => array( 
					"title" => esc_html__('Main menu attachment', 'dentario'),
					"desc" => wp_kses_data( __('Attach main menu to top of window then page scroll down', 'dentario') ),
					"std" => "fixed",
					"options" => array(
						"fixed"=>esc_html__("Fix menu position", 'dentario'), 
						"none"=>esc_html__("Don't fix menu position", 'dentario')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"menu_slider" => array( 
					"title" => esc_html__('Main menu slider', 'dentario'),
					"desc" => wp_kses_data( __('Use slider background for main menu items', 'dentario') ),
					"std" => "yes",
					"type" => "switch",
					"options" => dentario_get_options_param('list_yes_no')),

		"menu_animation_in" => array( 
					"title" => esc_html__('Submenu show animation', 'dentario'),
					"desc" => wp_kses_data( __('Select animation to show submenu ', 'dentario') ),
					"std" => "bounceIn",
					"type" => "select",
					"options" => dentario_get_options_param('list_animations_in')),

		"menu_animation_out" => array( 
					"title" => esc_html__('Submenu hide animation', 'dentario'),
					"desc" => wp_kses_data( __('Select animation to hide submenu ', 'dentario') ),
					"std" => "fadeOutDown",
					"type" => "select",
					"options" => dentario_get_options_param('list_animations_out')),
					
		"menu_mobile" => array( 
					"title" => esc_html__('Main menu responsive', 'dentario'),
					"desc" => wp_kses_data( __('Allow responsive version for the main menu if window width less then this value', 'dentario') ),
					"std" => 1024,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_width" => array( 
					"title" => esc_html__('Submenu width', 'dentario'),
					"desc" => wp_kses_data( __('Width for dropdown menus in main menu', 'dentario') ),
					"step" => 5,
					"std" => "",
					"min" => 180,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"),
		
		
		
		"info_header_3" => array(
					"title" => esc_html__("User's menu area components", 'dentario'),
					"desc" => wp_kses_data( __("Select parts for the user's menu area", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"show_top_panel_top" => array(
					"title" => esc_html__('Show user menu area', 'dentario'),
					"desc" => wp_kses_data( __('Show user menu area on top of page', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"menu_user" => array(
					"title" => esc_html__('Select user menu',  'dentario'),
					"desc" => wp_kses_data( __('Select user menu for the current page',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "default",
					"options" => dentario_get_options_param('list_menus'),
					"type" => "select"),
		
		"show_languages" => array(
					"title" => esc_html__('Show language selector', 'dentario'),
					"desc" => wp_kses_data( __('Show language selector in the user menu (if WPML plugin installed and current page/post has multilanguage version)', 'dentario') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_login" => array( 
					"title" => esc_html__('Show Login/Logout buttons', 'dentario'),
					"desc" => wp_kses_data( __('Show Login and Logout buttons in the user menu area', 'dentario') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_bookmarks" => array(
					"title" => esc_html__('Show bookmarks', 'dentario'),
					"desc" => wp_kses_data( __('Show bookmarks selector in the user menu', 'dentario') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_socials" => array( 
					"title" => esc_html__('Show Social icons', 'dentario'),
					"desc" => wp_kses_data( __('Show Social icons in the user menu area', 'dentario') ),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		

		
		"info_header_4" => array( 
					"title" => esc_html__("Table of Contents (TOC)", 'dentario'),
					"desc" => wp_kses_data( __("Table of Contents for the current page. Automatically created if the page contains objects with id starting with 'toc_'", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"menu_toc" => array( 
					"title" => esc_html__('TOC position', 'dentario'),
					"desc" => wp_kses_data( __('Show TOC for the current page', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "float",
					"options" => array(
						'hide'  => esc_html__('Hide', 'dentario'),
						'fixed' => esc_html__('Fixed', 'dentario'),
						'float' => esc_html__('Float', 'dentario')
					),
					"type" => "checklist"),
		
		"menu_toc_home" => array(
					"title" => esc_html__('Add "Home" into TOC', 'dentario'),
					"desc" => wp_kses_data( __('Automatically add "Home" item into table of contents - return to home page of the site', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'menu_toc' => array('fixed','float')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"menu_toc_top" => array( 
					"title" => esc_html__('Add "To Top" into TOC', 'dentario'),
					"desc" => wp_kses_data( __('Automatically add "To Top" item into table of contents - scroll to top of the page', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'menu_toc' => array('fixed','float')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		
		
		
		'info_header_5' => array(
					"title" => esc_html__('Main logo', 'dentario'),
					"desc" => wp_kses_data( __("Select or upload logos for the site's header and select it position", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),

		'favicon' => array(
					"title" => esc_html__('Favicon', 'dentario'),
					"desc" => wp_kses_data( __("Upload a 16px x 16px image that will represent your website's favicon.<br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href='http://www.favicon.cc/'>www.favicon.cc</a>)</em>", 'dentario') ),
					"std" => "",
					"type" => "media"
					),

		'logo' => array(
					"title" => esc_html__('Logo image', 'dentario'),
					"desc" => wp_kses_data( __('Main logo image', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"type" => "media"
					),

		'logo_retina' => array(
					"title" => esc_html__('Logo image for Retina', 'dentario'),
					"desc" => wp_kses_data( __('Main logo image used on Retina display', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "",
					"type" => "media"
					),

		'logo_fixed' => array(
					"title" => esc_html__('Logo image (fixed header)', 'dentario'),
					"desc" => wp_kses_data( __('Logo image for the header (if menu is fixed after the page is scrolled)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_text' => array(
					"title" => esc_html__('Logo text', 'dentario'),
					"desc" => wp_kses_data( __('Logo text - display it after logo image', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => '',
					"type" => "text"
					),

		'logo_height' => array(
					"title" => esc_html__('Logo height', 'dentario'),
					"desc" => wp_kses_data( __('Height for the logo in the header area', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"step" => 1,
					"std" => '',
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),

		'logo_offset' => array(
					"title" => esc_html__('Logo top offset', 'dentario'),
					"desc" => wp_kses_data( __('Top offset for the logo in the header area', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"step" => 1,
					"std" => '',
					"min" => 0,
					"max" => 99,
					"mask" => "?99",
					"type" => "spinner"
					),
		
		
		
		
		
		
		
		// Customization -> Slider
		//-------------------------------------------------
		
		"customization_slider" => array( 
					"title" => esc_html__('Slider', 'dentario'),
					"icon" => "iconadmin-picture",
					"override" => "category,services_group,page,custom",
					"type" => "tab"),
		
		"info_slider_1" => array(
					"title" => esc_html__('Main slider parameters', 'dentario'),
					"desc" => wp_kses_data( __('Select parameters for main slider (you can override it in each category and page)', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"type" => "info"),
					
		"show_slider" => array(
					"title" => esc_html__('Show Slider', 'dentario'),
					"desc" => wp_kses_data( __('Do you want to show slider on each page (post)', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_display" => array(
					"title" => esc_html__('Slider display', 'dentario'),
					"desc" => wp_kses_data( __('How display slider: boxed (fixed width and height), fullwide (fixed height) or fullscreen', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => "fullwide",
					"options" => array(
						"boxed"=>esc_html__("Boxed", 'dentario'),
						"fullwide"=>esc_html__("Fullwide", 'dentario'),
						"fullscreen"=>esc_html__("Fullscreen", 'dentario')
					),
					"type" => "checklist"),
		
		"slider_height" => array(
					"title" => esc_html__("Height (in pixels)", 'dentario'),
					"desc" => wp_kses_data( __("Slider height (in pixels) - only if slider display with fixed height.", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => '',
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"slider_engine" => array(
					"title" => esc_html__('Slider engine', 'dentario'),
					"desc" => wp_kses_data( __('What engine use to show slider?', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => "swiper",
					"options" => dentario_get_options_param('list_sliders'),
					"type" => "radio"),
		
		"slider_category" => array(
					"title" => esc_html__('Posts Slider: Category to show', 'dentario'),
					"desc" => wp_kses_data( __('Select category to show in Flexslider (ignored for Revolution and Royal sliders)', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "",
					"options" => dentario_array_merge(array(0 => esc_html__('- Select category -', 'dentario')), dentario_get_options_param('list_categories')),
					"type" => "select",
					"multiple" => true,
					"style" => "list"),
		
		"slider_posts" => array(
					"title" => esc_html__('Posts Slider: Number posts or comma separated posts list',  'dentario'),
					"desc" => wp_kses_data( __("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "5",
					"type" => "text"),
		
		"slider_orderby" => array(
					"title" => esc_html__("Posts Slider: Posts order by",  'dentario'),
					"desc" => wp_kses_data( __("Posts in slider ordered by date (default), comments, views, author rating, users rating, random or alphabetically", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "date",
					"options" => dentario_get_options_param('list_sorting'),
					"type" => "select"),
		
		"slider_order" => array(
					"title" => esc_html__("Posts Slider: Posts order", 'dentario'),
					"desc" => wp_kses_data( __('Select the desired ordering method for posts', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "desc",
					"options" => dentario_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
					
		"slider_interval" => array(
					"title" => esc_html__("Posts Slider: Slide change interval", 'dentario'),
					"desc" => wp_kses_data( __("Interval (in ms) for slides change in slider", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => 7000,
					"min" => 100,
					"step" => 100,
					"type" => "spinner"),
		
		"slider_pagination" => array(
					"title" => esc_html__("Posts Slider: Pagination", 'dentario'),
					"desc" => wp_kses_data( __("Choose pagination style for the slider", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "no",
					"options" => array(
						'no'   => esc_html__('None', 'dentario'),
						'yes'  => esc_html__('Dots', 'dentario'), 
						'over' => esc_html__('Titles', 'dentario')
					),
					"type" => "checklist"),
		
		"slider_infobox" => array(
					"title" => esc_html__("Posts Slider: Show infobox", 'dentario'),
					"desc" => wp_kses_data( __("Do you want to show post's title, reviews rating and description on slides in slider", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "slide",
					"options" => array(
						'no'    => esc_html__('None',  'dentario'),
						'slide' => esc_html__('Slide', 'dentario'), 
						'fixed' => esc_html__('Fixed', 'dentario')
					),
					"type" => "checklist"),
					
		"slider_info_category" => array(
					"title" => esc_html__("Posts Slider: Show post's category", 'dentario'),
					"desc" => wp_kses_data( __("Do you want to show post's category on slides in slider", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_info_reviews" => array(
					"title" => esc_html__("Posts Slider: Show post's reviews rating", 'dentario'),
					"desc" => wp_kses_data( __("Do you want to show post's reviews rating on slides in slider", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"slider_info_descriptions" => array(
					"title" => esc_html__("Posts Slider: Show post's descriptions", 'dentario'),
					"desc" => wp_kses_data( __("How many characters show in the post's description in slider. 0 - no descriptions", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => 0,
					"min" => 0,
					"step" => 10,
					"type" => "spinner"),
		
		
		
		
		
		// Customization -> Sidebars
		//-------------------------------------------------
		
		"customization_sidebars" => array( 
					"title" => esc_html__('Sidebars', 'dentario'),
					"icon" => "iconadmin-indent-right",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		"info_sidebars_1" => array( 
					"title" => esc_html__('Custom sidebars', 'dentario'),
					"desc" => wp_kses_data( __('In this section you can create unlimited sidebars. You can fill them with widgets in the menu Appearance - Widgets', 'dentario') ),
					"type" => "info"),
		
		"custom_sidebars" => array(
					"title" => esc_html__('Custom sidebars',  'dentario'),
					"desc" => wp_kses_data( __('Manage custom sidebars. You can use it with each category (page, post) independently',  'dentario') ),
					"std" => "",
					"cloneable" => true,
					"type" => "text"),
		
		"info_sidebars_2" => array(
					"title" => esc_html__('Main sidebar', 'dentario'),
					"desc" => wp_kses_data( __('Show / Hide and select main sidebar', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		'show_sidebar_main' => array( 
					"title" => esc_html__('Show main sidebar',  'dentario'),
					"desc" => wp_kses_data( __('Select position for the main sidebar or hide it',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "right",
					"options" => dentario_get_options_param('list_positions'),
					"dir" => "horizontal",
					"type" => "checklist"),

		"sidebar_main_scheme" => array(
					"title" => esc_html__("Color scheme", 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the main sidebar', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_main' => array('left', 'right')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "hidden"), //checklist
		
		"sidebar_main" => array( 
					"title" => esc_html__('Select main sidebar',  'dentario'),
					"desc" => wp_kses_data( __('Select main sidebar content',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_main' => array('left', 'right')
					),
					"std" => "sidebar_main",
					"options" => dentario_get_options_param('list_sidebars'),
					"type" => "select"),
		
		"info_sidebars_3" => array(
					"title" => esc_html__('Outer sidebar', 'dentario'),
					"desc" => wp_kses_data( __('Show / Hide and select outer sidebar (sidemenu, logo, etc.', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "hidden"), //info
		
		'show_sidebar_outer' => array( 
					"title" => esc_html__('Show outer sidebar',  'dentario'),
					"desc" => wp_kses_data( __('Select position for the outer sidebar or hide it',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "hide",
					"options" => dentario_get_options_param('list_positions'),
					"dir" => "horizontal",
					"type" => "hidden"), //checklist

		"sidebar_outer_scheme" => array(
					"title" => esc_html__("Color scheme", 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the outer sidebar', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"sidebar_outer_show_logo" => array( 
					"title" => esc_html__('Show Logo', 'dentario'),
					"desc" => wp_kses_data( __('Show Logo in the outer sidebar', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"sidebar_outer_show_socials" => array( 
					"title" => esc_html__('Show Social icons', 'dentario'),
					"desc" => wp_kses_data( __('Show Social icons in the outer sidebar', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"sidebar_outer_show_menu" => array( 
					"title" => esc_html__('Show Menu', 'dentario'),
					"desc" => wp_kses_data( __('Show Menu in the outer sidebar', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"menu_side" => array(
					"title" => esc_html__('Select menu',  'dentario'),
					"desc" => wp_kses_data( __('Select menu for the outer sidebar',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right'),
						'sidebar_outer_show_menu' => array('yes')
					),
					"std" => "default",
					"options" => dentario_get_options_param('list_menus'),
					"type" => "select"),
		
		"sidebar_outer_show_widgets" => array( 
					"title" => esc_html__('Show Widgets', 'dentario'),
					"desc" => wp_kses_data( __('Show Widgets in the outer sidebar', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"sidebar_outer" => array( 
					"title" => esc_html__('Select outer sidebar',  'dentario'),
					"desc" => wp_kses_data( __('Select outer sidebar content',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'sidebar_outer_show_widgets' => array('yes'),
						'show_sidebar_outer' => array('left', 'right')
					),
					"std" => "sidebar_outer",
					"options" => dentario_get_options_param('list_sidebars'),
					"type" => "select"),
		
		
		
		
		// Customization -> Footer
		//-------------------------------------------------
		
		'customization_footer' => array(
					"title" => esc_html__("Footer", 'dentario'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		
		"info_footer_1" => array(
					"title" => esc_html__("Footer components", 'dentario'),
					"desc" => wp_kses_data( __("Select components of the footer, set style and put the content for the user's footer area", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"show_sidebar_footer" => array(
					"title" => esc_html__('Show footer sidebar', 'dentario'),
					"desc" => wp_kses_data( __('Select style for the footer sidebar or hide it', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"sidebar_footer_scheme" => array(
					"title" => esc_html__("Color scheme", 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the footer', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "hidden"), //checklist
		
		"sidebar_footer" => array( 
					"title" => esc_html__('Select footer sidebar',  'dentario'),
					"desc" => wp_kses_data( __('Select footer sidebar for the blog page',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => "sidebar_footer",
					"options" => dentario_get_options_param('list_sidebars'),
					"type" => "select"),
		
		"sidebar_footer_columns" => array( 
					"title" => esc_html__('Footer sidebar columns',  'dentario'),
					"desc" => wp_kses_data( __('Select columns number for the footer sidebar',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => 3,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),
		
		
		"info_footer_2" => array(
					"title" => esc_html__('Testimonials in Footer', 'dentario'),
					"desc" => wp_kses_data( __('Select parameters for Testimonials in the Footer', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),

		"show_testimonials_in_footer" => array(
					"title" => esc_html__('Show Testimonials in footer', 'dentario'),
					"desc" => wp_kses_data( __('Show Testimonials slider in footer. For correct operation of the slider (and shortcode testimonials) you must fill out Testimonials posts on the menu "Testimonials"', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"testimonials_scheme" => array(
					"title" => esc_html__("Color scheme", 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the testimonials area', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_testimonials_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		"testimonials_count" => array( 
					"title" => esc_html__('Testimonials count', 'dentario'),
					"desc" => wp_kses_data( __('Number testimonials to show', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_testimonials_in_footer' => array('yes')
					),
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		
		"info_footer_3" => array(
					"title" => esc_html__('Twitter in Footer', 'dentario'),
					"desc" => wp_kses_data( __('Select parameters for Twitter stream in the Footer (you can override it in each category and page)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "hidden"), //info

		"show_twitter_in_footer" => array(
					"title" => esc_html__('Show Twitter in footer', 'dentario'),
					"desc" => wp_kses_data( __('Show Twitter slider in footer. For correct operation of the slider (and shortcode twitter) you must fill out the Twitter API keys on the menu "Appearance - Theme Options - Socials"', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "hidden"), //switch

		"twitter_scheme" => array(
					"title" => esc_html__("Color scheme", 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the twitter area', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_twitter_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		"twitter_count" => array( 
					"title" => esc_html__('Twitter count', 'dentario'),
					"desc" => wp_kses_data( __('Number twitter to show', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_twitter_in_footer' => array('yes')
					),
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),


		"info_footer_4" => array(
					"title" => esc_html__('Google map parameters', 'dentario'),
					"desc" => wp_kses_data( __('Select parameters for Google map (you can override it in each category and page)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
					
		"show_googlemap" => array(
					"title" => esc_html__('Show Google Map', 'dentario'),
					"desc" => wp_kses_data( __('Do you want to show Google map on each page (post)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"googlemap_height" => array(
					"title" => esc_html__("Map height", 'dentario'),
					"desc" => wp_kses_data( __("Map height (default - in pixels, allows any CSS units of measure)", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 400,
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"googlemap_address" => array(
					"title" => esc_html__('Address to show on map',  'dentario'),
					"desc" => wp_kses_data( __("Enter address to show on map center", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_latlng" => array(
					"title" => esc_html__('Latitude and Longitude to show on map',  'dentario'),
					"desc" => wp_kses_data( __("Enter coordinates (separated by comma) to show on map center (instead of address)", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_title" => array(
					"title" => esc_html__('Title to show on map',  'dentario'),
					"desc" => wp_kses_data( __("Enter title to show on map center", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_description" => array(
					"title" => esc_html__('Description to show on map',  'dentario'),
					"desc" => wp_kses_data( __("Enter description to show on map center", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_zoom" => array(
					"title" => esc_html__('Google map initial zoom',  'dentario'),
					"desc" => wp_kses_data( __("Enter desired initial zoom for Google map", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 16,
					"min" => 1,
					"max" => 20,
					"step" => 1,
					"type" => "spinner"),
		
		"googlemap_style" => array(
					"title" => esc_html__('Google map style',  'dentario'),
					"desc" => wp_kses_data( __("Select style to show Google map", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 'style1',
					"options" => dentario_get_options_param('list_gmap_styles'),
					"type" => "select"),
		
		"googlemap_marker" => array(
					"title" => esc_html__('Google map marker',  'dentario'),
					"desc" => wp_kses_data( __("Select or upload png-image with Google map marker", 'dentario') ),
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => '',
					"type" => "media"),
		
		
		
		"info_footer_5" => array(
					"title" => esc_html__("Contacts area", 'dentario'),
					"desc" => wp_kses_data( __("Show/Hide contacts area in the footer", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "hidden"), //info
		
		"show_contacts_in_footer" => array(
					"title" => esc_html__('Show Contacts in footer', 'dentario'),
					"desc" => wp_kses_data( __('Show contact information area in footer: site logo, contact info and large social icons', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "hidden"), //switch

		"contacts_scheme" => array(
					"title" => esc_html__("Color scheme", 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the contacts area', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "checklist"),

		'logo_footer' => array(
					"title" => esc_html__('Logo image for footer', 'dentario'),
					"desc" => wp_kses_data( __('Logo image in the footer (in the contacts area)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),

		'logo_footer_retina' => array(
					"title" => esc_html__('Logo image for footer for Retina', 'dentario'),
					"desc" => wp_kses_data( __('Logo image in the footer (in the contacts area) used on Retina display', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'logo_footer_height' => array(
					"title" => esc_html__('Logo height', 'dentario'),
					"desc" => wp_kses_data( __('Height for the logo in the footer area (in the contacts area)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"step" => 1,
					"std" => 30,
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),
		
		
		
		"info_footer_6" => array(
					"title" => esc_html__("Copyright and footer menu", 'dentario'),
					"desc" => wp_kses_data( __("Show/Hide copyright area in the footer", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),

		"show_copyright_in_footer" => array(
					"title" => esc_html__('Show Copyright area in footer', 'dentario'),
					"desc" => wp_kses_data( __('Show area with copyright information, footer menu and small social icons in footer', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "plain",
					"options" => array(
						'none' => esc_html__('Hide', 'dentario'),
						'text' => esc_html__('Text', 'dentario'),
						//'menu' => esc_html__('Text and menu', 'dentario'),
						'socials' => esc_html__('Text and Social icons', 'dentario')
					),
					"type" => "checklist"),

		"copyright_scheme" => array(
					"title" => esc_html__("Color scheme", 'dentario'),
					"desc" => wp_kses_data( __('Select predefined color scheme for the copyright area', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_copyright_in_footer' => array('text', 'menu', 'socials')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => dentario_get_options_param('list_color_schemes'),
					"type" => "checklist"),
		
		"menu_footer" => array( 
					"title" => esc_html__('Select footer menu',  'dentario'),
					"desc" => wp_kses_data( __('Select footer menu for the current page',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "default",
					"dependency" => array(
						'show_copyright_in_footer' => array('menu')
					),
					"options" => dentario_get_options_param('list_menus'),
					"type" => "select"),

		"footer_copyright" => array(
					"title" => esc_html__('Footer copyright text',  'dentario'),
					"desc" => wp_kses_data( __("Copyright text to show in footer area (bottom of site)", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_copyright_in_footer' => array('text', 'menu', 'socials')
					),
					"allow_html" => true,
					"std" => "Dentario &copy; 2014 All Rights Reserved ",
					"rows" => "10",
					"type" => "editor"),




		// Customization -> Other
		//-------------------------------------------------
		
		'customization_other' => array(
					"title" => esc_html__('Other', 'dentario'),
					"override" => "category,services_group,post,page,custom",
					"icon" => 'iconadmin-cog',
					"type" => "tab"
					),

		'info_other_1' => array(
					"title" => esc_html__('Theme customization other parameters', 'dentario'),
					"desc" => wp_kses_data( __('Animation parameters and responsive layouts for the small screens', 'dentario') ),
					"type" => "info"
					),

		'show_theme_customizer' => array(
					"title" => esc_html__('Show Theme customizer', 'dentario'),
					"desc" => wp_kses_data( __('Do you want to show theme customizer in the right panel? Your website visitors will be able to customise it yourself.', 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "hidden" //switch
					),

		"customizer_demo" => array(
					"title" => esc_html__('Theme customizer panel demo time', 'dentario'),
					"desc" => wp_kses_data( __('Timer for demo mode for the customizer panel (in milliseconds: 1000ms = 1s). If 0 - no demo.', 'dentario') ),
					"dependency" => array(
						'show_theme_customizer' => array('yes')
					),
					"std" => "0",
					"min" => 0,
					"max" => 10000,
					"step" => 500,
					"type" => "spinner"),
		
		'css_animation' => array(
					"title" => esc_html__('Extended CSS animations', 'dentario'),
					"desc" => wp_kses_data( __('Do you want use extended animations effects on your site?', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		'animation_on_mobile' => array(
					"title" => esc_html__('Allow CSS animations on mobile', 'dentario'),
					"desc" => wp_kses_data( __('Do you allow extended animations effects on mobile devices?', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),

		'remember_visitors_settings' => array(
					"title" => esc_html__("Remember visitor's settings", 'dentario'),
					"desc" => wp_kses_data( __('To remember the settings that were made by the visitor, when navigating to other pages or to limit their effect only within the current page', 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),
					
		'responsive_layouts' => array(
					"title" => esc_html__('Responsive Layouts', 'dentario'),
					"desc" => wp_kses_data( __('Do you want use responsive layouts on small screen or still use main layout?', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		'page_preloader' => array(
					"title" => esc_html__('Show page preloader',  'dentario'),
					"desc" => wp_kses_data( __('Do you want show animated page preloader?',  'dentario') ),
					"std" => "",
					"type" => "hidden" //media
					),


		'info_other_2' => array(
					"title" => esc_html__('Google fonts parameters', 'dentario'),
					"desc" => wp_kses_data( __('Specify additional parameters, used to load Google fonts', 'dentario') ),
					"type" => "info"
					),
		
		"fonts_subset" => array(
					"title" => esc_html__('Characters subset', 'dentario'),
					"desc" => wp_kses_data( __('Select subset, included into used Google fonts', 'dentario') ),
					"std" => "latin,latin-ext",
					"options" => array(
						'latin' => esc_html__('Latin', 'dentario'),
						'latin-ext' => esc_html__('Latin Extended', 'dentario'),
						'greek' => esc_html__('Greek', 'dentario'),
						'greek-ext' => esc_html__('Greek Extended', 'dentario'),
						'cyrillic' => esc_html__('Cyrillic', 'dentario'),
						'cyrillic-ext' => esc_html__('Cyrillic Extended', 'dentario'),
						'vietnamese' => esc_html__('Vietnamese', 'dentario')
					),
					"size" => "medium",
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),


		'info_other_3' => array(
					"title" => esc_html__('Additional CSS and HTML/JS code', 'dentario'),
					"desc" => wp_kses_data( __('Put here your custom CSS and JS code', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"
					),
					
		'custom_css_html' => array(
					"title" => esc_html__('Use custom CSS/HTML/JS', 'dentario'),
					"desc" => wp_kses_data( __('Do you want use custom HTML/CSS/JS code in your site? For example: custom styles, Google Analitics code, etc.', 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"
					),
		
		"gtm_code" => array(
					"title" => esc_html__('Google tags manager or Google analitics code',  'dentario'),
					"desc" => wp_kses_data( __('Put here Google Tags Manager (GTM) code from your account: Google analitics, remarketing, etc. This code will be placed after open body tag.',  'dentario') ),
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"allow_html" => true,
					"allow_js" => true,
					"type" => "textarea"),
		
		"gtm_code2" => array(
					"title" => esc_html__('Google remarketing code',  'dentario'),
					"desc" => wp_kses_data( __('Put here Google Remarketing code from your account. This code will be placed before close body tag.',  'dentario') ),
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"allow_html" => true,
					"allow_js" => true,
					"type" => "textarea"),
		
		'custom_code' => array(
					"title" => esc_html__('Your custom HTML/JS code',  'dentario'),
					"desc" => wp_kses_data( __('Put here your invisible html/js code: Google analitics, counters, etc',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"allow_html" => true,
					"allow_js" => true,
					"type" => "textarea"
					),
		
		'custom_css' => array(
					"title" => esc_html__('Your custom CSS code',  'dentario'),
					"desc" => wp_kses_data( __('Put here your css code to correct main theme styles',  'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"
					),
		
		
		
		
		
		
		
		
		
		//###############################
		//#### Blog and Single pages #### 
		//###############################
		"partition_blog" => array(
					"title" => esc_html__('Blog &amp; Single', 'dentario'),
					"icon" => "iconadmin-docs",
					"override" => "category,services_group,post,page,custom",
					"type" => "partition"),
		
		
		
		// Blog -> Stream page
		//-------------------------------------------------
		
		'blog_tab_stream' => array(
					"title" => esc_html__('Stream page', 'dentario'),
					"start" => 'blog_tabs',
					"icon" => "iconadmin-docs",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		"info_blog_1" => array(
					"title" => esc_html__('Blog streampage parameters', 'dentario'),
					"desc" => wp_kses_data( __('Select desired blog streampage parameters (you can override it in each category)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"blog_style" => array(
					"title" => esc_html__('Blog style', 'dentario'),
					"desc" => wp_kses_data( __('Select desired blog style', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "excerpt",
					"options" => dentario_get_options_param('list_blog_styles'),
					"type" => "select"),
		
		"hover_style" => array(
					"title" => esc_html__('Hover style', 'dentario'),
					"desc" => wp_kses_data( __('Select desired hover style (only for Blog style = Portfolio)', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored')
					),
					"std" => "square effect_shift",
					"options" => dentario_get_options_param('list_hovers'),
					"type" => "select"),
		
		"hover_dir" => array(
					"title" => esc_html__('Hover dir', 'dentario'),
					"desc" => wp_kses_data( __('Select hover direction (only for Blog style = Portfolio and Hover style = Circle or Square)', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored'),
						'hover_style' => array('square','circle')
					),
					"std" => "left_to_right",
					"options" => dentario_get_options_param('list_hovers_dir'),
					"type" => "select"),
		
		"article_style" => array(
					"title" => esc_html__('Article style', 'dentario'),
					"desc" => wp_kses_data( __('Select article display method: boxed or stretch', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "stretch",
					"options" => dentario_get_options_param('list_article_styles'),
					"size" => "medium",
					"type" => "switch"),
		
		"dedicated_location" => array(
					"title" => esc_html__('Dedicated location', 'dentario'),
					"desc" => wp_kses_data( __('Select location for the dedicated content or featured image in the "excerpt" blog style', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"std" => "default",
					"options" => dentario_get_options_param('list_locations'),
					"type" => "select"),
		
		"show_filters" => array(
					"title" => esc_html__('Show filters', 'dentario'),
					"desc" => wp_kses_data( __('What taxonomy use for filter buttons', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored')
					),
					"std" => "hide",
					"options" => dentario_get_options_param('list_filters'),
					"type" => "checklist"),
		
		"blog_sort" => array(
					"title" => esc_html__('Blog posts sorted by', 'dentario'),
					"desc" => wp_kses_data( __('Select the desired sorting method for posts', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "date",
					"options" => dentario_get_options_param('list_sorting'),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_order" => array(
					"title" => esc_html__('Blog posts order', 'dentario'),
					"desc" => wp_kses_data( __('Select the desired ordering method for posts', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "desc",
					"options" => dentario_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
		
		"posts_per_page" => array(
					"title" => esc_html__('Blog posts per page',  'dentario'),
					"desc" => wp_kses_data( __('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings',  'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "12",
					"mask" => "?99",
					"type" => "text"),
		
		"post_excerpt_maxlength" => array(
					"title" => esc_html__('Excerpt maxlength for streampage',  'dentario'),
					"desc" => wp_kses_data( __('How many characters from post excerpt are display in blog streampage (only for Blog style = Excerpt). 0 - do not trim excerpt.',  'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('excerpt', 'portfolio', 'grid', 'square', 'related')
					),
					"std" => "250",
					"mask" => "?9999",
					"type" => "text"),
		
		"post_excerpt_maxlength_masonry" => array(
					"title" => esc_html__('Excerpt maxlength for classic and masonry',  'dentario'),
					"desc" => wp_kses_data( __('How many characters from post excerpt are display in blog streampage (only for Blog style = Classic or Masonry). 0 - do not trim excerpt.',  'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'blog_style' => array('masonry', 'classic')
					),
					"std" => "150",
					"mask" => "?9999",
					"type" => "text"),
		
		
		
		
		// Blog -> Single page
		//-------------------------------------------------
		
		'blog_tab_single' => array(
					"title" => esc_html__('Single page', 'dentario'),
					"icon" => "iconadmin-doc",
					"override" => "category,services_group,post,page,custom",
					"type" => "tab"),
		
		
		"info_single_1" => array(
					"title" => esc_html__('Single (detail) pages parameters', 'dentario'),
					"desc" => wp_kses_data( __('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"type" => "info"),
		
		"single_style" => array(
					"title" => esc_html__('Single page style', 'dentario'),
					"desc" => wp_kses_data( __('Select desired style for single page', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "single-standard",
					"options" => dentario_get_options_param('list_single_styles'),
					"dir" => "horizontal",
					"type" => "radio"),

		"icon" => array(
					"title" => esc_html__('Select post icon', 'dentario'),
					"desc" => wp_kses_data( __('Select icon for output before post/category name in some layouts', 'dentario') ),
					"override" => "services_group,post,page,custom",
					"std" => "",
					"options" => dentario_get_options_param('list_icons'),
					"style" => "select",
					"type" => "icons"
					),

		"alter_thumb_size" => array(
					"title" => esc_html__('Alter thumb size (WxH)',  'dentario'),
					"override" => "page,post",
					"desc" => wp_kses_data( __("Select thumb size for the alternative portfolio layout (number items horizontally x number items vertically)", 'dentario') ),
					"class" => "",
					"std" => "1_1",
					"type" => "radio",
					"options" => dentario_get_options_param('list_alter_sizes')
					),
		
		"show_featured_image" => array(
					"title" => esc_html__('Show featured image before post',  'dentario'),
					"desc" => wp_kses_data( __("Show featured image (if selected) before post content on single pages", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_title" => array(
					"title" => esc_html__('Show post title', 'dentario'),
					"desc" => wp_kses_data( __('Show area with post title on single pages', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_title_on_quotes" => array(
					"title" => esc_html__('Show post title on links, chat, quote, status', 'dentario'),
					"desc" => wp_kses_data( __('Show area with post title on single and blog pages in specific post formats: links, chat, quote, status', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_info" => array(
					"title" => esc_html__('Show post info', 'dentario'),
					"desc" => wp_kses_data( __('Show area with post info on single pages', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_text_before_readmore" => array(
					"title" => esc_html__('Show text before "Read more" tag', 'dentario'),
					"desc" => wp_kses_data( __('Show text before "Read more" tag on single pages', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
					
		"show_post_author" => array(
					"title" => esc_html__('Show post author details',  'dentario'),
					"desc" => wp_kses_data( __("Show post author information block on single post page", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_tags" => array(
					"title" => esc_html__('Show post tags',  'dentario'),
					"desc" => wp_kses_data( __("Show tags block on single post page", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"show_post_related" => array(
					"title" => esc_html__('Show related posts',  'dentario'),
					"desc" => wp_kses_data( __("Show related posts block on single post page", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"post_related_count" => array(
					"title" => esc_html__('Related posts number',  'dentario'),
					"desc" => wp_kses_data( __("How many related posts showed on single post page", 'dentario') ),
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"override" => "category,services_group,post,page,custom",
					"std" => "2",
					"step" => 1,
					"min" => 2,
					"max" => 8,
					"type" => "spinner"),

		"post_related_columns" => array(
					"title" => esc_html__('Related posts columns',  'dentario'),
					"desc" => wp_kses_data( __("How many columns used to show related posts on single post page. 1 - use scrolling to show all related posts", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "2",
					"step" => 1,
					"min" => 1,
					"max" => 4,
					"type" => "spinner"),
		
		"post_related_sort" => array(
					"title" => esc_html__('Related posts sorted by', 'dentario'),
					"desc" => wp_kses_data( __('Select the desired sorting method for related posts', 'dentario') ),
		//			"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "date",
					"options" => dentario_get_options_param('list_sorting'),
					"type" => "select"),
		
		"post_related_order" => array(
					"title" => esc_html__('Related posts order', 'dentario'),
					"desc" => wp_kses_data( __('Select the desired ordering method for related posts', 'dentario') ),
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "desc",
					"options" => dentario_get_options_param('list_ordering'),
					"size" => "big",
					"type" => "switch"),
		
		"show_post_comments" => array(
					"title" => esc_html__('Show comments',  'dentario'),
					"desc" => wp_kses_data( __("Show comments block on single post page", 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		
		
		// Blog -> Other parameters
		//-------------------------------------------------
		
		'blog_tab_other' => array(
					"title" => esc_html__('Other parameters', 'dentario'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,services_group,page,custom",
					"type" => "tab"),
		
		"info_blog_other_1" => array(
					"title" => esc_html__('Other Blog parameters', 'dentario'),
					"desc" => wp_kses_data( __('Select excluded categories, substitute parameters, etc.', 'dentario') ),
					"type" => "info"),
		
		"exclude_cats" => array(
					"title" => esc_html__('Exclude categories', 'dentario'),
					"desc" => wp_kses_data( __('Select categories, which posts are exclude from blog page', 'dentario') ),
					"std" => "",
					"options" => dentario_get_options_param('list_categories'),
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"blog_pagination" => array(
					"title" => esc_html__('Blog pagination', 'dentario'),
					"desc" => wp_kses_data( __('Select type of the pagination on blog streampages', 'dentario') ),
					"std" => "pages",
					"override" => "category,services_group,page,custom",
					"options" => array(
						'pages'    => esc_html__('Standard page numbers', 'dentario'),
						'slider'   => esc_html__('Slider with page numbers', 'dentario'),
						'viewmore' => esc_html__('"View more" button', 'dentario'),
						'infinite' => esc_html__('Infinite scroll', 'dentario')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_counters" => array(
					"title" => esc_html__('Blog counters', 'dentario'),
					"desc" => wp_kses_data( __('Select counters, displayed near the post title', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "views",
					"options" => dentario_get_options_param('list_blog_counters'),
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),
		
		"close_category" => array(
					"title" => esc_html__("Post's category announce", 'dentario'),
					"desc" => wp_kses_data( __('What category display in announce block (over posts thumb) - original or nearest parental', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "parental",
					"options" => array(
						'parental' => esc_html__('Nearest parental category', 'dentario'),
						'original' => esc_html__("Original post's category", 'dentario')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"show_date_after" => array(
					"title" => esc_html__('Show post date after', 'dentario'),
					"desc" => wp_kses_data( __('Show post date after N days (before - show post age)', 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "30",
					"mask" => "?99",
					"type" => "text"),
		
		
		
		
		
		//###############################
		//#### Reviews               #### 
		//###############################
		"partition_reviews" => array(
					"title" => esc_html__('Reviews', 'dentario'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,services_group,services_group",
					"type" => "partition"),
		
		"info_reviews_1" => array(
					"title" => esc_html__('Reviews criterias', 'dentario'),
					"desc" => wp_kses_data( __('Set up list of reviews criterias. You can override it in any category.', 'dentario') ),
					"override" => "category,services_group,services_group",
					"type" => "info"),
		
		"show_reviews" => array(
					"title" => esc_html__('Show reviews block',  'dentario'),
					"desc" => wp_kses_data( __("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'dentario') ),
					"override" => "category,services_group,services_group",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"reviews_max_level" => array(
					"title" => esc_html__('Max reviews level',  'dentario'),
					"desc" => wp_kses_data( __("Maximum level for reviews marks", 'dentario') ),
					"std" => "5",
					"options" => array(
						'5'=>esc_html__('5 stars', 'dentario'), 
						'10'=>esc_html__('10 stars', 'dentario'), 
						'100'=>esc_html__('100%', 'dentario')
					),
					"type" => "radio",
					),
		
		"reviews_style" => array(
					"title" => esc_html__('Show rating as',  'dentario'),
					"desc" => wp_kses_data( __("Show rating marks as text or as stars/progress bars.", 'dentario') ),
					"std" => "stars",
					"options" => array(
						'text' => esc_html__('As text (for example: 7.5 / 10)', 'dentario'), 
						'stars' => esc_html__('As stars or bars', 'dentario')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"reviews_criterias_levels" => array(
					"title" => esc_html__('Reviews Criterias Levels', 'dentario'),
					"desc" => wp_kses_data( __('Words to mark criterials levels. Just write the word and press "Enter". Also you can arrange words.', 'dentario') ),
					"std" => esc_html__("bad,poor,normal,good,great", 'dentario'),
					"type" => "tags"),
		
		"reviews_first" => array(
					"title" => esc_html__('Show first reviews',  'dentario'),
					"desc" => wp_kses_data( __("What reviews will be displayed first: by author or by visitors. Also this type of reviews will display under post's title.", 'dentario') ),
					"std" => "author",
					"options" => array(
						'author' => esc_html__('By author', 'dentario'),
						'users' => esc_html__('By visitors', 'dentario')
						),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_second" => array(
					"title" => esc_html__('Hide second reviews',  'dentario'),
					"desc" => wp_kses_data( __("Do you want hide second reviews tab in widgets and single posts?", 'dentario') ),
					"std" => "show",
					"options" => dentario_get_options_param('list_show_hide'),
					"size" => "medium",
					"type" => "switch"),
		
		"reviews_can_vote" => array(
					"title" => esc_html__('What visitors can vote',  'dentario'),
					"desc" => wp_kses_data( __("What visitors can vote: all or only registered", 'dentario') ),
					"std" => "all",
					"options" => array(
						'all'=>esc_html__('All visitors', 'dentario'), 
						'registered'=>esc_html__('Only registered', 'dentario')
					),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_criterias" => array(
					"title" => esc_html__('Reviews criterias',  'dentario'),
					"desc" => wp_kses_data( __('Add default reviews criterias.',  'dentario') ),
					"override" => "category,services_group,services_group",
					"std" => "",
					"cloneable" => true,
					"type" => "text"),

		// Don't remove this parameter - it used in admin for store marks
		"reviews_marks" => array(
					"std" => "",
					"type" => "hidden"),
		





		//###############################
		//#### Media                #### 
		//###############################
		"partition_media" => array(
					"title" => esc_html__('Media', 'dentario'),
					"icon" => "iconadmin-picture",
					"override" => "category,services_group,post,page,custom",
					"type" => "partition"),
		
		"info_media_1" => array(
					"title" => esc_html__('Media settings', 'dentario'),
					"desc" => wp_kses_data( __('Set up parameters to show images, galleries, audio and video posts', 'dentario') ),
					"override" => "category,services_group,services_group",
					"type" => "info"),
					
		"retina_ready" => array(
					"title" => esc_html__('Image dimensions', 'dentario'),
					"desc" => wp_kses_data( __('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'dentario') ),
					"std" => "1",
					"size" => "medium",
					"options" => array(
						"1" => esc_html__("Original", 'dentario'), 
						"2" => esc_html__("Retina", 'dentario')
					),
					"type" => "switch"),
		
		"images_quality" => array(
					"title" => esc_html__('Quality for cropped images', 'dentario'),
					"desc" => wp_kses_data( __('Quality (1-100) to save cropped images', 'dentario') ),
					"std" => "70",
					"min" => 1,
					"max" => 100,
					"type" => "spinner"),
		
		"substitute_gallery" => array(
					"title" => esc_html__('Substitute standard Wordpress gallery', 'dentario'),
					"desc" => wp_kses_data( __('Substitute standard Wordpress gallery with our slider on the single pages', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"gallery_instead_image" => array(
					"title" => esc_html__('Show gallery instead featured image', 'dentario'),
					"desc" => wp_kses_data( __('Show slider with gallery instead featured image on blog streampage and in the related posts section for the gallery posts', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"gallery_max_slides" => array(
					"title" => esc_html__('Max images number in the slider', 'dentario'),
					"desc" => wp_kses_data( __('Maximum images number from gallery into slider', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"dependency" => array(
						'gallery_instead_image' => array('yes')
					),
					"std" => "5",
					"min" => 2,
					"max" => 10,
					"type" => "spinner"),
		
		"popup_engine" => array(
					"title" => esc_html__('Popup engine to zoom images', 'dentario'),
					"desc" => wp_kses_data( __('Select engine to show popup windows with images and galleries', 'dentario') ),
					"std" => "magnific",
					"options" => dentario_get_options_param('list_popups'),
					"type" => "select"),
		
		"substitute_audio" => array(
					"title" => esc_html__('Substitute audio tags', 'dentario'),
					"desc" => wp_kses_data( __('Substitute audio tag with source from soundcloud to embed player', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"substitute_video" => array(
					"title" => esc_html__('Substitute video tags', 'dentario'),
					"desc" => wp_kses_data( __('Substitute video tags with embed players or leave video tags unchanged (if you use third party plugins for the video tags)', 'dentario') ),
					"override" => "category,services_group,post,page,custom",
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"use_mediaelement" => array(
					"title" => esc_html__('Use Media Element script for audio and video tags', 'dentario'),
					"desc" => wp_kses_data( __('Do you want use the Media Element script for all audio and video tags on your site or leave standard HTML5 behaviour?', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		
		
		
		//###############################
		//#### Socials               #### 
		//###############################
		"partition_socials" => array(
					"title" => esc_html__('Socials', 'dentario'),
					"icon" => "iconadmin-users",
					"override" => "category,services_group,page,custom",
					"type" => "partition"),
		
		"info_socials_1" => array(
					"title" => esc_html__('Social networks', 'dentario'),
					"desc" => wp_kses_data( __("Social networks list for site footer and Social widget", 'dentario') ),
					"type" => "info"),
		
		"social_icons" => array(
					"title" => esc_html__('Social networks',  'dentario'),
					"desc" => wp_kses_data( __('Select icon and write URL to your profile in desired social networks.',  'dentario') ),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"cloneable" => true,
					"size" => "small",
					"style" => $socials_type,
					"options" => $socials_type=='images' ? dentario_get_options_param('list_socials') : dentario_get_options_param('list_icons'),
					"type" => "socials"),
		
		"info_socials_2" => array(
					"title" => esc_html__('Share buttons', 'dentario'),
					"desc" => wp_kses_data( __("Add button's code for each social share network.<br>
					In share url you can use next macro:<br>
					<b>{url}</b> - share post (page) URL,<br>
					<b>{title}</b> - post title,<br>
					<b>{image}</b> - post image,<br>
					<b>{descr}</b> - post description (if supported)<br>
					For example:<br>
					<b>Facebook</b> share string: <em>http://www.facebook.com/sharer.php?u={link}&amp;t={title}</em><br>
					<b>Delicious</b> share string: <em>http://delicious.com/save?url={link}&amp;title={title}&amp;note={descr}</em>", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"type" => "info"),
		
		"show_share" => array(
					"title" => esc_html__('Show social share buttons',  'dentario'),
					"desc" => wp_kses_data( __("Show social share buttons block", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"std" => "horizontal",
					"options" => array(
						'hide'		=> esc_html__('Hide', 'dentario'),
						'horizontal'=> esc_html__('Show', 'dentario')
					),
					"type" => "checklist"),

		"show_share_counters" => array(
					"title" => esc_html__('Show share counters',  'dentario'),
					"desc" => wp_kses_data( __("Show share counters after social buttons", 'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "hidden"), //switch

		"share_caption" => array(
					"title" => esc_html__('Share block caption',  'dentario'),
					"desc" => wp_kses_data( __('Caption for the block with social share buttons',  'dentario') ),
					"override" => "category,services_group,page,custom",
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => esc_html__('Share:', 'dentario'),
					"type" => "text"),
		
		"share_buttons" => array(
					"title" => esc_html__('Share buttons',  'dentario'),
					"desc" => wp_kses_data( __('Select icon and write share URL for desired social networks.<br><b>Important!</b> If you leave text field empty - internal theme link will be used (if present).',  'dentario') ),
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"cloneable" => true,
					"size" => "small",
					"style" => $socials_type,
					"options" => $socials_type=='images' ? dentario_get_options_param('list_socials') : dentario_get_options_param('list_icons'),
					"type" => "socials"),
		
		
		"info_socials_3" => array(
					"title" => esc_html__('Twitter API keys', 'dentario'),
					"desc" => wp_kses_data( __("Put to this section Twitter API 1.1 keys.<br>You can take them after registration your application in <strong>https://apps.twitter.com/</strong>", 'dentario') ),
					"type" => "info"),
		
		"twitter_username" => array(
					"title" => esc_html__('Twitter username',  'dentario'),
					"desc" => wp_kses_data( __('Your login (username) in Twitter',  'dentario') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_key" => array(
					"title" => esc_html__('Consumer Key',  'dentario'),
					"desc" => wp_kses_data( __('Twitter API Consumer key',  'dentario') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_consumer_secret" => array(
					"title" => esc_html__('Consumer Secret',  'dentario'),
					"desc" => wp_kses_data( __('Twitter API Consumer secret',  'dentario') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_key" => array(
					"title" => esc_html__('Token Key',  'dentario'),
					"desc" => wp_kses_data( __('Twitter API Token key',  'dentario') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		"twitter_token_secret" => array(
					"title" => esc_html__('Token Secret',  'dentario'),
					"desc" => wp_kses_data( __('Twitter API Token secret',  'dentario') ),
					"divider" => false,
					"std" => "",
					"type" => "text"),
		
		
		
		
		
		//###############################
		//#### Contact info          #### 
		//###############################
		"partition_contacts" => array(
					"title" => esc_html__('Contact info', 'dentario'),
					"icon" => "iconadmin-mail",
					"type" => "partition"),
		
		"info_contact_1" => array(
					"title" => esc_html__('Contact information', 'dentario'),
					"desc" => wp_kses_data( __('Company address, phones and e-mail', 'dentario') ),
					"type" => "info"),
		
		"contact_info" => array(
					"title" => esc_html__('Contacts in the header', 'dentario'),
					"desc" => wp_kses_data( __('String with contact info in the left side of the site header', 'dentario') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_open_hours" => array(
					"title" => esc_html__('Open hours in the header', 'dentario'),
					"desc" => wp_kses_data( __('String with open hours in the site header', 'dentario') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-clock'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_email" => array(
					"title" => esc_html__('Contact form email', 'dentario'),
					"desc" => wp_kses_data( __('E-mail for send contact form and user registration data', 'dentario') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-mail'),
					"type" => "text"),
		
		"contact_address_1" => array(
					"title" => esc_html__('Company address (part 1)', 'dentario'),
					"desc" => wp_kses_data( __('Company country, post code and city', 'dentario') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_address_2" => array(
					"title" => esc_html__('Company address (part 2)', 'dentario'),
					"desc" => wp_kses_data( __('Street and house number', 'dentario') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_phone" => array(
					"title" => esc_html__('Phone', 'dentario'),
					"desc" => wp_kses_data( __('Phone number', 'dentario') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"allow_html" => true,
					"type" => "text"),
		
		"contact_fax" => array(
					"title" => esc_html__('Fax', 'dentario'),
					"desc" => wp_kses_data( __('Fax number', 'dentario') ),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"allow_html" => true,
					"type" => "text"),
		
		"info_contact_2" => array(
					"title" => esc_html__('Contact and Comments form', 'dentario'),
					"desc" => wp_kses_data( __('Maximum length of the messages in the contact form shortcode and in the comments form', 'dentario') ),
					"type" => "info"),
		
		"message_maxlength_contacts" => array(
					"title" => esc_html__('Contact form message', 'dentario'),
					"desc" => wp_kses_data( __("Message's maxlength in the contact form shortcode", 'dentario') ),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"message_maxlength_comments" => array(
					"title" => esc_html__('Comments form message', 'dentario'),
					"desc" => wp_kses_data( __("Message's maxlength in the comments form", 'dentario') ),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"info_contact_3" => array(
					"title" => esc_html__('Default mail function', 'dentario'),
					"desc" => wp_kses_data( __('What function you want to use for sending mail: the built-in Wordpress wp_mail() or standard PHP mail() function? Attention! Some plugins may not work with one of them and you always have the ability to switch to alternative.', 'dentario') ),
					"type" => "info"),
		
		"mail_function" => array(
					"title" => esc_html__("Mail function", 'dentario'),
					"desc" => wp_kses_data( __("What function you want to use for sending mail?", 'dentario') ),
					"std" => "wp_mail",
					"size" => "medium",
					"options" => array(
						'wp_mail' => esc_html__('WP mail', 'dentario'),
						'mail' => esc_html__('PHP mail', 'dentario')
					),
					"type" => "switch"),
		
		
		
		
		
		
		
		//###############################
		//#### Search parameters     #### 
		//###############################
		"partition_search" => array(
					"title" => esc_html__('Search', 'dentario'),
					"icon" => "iconadmin-search",
					"type" => "partition"),
		
		"info_search_1" => array(
					"title" => esc_html__('Search parameters', 'dentario'),
					"desc" => wp_kses_data( __('Enable/disable AJAX search and output settings for it', 'dentario') ),
					"type" => "info"),
		
		"show_search" => array(
					"title" => esc_html__('Show search field', 'dentario'),
					"desc" => wp_kses_data( __('Show search field in the top area and side menus', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"use_ajax_search" => array(
					"title" => esc_html__('Enable AJAX search', 'dentario'),
					"desc" => wp_kses_data( __('Use incremental AJAX search for the search field in top of page', 'dentario') ),
					"dependency" => array(
						'show_search' => array('yes')
					),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_min_length" => array(
					"title" => esc_html__('Min search string length',  'dentario'),
					"desc" => wp_kses_data( __('The minimum length of the search string',  'dentario') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"std" => 4,
					"min" => 3,
					"type" => "spinner"),
		
		"ajax_search_delay" => array(
					"title" => esc_html__('Delay before search (in ms)',  'dentario'),
					"desc" => wp_kses_data( __('How much time (in milliseconds, 1000 ms = 1 second) must pass after the last character before the start search',  'dentario') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"std" => 500,
					"min" => 300,
					"max" => 1000,
					"step" => 100,
					"type" => "spinner"),
		
		"ajax_search_types" => array(
					"title" => esc_html__('Search area', 'dentario'),
					"desc" => wp_kses_data( __('Select post types, what will be include in search results. If not selected - use all types.', 'dentario') ),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"std" => "",
					"options" => dentario_get_options_param('list_posts_types'),
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"ajax_search_posts_count" => array(
					"title" => esc_html__('Posts number in output',  'dentario'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __('Number of the posts to show in search results',  'dentario') ),
					"std" => 5,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		"ajax_search_posts_image" => array(
					"title" => esc_html__("Show post's image", 'dentario'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's thumbnail in the search results", 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_date" => array(
					"title" => esc_html__("Show post's date", 'dentario'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's publish date in the search results", 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_author" => array(
					"title" => esc_html__("Show post's author", 'dentario'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's author in the search results", 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"ajax_search_posts_counters" => array(
					"title" => esc_html__("Show post's counters", 'dentario'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => wp_kses_data( __("Show post's counters (views, comments, likes) in the search results", 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		
		
		
		
		//###############################
		//#### Service               #### 
		//###############################
		
		"partition_service" => array(
					"title" => esc_html__('Service', 'dentario'),
					"icon" => "iconadmin-wrench",
					"type" => "partition"),
		
		"info_service_1" => array(
					"title" => esc_html__('Theme functionality', 'dentario'),
					"desc" => wp_kses_data( __('Basic theme functionality settings', 'dentario') ),
					"type" => "info"),
		
		"notify_about_new_registration" => array(
					"title" => esc_html__('Notify about new registration', 'dentario'),
					"desc" => wp_kses_data( __('Send E-mail with new registration data to the contact email or to site admin e-mail (if contact email is empty)', 'dentario') ),
					"divider" => false,
					"std" => "no",
					"options" => array(
						'no'    => esc_html__('No', 'dentario'),
						'both'  => esc_html__('Both', 'dentario'),
						'admin' => esc_html__('Admin', 'dentario'),
						'user'  => esc_html__('User', 'dentario')
					),
					"dir" => "horizontal",
					"type" => "checklist"),
		
		"use_ajax_views_counter" => array(
					"title" => esc_html__('Use AJAX post views counter', 'dentario'),
					"desc" => wp_kses_data( __('Use javascript for post views count (if site work under the caching plugin) or increment views count in single page template', 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"allow_editor" => array(
					"title" => esc_html__('Frontend editor',  'dentario'),
					"desc" => wp_kses_data( __("Allow authors to edit their posts in frontend area)", 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"admin_add_filters" => array(
					"title" => esc_html__('Additional filters in the admin panel', 'dentario'),
					"desc" => wp_kses_data( __('Show additional filters (on post formats, tags and categories) in admin panel page "Posts". <br>Attention! If you have more than 2.000-3.000 posts, enabling this option may cause slow load of the "Posts" page! If you encounter such slow down, simply open Appearance - Theme Options - Service and set "No" for this option.', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"show_overriden_taxonomies" => array(
					"title" => esc_html__('Show overriden options for taxonomies', 'dentario'),
					"desc" => wp_kses_data( __('Show extra column in categories list, where changed (overriden) theme options are displayed.', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"show_overriden_posts" => array(
					"title" => esc_html__('Show overriden options for posts and pages', 'dentario'),
					"desc" => wp_kses_data( __('Show extra column in posts and pages list, where changed (overriden) theme options are displayed.', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"admin_dummy_data" => array(
					"title" => esc_html__('Enable Dummy Data Installer', 'dentario'),
					"desc" => wp_kses_data( __('Show "Install Dummy Data" in the menu "Appearance". <b>Attention!</b> When you install dummy data all content of your site will be replaced!', 'dentario') ),
					"std" => "yes",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"admin_dummy_timeout" => array(
					"title" => esc_html__('Dummy Data Installer Timeout',  'dentario'),
					"desc" => wp_kses_data( __('Web-servers set the time limit for the execution of php-scripts. By default, this is 30 sec. Therefore, the import process will be split into parts. Upon completion of each part - the import will resume automatically! The import process will try to increase this limit to the time, specified in this field.',  'dentario') ),
					"std" => 120,
					"min" => 30,
					"max" => 1800,
					"type" => "spinner"),
		
		"admin_emailer" => array(
					"title" => esc_html__('Enable Emailer in the admin panel', 'dentario'),
					"desc" => wp_kses_data( __('Allow to use Dentario Emailer for mass-volume e-mail distribution and management of mailing lists in "Appearance - Emailer"', 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"admin_po_composer" => array(
					"title" => esc_html__('Enable PO Composer in the admin panel', 'dentario'),
					"desc" => wp_kses_data( __('Allow to use "PO Composer" for edit language files in this theme (in the "Appearance - PO Composer")', 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"debug_mode" => array(
					"title" => esc_html__('Debug mode', 'dentario'),
					"desc" => wp_kses_data( __('In debug mode we are using unpacked scripts and styles, else - using minified scripts and styles (if present). <b>Attention!</b> If you have modified the source code in the js or css files, regardless of this option will be used latest (modified) version stylesheets and scripts. You can re-create minified versions of files using on-line services or utilities', 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),

		"info_service_3" => array(
					"title" => esc_html__('API Keys', 'dentario'),
					"desc" => wp_kses_data( __('API Keys for some Web services', 'dentario') ),
					"type" => "info"),
		'api_google' => array(
					"title" => esc_html__('Google API Key', 'dentario'),
					"desc" => wp_kses_data( __("Insert Google API Key for browsers into the field above to generate Google Maps", 'dentario') ),
					"std" => "",
					"type" => "text"),

		"info_service_2" => array(
					"title" => esc_html__('Wordpress cache', 'dentario'),
					"desc" => wp_kses_data( __('For example, it recommended after activating the WPML plugin - in the cache are incorrect data about the structure of categories and your site may display "white screen". After clearing the cache usually the performance of the site is restored.', 'dentario') ),
					"type" => "info"),
		
		"use_menu_cache" => array(
					"title" => esc_html__('Use menu cache', 'dentario'),
					"desc" => wp_kses_data( __('Use cache for any menu (increase theme speed, decrease queries number). Attention! Please, clear cache after change permalink settings!', 'dentario') ),
					"std" => "no",
					"options" => dentario_get_options_param('list_yes_no'),
					"type" => "switch"),
		
		"clear_cache" => array(
					"title" => esc_html__('Clear cache', 'dentario'),
					"desc" => wp_kses_data( __('Clear Wordpress cache data', 'dentario') ),
					"divider" => false,
					"icon" => "iconadmin-trash",
					"action" => "clear_cache",
					"type" => "button")
		));



	}
}


// Update all temporary vars (start with $dentario_) in the Theme Options with actual lists
if ( !function_exists( 'dentario_options_settings_theme_setup2' ) ) {
	add_action( 'dentario_action_after_init_theme', 'dentario_options_settings_theme_setup2', 1 );
	function dentario_options_settings_theme_setup2() {
		if (dentario_options_is_used()) {
			// Replace arrays with actual parameters
			$lists = array();
			$tmp = dentario_storage_get('options');
			if (is_array($tmp) && count($tmp) > 0) {
				$prefix = '$dentario_';
				$prefix_len = dentario_strlen($prefix);
				foreach ($tmp as $k=>$v) {
					if (isset($v['options']) && is_array($v['options']) && count($v['options']) > 0) {
						foreach ($v['options'] as $k1=>$v1) {
							if (dentario_substr($k1, 0, $prefix_len) == $prefix || dentario_substr($v1, 0, $prefix_len) == $prefix) {
								$list_func = dentario_substr(dentario_substr($k1, 0, $prefix_len) == $prefix ? $k1 : $v1, 1);
								unset($tmp[$k]['options'][$k1]);
								if (isset($lists[$list_func]))
									$tmp[$k]['options'] = dentario_array_merge($tmp[$k]['options'], $lists[$list_func]);
								else {
									if (function_exists($list_func)) {
										$tmp[$k]['options'] = $lists[$list_func] = dentario_array_merge($tmp[$k]['options'], $list_func == 'dentario_get_list_menus' ? $list_func(true) : $list_func());
								   	} else
								   		dfl(sprintf(esc_html__('Wrong function name %s in the theme options array', 'dentario'), $list_func));
								}
							}
						}
					}
				}
				dentario_storage_set('options', $tmp);
			}
		}
	}
}

// Reset old Theme Options while theme first run
if ( !function_exists( 'dentario_options_reset' ) ) {
	function dentario_options_reset($clear=true) {
		$theme_data = wp_get_theme();
		$slug = str_replace(' ', '_', trim(dentario_strtolower((string) $theme_data->get('Name'))));
		$option_name = 'dentario_'.strip_tags($slug).'_options_reset';
		if ( get_option($option_name, false) === false ) {
			if ($clear) {
				// Remove Theme Options from WP Options
				global $wpdb;
				$wpdb->query('delete from '.esc_sql($wpdb->options).' where option_name like "dentario_%"');
				// Add Templates Options
				if (file_exists(dentario_get_file_dir('demo/templates_options.txt'))) {
					$txt = dentario_fgc(dentario_get_file_dir('demo/templates_options.txt'));
					$data = dentario_unserialize($txt);
					// Replace upload url in options
					if (is_array($data) && count($data) > 0) {
						foreach ($data as $k=>$v) {
							if (is_array($v) && count($v) > 0) {
								foreach ($v as $k1=>$v1) {
									$v[$k1] = dentario_replace_uploads_url(dentario_replace_uploads_url($v1, 'uploads'), 'imports');
								}
							}
							add_option( $k, $v, '', 'yes' );
						}
					}
				}
			}
			add_option($option_name, 1, '', 'yes');
		}
	}
}
?>