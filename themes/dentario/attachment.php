<?php
/**
 * Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move dentario_set_post_views to the javascript - counter will work under cache system
	if (dentario_get_custom_option('use_ajax_views_counter')=='no') {
		dentario_set_post_views(get_the_ID());
	}

	dentario_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !dentario_param_is_off(dentario_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>