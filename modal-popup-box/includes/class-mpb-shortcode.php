<?php
/**
 * Modal Popup Box — Shortcode
 *
 * Registers and renders the [MPBOX] shortcode.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class MPB_Shortcode
 */
class MPB_Shortcode
{

    /**
     * Initialize shortcode.
     */
    public function init()
    {
        add_shortcode('MPBOX', array($this, 'render'));
        add_filter('widget_text', 'do_shortcode');
    }

    /**
     * Render the [MPBOX] shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @return string Shortcode HTML output.
     */
    public function render($atts)
    {
        $atts = shortcode_atts(
            array('id' => 0),
            $atts,
            'MPBOX'
        );

        $post_id = absint($atts['id']);
        if (!$post_id) {
            return '';
        }

        // Verify the post exists and is the correct type.
        $post = get_post($post_id);
        if (!$post || 'modalpopupbox' !== $post->post_type || 'publish' !== $post->post_status) {
            return '';
        }

        // Get settings.
        $settings = MPB_Data::get_settings($post_id);

        // Enqueue frontend assets.
        $frontend = new MPB_Frontend();
        $frontend->enqueue_assets($settings);

        // Build output.
        ob_start();
        $frontend->render_modal($post_id, $post, $settings);
        return ob_get_clean();
    }
}
