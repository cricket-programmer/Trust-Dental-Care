<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_form_2_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_form_2_theme_setup', 1 );
	function dentario_template_form_2_theme_setup() {
		dentario_add_template(array(
			'layout' => 'form_2',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 2', 'dentario')
			));
	}
}

// Template output
if ( !function_exists( 'dentario_template_form_2_output' ) ) {
	function dentario_template_form_2_output($post_options, $post_data) {
		?>
		<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
			<?php dentario_sc_form_show_fields($post_options['fields']); ?>
			<div class="sc_form_info">
				<div class="columns_wrap sc_columns columns_nofluid sc_columns_count_2"><div class="column-1_2 sc_column_item sc_column_item_1 odd first">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper">
								<div class="sc_form_item sc_form_field label_over"><i class="icon  icon-user-light"></i><label class="required" for="sc_form_username"><?php esc_html_e('Name', 'dentario'); ?></label><input id="sc_form_username" type="text" name="username" placeholder="<?php esc_attr_e('Name *', 'dentario'); ?>"></div>
							</div>
						</div>
					</div><div class="column-1_2 sc_column_item sc_column_item_2 even">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper">
								<div class="sc_form_item sc_form_field label_over"><i class="icon icon-mobile-light"></i><label class="required" for="sc_form_phone"><?php esc_html_e('Phone', 'dentario'); ?></label><input id="sc_form_phone" type="text" name="phone" placeholder="<?php esc_attr_e('Phone (Ex. +1-234-567-890)', 'dentario'); ?>"></div>
							</div>
						</div>
					</div>
				</div><div class="columns_wrap sc_columns columns_nofluid sc_columns_count_2"><div class="column-1_2 sc_column_item sc_column_item_1 odd first">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper">
								<div class="sc_form_item sc_form_field label_over"><i class="icon icon-mail-light"></i><label class="required" for="sc_form_email"><?php esc_html_e('E-mail', 'dentario'); ?></label><input id="sc_form_email" type="text" name="email" placeholder="<?php esc_attr_e('E-mail *', 'dentario'); ?>"></div>

							</div>
						</div>
					</div><div class="column-1_2 sc_column_item sc_column_item_2 even">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper">
								<div class="sc_form_item sc_form_field label_over"><i class="icon icon-dentrario_add_user"></i><label class="required" for="sc_form_doctor"><?php esc_html_e('Doctor', 'dentario'); ?></label><input id="sc_form_doctor" type="text" name="doctor" placeholder="<?php esc_attr_e('Doctor', 'dentario'); ?>"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sc_form_item sc_form_message label_over"><label class="required" for="sc_form_message"><?php esc_html_e('Message', 'dentario'); ?></label><textarea id="sc_form_message" data-autoresize rows="1" name="message" placeholder="<?php esc_attr_e('Message', 'dentario'); ?>"></textarea></div>
			<div class="sc_form_item sc_form_button"><button class="aligncenter"><?php esc_html_e('Make an Appointment', 'dentario'); ?></button></div>
			<div class="result sc_infobox"></div>
		</form>
		<?php
	}
}
?>