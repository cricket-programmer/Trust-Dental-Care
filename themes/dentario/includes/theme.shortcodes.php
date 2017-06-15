<?php
if (!function_exists('dentario_theme_shortcodes_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_theme_shortcodes_setup', 1 );
	function dentario_theme_shortcodes_setup() {
		add_filter('dentario_filter_googlemap_styles', 'dentario_theme_shortcodes_googlemap_styles');
	}
}


// Add theme-specific Google map styles
if ( !function_exists( 'dentario_theme_shortcodes_googlemap_styles' ) ) {
	function dentario_theme_shortcodes_googlemap_styles($list) {
		$list['inverse']	= esc_html__('Inverse', 'dentario');
		$list['dark']		= esc_html__('Dark', 'dentario');
		$list['ultra_light'] = esc_html__('Ultra Light', 'dentario');
		return $list;
	}
}
?>