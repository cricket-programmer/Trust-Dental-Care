<?php
/**
 * Skin file for the theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('dentario_action_skin_theme_setup')) {
	add_action( 'dentario_action_init_theme', 'dentario_action_skin_theme_setup', 1 );
	function dentario_action_skin_theme_setup() {

		// Add skin fonts in the used fonts list
		add_filter('dentario_filter_used_fonts',			'dentario_filter_skin_used_fonts');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('dentario_filter_list_fonts',			'dentario_filter_skin_list_fonts');

		// Add skin stylesheets
		add_action('dentario_action_add_styles',			'dentario_action_skin_add_styles');
		// Add skin inline styles
		add_filter('dentario_filter_add_styles_inline',		'dentario_filter_skin_add_styles_inline');
		// Add skin responsive styles
		add_action('dentario_action_add_responsive',		'dentario_action_skin_add_responsive');
		// Add skin responsive inline styles
		add_filter('dentario_filter_add_responsive_inline',	'dentario_filter_skin_add_responsive_inline');

		// Add skin scripts
		add_action('dentario_action_add_scripts',			'dentario_action_skin_add_scripts');
		// Add skin scripts inline
		add_action('dentario_action_add_scripts_inline',	'dentario_action_skin_add_scripts_inline');

		// Add skin less files into list for compilation
		add_filter('dentario_filter_compile_less',			'dentario_filter_skin_compile_less');


		/* Color schemes
		
		// Accenterd colors
		accent1			- theme accented color 1
		accent1_hover	- theme accented color 1 (hover state)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		dentario_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'dentario'),

			// Accent colors
			'accent1'				=> '#3FB6E0',
			'accent1_hover'			=> '#A5C422',

			// Headers, text and links colors
			'text'					=> '#30383B',
			'text_light'			=> '#ACB4B6',
			'text_dark'				=> '#232A34',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#30383B',
			
			// Whole block border and background
			'bd_color'				=> '#EDEDED',
			'bg_color'				=> '#ffffff',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#787C83',
			'alter_light'			=> '#ACB4B6',
			'alter_dark'			=> '#30383B',
			'alter_link'			=> '#3FB6E0',
			'alter_hover'			=> '#A5C422',
			'alter_bd_color'		=> '#DADEE6',
			'alter_bd_hover'		=> '#B8BCC4',
			'alter_bg_color'		=> '#ffffff',
			'alter_bg_hover'		=> '#ffffff',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
		dentario_add_color_scheme('light', array(

			'title'					=> esc_html__('Light', 'dentario'),

			// Accent colors
			'accent1'				=> '#3FB6E0',
			'accent1_hover'			=> '#A5C422',

			// Headers, text and links colors
			'text'					=> '#30383B',
			'text_light'			=> '#ACB4B6',
			'text_dark'				=> '#232A34',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#dddddd',
			'bg_color'				=> '#fafcfc',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#787C83',
			'alter_light'			=> '#ACB4B6',
			'alter_dark'			=> '#30383B',
			'alter_link'			=> '#3FB6E0',
			'alter_hover'			=> '#A5C422',
			'alter_bd_color'		=> '#DADEE6',
			'alter_bd_hover'		=> '#B8BCC4',
			'alter_bg_color'		=> '#ffffff',
			'alter_bg_hover'		=> '#ffffff',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
		dentario_add_color_scheme('dark', array(

			'title'					=> esc_html__('Dark', 'dentario'),

			// Accent colors
			'accent1'				=> '#A1AAAD',
			'accent1_hover'			=> '#55BDE3',

			// Headers, text and links colors
			'text'					=> '#A1AAAD',
			'text_light'			=> '#FFFFFF',
			'text_dark'				=> '#ECECEC',
			'inverse_text'			=> '#f0f0f0',
			'inverse_light'			=> '#e0e0e0',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#e5e5e5',
			
			// Whole block border and background
			'bd_color'				=> '#4F5B64',
			'bg_color'				=> '#333F48',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#ffffff',
			'alter_light'			=> '#ECECEC',
			'alter_dark'			=> '#A4ABAE',
			'alter_link'			=> '#9CA4AA',
			'alter_hover'			=> '#55BDE3',
			'alter_bd_color'		=> '#4F5B64',
			'alter_bd_hover'		=> '#9CA4AA',
			'alter_bg_color'		=> '#333F48',
			'alter_bg_hover'		=> '#333F48',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		dentario_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'dentario'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '3em',
			'font-weight'	=> '300',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.5em'
			)
		);
		dentario_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'dentario'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '2.5em',
			'font-weight'	=> '300',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.5em'
			)
		);
		dentario_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'dentario'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '2.214em',
			'font-weight'	=> '300',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6667em',
			'margin-bottom'	=> '0.4em'
			)
		);
		dentario_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'dentario'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '2em',
			'font-weight'	=> '300',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '0.9em'
			)
		);
		dentario_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'dentario'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '1.357em',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '1em'
			)
		);
		dentario_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'dentario'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '1.214em',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '1.25em',
			'margin-bottom'	=> '1.3em'
			)
		);
		dentario_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'dentario'),
			'description'	=> '',
			'font-family'	=> 'Poppins',
			'font-size' 	=> '14px',
			'font-weight'	=> '300',
			'font-style'	=> '',
			'line-height'	=> '1.7em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1em'
			)
		);
		dentario_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'dentario'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		dentario_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'dentario'),
			'description'	=> '',
			'font-family'	=> 'Lora',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> 'i',
			'line-height'	=> '1.2857em',
			'margin-top'	=> '',
			'margin-bottom'	=> '2.5em'
			)
		);
		dentario_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'dentario'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em',
			'margin-top'	=> '1.8em',
			'margin-bottom'	=> '1.8em'
			)
		);
		dentario_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'dentario'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.2857em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		dentario_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'dentario'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2.8571em',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '2.2em',
			'margin-bottom'	=> '2.2em'
			)
		);
		dentario_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'dentario'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.929em',
			'font-weight'	=> '500',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);
		dentario_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'dentario'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.929em',
			'font-weight'	=> '500',
			'font-style'	=> '',
			'line-height'	=> '1.2857em'
			)
		);

	}
}





//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('dentario_filter_skin_used_fonts')) {
	//add_filter('dentario_filter_used_fonts', 'dentario_filter_skin_used_fonts');
	function dentario_filter_skin_used_fonts($theme_fonts) {
		$theme_fonts['Lora'] = 1;
		$theme_fonts['Merriweather'] = 1;
		$theme_fonts['Open Sans'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('dentario_filter_skin_list_fonts')) {
	//add_filter('dentario_filter_list_fonts', 'dentario_filter_skin_list_fonts');
	function dentario_filter_skin_list_fonts($list) {
		// Example:
		// if (!isset($list['Advent Pro'])) {
		//		$list['Advent Pro'] = array(
		//			'family' => 'sans-serif',																						// (required) font family
		//			'link'   => 'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
		//			'css'    => dentario_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
		//			);
		// }
		if (!isset($list['Lato']))	$list['Lato'] = array('family'=>'sans-serif');
		if (!isset($list['Lora']))	$list['Lora'] = array('family'=>'serif');
		if (!isset($list['Poppins'])) {
				$list['Poppins'] = array(
					'family' => 'sans-serif',
					'css'    => dentario_get_file_url('/css/font-face/poppins/_fonts.css ')
					);
		 }

		return $list;
	}
}



//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('dentario_action_skin_add_styles')) {
	//add_action('dentario_action_add_styles', 'dentario_action_skin_add_styles');
	function dentario_action_skin_add_styles() {
		// Add stylesheet files
		dentario_enqueue_style( 'dentario-skin-style', dentario_get_file_url('skin.css'), array(), null );
		if (file_exists(dentario_get_file_dir('skin.customizer.css')))
			dentario_enqueue_style( 'dentario-skin-customizer-style', dentario_get_file_url('skin.customizer.css'), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('dentario_filter_skin_add_styles_inline')) {
	//add_filter('dentario_filter_add_styles_inline', 'dentario_filter_skin_add_styles_inline');
	function dentario_filter_skin_add_styles_inline($custom_style) {
		// Todo: add skin specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = dentario_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = dentario_get_scheme_color('accent1');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_regular .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_regular .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}
		return $custom_style;	
	}
}

// Add skin responsive styles
if (!function_exists('dentario_action_skin_add_responsive')) {
	//add_action('dentario_action_add_responsive', 'dentario_action_skin_add_responsive');
	function dentario_action_skin_add_responsive() {
		$suffix = dentario_param_is_off(dentario_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
		if (file_exists(dentario_get_file_dir('skin.responsive'.($suffix).'.css'))) 
			dentario_enqueue_style( 'theme-skin-responsive-style', dentario_get_file_url('skin.responsive'.($suffix).'.css'), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('dentario_filter_skin_add_responsive_inline')) {
	//add_filter('dentario_filter_add_responsive_inline', 'dentario_filter_skin_add_responsive_inline');
	function dentario_filter_skin_add_responsive_inline($custom_style) {
		return $custom_style;	
	}
}

// Add skin.less into list files for compilation
if (!function_exists('dentario_filter_skin_compile_less')) {
	//add_filter('dentario_filter_compile_less', 'dentario_filter_skin_compile_less');
	function dentario_filter_skin_compile_less($files) {
		if (file_exists(dentario_get_file_dir('skin.less'))) {
		 	$files[] = dentario_get_file_dir('skin.less');
		}
		return $files;	
	}
}



//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('dentario_action_skin_add_scripts')) {
	//add_action('dentario_action_add_scripts', 'dentario_action_skin_add_scripts');
	function dentario_action_skin_add_scripts() {
		if (file_exists(dentario_get_file_dir('skin.js')))
			dentario_enqueue_script( 'theme-skin-script', dentario_get_file_url('skin.js'), array(), null );
		if (dentario_get_theme_option('show_theme_customizer') == 'yes' && file_exists(dentario_get_file_dir('skin.customizer.js')))
			dentario_enqueue_script( 'theme-skin-customizer-script', dentario_get_file_url('skin.customizer.js'), array(), null );
	}
}

// Add skin scripts inline
if (!function_exists('dentario_action_skin_add_scripts_inline')) {
	//add_action('dentario_action_add_scripts_inline', 'dentario_action_skin_add_scripts_inline');
	function dentario_action_skin_add_scripts_inline() {
		// Todo: add skin specific scripts
		// Example:
		// echo '<script type="text/javascript">'
		//	. 'jQuery(document).ready(function() {'
		//	. "if (DENTARIO_STORAGE['theme_font']=='') DENTARIO_STORAGE['theme_font'] = '" . dentario_get_custom_font_settings('p', 'font-family') . "';"
		//	. "DENTARIO_STORAGE['theme_skin_color'] = '" . dentario_get_scheme_color('accent1') . "';"
		//	. "});"
		//	. "< /script>";
	}
}
?>