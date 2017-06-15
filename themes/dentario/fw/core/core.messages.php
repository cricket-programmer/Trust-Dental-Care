<?php
/**
 * Dentario Framework: messages subsystem
 *
 * @package	dentario
 * @since	dentario 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('dentario_messages_theme_setup')) {
	add_action( 'dentario_action_before_init_theme', 'dentario_messages_theme_setup' );
	function dentario_messages_theme_setup() {
		// Core messages strings
		add_action('dentario_action_add_scripts_inline', 'dentario_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('dentario_get_error_msg')) {
	function dentario_get_error_msg() {
		return dentario_storage_get('error_msg');
	}
}

if (!function_exists('dentario_set_error_msg')) {
	function dentario_set_error_msg($msg) {
		$msg2 = dentario_get_error_msg();
		dentario_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('dentario_get_success_msg')) {
	function dentario_get_success_msg() {
		return dentario_storage_get('success_msg');
	}
}

if (!function_exists('dentario_set_success_msg')) {
	function dentario_set_success_msg($msg) {
		$msg2 = dentario_get_success_msg();
		dentario_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('dentario_get_notice_msg')) {
	function dentario_get_notice_msg() {
		return dentario_storage_get('notice_msg');
	}
}

if (!function_exists('dentario_set_notice_msg')) {
	function dentario_set_notice_msg($msg) {
		$msg2 = dentario_get_notice_msg();
		dentario_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('dentario_set_system_message')) {
	function dentario_set_system_message($msg, $status='info', $hdr='') {
		update_option('dentario_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('dentario_get_system_message')) {
	function dentario_get_system_message($del=false) {
		$msg = get_option('dentario_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			dentario_del_system_message();
		return $msg;
	}
}

if (!function_exists('dentario_del_system_message')) {
	function dentario_del_system_message() {
		delete_option('dentario_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('dentario_messages_add_scripts_inline')) {
	function dentario_messages_add_scripts_inline() {
		echo '<script type="text/javascript">'
			
			. "if (typeof DENTARIO_STORAGE == 'undefined') var DENTARIO_STORAGE = {};"
			
			// Strings for translation
			. 'DENTARIO_STORAGE["strings"] = {'
				. 'ajax_error: 			"' . addslashes(esc_html__('Invalid server answer', 'dentario')) . '",'
				. 'bookmark_add: 		"' . addslashes(esc_html__('Add the bookmark', 'dentario')) . '",'
				. 'bookmark_added:		"' . addslashes(esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'dentario')) . '",'
				. 'bookmark_del: 		"' . addslashes(esc_html__('Delete this bookmark', 'dentario')) . '",'
				. 'bookmark_title:		"' . addslashes(esc_html__('Enter bookmark title', 'dentario')) . '",'
				. 'bookmark_exists:		"' . addslashes(esc_html__('Current page already exists in the bookmarks list', 'dentario')) . '",'
				. 'search_error:		"' . addslashes(esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'dentario')) . '",'
				. 'email_confirm:		"' . addslashes(esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'dentario')) . '",'
				. 'reviews_vote:		"' . addslashes(esc_html__('Thanks for your vote! New average rating is:', 'dentario')) . '",'
				. 'reviews_error:		"' . addslashes(esc_html__('Error saving your vote! Please, try again later.', 'dentario')) . '",'
				. 'error_like:			"' . addslashes(esc_html__('Error saving your like! Please, try again later.', 'dentario')) . '",'
				. 'error_global:		"' . addslashes(esc_html__('Global error text', 'dentario')) . '",'
				. 'name_empty:			"' . addslashes(esc_html__('The name can\'t be empty', 'dentario')) . '",'
				. 'name_long:			"' . addslashes(esc_html__('Too long name', 'dentario')) . '",'
				. 'email_empty:			"' . addslashes(esc_html__('Too short (or empty) email address', 'dentario')) . '",'
				. 'email_long:			"' . addslashes(esc_html__('Too long email address', 'dentario')) . '",'
				. 'email_not_valid:		"' . addslashes(esc_html__('Invalid email address', 'dentario')) . '",'
				. 'subject_empty:		"' . addslashes(esc_html__('The subject can\'t be empty', 'dentario')) . '",'
				. 'subject_long:		"' . addslashes(esc_html__('Too long subject', 'dentario')) . '",'
				. 'text_empty:			"' . addslashes(esc_html__('The message text can\'t be empty', 'dentario')) . '",'
				. 'text_long:			"' . addslashes(esc_html__('Too long message text', 'dentario')) . '",'
				. 'send_complete:		"' . addslashes(esc_html__("Send message complete!", 'dentario')) . '",'
				. 'send_error:			"' . addslashes(esc_html__('Transmit failed!', 'dentario')) . '",'
				. 'login_empty:			"' . addslashes(esc_html__('The Login field can\'t be empty', 'dentario')) . '",'
				. 'login_long:			"' . addslashes(esc_html__('Too long login field', 'dentario')) . '",'
				. 'login_success:		"' . addslashes(esc_html__('Login success! The page will be reloaded in 3 sec.', 'dentario')) . '",'
				. 'login_failed:		"' . addslashes(esc_html__('Login failed!', 'dentario')) . '",'
				. 'password_empty:		"' . addslashes(esc_html__('The password can\'t be empty and shorter then 4 characters', 'dentario')) . '",'
				. 'password_long:		"' . addslashes(esc_html__('Too long password', 'dentario')) . '",'
				. 'password_not_equal:	"' . addslashes(esc_html__('The passwords in both fields are not equal', 'dentario')) . '",'
				. 'registration_success:"' . addslashes(esc_html__('Registration success! Please log in!', 'dentario')) . '",'
				. 'registration_failed:	"' . addslashes(esc_html__('Registration failed!', 'dentario')) . '",'
				. 'geocode_error:		"' . addslashes(esc_html__('Geocode was not successful for the following reason:', 'dentario')) . '",'
				. 'googlemap_not_avail:	"' . addslashes(esc_html__('Google map API not available!', 'dentario')) . '",'
				. 'editor_save_success:	"' . addslashes(esc_html__("Post content saved!", 'dentario')) . '",'
				. 'editor_save_error:	"' . addslashes(esc_html__("Error saving post data!", 'dentario')) . '",'
				. 'editor_delete_post:	"' . addslashes(esc_html__("You really want to delete the current post?", 'dentario')) . '",'
				. 'editor_delete_post_header:"' . addslashes(esc_html__("Delete post", 'dentario')) . '",'
				. 'editor_delete_success:	"' . addslashes(esc_html__("Post deleted!", 'dentario')) . '",'
				. 'editor_delete_error:		"' . addslashes(esc_html__("Error deleting post!", 'dentario')) . '",'
				. 'editor_caption_cancel:	"' . addslashes(esc_html__('Cancel', 'dentario')) . '",'
				. 'editor_caption_close:	"' . addslashes(esc_html__('Close', 'dentario')) . '"'
				. '};'
			
			. '</script>';
	}
}
?>