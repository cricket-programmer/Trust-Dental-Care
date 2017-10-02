<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'dentario_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_theme_setup', 1 );
	function dentario_theme_setup() {

		// Register theme menus
		add_filter( 'dentario_filter_add_theme_menus',		'dentario_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'dentario_filter_add_theme_sidebars',	'dentario_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'dentario_filter_importer_options',		'dentario_set_importer_options' );

		// Add theme specified classes into the body
		add_filter( 'body_class', 'dentario_body_classes' );

		// Set additional menu wrapper
		add_filter( 'dentario_filter_get_nav_menu',		'dentario_filter_get_nav_menu_with_wrappers' );

		// Add new text strings to core.messages.php
		add_action( 'dentario_action_add_scripts_inline', 'dentario_messages_add_custom_scripts_inline', 11 );

		// Set list of the theme required plugins
		dentario_storage_set('required_plugins', array(
				'booked',
				'essgrids',
				'revslider',
				'tribe_events',
				'trx_utils',
				'visual_composer',
				'woocommerce'
			)
		);

	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'dentario_add_theme_menus' ) ) {
	//add_filter( 'dentario_filter_add_theme_menus', 'dentario_add_theme_menus' );
	function dentario_add_theme_menus($menus) {
		//For example:
		//$menus['menu_footer'] = esc_html__('Footer Menu', 'dentario');
		//if (isset($menus['menu_panel'])) unset($menus['menu_panel']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'dentario_add_theme_sidebars' ) ) {
	//add_filter( 'dentario_filter_add_theme_sidebars',	'dentario_add_theme_sidebars' );
	function dentario_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'dentario' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'dentario' )
			);
			if (function_exists('dentario_exists_woocommerce') && dentario_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'dentario' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme specified classes into the body
if ( !function_exists('dentario_body_classes') ) {
	//add_filter( 'body_class', 'dentario_body_classes' );
	function dentario_body_classes( $classes ) {

		$classes[] = 'dentario_body';
		$classes[] = 'body_style_' . trim(dentario_get_custom_option('body_style'));
		$classes[] = 'body_' . (dentario_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'theme_skin_' . trim(dentario_get_custom_option('theme_skin'));
		$classes[] = 'article_style_' . trim(dentario_get_custom_option('article_style'));
		
		$blog_style = dentario_get_custom_option(is_singular() && !dentario_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(dentario_get_template_name($blog_style));
		
		$body_scheme = dentario_get_custom_option('body_scheme');
		if (empty($body_scheme)  || dentario_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = dentario_get_custom_option('top_panel_position');
		if (!dentario_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = dentario_get_sidebar_class();

		if (dentario_get_custom_option('show_video_bg')=='yes' && (dentario_get_custom_option('video_bg_youtube_code')!='' || dentario_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		if (dentario_get_theme_option('page_preloader')!='')
			$classes[] = 'preloader';

		return $classes;
	}
}


// Set theme specific importer options
if ( !function_exists( 'dentario_set_importer_options' ) ) {
	//add_filter( 'dentario_filter_importer_options',	'dentario_set_importer_options' );
	function dentario_set_importer_options($options=array()) {
		if (is_array($options)) {
			$options['debug'] = dentario_get_theme_option('debug_mode')=='yes';
			$options['domain_dev'] = '';
			$options['domain_demo'] = 'dentario.themerex.net';
			$options['menus'] = array(
				'menu-main'	  => esc_html__('Main menu', 'dentario'),
				'menu-user'	  => esc_html__('User menu', 'dentario'),
				'menu-footer' => esc_html__('Footer menu', 'dentario')
			);
			$options['file_with_attachments'] = array(				// Array with names of the attachments
				//			'http://some.cloud.net/theme_name/uploads.zip',		// Name of the remote file with attachments
				//			'demo/uploads.zip',									// Name of the local file with attachments
				'http://dentario.themerex.net/wp-content/imports/uploads.001',
				'http://dentario.themerex.net/wp-content/imports/uploads.002',
				'http://dentario.themerex.net/wp-content/imports/uploads.003',
				'http://dentario.themerex.net/wp-content/imports/uploads.004',
				'http://dentario.themerex.net/wp-content/imports/uploads.005',
				'http://dentario.themerex.net/wp-content/imports/uploads.006',
				'http://dentario.themerex.net/wp-content/imports/uploads.007',
				'http://dentario.themerex.net/wp-content/imports/uploads.008',
				'http://dentario.themerex.net/wp-content/imports/uploads.009',
				'http://dentario.themerex.net/wp-content/imports/uploads.010',
				'http://dentario.themerex.net/wp-content/imports/uploads.011',
				'http://dentario.themerex.net/wp-content/imports/uploads.012',
				'http://dentario.themerex.net/wp-content/imports/uploads.013',
				'http://dentario.themerex.net/wp-content/imports/uploads.014',
				'http://dentario.themerex.net/wp-content/imports/uploads.015',
				'http://dentario.themerex.net/wp-content/imports/uploads.016'
			);
			$options['attachments_by_parts'] = true;				// Files above are parts of single file - large media archive. They are must be concatenated in one file before unpacking
		}
		return $options;
	}
}

// Set additional menu wrapper
if ( !function_exists( 'dentario_filter_get_nav_menu_with_wrappers' ) ) {
	function dentario_filter_get_nav_menu_with_wrappers($args) {
		$args['link_before'] = "<span>";
		$args['link_after'] = "</span>";
		return $args;
	}
}

// Add parameters to URL
if (!function_exists('dentario_add_to_url')) {
	function dentario_add_to_url($url, $prm) {
		if (is_array($prm) && count($prm) > 0) {
			$separator = dentario_strpos($url, '?')===false ? '?' : '&';
			foreach ($prm as $k=>$v) {
				$url .= $separator . urlencode($k) . '=' . urlencode($v);
				$separator = '&';
			}
		}
		return $url;
	}
}

// Add new text strings to core.messages.php
if ( !function_exists( 'dentario_messages_add_custom_scripts_inline' ) ) {
	function dentario_messages_add_custom_scripts_inline() {
		echo '<script type="text/javascript">
				jQuery("document").ready (function(){'

		     // Phone mask
		     .  "DENTARIO_STORAGE['phone_mask']		= '^[0-9\\-\\+]{9,15}$';"

		     // Strings for translation
		     . 'DENTARIO_STORAGE["strings"]["phone_not_valid"] = "' . addslashes(esc_html__('Invalid phone number', 'dentario')) . '" ;'
		     . 'DENTARIO_STORAGE["strings"]["phone_empty"] = "' . addslashes(esc_html__('The phone can not be empty', 'dentario')) . '" ;'
		     . 'DENTARIO_STORAGE["strings"]["phone_wrong"] = "' . addslashes(esc_html__('The phone is wrong', 'dentario')) . '" ;'
		     . 'DENTARIO_STORAGE["strings"]["doctor_empty"] = "' . addslashes(esc_html__('Doctor name can not be empty', 'dentario')) . '" ;'
		     . 'DENTARIO_STORAGE["strings"]["doctor_long"] = "' . addslashes(esc_html__('Doctor name too long', 'dentario')) . '" ;'
		     . '});</script>';
	}
}

/* Include framework core files
------------------------------------------------------------------- */
// If now is WP Heartbeat call - skip loading theme core files (to reduce server and DB uploads)
// Remove comments below only if your theme not work with own post types and/or taxonomies
//if (!isset($_POST['action']) || $_POST['action']!="heartbeat") {
	require_once trailingslashit( get_template_directory() ) .'fw/loader.php';
//}

// Custom Scripting to Move JavaScript from the Head to the Footer
 
function remove_head_scripts() {
   remove_action('wp_head', 'wp_print_scripts');
   remove_action('wp_head', 'wp_print_head_scripts', 9);
   remove_action('wp_head', 'wp_enqueue_scripts', 1);
 
   add_action('wp_footer', 'wp_print_scripts', 5);
   add_action('wp_footer', 'wp_enqueue_scripts', 5);
   add_action('wp_footer', 'wp_print_head_scripts', 5);
}
add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );


// custom script for redirect user after leave a comment
// function redirect_after_comment(){
// wp_redirect('https://trustdentalcare.com/thank-you-for-contactig-us');
// exit();
// }
// add_filter('comment_post_redirect', 'redirect_after_comment');


function yelp_api() {
	// API constants, you shouldn't have to change these.
	$CLIENT_ID = 'dFGKv_8xcwdDvg1TID4GNg';
	$CLIENT_SECRET = 'U0FaolT3NaevckEjyxncCBctWQmBjxgu2wI2jRaMdW0AYJ5Q9lcQ2NmeHkXCIvBI';

	$API_HOST = "https://api.yelp.com";
	$TOKEN_PATH = "/oauth2/token";
	$GRANT_TYPE = "client_credentials";
	$BUSINESS_PATH = "/v3/businesses/trust-dental-care-tijuana-4";  // Business ID will come after slash.

	assert($CLIENT_ID, "Please supply your client_id.");
	assert($CLIENT_SECRET, "Please supply your client_secret.");



	try {
        # Using the built-in cURL library for easiest installation.
        # Extension library HttpRequest would also work here.
        $curl = curl_init();
        if (FALSE === $curl)
            throw new Exception('Failed to initialize');
        $postfields = "client_id=" . $CLIENT_ID .
            "&client_secret=" . $CLIENT_SECRET .
            "&grant_type=" . $GRANT_TYPE;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $API_HOST . $TOKEN_PATH,
            CURLOPT_RETURNTRANSFER => true,  // Capture response.
            CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
            ),
        ));
        $response = curl_exec($curl);
        if (FALSE === $response)
            throw new Exception(curl_error($curl), curl_errno($curl));
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($response, $http_status);
        curl_close($curl);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }

        $body = json_decode($response);
	    $bearer_token = $body->access_token;
	    request($bearer_token);
}


function request($bearer_token) {
   return 'api';
    // // Send Yelp API Call
    // try {
    //     $curl = curl_init();
    //     if (FALSE === $curl)
    //         throw new Exception('Failed to initialize');
    //     $url = 'https://api.yelp.com/v3/businesses/trust-dental-care-tijuana-4/reviews';
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,  // Capture response.
    //         CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 30,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET",
    //         CURLOPT_HTTPHEADER => array(
    //             "authorization: Bearer " . $bearer_token,
    //             "cache-control: no-cache",
    //         ),
    //     ));
    //     $response = curl_exec($curl);
    //     if (FALSE === $response)
    //         throw new Exception(curl_error($curl), curl_errno($curl));
    //     $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //     if (200 != $http_status)
    //         throw new Exception($response, $http_status);
    //     curl_close($curl);
    // } catch(Exception $e) {
    //     trigger_error(sprintf(
    //         'Curl failed with error #%d: %s',
    //         $e->getCode(), $e->getMessage()),
    //         E_USER_ERROR);
    // }
    // return $response;
}


	add_shortcode( 'yelp', 'yelp_api' );
?>