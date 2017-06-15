<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_form_1_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_form_1_theme_setup', 1 );
	function dentario_template_form_1_theme_setup() {
		dentario_add_template(array(
			'layout' => 'form_1',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 1', 'dentario')
			));
	}
}

// Template output
if ( !function_exists( 'dentario_template_form_1_output' ) ) {
	function dentario_template_form_1_output($post_options, $post_data) {
		?>
		<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
			<?php dentario_sc_form_show_fields($post_options['fields']); ?>
			<div class="sc_form_info">
				<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_username"><?php esc_html_e('Name', 'dentario'); ?></label><input id="sc_form_username" type="text" name="username" placeholder="<?php esc_attr_e('Name *', 'dentario'); ?>"></div>
				<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_email"><?php esc_html_e('E-mail', 'dentario'); ?></label><input id="sc_form_email" type="text" name="email" placeholder="<?php esc_attr_e('E-mail *', 'dentario'); ?>"></div>
			</div>
			<div class="sc_form_item sc_form_message label_over"><label class="required" for="sc_form_message"><?php esc_html_e('Message', 'dentario'); ?></label><textarea data-autoresize rows="1" id="sc_form_message" name="message" placeholder="<?php esc_attr_e('Message', 'dentario'); ?>"></textarea></div>
			<div class="sc_form_item sc_form_button"><button><?php esc_html_e('Send Message', 'dentario'); ?></button></div>
			<div class="result sc_infobox"></div>
		</form>
		<?php
	}
}
?>