<?php
/**
 * Dentario Framework: shortcodes manipulations
 *
 * @package	dentario
 * @since	dentario 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('dentario_sc_theme_setup')) {
	add_action( 'dentario_action_init_theme', 'dentario_sc_theme_setup', 1 );
	function dentario_sc_theme_setup() {
		// Add sc stylesheets
		add_action('dentario_action_add_styles', 'dentario_sc_add_styles', 1);
	}
}

if (!function_exists('dentario_sc_theme_setup2')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_sc_theme_setup2' );
	function dentario_sc_theme_setup2() {

		if ( !is_admin() || isset($_POST['action']) ) {
			// Enable/disable shortcodes in excerpt
			add_filter('the_excerpt', 					'dentario_sc_excerpt_shortcodes');
	
			// Prepare shortcodes in the content
			if (function_exists('dentario_sc_prepare_content')) dentario_sc_prepare_content();
		}

		// Add init script into shortcodes output in VC frontend editor
		add_filter('dentario_shortcode_output', 'dentario_sc_add_scripts', 10, 4);

		// AJAX: Send contact form data
		add_action('wp_ajax_send_form',			'dentario_sc_form_send');
		add_action('wp_ajax_nopriv_send_form',	'dentario_sc_form_send');

		// Show shortcodes list in admin editor
		add_action('media_buttons',				'dentario_sc_selector_add_in_toolbar', 11);

	}
}


// Register shortcodes styles
if ( !function_exists( 'dentario_sc_add_styles' ) ) {
	//add_action('dentario_action_add_styles', 'dentario_sc_add_styles', 1);
	function dentario_sc_add_styles() {
		// Shortcodes
		dentario_enqueue_style( 'dentario-shortcodes-style',	dentario_get_file_url('shortcodes/theme.shortcodes.css'), array(), null );
	}
}


// Register shortcodes init scripts
if ( !function_exists( 'dentario_sc_add_scripts' ) ) {
	//add_filter('dentario_shortcode_output', 'dentario_sc_add_scripts', 10, 4);
	function dentario_sc_add_scripts($output, $tag='', $atts=array(), $content='') {

		if (dentario_storage_empty('shortcodes_scripts_added')) {
			dentario_storage_set('shortcodes_scripts_added', true);
			//dentario_enqueue_style( 'dentario-shortcodes-style', dentario_get_file_url('shortcodes/theme.shortcodes.css'), array(), null );
			dentario_enqueue_script( 'dentario-shortcodes-script', dentario_get_file_url('shortcodes/theme.shortcodes.js'), array('jquery'), null, true );	
		}
		
		return $output;
	}
}


/* Prepare text for shortcodes
-------------------------------------------------------------------------------- */

// Prepare shortcodes in content
if (!function_exists('dentario_sc_prepare_content')) {
	function dentario_sc_prepare_content() {
		if (function_exists('dentario_sc_clear_around')) {
			$filters = array(
				array('dentario', 'sc', 'clear', 'around'),
				array('widget', 'text'),
				array('the', 'excerpt'),
				array('the', 'content')
			);
			if (function_exists('dentario_exists_woocommerce') && dentario_exists_woocommerce()) {
				$filters[] = array('woocommerce', 'template', 'single', 'excerpt');
				$filters[] = array('woocommerce', 'short', 'description');
			}
			if (is_array($filters) && count($filters) > 0) {
				foreach ($filters as $flt)
					add_filter(join('_', $flt), 'dentario_sc_clear_around', 1);	// Priority 1 to clear spaces before do_shortcodes()
			}
		}
	}
}

// Enable/Disable shortcodes in the excerpt
if (!function_exists('dentario_sc_excerpt_shortcodes')) {
	function dentario_sc_excerpt_shortcodes($content) {
		if (!empty($content)) {
			$content = do_shortcode($content);
			//$content = strip_shortcodes($content);
		}
		return $content;
	}
}



/*
// Remove spaces and line breaks between close and open shortcode brackets ][:
[trx_columns]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
[/trx_columns]

convert to

[trx_columns][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][/trx_columns]
*/
if (!function_exists('dentario_sc_clear_around')) {
	function dentario_sc_clear_around($content) {
		if (!empty($content)) $content = preg_replace("/\](\s|\n|\r)*\[/", "][", $content);
		return $content;
	}
}






/* Shortcodes support utils
---------------------------------------------------------------------- */

// Dentario shortcodes load scripts
if (!function_exists('dentario_sc_load_scripts')) {
	function dentario_sc_load_scripts() {
		dentario_enqueue_script( 'dentario-shortcodes-script', dentario_get_file_url('core/core.shortcodes/shortcodes_admin.js'), array('jquery'), null, true );
		dentario_enqueue_script( 'dentario-selection-script',  dentario_get_file_url('js/jquery.selection.js'), array('jquery'), null, true );
	}
}

// Dentario shortcodes prepare scripts
if (!function_exists('dentario_sc_prepare_scripts')) {
	function dentario_sc_prepare_scripts() {
		if (!dentario_storage_isset('shortcodes_prepared')) {
			dentario_storage_set('shortcodes_prepared', true);
			$json_parse_func = 'eval';	// 'JSON.parse'
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					try {
						DENTARIO_STORAGE['shortcodes'] = <?php echo trim($json_parse_func); ?>(<?php echo json_encode( dentario_array_prepare_to_json(dentario_storage_get('shortcodes')) ); ?>);
					} catch (e) {}
					DENTARIO_STORAGE['shortcodes_cp'] = '<?php echo is_admin() ? (!dentario_storage_empty('to_colorpicker') ? dentario_storage_get('to_colorpicker') : 'wp') : 'custom'; ?>';	// wp | tiny | custom
				});
			</script>
			<?php
		}
	}
}

// Show shortcodes list in admin editor
if (!function_exists('dentario_sc_selector_add_in_toolbar')) {
	//add_action('media_buttons','dentario_sc_selector_add_in_toolbar', 11);
	function dentario_sc_selector_add_in_toolbar(){

		if ( !dentario_options_is_used() ) return;

		dentario_sc_load_scripts();
		dentario_sc_prepare_scripts();

		$shortcodes = dentario_storage_get('shortcodes');
		$shortcodes_list = '<select class="sc_selector"><option value="">&nbsp;'.esc_html__('- Select Shortcode -', 'dentario').'&nbsp;</option>';

		if (is_array($shortcodes) && count($shortcodes) > 0) {
			foreach ($shortcodes as $idx => $sc) {
				$shortcodes_list .= '<option value="'.esc_attr($idx).'" title="'.esc_attr($sc['desc']).'">'.esc_html($sc['title']).'</option>';
			}
		}

		$shortcodes_list .= '</select>';

		echo trim($shortcodes_list);
	}
}

// Dentario shortcodes builder settings
require_once trailingslashit(get_template_directory()) .'fw/core/core.shortcodes/shortcodes_settings.php';

// VC shortcodes settings
if ( class_exists('WPBakeryShortCode') ) {
	require_once trailingslashit(get_template_directory()) .'fw/core/core.shortcodes/shortcodes_vc.php';
}

// Dentario shortcodes implementation
dentario_autoload_folder( 'shortcodes/trx_basic' );
dentario_autoload_folder( 'shortcodes/trx_optional' );
?>