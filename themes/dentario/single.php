<?php
/**
 * Single post
 */
get_header(); 

$single_style = dentario_storage_get('single_style');
if (empty($single_style)) $single_style = dentario_get_custom_option('single_style');
while ( have_posts() ) { the_post();
	dentario_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !dentario_param_is_off(dentario_get_custom_option('show_sidebar_main')),
			'content' => dentario_get_template_property($single_style, 'need_content'),

			'terms_list' => dentario_get_template_property($single_style, 'need_terms')
		)
	);	




}


get_footer();
?>