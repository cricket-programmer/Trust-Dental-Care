<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'dentario_template_404_theme_setup' ) ) {
	add_action( 'dentario_action_before_init_theme', 'dentario_template_404_theme_setup', 1 );
	function dentario_template_404_theme_setup() {
		dentario_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			)
		));
	}
}

// Template output
if ( !function_exists( 'dentario_template_404_output' ) ) {
	function dentario_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
				<div class="vc_empty_space" style="height: 32px"><span class="vc_empty_space_inner"></span></div>
				<h1 class="page_title"><?php esc_html_e( '404', 'dentario' ); ?></h1>
				<h2 class="page_subtitle"><?php esc_html_e('The requested page cannot be found', 'dentario'); ?></h2>
				<p class="page_description"><?php echo wp_kses_data( sprintf( __('Can\'t find what you need? Take a moment and do a search below or start from <a href="%s">our homepage</a>.', 'dentario'), esc_url(home_url('/')) ) ); ?></p>
				<?php
				echo '<div class="aligncenter">' . dentario_do_shortcode('[trx_button link="' . esc_url(home_url('/')) . '" size="medium" bg_color="#a5c422" top="null" bottom="null"]' . esc_html__("Go Back Home", 'dentario' ) . '[/trx_button]') . '</div>';
		?>
			</div>
		</article>
		<?php
	}
}
?>