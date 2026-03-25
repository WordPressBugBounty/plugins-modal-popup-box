<?php
/**
 * Modal Popup Box — Data Handler
 *
 * Handles settings retrieval, defaults, and legacy data migration.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Class MPB_Data
 *
 * Responsible for reading, parsing, and providing modal settings.
 * Supports JSON, Base64+JSON, and legacy Base64+Serialized formats.
 */
class MPB_Data
{

	/**
	 * Default settings for the Free version.
	 *
	 * @return array Associative array of default settings.
	 */
	public static function get_defaults()
	{
		return array(
			'mpb_show_modal' => 'onload',
			'mpb_main_button_text' => 'Click Me',
			'mpb_main_button_size' => 'btn btn-lg',
			'mpb_main_button_color' => '#008EC2',
			'mpb_main_button_text_color' => '#ffffff',
			'modal_popup_design' => 'color_1',
			'mpb_animation_effect_open_btn' => 'md-effect-1',
			'mpb_button2_text' => 'Close Me',
			'mpb_button2_size' => 'btn btn-default',
			'mpb_button2_color' => '#666666',
			'mpb_button2_text_color' => '#ffffff',
			'mpb_close_icon_color' => '#666666',
			'mpb_width' => '35',
			'mpb_height' => '350',
			'mpb_bt_ds' => 'true',
			'mpb_custom_css' => '',
			'mpb_open_delay' => '0',
			'mpb_overlay_opacity' => '60',
			'mpb_modal_bg_color' => '#008EC2',
			'mpb_overlay_color' => '#000000',
		);
	}

	/**
	 * Get settings for a given modal post ID.
	 *
	 * Merges stored settings with defaults so new keys always have values.
	 *
	 * @param int $post_id The modal post ID.
	 * @return array Complete settings array.
	 */
	public static function get_settings($post_id)
	{
		$post_id = absint($post_id);
		$defaults = self::get_defaults();
		$stored = self::get_raw_settings($post_id);

		return wp_parse_args($stored, $defaults);
	}

	/**
	 * Safely parse modal popup box settings from post meta.
	 *
	 * Handles JSON, Base64+JSON, and legacy Base64+Serialized formats.
	 * Auto-migrates legacy formats to JSON.
	 *
	 * @param int $post_id The post ID.
	 * @return array Settings array (may be empty).
	 */
	public static function get_raw_settings($post_id)
	{
		$post_id = absint($post_id);
		$meta_key = 'awl_mpb_settings_' . $post_id;
		$raw_data = get_post_meta($post_id, $meta_key, true);

		if (empty($raw_data)) {
			return array();
		}

		// Try JSON first (current format).
		$settings = json_decode($raw_data, true);
		if (is_array($settings)) {
			return $settings;
		}

		// Try Base64 decode (legacy format).
		$decoded = base64_decode($raw_data, true);
		if (false !== $decoded) {
			// Try JSON on decoded data.
			$settings = json_decode($decoded, true);
			if (is_array($settings)) {
				update_post_meta($post_id, $meta_key, wp_json_encode($settings));
				return $settings;
			}

			// Try legacy serialized format (safe regex parse, no unserialize).
			if (0 === strpos($decoded, 'a:')) {
				$settings = self::safe_parse_serialized($decoded);
				if (!empty($settings)) {
					update_post_meta($post_id, $meta_key, wp_json_encode($settings));
					return $settings;
				}
			}
		}

		return array();
	}

	/**
	 * Save settings for a modal post.
	 *
	 * @param int   $post_id  The post ID.
	 * @param array $settings Associative array of settings.
	 */
	public static function save_settings($post_id, $settings)
	{
		$post_id = absint($post_id);
		$meta_key = 'awl_mpb_settings_' . $post_id;
		update_post_meta($post_id, $meta_key, wp_json_encode($settings));
	}

	/**
	 * Safely parse a PHP serialized array string without using unserialize().
	 *
	 * Only extracts string and integer values using regex.
	 * Prevents PHP Object Injection attacks.
	 *
	 * @param string $serialized The serialized string.
	 * @return array Extracted key-value pairs.
	 */
	private static function safe_parse_serialized($serialized)
	{
		$result = array();

		if (0 !== strpos($serialized, 'a:')) {
			return $result;
		}

		// Extract string key => string value pairs.
		$pattern = '/s:\d+:"([^"]+)";s:\d+:"([^"]*)";/';
		if (preg_match_all($pattern, $serialized, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$result[sanitize_text_field($match[1])] = sanitize_text_field($match[2]);
			}
		}

		// Extract string key => integer value pairs.
		$pattern_int = '/s:\d+:"([^"]+)";i:(\d+);/';
		if (preg_match_all($pattern_int, $serialized, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$result[sanitize_text_field($match[1])] = intval($match[2]);
			}
		}

		return $result;
	}

	/**
	 * Sanitize and collect settings from POST data.
	 *
	 * @return array Sanitized settings array.
	 */
	public static function sanitize_post_data()
	{
		$fields = self::get_defaults();
		$settings = array();

		foreach ($fields as $field => $default) {
			if (isset($_POST[$field])) { // phpcs:ignore WordPress.Security.NonceVerification
				$val = wp_unslash($_POST[$field]); // phpcs:ignore WordPress.Security.NonceVerification

				if ($field === 'mpb_custom_css') {
					$settings[$field] = wp_strip_all_tags($val);
				} elseif (strpos($field, 'color') !== false || strpos($field, 'design') !== false) {
					// Use sanitize_hex_color for hex, or sanitize_text_field for presets.
					$settings[$field] = (0 === strpos($val, '#')) ? sanitize_hex_color($val) : sanitize_text_field($val);
				} elseif (is_numeric($default)) {
					$settings[$field] = absint($val);
				} else {
					$settings[$field] = sanitize_text_field($val);
				}
			}
		}

		return wp_parse_args($settings, self::get_defaults());
	}
}
