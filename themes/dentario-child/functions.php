<?php
/**
 * Child-Theme functions and definitions
 */

// wp_dequeue_style( 'dentario-custom-style-inline-css');

function _remove_script_version( $src ){
$parts = explode( '?ver', $src );
return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

?>
