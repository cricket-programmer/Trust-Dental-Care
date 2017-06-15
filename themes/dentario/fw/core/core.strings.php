<?php
/**
 * Dentario Framework: strings manipulations
 *
 * @package	dentario
 * @since	dentario 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'DENTARIO_MULTIBYTE' ) ) define( 'DENTARIO_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('dentario_strlen')) {
	function dentario_strlen($text) {
		return DENTARIO_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('dentario_strpos')) {
	function dentario_strpos($text, $char, $from=0) {
		return DENTARIO_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('dentario_strrpos')) {
	function dentario_strrpos($text, $char, $from=0) {
		return DENTARIO_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('dentario_substr')) {
	function dentario_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = dentario_strlen($text)-$from;
		}
		return DENTARIO_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('dentario_strtolower')) {
	function dentario_strtolower($text) {
		return DENTARIO_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('dentario_strtoupper')) {
	function dentario_strtoupper($text) {
		return DENTARIO_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('dentario_strtoproper')) {
	function dentario_strtoproper($text) { 
		$rez = ''; $last = ' ';
		for ($i=0; $i<dentario_strlen($text); $i++) {
			$ch = dentario_substr($text, $i, 1);
			$rez .= dentario_strpos(' .,:;?!()[]{}+=', $last)!==false ? dentario_strtoupper($ch) : dentario_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('dentario_strrepeat')) {
	function dentario_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('dentario_strshort')) {
	function dentario_strshort($str, $maxlength, $add='...') {
	//	if ($add && dentario_substr($add, 0, 1) != ' ')
	//		$add .= ' ';
		if ($maxlength < 0) 
			return $str;
		if ($maxlength == 0) 
			return '';
		if ($maxlength >= dentario_strlen($str)) 
			return strip_tags($str);
		$str = dentario_substr(strip_tags($str), 0, $maxlength - dentario_strlen($add));
		$ch = dentario_substr($str, $maxlength - dentario_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = dentario_strlen($str) - 1; $i > 0; $i--)
				if (dentario_substr($str, $i, 1) == ' ') break;
			$str = trim(dentario_substr($str, 0, $i));
		}
		if (!empty($str) && dentario_strpos(',.:;-', dentario_substr($str, -1))!==false) $str = dentario_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('dentario_strclear')) {
	function dentario_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (dentario_substr($text, 0, dentario_strlen($open))==$open) {
					$pos = dentario_strpos($text, '>');
					if ($pos!==false) $text = dentario_substr($text, $pos+1);
				}
				if (dentario_substr($text, -dentario_strlen($close))==$close) $text = dentario_substr($text, 0, dentario_strlen($text) - dentario_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('dentario_get_slug')) {
	function dentario_get_slug($title) {
		return dentario_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('dentario_strmacros')) {
	function dentario_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('dentario_unserialize')) {
	function dentario_unserialize($str) {
		if ( is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = @unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			//if ($data===false) $data = @unserialize(str_replace(array("\n", "\r"), array('\\n','\\r'), $str));
			return $data;
		} else
			return $str;
	}
}
?>