<?php

/**
 * Plugin Name: Modal Popup Box New
 * Plugin URI:  https://awplife.com/wordpress-plugins/modal-popup-box-premium/
 * Description: Create customizable modal popup boxes with CSS animations. Embed images, videos, forms, shortcodes, and more.
 * Version:     2.1.0
 * Author:      A WP Life
 * Author URI:  https://awplife.com/
 * License:     GPLv2 or later
 * Text Domain: modal-popup-box
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 *
 * @package ModalPopupBox
 */

if (!defined('ABSPATH')) {
	exit;
}

// Prevent duplicate loading.
if (defined('MPB_PLUGIN_VER')) {
	return;
}

// ── Plugin Constants ────────────────────────────────
define('MPB_PLUGIN_VER', '2.1.0');
define('MPB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MPB_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MPB_PLUGIN_SLUG', 'modalpopupbox');

// ── Backward Compatibility ──────────────────────────
// Keep MPB_TXTDM for any legacy code referencing it.
if (!defined('MPB_TXTDM')) {
	define('MPB_TXTDM', 'modal-popup-box');
}
if (!defined('MPB_PLUGIN_NAME')) {
	define('MPB_PLUGIN_NAME', 'Modal Popup Box');
}

// ── Legacy Function Stubs ───────────────────────────
// Keep the old function name available so existing themes/snippets don't break.
if (!function_exists('mpb_get_safe_settings')) {
	/**
	 * Legacy wrapper for MPB_Data::get_raw_settings().
	 *
	 * @param int $post_id Post ID.
	 * @return array Settings array.
	 */
	function mpb_get_safe_settings($post_id)
	{
		if (class_exists('MPB_Data')) {
			return MPB_Data::get_raw_settings($post_id);
		}
		return array();
	}
}

if (!function_exists('mpb_safe_parse_serialized')) {
	/**
	 * Legacy stub — parsing is now handled internally by MPB_Data.
	 *
	 * @param string $serialized Serialized string.
	 * @return array Empty array (use MPB_Data methods instead).
	 */
	function mpb_safe_parse_serialized($serialized)
	{
		return array();
	}
}

// ── Boot Plugin ─────────────────────────────────────
require_once MPB_PLUGIN_DIR . 'includes/class-mpb-plugin.php';
MPB_Plugin::get_instance();
