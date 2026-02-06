<?php
/**
Plugin Name: Modal Popup Box
Plugin URI: https://awplife.com/wordpress-plugins/modal-popup-box-premium/
Description: A set of experimental modal window appearance effects with CSS transitions and animations.An Easy And Powerful modal popup box plugin for WordPress.
Version: 1.6.2
Author: A WP Life
Author URI: https://awplife.com/
License: GPLv2 or later
Text Domain: modal-popup-box
Domain Path: /languages

Modal Popup Box is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Modal Popup Box is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Modal Popup Box. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.
 */

if ( ! class_exists( 'Modal_Popup_Box' ) ) {

	class Modal_Popup_Box {

		protected $protected_plugin_api;
		protected $ajax_plugin_nonce;

		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}

		protected function _constants() {
			// Plugin Version
			define( 'MPB_PLUGIN_VER', '1.6.2' );

			// Plugin Text Domain
			define( 'MPB_TXTDM', 'modal-popup-box' );

			// Plugin Name
			define( 'MPB_PLUGIN_NAME', 'Modal Popup Box' );

			// Plugin Slug
			define( 'MPB_PLUGIN_SLUG', 'modalpopupbox' );

			// Plugin Directory Path
			define( 'MPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			// Plugin Directory URL
			define( 'MPB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			/**
			 * Create a key for the .htaccess secure download link.
			 *
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'MPB_SECURE_KEY', md5( NONCE_KEY ) );

		} // end of constructor function

		protected function _hooks() {
			// Load text domain
			add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );

			// add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, '_srgallery_menu' ), 101 );

			// Create Image Gallery Custom Post
			add_action( 'init', array( $this, 'codex_modalpopupbox_init' ) );

			// Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, '_admin_add_meta_box' ) );

			// loaded during admin init
			add_action( 'admin_init', array( $this, '_admin_add_meta_box' ) );

			// save setting
			add_action( 'save_post', array( &$this, '_mpb_save_settings' ) );

			// Shortcode Compatibility in Text Widgets
			add_filter( 'widget_text', 'do_shortcode' );

			// add mpbox cpt shortcode column - manage_{$post_type}_posts_columns
			add_filter( 'manage_modalpopupbox_posts_columns', array( &$this, 'set_modalpopupbox_shortcode_column_name' ) );

			// add mpbox cpt shortcode column data - manage_{$post_type}_posts_custom_column
			add_action( 'manage_modalpopupbox_posts_custom_column', array( &$this, 'custom_modalpopupbox_shodrcode_data' ), 10, 2 );

			add_action( 'wp_enqueue_scripts', array( &$this, 'modal_enqueue_scripts_in_header' ) );
		} // end of hook function

		public function modal_enqueue_scripts_in_header() {
			wp_enqueue_script( 'jquery' );
		}

		// Modal Box cpt shortcode column before date columns
		public function set_modalpopupbox_shortcode_column_name( $defaults ) {
			$new       = array();
			unset( $defaults['tags'] );   // remove it from the columns list

			foreach ( $defaults as $key => $value ) {
				if ( $key == 'date' ) {  // when we find the date column
					$new['modalpopupbox_shortcode'] = __( 'Shortcode', 'modal-popup-box' );  // put the tags column before it
				}
				$new[ $key ] = $value;
			}
			return $new;
		}

		// Modal Box cpt shortcode column data
		public function custom_modalpopupbox_shodrcode_data( $column, $post_id ) {
			switch ( $column ) {
				case 'modalpopupbox_shortcode':
					echo "<input type='text' class='button button-primary' id='modalpopupbox-shortcode-" . esc_attr( $post_id ) . "' value='[MPBOX id=" . esc_attr( $post_id ) . "]' style='font-weight:bold; background-color:#32373C; color:#FFFFFF; text-align:center;' />";
					echo "<input type='button' class='button button-primary' onclick='return MODALCopyShortcode" . esc_attr( $post_id ) . "();' readonly value='Copy' style='margin-left:4px;' />";
					echo "<span id='copy-msg-" . esc_attr( $post_id ) . "' class='button button-primary' style='display:none; background-color:#32CD32; color:#FFFFFF; margin-left:4px; border-radius: 4px;'>copied</span>";
					echo '<script>
						function MODALCopyShortcode' . esc_attr( $post_id ) . "() {
							var copyText = document.getElementById('modalpopupbox-shortcode-" . esc_attr( $post_id ) . "');
							copyText.select();
							document.execCommand('copy');
							
							//fade in and out copied message
							jQuery('#copy-msg-" . esc_attr( $post_id ) . "').fadeIn('1000', 'linear');
							jQuery('#copy-msg-" . esc_attr( $post_id ) . "').fadeOut(2500,'swing');
						}
						</script>
					";
					break;
			}
		}

		public function _load_textdomain() {
			load_plugin_textdomain( 'modal-popup-box', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		public function _srgallery_menu() {
			$featured_plugin_menu = add_submenu_page( 'edit.php?post_type=' . MPB_PLUGIN_SLUG, __( 'Featured-Plugin', 'modal-popup-box' ), __( 'Featured Plugin', 'modal-popup-box' ), 'administrator', 'sr-featured-plugin-page', array( $this, '_featured_plugin_page' ) );
			$theme_menu           = add_submenu_page( 'edit.php?post_type=' . MPB_PLUGIN_SLUG, __( 'Our Theme', 'modal-popup-box' ), __( 'Our Theme', 'modal-popup-box' ), 'administrator', 'sr-theme-page', array( $this, '_theme_page' ) );
		}

		// Modal Popup Box Custom Post Type
		function codex_modalpopupbox_init() {
			$labels = array(
				'name'               => __( 'Modal Popup Box', 'modal-popup-box' ),
				'singular_name'      => __( 'Modal Popup Box', 'modal-popup-box' ),
				'menu_name'          => __( 'Modal Popup Box', 'modal-popup-box' ),
				'name_admin_bar'     => __( 'Modal Popup Box', 'modal-popup-box' ),
				'add_new'            => __( 'Add New', 'modal-popup-box' ),
				'add_new_item'       => __( 'Add New Modal Popup Box', 'modal-popup-box' ),
				'new_item'           => __( 'New Modal Popup Box', 'modal-popup-box' ),
				'edit_item'          => __( 'Edit Modal Popup Box', 'modal-popup-box' ),
				'view_item'          => __( 'View Modal Popup Box', 'modal-popup-box' ),
				'all_items'          => __( 'All Modal Popup Box', 'modal-popup-box' ),
				'search_items'       => __( 'Search Modal Popup Box', 'modal-popup-box' ),
				'parent_item_colon'  => __( 'Parent Modal Popup Box', 'modal-popup-box' ),
				'not_found'          => __( 'No Modal Popup Box found', 'modal-popup-box' ),
				'not_found_in_trash' => __( 'No Modal Popup Box found in Trash', 'modal-popup-box' ),
			);

			$args = array(
				'labels'             => $labels,
				'description'        => __( 'Description', 'modal-popup-box' ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'modalpopupbox' ),
				'capability_type'    => 'page',
				'menu_icon'          => 'dashicons-archive',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title', 'editor' ),
			);

			register_post_type( 'modalpopupbox', $args );
		}

		public function _admin_add_meta_box() {
			add_meta_box( '1', __( 'Copy Modal Popup Shortcode', 'modal-popup-box' ), array( &$this, '_mpb_shortcode_left_metabox' ), 'modalpopupbox', 'side', 'default' );
			add_meta_box( __( 'Modal Box Settings', 'modal-popup-box' ), __( 'Modal Box Settings', 'modal-popup-box' ), array( &$this, 'mpb_metabox_function' ), 'modalpopupbox', 'normal', 'default' );
			add_meta_box( __( 'Rate Our Plugin', 'modal-popup-box' ), __( 'Rate Our Plugin', 'modal-popup-box' ), array( &$this, 'mpb_rate_plugin' ), 'modalpopupbox', 'side', 'default' );
		}
		// image gallery copy shortcode meta box under publish button
		public function _mpb_shortcode_left_metabox( $post ) { ?>
			<p class="input-text-wrap">
				<input type="text" name="MODALCopyShortcode" id="MODALCopyShortcode" value="<?php echo '[MPBOX id=' . esc_attr( $post->ID ) . ']'; ?>" readonly style="height: 50px; text-align: center; width:100%;  font-size: 24px; border: 2px dashed;">
				<p id="mpb-copy-code"><?php esc_html_e( 'Shortcode copied to clipboard!', 'modal-popup-box' ); ?></p>
				<p style="margin-top: 10px"><?php esc_html_e( 'Copy & Embed shotcode into any Page/ Post / Text Widget to display gallery.', 'modal-popup-box' ); ?></p>
			</p>
			<span onclick="copyToClipboard('#MODALCopyShortcode')" class="mpb-copy dashicons dashicons-clipboard"></span>
			<style>
				.mpb-copy {
					position: absolute;
					top: 9px;
					right: 24px;
					font-size: 26px;
					cursor: pointer;
				}
				.ui-sortable-handle > span {
					font-size: 16px !important;
				}
			</style>
			<script>
			jQuery( "#mpb-copy-code" ).hide();
			function copyToClipboard(element) {
				var $temp = jQuery("<input>");
				jQuery("body").append($temp);
				$temp.val(jQuery(element).val()).select();
				document.execCommand("copy");
				$temp.remove();
				jQuery( "#MODALCopyShortcode" ).select();
				jQuery( "#mpb-copy-code" ).fadeIn();
			}
			</script>
			<?php
		}

		// meta rate us
		public function mpb_rate_plugin() {
			?>
			<div style="text-align:center">
				<p><?php esc_html_e( 'If you like our plugin then please', 'modal-popup-box' ); ?> <b><?php esc_html_e( 'Rate us', 'modal-popup-box' ); ?></b><?php esc_html_e( 'on WordPress', 'modal-popup-box' ); ?> </p>
			</div>
			<div style="text-align:center">
				<span class="dashicons dashicons-star-filled"></span>
				<span class="dashicons dashicons-star-filled"></span>
				<span class="dashicons dashicons-star-filled"></span>
				<span class="dashicons dashicons-star-filled"></span>
				<span class="dashicons dashicons-star-filled"></span>
			</div>
			<br>
			<div style="text-align:center">
				<a href="https://wordpress.org/support/plugin/modal-popup-box/reviews/?filter=5" target="_new" class="button button-primary button-large" style="background: #008EC2; text-shadow: none;"><span class="dashicons dashicons-heart" style="line-height:1.4;" ></span><?php esc_html_e( 'Please Rate Us', 'modal-popup-box' ); ?></a>
			</div>
			<?php
		}

		public function mpb_metabox_function( $post ) {
			wp_enqueue_style( 'mbp-metabox-css', MPB_PLUGIN_URL . 'assets/css/metabox.css' );
			require_once 'include/modal-popup-box-settings.php';
		} // end of upload multiple image

		public function _mpb_save_settings( $post_id ) {
			// Check if user can edit this specific post (allows editors, not just admins)
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			
			if ( isset( $_POST['mpb_save_nonce'] ) && wp_verify_nonce( $_POST['mpb_save_nonce'], 'mpb_save_settings' ) ) {

				$mpb_show_modal                	= isset( $_POST['mpb_show_modal'] ) ? sanitize_text_field( $_POST['mpb_show_modal'] ) : 'onclick';
				$mpb_main_button_text          	= isset( $_POST['mpb_main_button_text'] ) ? sanitize_text_field( $_POST['mpb_main_button_text'] ) : 'Click Me';
				$mpb_main_button_size          	= isset( $_POST['mpb_main_button_size'] ) ? sanitize_text_field( $_POST['mpb_main_button_size'] ) : 'btn btn-lg';
				$mpb_main_button_color         	= isset( $_POST['mpb_main_button_color'] ) ? sanitize_text_field( $_POST['mpb_main_button_color'] ) : '#008EC2';
				$mpb_main_button_text_color    	= isset( $_POST['mpb_main_button_text_color'] ) ? sanitize_text_field( $_POST['mpb_main_button_text_color'] ) : '#ffffff';
				$modal_popup_design            	= isset( $_POST['modal_popup_design'] ) ? sanitize_text_field( $_POST['modal_popup_design'] ) : 'color_1';
				$mpb_animation_effect_open_btn 	= isset( $_POST['mpb_animation_effect_open_btn'] ) ? sanitize_text_field( $_POST['mpb_animation_effect_open_btn'] ) : 'md-effect-1';
				$mpb_button2_text             	= isset( $_POST['mpb_button2_text'] ) ? sanitize_text_field( $_POST['mpb_button2_text'] ) : 'Close Me';
				$mpb_width                    	= isset( $_POST['mpb_width'] ) ? sanitize_text_field( $_POST['mpb_width'] ) : '35';
				$mpb_height                   	= isset( $_POST['mpb_height'] ) ? sanitize_text_field( $_POST['mpb_height'] ) : '350';
				$mpb_bt_ds						= isset( $_POST['mpb_bt_ds'] ) ? sanitize_text_field( $_POST['mpb_bt_ds'] ) : 'true';
				$mpb_custom_css               	= isset( $_POST['mpb_custom_css'] ) ? sanitize_text_field( $_POST['mpb_custom_css'] ) : '';

				$modal_popup_box_settings = array(
					'mpb_show_modal'                => $mpb_show_modal,
					'mpb_main_button_text'          => $mpb_main_button_text,
					'mpb_main_button_size'          => $mpb_main_button_size,
					'mpb_main_button_color'         => $mpb_main_button_color,
					'mpb_main_button_text_color'    => $mpb_main_button_text_color,
					'modal_popup_design'            => $modal_popup_design,
					'mpb_animation_effect_open_btn' => $mpb_animation_effect_open_btn,
					'mpb_button2_text'              => $mpb_button2_text,
					'mpb_width'                     => $mpb_width,
					'mpb_height'                    => $mpb_height,
					'mpb_bt_ds'                  	=> $mpb_bt_ds,
					'mpb_custom_css'                => $mpb_custom_css,
				);

				$awl_modal_popup_box_shortcode_setting = 'awl_mpb_settings_' . $post_id;
				update_post_meta($post_id, $awl_modal_popup_box_shortcode_setting, json_encode($modal_popup_box_settings));
			}
		}//end _mpb_save_settings()

		public function _featured_plugin_page() {
			require_once 'featured-plugins/featured-plugins.php';
		}

		// theme page
		public function _theme_page() {
			require_once 'our-theme/awp-theme.php';
		}
	} // end of class

	/**
	 * Safely parse modal popup box settings.
	 * Handles both JSON and legacy serialized formats without using unserialize().
	 * 
	 * @param int $post_id The post ID
	 * @return array Settings array
	 */
	function mpb_get_safe_settings($post_id) {
		$post_id = intval($post_id);
		$meta_key = 'awl_mpb_settings_' . $post_id;
		$raw_data = get_post_meta($post_id, $meta_key, true);
		
		if (empty($raw_data)) {
			return array();
		}
		
		// First, try to decode as JSON (current format)
		$settings = json_decode($raw_data, true);
		if (is_array($settings)) {
			return $settings;
		}
		
		// Check if it's base64 encoded (legacy format)
		$decoded = base64_decode($raw_data, true);
		if ($decoded !== false) {
			// Try JSON decode on decoded data
			$settings = json_decode($decoded, true);
			if (is_array($settings)) {
				// Migrate to new format
				update_post_meta($post_id, $meta_key, json_encode($settings));
				return $settings;
			}
			
			// Legacy serialized format - parse safely with regex (no unserialize!)
			if (strpos($decoded, 'a:') === 0) {
				$settings = mpb_safe_parse_serialized($decoded);
				if (!empty($settings)) {
					// Migrate to JSON format
					update_post_meta($post_id, $meta_key, json_encode($settings));
					return $settings;
				}
			}
		}
		
		return array();
	}

	/**
	 * Safely parse a PHP serialized array string without using unserialize().
	 * Only extracts string and integer values, ignoring any object definitions.
	 * This prevents PHP Object Injection attacks.
	 * 
	 * @param string $serialized The serialized string
	 * @return array Extracted key-value pairs
	 */
	function mpb_safe_parse_serialized($serialized) {
		$result = array();
		
		// Only process if it looks like a serialized array
		if (strpos($serialized, 'a:') !== 0) {
			return $result;
		}
		
		// Extract string key-value pairs: s:N:"key";s:N:"value";
		$pattern = '/s:\d+:"([^"]+)";s:\d+:"([^"]*)";/';
		if (preg_match_all($pattern, $serialized, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$result[sanitize_text_field($match[1])] = sanitize_text_field($match[2]);
			}
		}
		
		// Extract string key with integer value: s:N:"key";i:N;
		$pattern_int = '/s:\d+:"([^"]+)";i:(\d+);/';
		if (preg_match_all($pattern_int, $serialized, $matches, PREG_SET_ORDER)) {
			foreach ($matches as $match) {
				$result[sanitize_text_field($match[1])] = intval($match[2]);
			}
		}
		
		return $result;
	}

	// register sf scripts
	function awplife_mpb_register_scripts() {

		// css & JS
		wp_register_script( 'mbp-modernizr-custom-js', plugin_dir_url( __FILE__ ) . 'assets/js/modal/modernizr.custom.js' );
		wp_register_script( 'mbp-classie-js', plugin_dir_url( __FILE__ ) . 'assets/js/modal/classie.js' );
		wp_register_script( 'mbp-cssParser-js', plugin_dir_url( __FILE__ ) . 'assets/js/modal/cssParser.js' );
		wp_register_style( 'mbp-fronted-bootstrap-css', plugin_dir_url( __FILE__ ) . 'assets/css/fronted-bootstrap.css' );
		wp_register_style( 'mbp-animate-css', plugin_dir_url( __FILE__ ) . 'assets/css/animate.css' );
		wp_register_style( 'mbp-modal-box-css', plugin_dir_url( __FILE__ ) . 'assets/css/modal-box.css' );
		wp_register_style( 'mbp-component-css', plugin_dir_url( __FILE__ ) . 'assets/css/component-update.css' );
		// css & JS
	}
		add_action( 'wp_enqueue_scripts', 'awplife_mpb_register_scripts' );

	// Plugin Recommend
		add_action( 'tgmpa_register', 'MPB_TXTDM_plugin_recommend' );
	function MPB_TXTDM_plugin_recommend() {
		$plugins = array(
			array(
				'name'     => 'Pricing Table',
				'slug'     => 'abc-pricing-table',
				'required' => false,
			),
			array(
				'name'     => 'Social Media Icons',
				'slug'     => 'new-social-media-widget',
				'required' => false,
			),
			array(
				'name'     => 'Team Builder Member Showcase',
				'slug'     => 'team-builder-member-showcase',
				'required' => false,
			),
		);
		tgmpa( $plugins );
	}

	/**
	 * Instantiates the Class
	 *
	 * @since     3.0
	 * @global    object    $Modal_Popup_Box_object
	 */
	$mpbox_object = new Modal_Popup_Box();
	require_once 'include/modal-popup-box-shortcode.php';
	require_once 'class-tgm-plugin-activation.php';

} // end of class exists
?>
