<?php
if (dentario_get_custom_option('menu_toc_home')=='yes')
	echo trim(dentario_sc_anchor(array(
			'id' => "toc_home",
			'title' => esc_html__('Home', 'dentario'),
			'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'dentario'),
			'icon' => "icon-home",
			'separator' => "yes",
			'url' => esc_url(home_url('/'))
		)
	));
if (dentario_get_custom_option('menu_toc_top')=='yes')
	echo trim(dentario_sc_anchor(array(
			'id' => "toc_top",
			'title' => esc_html__('To Top', 'dentario'),
			'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'dentario'),
			'icon' => "icon-double-up",
			'separator' => "yes")
	)); 