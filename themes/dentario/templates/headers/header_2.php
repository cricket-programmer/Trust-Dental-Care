<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_header_2_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_header_2_theme_setup', 1 );
	function dentario_template_header_2_theme_setup() {
		dentario_add_template(array(
			'layout' => 'header_2',
			'mode'   => 'header',
			'title'  => esc_html__('Header 2', 'dentario'),
			'icon'   => dentario_get_file_url('templates/headers/images/2.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'dentario_template_header_2_output' ) ) {
	function dentario_template_header_2_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!=''
				? ' style="background-image: url('.esc_url($header_image).')"'
				: '';
		}
		?>
		<div id="preloader"></div>
		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_2 scheme_<?php echo esc_attr($post_options['scheme']); ?>" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
			<div class="top_panel_wrap_inner top_panel_inner_style_2 top_panel_position_<?php echo esc_attr(dentario_get_custom_option('top_panel_position')); ?>">

			<?php if (dentario_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						dentario_template_set_args('top-panel-top', array(
							'top_panel_top_components' => array('contact_phone', 'open_hours', 'login', 'socials', 'currency')
						));
						get_template_part(dentario_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>

			<div class="top_panel_middle" <?php echo trim($header_css); ?>>
				<div class="content_wrap">
					<div class="columns_wrap columns_fluid"><?php
						// Phone and email
						$contact_phone=trim(dentario_get_custom_option('contact_phone'));
						$contact_info=trim(dentario_get_custom_option('contact_info'));
						$open_hours=trim(dentario_get_custom_option('contact_open_hours'));
						if (!empty($contact_phone) || !empty($contact_info)) {
							?><div class="column-1_3 contact_field contact_phone_wrap">
								<span class="contact_icon icon-phone"></span>
								<span class="contact_label contact_phone"><?php echo force_balance_tags($contact_phone); ?></span>
								<span class="contact_address"><?php echo force_balance_tags($contact_info); ?></span>
							</div><?php
						}
						?><div class="column-1_3 contact_logo">
								<?php dentario_show_logo(); ?>
							</div>

							<div class="column-1_3 header_contact_phone">
								<p>
									<a href="tel:8448487878">
										<i class="sc_list_icon icon-mobile"></i>
										<span class="phone">(844) 848 7878</span>
										<span class="phone-text">Contact us today. We're here for you!</span>
									</a>

								</p>
							</div>









						<?php
                        if (!empty($open_hours)) {
                            ?><div class="column-1_3 contact_field open_hours_wrap">
                            <span class="contact_icon icon-calendar-light"></span>
                            <span class="open_hours_label">Office hours:</span>
                            <span class="open_hours_text"><?php echo force_balance_tags($open_hours); ?></span>
                            </div><?php
                        }
                        ?>
					</div>
				</div>
			</div>

			<div class="top_panel_bottom">
				<div class="content_wrap clearfix">
					<nav class="menu_main_nav_area" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
						<?php
						$menu_main = dentario_get_nav_menu('menu_main');
						if (empty($menu_main)) $menu_main = dentario_get_nav_menu();
						echo trim($menu_main);
						?>
					</nav>
				</div>
			</div>

			</div>
		</header>

		<?php

		$show_login = false;
		if (dentario_get_custom_option('show_top_panel_top')=='yes') $show_login = true;

		dentario_storage_set('header_mobile', array(
				'open_hours' => false,
				'login' => $show_login,
				'socials' => true,
				'bookmarks' => false,
				'contact_address' => false,
				'contact_phone' => true,
				'contact_phone_email' => false,
				'woo_cart' => true,
				'search' => true
			)
			);
	}
}
?>
