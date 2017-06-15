<?php
/**
 * Dentario Framework: Theme options custom fields
 *
 * @package	dentario
 * @since	dentario 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_options_custom_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_options_custom_theme_setup' );
	function dentario_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'dentario_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'dentario_options_custom_load_scripts' ) ) {
	//add_action("admin_enqueue_scripts", 'dentario_options_custom_load_scripts');
	function dentario_options_custom_load_scripts() {
		dentario_enqueue_script( 'dentario-options-custom-script',	dentario_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );	
	}
}


// Show theme specific fields in Post (and Page) options
if ( !function_exists( 'dentario_show_custom_field' ) ) {
	function dentario_show_custom_field($id, $field, $value) {
		$output = '';
		switch ($field['type']) {
			case 'reviews':
				$output .= '<div class="reviews_block">' . trim(dentario_reviews_get_markup($field, $value, true)) . '</div>';
				break;
	
			case 'mediamanager':
				wp_enqueue_media( );
				$output .= '<a id="'.esc_attr($id).'" class="button mediamanager dentario_media_selector"
					data-param="' . esc_attr($id) . '"
					data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'dentario') : esc_html__( 'Choose Image', 'dentario')).'"
					data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'dentario') : esc_html__( 'Choose Image', 'dentario')).'"
					data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
					data-linked-field="'.esc_attr($field['media_field_id']).'"
					>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'dentario') : esc_html__( 'Choose Image', 'dentario')) . '</a>';
				break;
		}
		return apply_filters('dentario_filter_show_custom_field', $output, $id, $field, $value);
	}
}
?>