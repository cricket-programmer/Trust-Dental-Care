<?php
/**
 * Dentario Framework
 *
 * @package dentario
 * @since dentario 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'DENTARIO_FW_DIR' ) )			define( 'DENTARIO_FW_DIR', 'fw' );

// Theme timing
if ( ! defined( 'DENTARIO_START_TIME' ) )		define( 'DENTARIO_START_TIME', microtime(true));		// Framework start time
if ( ! defined( 'DENTARIO_START_MEMORY' ) )		define( 'DENTARIO_START_MEMORY', memory_get_usage());	// Memory usage before core loading
if ( ! defined( 'DENTARIO_START_QUERIES' ) )	define( 'DENTARIO_START_QUERIES', get_num_queries());	// DB queries used

// Include theme variables storage
require_once trailingslashit(get_template_directory()) .'fw/core/core.storage.php';

// Theme variables storage
dentario_storage_set('options_prefix', 'dentario');	// Used as prefix for store theme's options in the post meta and wp options
dentario_storage_set('page_template', '');			// Storage for current page template name (used in the inheritance system)
dentario_storage_set('widgets_args', array(			// Arguments to register widgets
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget_title">',
		'after_title'   => '</h5>',
	)
);

/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'dentario_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'dentario_loader_theme_setup', 20 );
	function dentario_loader_theme_setup() {

		dentario_profiler_add_point(esc_html__('After load theme required files', 'dentario'));

		// Before init theme
		do_action('dentario_action_before_init_theme');

		// Load current values for main theme options
		dentario_load_main_options();

		// Theme core init - only for admin side. In frontend it called from header.php
		if ( is_admin() ) {
			dentario_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */
// Manual load important libraries before load all rest files
// core.strings must be first - we use dentario_str...() in the dentario_get_file_dir()
require_once trailingslashit(get_template_directory()) .'fw/core/core.strings.php';
// core.files must be first - we use dentario_get_file_dir() to include all rest parts
require_once trailingslashit(get_template_directory()) .'fw/core/core.files.php';

// Include debug and profiler
require_once trailingslashit(get_template_directory()) .'fw/core/core.debug.php';

// Include custom theme files
dentario_autoload_folder( 'includes' );

// Include core files
dentario_autoload_folder( 'core' );

// Include theme-specific plugins and post types
dentario_autoload_folder( 'plugins' );

// Include theme templates
dentario_autoload_folder( 'templates' );

// Include theme widgets
dentario_autoload_folder( 'widgets' );
?>