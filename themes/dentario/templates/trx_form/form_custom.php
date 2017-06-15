<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_form_custom_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_form_custom_theme_setup', 1 );
	function dentario_template_form_custom_theme_setup() {
		dentario_add_template(array(
			'layout' => 'form_custom',
			'mode'   => 'forms',
			'title'  => esc_html__('Custom Form', 'dentario')
			));
	}
}

// Template output
if ( !function_exists( 'dentario_template_form_custom_output' ) ) {
	function dentario_template_form_custom_output($post_options, $post_data) {
		?>
		<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
			<?php
			dentario_sc_form_show_fields($post_options['fields']);
			echo trim($post_options['content']);
			?>
			<div class="result sc_infobox"></div>
		</form>
		<?php
	}
}
?>