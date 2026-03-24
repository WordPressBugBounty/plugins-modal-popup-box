<?php
/**
 * Modal Popup Box — Admin
 *
 * Handles admin-side functionality: CPT registration, metaboxes, columns, save.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class MPB_Admin
 */
class MPB_Admin
{

    /**
     * Initialize admin hooks.
     */
    public function init()
    {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_settings'));
        add_filter('manage_modalpopupbox_posts_columns', array($this, 'add_shortcode_column'));
        add_action('manage_modalpopupbox_posts_custom_column', array($this, 'render_shortcode_column'), 10, 2);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Register the Modal Popup Box custom post type.
     */
    public function register_post_type()
    {
        $labels = array(
            'name' => __('Modal Popup Box', 'modal-popup-box'),
            'singular_name' => __('Modal Popup Box', 'modal-popup-box'),
            'menu_name' => __('Modal Popup Box', 'modal-popup-box'),
            'name_admin_bar' => __('Modal Popup Box', 'modal-popup-box'),
            'add_new' => __('Add New', 'modal-popup-box'),
            'add_new_item' => __('Add New Modal Popup Box', 'modal-popup-box'),
            'new_item' => __('New Modal Popup Box', 'modal-popup-box'),
            'edit_item' => __('Edit Modal Popup Box', 'modal-popup-box'),
            'view_item' => __('View Modal Popup Box', 'modal-popup-box'),
            'all_items' => __('All Modal Popup Box', 'modal-popup-box'),
            'search_items' => __('Search Modal Popup Box', 'modal-popup-box'),
            'parent_item_colon' => __('Parent Modal Popup Box', 'modal-popup-box'),
            'not_found' => __('No Modal Popup Box found', 'modal-popup-box'),
            'not_found_in_trash' => __('No Modal Popup Box found in Trash', 'modal-popup-box'),
        );

        $args = array(
            'labels' => $labels,
            'description' => __('Modal Popup Box', 'modal-popup-box'),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'modalpopupbox'),
            'capability_type' => 'page',
            'menu_icon' => 'dashicons-archive',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor'),
        );

        register_post_type('modalpopupbox', $args);
    }

    /**
     * Register meta boxes.
     */
    public function add_meta_boxes()
    {
        add_meta_box(
            'mpb-shortcode',
            __('Copy Modal Popup Shortcode', 'modal-popup-box'),
            array($this, 'render_shortcode_metabox'),
            'modalpopupbox',
            'side',
            'default'
        );

        add_meta_box(
            'mpb-settings',
            __('Modal Box Settings', 'modal-popup-box'),
            array($this, 'render_settings_metabox'),
            'modalpopupbox',
            'normal',
            'default'
        );
    }

    /**
     * Render the shortcode copy metabox.
     *
     * @param WP_Post $post Current post object.
     */
    public function render_shortcode_metabox($post)
    {
        $shortcode = '[MPBOX id=' . absint($post->ID) . ']';
        ?>
        <div class="mpb-shortcode-wrap">
            <input type="text" id="mpb-shortcode-input" value="<?php echo esc_attr($shortcode); ?>" readonly class="widefat"
                style="font-size: 16px; text-align: center; padding: 8px; border: 2px dashed #ccc; font-weight: bold;">
            <p style="margin-top: 8px;">
                <button type="button" class="button button-primary mpb-copy-shortcode" data-target="#mpb-shortcode-input">
                    <span class="dashicons dashicons-clipboard" style="vertical-align: middle; margin-right: 4px;"></span>
                    <?php esc_html_e('Copy Shortcode', 'modal-popup-box'); ?>
                </button>
                <span class="mpb-copy-success" style="display:none; color: #46b450; margin-left: 8px; font-weight: bold;">
                    <?php esc_html_e('Copied!', 'modal-popup-box'); ?>
                </span>
            </p>
            <p class="description">
                <?php esc_html_e('Copy & paste this shortcode into any Page, Post, or Widget to display the modal.', 'modal-popup-box'); ?>
            </p>
        </div>
        <?php
    }

    /**
     * Render the main settings metabox.
     *
     * @param WP_Post $post Current post object.
     */
    public function render_settings_metabox($post)
    {
        $settings_renderer = new MPB_Settings();
        $settings_renderer->render($post);
    }

    /**
     * Save modal settings on post save.
     *
     * @param int $post_id The post ID being saved.
     */
    public function save_settings($post_id)
    {
        // Verify nonce (sanitize before verification).
        if (!isset($_POST['mpb_save_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mpb_save_nonce'])), 'mpb_save_settings')) {
            return;
        }

        // Check capability.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Don't save on autosave.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Verify post type.
        if ('modalpopupbox' !== get_post_type($post_id)) {
            return;
        }

        $settings = MPB_Data::sanitize_post_data();
        MPB_Data::save_settings($post_id, $settings);
    }

    /**
     * Add shortcode column to the CPT list table.
     *
     * @param array $columns Existing columns.
     * @return array Modified columns.
     */
    public function add_shortcode_column($columns)
    {
        $new = array();
        unset($columns['tags']);

        foreach ($columns as $key => $value) {
            if ('date' === $key) {
                $new['mpb_shortcode'] = __('Shortcode', 'modal-popup-box');
            }
            $new[$key] = $value;
        }

        return $new;
    }

    /**
     * Render shortcode column content.
     *
     * @param string $column  Column name.
     * @param int    $post_id Post ID.
     */
    public function render_shortcode_column($column, $post_id)
    {
        if ('mpb_shortcode' !== $column) {
            return;
        }

        $shortcode = '[MPBOX id=' . absint($post_id) . ']';
        printf(
            '<input type="text" value="%s" readonly class="mpb-column-shortcode" style="font-weight:bold; background-color:#32373C; color:#fff; text-align:center; width: 160px; padding: 4px 8px;" />',
            esc_attr($shortcode)
        );
        printf(
            '<button type="button" class="button button-small mpb-copy-shortcode" data-target=".mpb-column-shortcode" style="margin-left:4px;">%s</button>',
            esc_html__('Copy', 'modal-popup-box')
        );
    }

    /**
     * Enqueue admin-only assets.
     *
     * @param string $hook_suffix Current admin page hook.
     */
    public function enqueue_admin_assets($hook_suffix)
    {
        $screen = get_current_screen();

        if (!$screen || 'modalpopupbox' !== $screen->post_type) {
            return;
        }

        // Admin CSS.
        wp_enqueue_style(
            'mpb-admin-css',
            MPB_PLUGIN_URL . 'admin/css/mpb-admin.css',
            array(),
            MPB_PLUGIN_VER
        );

        // Color picker.
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script(
            'mpb-admin-js',
            MPB_PLUGIN_URL . 'admin/js/mpb-admin.js',
            array('jquery', 'wp-color-picker'),
            MPB_PLUGIN_VER,
            true
        );

        wp_localize_script('mpb-admin-js', 'mpb_admin_vars', array(
            'copied_text' => __('Copied!', 'modal-popup-box'),
        ));
    }
}
