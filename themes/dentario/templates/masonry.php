<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_masonry_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_masonry_theme_setup', 1 );
	function dentario_template_masonry_theme_setup() {
		dentario_add_template(array(
			'layout' => 'masonry_2',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'need_terms' => true,
			'title'  => esc_html__('Masonry tile (different height) /2 columns/', 'dentario'),
			'thumb_title'  => esc_html__('Medium image', 'dentario'),
			'w'		 => 370,
			'h_crop' => 267,
			'h'      => null
		));
		dentario_add_template(array(
			'layout' => 'masonry_3',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'need_terms' => true,
			'title'  => esc_html__('Masonry tile /3 columns/', 'dentario'),
			'thumb_title'  => esc_html__('Medium image', 'dentario'),
			'w'		 => 370,
			'h_crop' => 267,
			'h'      => null
		));
		dentario_add_template(array(
			'layout' => 'masonry_4',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'need_terms' => true,
			'title'  => esc_html__('Masonry tile /4 columns/', 'dentario'),
			'thumb_title'  => esc_html__('Medium image', 'dentario'),
			'w'		 => 370,
			'h_crop' => 267,
			'h'      => null
		));
		dentario_add_template(array(
			'layout' => 'classic_2',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'need_terms' => true,
			'title'  => esc_html__('Classic tile (equal height) /2 columns/', 'dentario'),
			'thumb_title'  => esc_html__('Medium image (crop)', 'dentario'),
			'w'		 => 370,
			'h'		 => 267
		));
		dentario_add_template(array(
			'layout' => 'classic_3',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'need_terms' => true,
			'title'  => esc_html__('Classic tile /3 columns/', 'dentario'),
			'thumb_title'  => esc_html__('Medium image (crop)', 'dentario'),
			'w'		 => 370,
			'h'		 => 267
		));
		dentario_add_template(array(
			'layout' => 'classic_4',
			'template' => 'masonry',
			'mode'   => 'blog',
			'need_isotope' => true,
			'need_terms' => true,
			'title'  => esc_html__('Classic tile /4 columns/', 'dentario'),
			'thumb_title'  => esc_html__('Medium image (crop)', 'dentario'),
			'w'		 => 370,
			'h'		 => 267
		));
		// Add template specific scripts
		add_action('dentario_action_blog_scripts', 'dentario_template_masonry_add_scripts');
	}
}

// Add template specific scripts
if (!function_exists('dentario_template_masonry_add_scripts')) {
	//add_action('dentario_action_blog_scripts', 'dentario_template_masonry_add_scripts');
	function dentario_template_masonry_add_scripts($style) {
		if (in_array(dentario_substr($style, 0, 8), array('classic_', 'masonry_'))) {
			dentario_enqueue_script( 'isotope', dentario_get_file_url('js/jquery.isotope.min.js'), array(), null, true );
		}
	}
}

// Template output
if ( !function_exists( 'dentario_template_masonry_output' ) ) {
	function dentario_template_masonry_output($post_options, $post_data) {
		$show_title = !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote'));
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($post_options['columns_count']) 
									? (empty($parts[1]) ? 1 : (int) $parts[1])
									: $post_options['columns_count']
									));
		$tag = dentario_in_shortcode_blogger(true) ? 'div' : 'article';
		?>
		<div class="isotope_item isotope_item_<?php echo esc_attr($style); ?> isotope_item_<?php echo esc_attr($post_options['layout']); ?> isotope_column_<?php echo esc_attr($columns); ?>
					<?php
					if ($post_options['filters'] != '') {
						if ($post_options['filters']=='categories' && !empty($post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids))
							echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy']]->terms_ids);
						else if ($post_options['filters']=='tags' && !empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids))
							echo ' flt_' . join(' flt_', $post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms_ids);
					}
					?>">
			<<?php echo trim($tag); ?> class="post_item post_item_<?php echo esc_attr($style); ?> post_item_<?php echo esc_attr($post_options['layout']); ?>
				 <?php echo ' post_format_'.esc_attr($post_data['post_format']) 
					. ($post_options['number']%2==0 ? ' even' : ' odd') 
					. ($post_options['number']==0 ? ' first' : '') 
					. ($post_options['number']==$post_options['posts_on_page'] ? ' last' : '');
				?>">
				
				<?php if ($post_data['post_video'] || $post_data['post_audio'] || $post_data['post_thumb'] ||  $post_data['post_gallery']) { ?>
					<div class="post_featured">
						<?php
						dentario_template_set_args('post-featured', array(
							'post_options' => $post_options,
							'post_data' => $post_data
						));
						get_template_part(dentario_get_file_slug('templates/_parts/post-featured.php'));
						?>
					</div>
				<?php } ?>

				<div class="post_content isotope_item_content">
					
					<?php
					if ($show_title) {
						if (!isset($post_options['links']) || $post_options['links']) {
							?>
							<h6 class="post_title"><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php echo trim($post_data['post_title']); ?></a></h6>
							<?php
						} else {
							?>
							<h6 class="post_title"><?php echo trim($post_data['post_title']); ?></h6>
							<?php
						}
					}

					if (!$post_data['post_protected'] && $post_options['info']) {
						$post_options['info_parts'] = array('counters'=>false, 'terms'=>true, 'author'=>true);
						dentario_template_set_args('post-info', array(
							'post_options' => $post_options,
							'post_data' => $post_data
						));
						get_template_part(dentario_get_file_slug('templates/_parts/post-info.php'));
					}
					?>

					<div class="post_descr">
						<?php
						if ($post_data['post_protected']) {
							echo trim($post_data['post_excerpt']); 
						} else {
							if ($post_data['post_excerpt']) {
								echo in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status')) ? $post_data['post_excerpt'] : '<p>'.trim(dentario_strshort($post_data['post_excerpt'], isset($post_options['descr']) ? $post_options['descr'] : dentario_get_custom_option('post_excerpt_maxlength_masonry'))).'</p>';
							}
							if (!empty($post_options['readmore']) && !in_array($post_data['post_format'], array('quote', 'link', 'chat', 'aside', 'status'))) {
								?><a href="<?php echo esc_url($post_data['post_link']); ?>" class="post_readmore"><span class="post_readmore_label"><?php echo trim($post_options['readmore']); ?></span></a><?php
							}
						}
						?>
					</div>

				</div>				<!-- /.post_content -->
			</<?php echo trim($tag); ?>>	<!-- /.post_item -->
		</div>						<!-- /.isotope_item -->
		<?php
	}
}
?>