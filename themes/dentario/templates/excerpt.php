<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_excerpt_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_excerpt_theme_setup', 1 );
	function dentario_template_excerpt_theme_setup() {
		dentario_add_template(array(
			'layout' => 'excerpt',
			'mode'   => 'blog',
			'title'  => esc_html__('Excerpt', 'dentario'),
			'thumb_title'  => esc_html__('Large image (crop)', 'dentario'),
			'need_terms'=> 'true',
			'w'		 => 770,
			'h'		 => 434
		));
	}
}

// Template output
if ( !function_exists( 'dentario_template_excerpt_output' ) ) {
	function dentario_template_excerpt_output($post_options, $post_data) {
		$show_title = true;	//!in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote'));
		$tag = dentario_in_shortcode_blogger(true) ? 'div' : 'article';
		?>
		<<?php echo trim($tag); ?>
		<?php post_class('post_item post_item_excerpt post_featured_' . esc_attr($post_options['post_class']) . ' post_format_'.esc_attr($post_data['post_format']) . ($post_options['number']%2==0 ? ' even' : ' odd') . ($post_options['number']==0 ? ' first' : '') . ($post_options['number']==$post_options['posts_on_page']? ' last' : '') . ($post_options['add_view_more'] ? ' viewmore' : '')); ?>>
			<?php
			if ($post_data['post_flags']['sticky']) {
				?><span class="sticky_label"></span><?php
			}

			if ($show_title && $post_options['location'] == 'center' && !empty($post_data['post_title'])) {
				?><h3 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_icon <?php echo esc_attr($post_data['post_icon']); ?>"></span><?php echo trim($post_data['post_title']); ?></a></h3><?php
			}
			?>
	
			<div class="post_content clearfix">
				<?php
				if ($show_title && $post_options['location'] != 'center' && !empty($post_data['post_title'])) {
					?><h4 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_icon <?php echo esc_attr($post_data['post_icon']); ?>"></span><?php echo trim($post_data['post_title']); ?></a></h4><?php
				}

				if (!$post_data['post_protected'] && $post_options['info']) {
					dentario_template_set_args( 'post-info', array(
						'post_options' => $post_options,
						'post_data'    => $post_data
					) );
					get_template_part( dentario_get_file_slug( 'templates/_parts/post-info.php' ) );
				}
				?>
			</div>
			<?php
		if (!$post_data['post_protected'] && (!empty($post_options['dedicated']) || $post_data['post_thumb'] || $post_data['post_gallery'] || $post_data['post_video'] || $post_data['post_audio'])) {
			?>
			<div class="post_featured">
				<?php
				if (!empty($post_options['dedicated'])) {
					echo trim($post_options['dedicated']);
				} else if ($post_data['post_thumb'] || $post_data['post_gallery'] || $post_data['post_video'] || $post_data['post_audio']) {
					dentario_template_set_args('post-featured', array(
						'post_options' => $post_options,
						'post_data' => $post_data
					));
					get_template_part(dentario_get_file_slug('templates/_parts/post-featured.php'));
				}
				?>
			</div>
			<?php
			}
			?>
			<div class="post_content clearfix">
				<div class="post_descr">
				<?php
					if ($post_data['post_protected']) {
						echo trim($post_data['post_excerpt']); 
					} else {
						if ($post_data['post_excerpt']) {
							echo in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status')) ? $post_data['post_excerpt'] : '<p>'.trim(dentario_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : dentario_get_custom_option('post_excerpt_maxlength'))).'</p>';
						}
					}
					if (empty($post_options['readmore'])) $post_options['readmore'] = esc_html__('Read more', 'dentario');
					if (!dentario_param_is_off($post_options['readmore']) && !in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))) {
						echo trim(dentario_sc_button(array('link'=>$post_data['post_link'],'size'=>'medium'), $post_options['readmore']));
					}
				?>
				</div>

			</div>	<!-- /.post_content -->

		</<?php echo trim($tag); ?>>	<!-- /.post_item -->

	<?php
	}
}
?>