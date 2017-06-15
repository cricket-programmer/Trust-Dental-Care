<?php
/**
 * Dentario Framework: theme variables storage
 *
 * @package	dentario
 * @since	dentario 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('dentario_storage_get')) {
	function dentario_storage_get($var_name, $default='') {
		global $DENTARIO_STORAGE;
		return isset($DENTARIO_STORAGE[$var_name]) ? $DENTARIO_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('dentario_storage_set')) {
	function dentario_storage_set($var_name, $value) {
		global $DENTARIO_STORAGE;
		$DENTARIO_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('dentario_storage_empty')) {
	function dentario_storage_empty($var_name, $key='', $key2='') {
		global $DENTARIO_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($DENTARIO_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($DENTARIO_STORAGE[$var_name][$key]);
		else
			return empty($DENTARIO_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('dentario_storage_isset')) {
	function dentario_storage_isset($var_name, $key='', $key2='') {
		global $DENTARIO_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($DENTARIO_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($DENTARIO_STORAGE[$var_name][$key]);
		else
			return isset($DENTARIO_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('dentario_storage_inc')) {
	function dentario_storage_inc($var_name, $value=1) {
		global $DENTARIO_STORAGE;
		if (empty($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = 0;
		$DENTARIO_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('dentario_storage_concat')) {
	function dentario_storage_concat($var_name, $value) {
		global $DENTARIO_STORAGE;
		if (empty($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = '';
		$DENTARIO_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('dentario_storage_get_array')) {
	function dentario_storage_get_array($var_name, $key, $key2='', $default='') {
		global $DENTARIO_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($DENTARIO_STORAGE[$var_name][$key]) ? $DENTARIO_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($DENTARIO_STORAGE[$var_name][$key][$key2]) ? $DENTARIO_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('dentario_storage_set_array')) {
	function dentario_storage_set_array($var_name, $key, $value) {
		global $DENTARIO_STORAGE;
		if (!isset($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = array();
		if ($key==='')
			$DENTARIO_STORAGE[$var_name][] = $value;
		else
			$DENTARIO_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('dentario_storage_set_array2')) {
	function dentario_storage_set_array2($var_name, $key, $key2, $value) {
		global $DENTARIO_STORAGE;
		if (!isset($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = array();
		if (!isset($DENTARIO_STORAGE[$var_name][$key])) $DENTARIO_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$DENTARIO_STORAGE[$var_name][$key][] = $value;
		else
			$DENTARIO_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('dentario_storage_set_array_after')) {
	function dentario_storage_set_array_after($var_name, $after, $key, $value='') {
		global $DENTARIO_STORAGE;
		if (!isset($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = array();
		if (is_array($key))
			dentario_array_insert_after($DENTARIO_STORAGE[$var_name], $after, $key);
		else
			dentario_array_insert_after($DENTARIO_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('dentario_storage_set_array_before')) {
	function dentario_storage_set_array_before($var_name, $before, $key, $value='') {
		global $DENTARIO_STORAGE;
		if (!isset($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = array();
		if (is_array($key))
			dentario_array_insert_before($DENTARIO_STORAGE[$var_name], $before, $key);
		else
			dentario_array_insert_before($DENTARIO_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('dentario_storage_push_array')) {
	function dentario_storage_push_array($var_name, $key, $value) {
		global $DENTARIO_STORAGE;
		if (!isset($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($DENTARIO_STORAGE[$var_name], $value);
		else {
			if (!isset($DENTARIO_STORAGE[$var_name][$key])) $DENTARIO_STORAGE[$var_name][$key] = array();
			array_push($DENTARIO_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('dentario_storage_pop_array')) {
	function dentario_storage_pop_array($var_name, $key='', $defa='') {
		global $DENTARIO_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($DENTARIO_STORAGE[$var_name]) && is_array($DENTARIO_STORAGE[$var_name]) && count($DENTARIO_STORAGE[$var_name]) > 0) 
				$rez = array_pop($DENTARIO_STORAGE[$var_name]);
		} else {
			if (isset($DENTARIO_STORAGE[$var_name][$key]) && is_array($DENTARIO_STORAGE[$var_name][$key]) && count($DENTARIO_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($DENTARIO_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('dentario_storage_inc_array')) {
	function dentario_storage_inc_array($var_name, $key, $value=1) {
		global $DENTARIO_STORAGE;
		if (!isset($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = array();
		if (empty($DENTARIO_STORAGE[$var_name][$key])) $DENTARIO_STORAGE[$var_name][$key] = 0;
		$DENTARIO_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('dentario_storage_concat_array')) {
	function dentario_storage_concat_array($var_name, $key, $value) {
		global $DENTARIO_STORAGE;
		if (!isset($DENTARIO_STORAGE[$var_name])) $DENTARIO_STORAGE[$var_name] = array();
		if (empty($DENTARIO_STORAGE[$var_name][$key])) $DENTARIO_STORAGE[$var_name][$key] = '';
		$DENTARIO_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('dentario_storage_call_obj_method')) {
	function dentario_storage_call_obj_method($var_name, $method, $param=null) {
		global $DENTARIO_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($DENTARIO_STORAGE[$var_name]) ? $DENTARIO_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($DENTARIO_STORAGE[$var_name]) ? $DENTARIO_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('dentario_storage_get_obj_property')) {
	function dentario_storage_get_obj_property($var_name, $prop, $default='') {
		global $DENTARIO_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($DENTARIO_STORAGE[$var_name]->$prop) ? $DENTARIO_STORAGE[$var_name]->$prop : $default;
	}
}
?>