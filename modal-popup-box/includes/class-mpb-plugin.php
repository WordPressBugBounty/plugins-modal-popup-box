<?php
/**
 * Modal Popup Box — Main Plugin Class
 *
 * Bootstraps the plugin: defines constants, loads classes, initializes components.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class MPB_Plugin
 *
 * Singleton plugin bootstrap.
 */
class MPB_Plugin
{

    /**
     * Singleton instance.
     *
     * @var MPB_Plugin|null
     */
    private static $instance = null;

    /**
     * Get singleton instance.
     *
     * @return MPB_Plugin
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private constructor — use get_instance().
     */
    private function __construct()
    {
        $this->load_classes();
        $this->init_components();
    }

    /**
     * Load all class files.
     */
    private function load_classes()
    {
        $includes_dir = MPB_PLUGIN_DIR . 'includes/';

        require_once $includes_dir . 'class-mpb-data.php';
        require_once $includes_dir . 'class-mpb-admin.php';
        require_once $includes_dir . 'class-mpb-settings.php';
        require_once $includes_dir . 'class-mpb-shortcode.php';
        require_once $includes_dir . 'class-mpb-frontend.php';
    }

    /**
     * Initialize plugin components.
     */
    private function init_components()
    {
        // Admin.
        if (is_admin()) {
            $admin = new MPB_Admin();
            $admin->init();
        }

        // Shortcode (needed on both admin and front for previews).
        $shortcode = new MPB_Shortcode();
        $shortcode->init();

        // Frontend assets (register them early).
        $frontend = new MPB_Frontend();
        $frontend->init();
    }
}
