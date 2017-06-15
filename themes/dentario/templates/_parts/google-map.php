<?php
if ( dentario_get_custom_option('show_googlemap')=='yes' ) {
	$map_address = dentario_get_custom_option('googlemap_address');
	$map_latlng  = dentario_get_custom_option('googlemap_latlng');
	$map_zoom    = dentario_get_custom_option('googlemap_zoom');
	$map_style   = dentario_get_custom_option('googlemap_style');
	$map_height  = dentario_get_custom_option('googlemap_height');
	if (!empty($map_address) || !empty($map_latlng)) {
		$args = array();
		if (!empty($map_style))		$args['style'] = esc_attr($map_style);
		if (!empty($map_zoom))		$args['zoom'] = esc_attr($map_zoom);
		if (!empty($map_height))	$args['height'] = esc_attr($map_height);
		echo trim(dentario_sc_googlemap($args));
	}
}