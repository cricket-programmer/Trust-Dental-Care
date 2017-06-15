<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_plain_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_plain_theme_setup', 1 );
	function dentario_template_plain_theme_setup() {
		dentario_add_template(array(
			'layout' => 'plain',
			'template' => 'plain',
			'need_terms' => true,
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Plain', 'dentario')
			));
	}
}

// Template output
if ( !function_exists( 'dentario_template_plain_output' ) ) {
	function dentario_template_plain_output($post_options, $post_data) {
		?>
		<div class="post_item sc_blogger_item sc_plain_item<?php if ($post_options['number'] == $post_options['posts_on_page'] && !dentario_param_is_on($post_options['loadmore'])) echo ' sc_blogger_item_last'; ?>">
			
			<?php

			if (!isset($post_options['links']) || $post_options['links']) { 
				?><h6 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php echo trim($post_data['post_title']); ?></a></h6><?php
			} else {
				?><h6 class="post_title"><?php echo trim($post_data['post_title']); ?></h6><?php
			}

			if ($post_data['post_excerpt']) {
				echo in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status')) ? $post_data['post_excerpt'] : '<p>'.trim(dentario_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : dentario_get_custom_option('post_excerpt_maxlength'))).'</p>';
			}
			
			if (!$post_data['post_protected'] && $post_options['info']) {
				$post_options['info_parts'] = array('counters'=>false, 'terms'=>true, 'author' => true);
				dentario_template_set_args('post-info', array(
					'post_options' => $post_options,
					'post_data' => $post_data
				));
				get_template_part(dentario_get_file_slug('templates/_parts/post-info.php'));
			}
			?>

		</div>		<!-- /.post_item -->

		<?php
	}
}
?>