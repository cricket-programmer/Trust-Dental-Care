<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_header_3_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_header_3_theme_setup', 1 );
	function dentario_template_header_3_theme_setup() {
		dentario_add_template(array(
			'layout' => 'header_3',
			'mode'   => 'header',
			'title'  => esc_html__('Header 3', 'dentario'),
			'icon'   => dentario_get_file_url('templates/headers/images/3.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'dentario_template_header_3_output' ) ) {
	function dentario_template_header_3_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background-image: url('.esc_url($header_image).')"' 
				: '';
		}
		?>
		
		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_3 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_3 top_panel_position_<?php echo esc_attr(dentario_get_custom_option('top_panel_position')); ?>">
			
			<?php if (dentario_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						dentario_template_set_args('top-panel-top', array(
							'top_panel_top_components' => array('contact_phone',  'open_hours', 'socials')
						));
						get_template_part(dentario_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>

			<div class="top_panel_middle" <?php echo trim($header_css); ?>>
				<div class="content_wrap">
					<div class="contact_logo">
						<?php dentario_show_logo(true, true); ?>
					</div>
                    <?php if (dentario_get_custom_option('show_search')=='yes'){ ?>
                        <div class="search_wrap_fixed">
                            <a class="search_link icon-magnifying-glass-2" href="#"></a>
                            <div class="search_form_wrap_fixed scheme_dark">
                                <form method="get" class="search_form" action="<?php echo esc_url(home_url('/')); ?>">
                                    <button type="submit" class="search_submit icon-magnifying-glass-2" title=""></button>
                                    <input type="text" class="search_field" placeholder="<?php esc_attr_e('Search', 'dentario'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
                                    <span class="search_close icon-cross"></span>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="menu_main_wrap">
                        <a href="#" class="menu_main_responsive_button icon-menu"></a>
                        <nav class="menu_main_nav_area">
                            <?php
                            $menu_main = dentario_get_nav_menu('menu_main');
                            if (empty($menu_main)) $menu_main = dentario_get_nav_menu();
                            echo trim($menu_main);
                            ?>
                        </nav>
                    </div>
				</div>
			</div>

			</div>
		</header>

		<?php
		dentario_storage_set('header_mobile', array(
				'open_hours' => false,
				'login' => false,
				'socials' => true,
				'bookmarks' => false,
				'contact_address' => false,
				'contact_phone_email' => false,
				'contact_phone' => true,
				'woo_cart' => false,
				'search' => false
			)
		);
	}
}
?>