<?php
/**
 * The Header for our theme.
 */

// Theme init - don't remove next row! Load custom options
dentario_core_init_theme();

dentario_profiler_add_point(esc_html__('Before Theme HTML output', 'dentario'));

$theme_skin = dentario_esc(dentario_get_custom_option('theme_skin'));
$body_scheme = dentario_get_custom_option('body_scheme');
if (empty($body_scheme)  || dentario_is_inherit_option($body_scheme)) $body_scheme = 'original';
$body_style  = dentario_get_custom_option('body_style');
$top_panel_style = dentario_get_custom_option('top_panel_style');
$top_panel_position = dentario_get_custom_option('top_panel_position');
$top_panel_scheme = dentario_get_custom_option('top_panel_scheme');
$video_bg_show  = dentario_get_custom_option('show_video_bg')=='yes' && (dentario_get_custom_option('video_bg_youtube_code')!='' || dentario_get_custom_option('video_bg_url')!='');

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo 'scheme_' . esc_attr($body_scheme); ?>">
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1<?php if (dentario_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
	<meta name="format-detection" content="telephone=no">

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php
	if ( !function_exists('has_site_icon') || !has_site_icon() ) {
		$favicon = dentario_get_custom_option('favicon');
		if (!$favicon) {
			if ( file_exists(dentario_get_file_dir('skins/'.($theme_skin).'/images/favicon.ico')) )
				$favicon = dentario_get_file_url('skins/'.($theme_skin).'/images/favicon.ico');
			if ( !$favicon && file_exists(dentario_get_file_dir('favicon.ico')) )
				$favicon = dentario_get_file_url('favicon.ico');
		}
		if ($favicon) {
			?><link rel="icon" type="image/x-icon" href="<?php echo esc_url($favicon); ?>" /><?php
		}
	}

?>

<?php

	if(is_home) {
		echo '
	<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "LocalBusiness",
  "image": "https://trustdentalcare.com/wp-content/uploads/2016/12/trust-dental-care-logo.png",
  "@id": "https://trustdentalcare.com",
  "name": "Trust Dental Care",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Blvd. General Rodolfo Sánchez Taboada 929",
    "addressLocality": "Tijuana",
    "addressRegion": "TJ",
    "postalCode": "22000",
    "addressCountry": "MX"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 32.533909,
    "longitude": -117.0332227
  },
  "url": "https://trustdentalcare.com",
  "telephone": "8448487878",
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday"
      ],
      "opens": "08:30",
      "closes": "18:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Saturday",
      "opens": "08:30",
      "closes": "14:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Sunday",
      "opens": "closed",
      "closes": "closed"
    }
  ]
}
</script>
';
	}

 ?>

 <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Dentist",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Tijuana",
    "addressRegion": "BC",
    "postalCode": "22200",
    "streetAddress": "Boulevard General Rodolfo Sánchez Taboada 929,"
  },
  "image": "https://trustdentalcare.com/wp-content/uploads/2016/12/trust-dental-care-logo.png",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "reviewCount": "1742"
  },
  "name": "Trust Dental Care",
  "openingHours": [
    "Mo-Fr 09:00-18:00",
    "St 09:00-14:00"
  ],
  "priceRange": "$$",

  "telephone": "(844) 8487878",
  "url": "https://trustdentalcare.com/"
}
</script>

<?php
if(is_single()) {

echo "
<style>
.post_content p{
font-size:15px;
}
.page_title {
font-size: 2.8em!important;
font-weight: bold!important;
}
</style>";


}
wp_head();
?>
</head>
<body <?php body_class();?>>

<!-- facebook plugin -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



	<?php
	dentario_profiler_add_point(esc_html__('BODY start', 'dentario'));

	echo force_balance_tags(dentario_get_custom_option('gtm_code'));

	do_action( 'before' );

	// Add TOC items 'Home' and "To top"
	require_once dentario_get_file_dir('templates/_parts/menu-toc.php');

	?>

	<?php if ( !dentario_param_is_off(dentario_get_custom_option('show_sidebar_outer')) ) { ?>
	<div class="outer_wrap">
	<?php } ?>

	<?php get_template_part(dentario_get_file_slug('sidebar_outer.php')); ?>

	<?php
		$class = $style = '';
		if (dentario_get_custom_option('bg_custom')=='yes' && ($body_style=='boxed' || dentario_get_custom_option('bg_image_load')=='always')) {
				if (($img = dentario_get_custom_option('bg_image_custom')) != '')
					$style = 'background: url('.esc_url($img).') ' . str_replace('_', ' ', dentario_get_custom_option('bg_image_custom_position')) . ' no-repeat fixed;';
				else if (($img = dentario_get_custom_option('bg_pattern_custom')) != '')
					$style = 'background: url('.esc_url($img).') 0 0 repeat fixed;';
				else if (($img = dentario_get_custom_option('bg_image')) > 0)
					$class = 'bg_image_'.($img);
				else if (($img = dentario_get_custom_option('bg_pattern')) > 0)
					$class = 'bg_pattern_'.($img);
				if (($img = dentario_get_custom_option('bg_color')) != '')
					$style .= 'background-color: '.($img).';';
			}
	?>

	<script type="text/javascript">
		function messengerHandle() {
		var messengerBtn = document.getElementById('messenger-btn');
		var messengerTab = document.getElementById('messenger-tab');


		if (messengerTab.classList.contains('fb-message-hide')) {
			messengerTab.classList.remove('fb-message-hide');
			messengerTab.classList.add('fb-message-show');
		} else {
			messengerTab.classList.remove('fb-message-show');
			messengerTab.classList.add('fb-message-hide');
		}


		console.log('hola');
		console.log(messengerTab);
		}

	</script>




	<div class="body_wrap<?php echo !empty($class) ? ' '.esc_attr($class) : ''; ?>"<?php echo !empty($style) ? ' style="'.esc_attr($style).'"' : ''; ?>>

		<?php
		// Video BG
		require_once dentario_get_file_dir('templates/headers/_parts/video-bg.php');
		?>

		<div class="page_wrap">

			<?php
			dentario_profiler_add_point(esc_html__('Before Page Header', 'dentario'));
			// Top panel 'Above' or 'Over'
			if (in_array($top_panel_position, array('above', 'over'))) {
				dentario_show_post_layout(array(
					'layout' => $top_panel_style,
					'position' => $top_panel_position,
					'scheme' => $top_panel_scheme
					), false);
				// Mobile Menu
				get_template_part(dentario_get_file_slug('templates/headers/_parts/header-mobile.php'));
				dentario_profiler_add_point(esc_html__('After show menu', 'dentario'));
			}

			// Slider
			get_template_part(dentario_get_file_slug('templates/headers/_parts/slider.php'));
			// Top panel 'Below'
			if ($top_panel_position == 'below') {
				dentario_show_post_layout(array(
					'layout' => $top_panel_style,
					'position' => $top_panel_position,
					'scheme' => $top_panel_scheme
					), false);
				// Mobile Menu
				get_template_part(dentario_get_file_slug('templates/headers/_parts/header-mobile.php'));
				dentario_profiler_add_point(esc_html__('After show menu', 'dentario'));
			}

			// Top of page section: page title and breadcrumbs
			require_once dentario_get_file_dir('templates/headers/_parts/breadcrumbs.php');

			?>

			<div class="page_content_wrap page_paddings_<?php echo esc_attr(dentario_get_custom_option('body_paddings')); ?>">

				<?php
				dentario_profiler_add_point(esc_html__('Before Page content', 'dentario'));
				// Content and sidebar wrapper
				if ($body_style!='fullscreen') dentario_open_wrapper('<div class="content_wrap">');

				// Main content wrapper
				dentario_open_wrapper('<div class="content">');

				?>
