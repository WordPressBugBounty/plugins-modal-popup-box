<?php
/**
 * Modal Popup Box — Frontend
 *
 * Handles frontend asset loading and modal HTML/CSS/JS output.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class MPB_Frontend
 */
class MPB_Frontend
{

    /**
     * Track if base assets have been enqueued.
     *
     * @var bool
     */
    private static $assets_enqueued = false;

    /**
     * Register frontend styles and scripts (registered, not enqueued).
     */
    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'register_assets'));
    }

    /**
     * Register (but don't enqueue) frontend assets.
     * They will be enqueued only when a shortcode is found.
     */
    public function register_assets()
    {
        // Merged frontend CSS.
        wp_register_style(
            'mpb-frontend-css',
            MPB_PLUGIN_URL . 'public/css/mpb-frontend.css',
            array(),
            MPB_PLUGIN_VER
        );

        // JS.
        wp_register_script(
            'mpb-modal-js',
            MPB_PLUGIN_URL . 'public/js/mpb-modal.js',
            array('jquery'),
            MPB_PLUGIN_VER,
            true
        );
    }

    /**
     * Enqueue frontend assets when shortcode is used.
     *
     * @param array $settings Modal settings.
     */
    public function enqueue_assets($settings)
    {
        if (!self::$assets_enqueued) {
            wp_enqueue_style('mpb-frontend-css');
            wp_enqueue_script('mpb-modal-js');


            self::$assets_enqueued = true;
        }

    }

    /**
     * Render the modal HTML output.
     *
     * @param int     $post_id  Modal post ID.
     * @param WP_Post $post     Post object.
     * @param array   $settings Modal settings.
     */
    public function render_modal($post_id, $post, $settings)
    {
        $post_id = absint($post_id);

        // Extract settings for template readability.
        $show_modal = $settings['mpb_show_modal'];
        $button_text = $settings['mpb_main_button_text'];
        $button_size = $settings['mpb_main_button_size'];
        $button_color = $settings['mpb_main_button_color'];
        $button_text_clr = $settings['mpb_main_button_text_color'];
        $close_button_color = $settings['mpb_button2_color'];
        $close_button_text_color = $settings['mpb_button2_text_color'];
        $close_text = $settings['mpb_button2_text'];
        $design = $settings['modal_popup_design'];
        $animation = !empty($settings['mpb_animation_effect_open_btn']) ? $settings['mpb_animation_effect_open_btn'] : 'mpb-md-effect-1';
        if (0 !== strpos($animation, 'mpb-')) {
            $animation = 'mpb-' . $animation;
        }

        // Get post content.
        $modal_title = get_the_title($post_id);
        $modal_content = $post->post_content;

        // Determine color based on design preset.
        $color_map = array(
            'color_1' => '#008EC2',
            'color_2' => '#FF0000',
            'color_3' => '#4CAF50',
            'color_4' => '#9C27B0',
            'color_5' => '#FF9800',
        );

        if ('custom' === $design && !empty($settings['mpb_modal_bg_color'])) {
            $bg_color = $settings['mpb_modal_bg_color'];
        } else {
            $bg_color = isset($color_map[$design]) ? $color_map[$design] : '#008EC2';
        }
        $btn_class = ('color_1' === $design) ? 'btn-style' : 'btn-primary_' . $post_id;
        $close_btn_class = 'btn-close-bg-' . $post_id;

        // Prepare configuration.
        $config = array(
            'id' => $post_id,
            'showModal' => $show_modal,
            'animation' => $animation,
            'delay' => isset($settings['mpb_open_delay']) ? absint($settings['mpb_open_delay']) : 0,
        );

        // Render modal HTML.
        ?>
        <div class="mpb-modal-wrapper" id="mpb-wrapper-<?php echo esc_attr($post_id); ?>" data-mpb-config="<?php echo esc_attr(wp_json_encode($config)); ?>">
            <div class="mpb-md-modal mpb-modal-<?php echo esc_attr($post_id); ?> <?php echo esc_attr($animation); ?>"
                id="modal-<?php echo esc_attr($post_id); ?>" role="dialog" aria-modal="true"
                aria-labelledby="mpb-title-<?php echo esc_attr($post_id); ?>" <?php if ('onclick' === $show_modal): ?>
                    style="display:none;" <?php endif; ?>>
                <div class="mpb-md-content mpb-md-content-<?php echo esc_attr($post_id); ?>"
                    style="background-color: <?php echo esc_attr($bg_color); ?>;">
                    <h3 id="mpb-title-<?php echo esc_attr($post_id); ?>" class="mbox-title text-center"
                        style="margin:0; padding:20px; font-weight:bolder; background:rgba(0,0,0,0.1);">
                        <?php echo esc_html($modal_title ? $modal_title : __('Modal Title', 'modal-popup-box')); ?>
                    </h3>
                    <button type="button" class="mpb-md-close mpb-close-x"
                        aria-label="<?php esc_attr_e('Close modal', 'modal-popup-box'); ?>">&times;</button>
                    <div class="mpb-content-body">
                        <?php
                        if (empty($modal_content)) {
                            echo '<p>' . esc_html__('Modal content is empty. Add content in the editor above.', 'modal-popup-box') . '</p>';
                        } else {
                            echo wp_kses_post(do_shortcode($modal_content));
                        }
                        ?>
                    </div>
                    <div class="mpb-buttons text-center">
                        <button type="button"
                            class="mpb-btn <?php echo esc_attr($close_btn_class); ?> mpb-text-center mpb-md-close">
                            <?php echo esc_html($close_text); ?>
                        </button>
                    </div>
                </div>
            </div>

            <?php
            $overlay_opacity = isset($settings['mpb_overlay_opacity']) ? intval($settings['mpb_overlay_opacity']) / 100 : 0.6;
            $overlay_color = !empty($settings['mpb_overlay_color']) ? $settings['mpb_overlay_color'] : '#000000';
            // Convert Hex to RGBA.
            list($r, $g, $b) = sscanf($overlay_color, "#%02x%02x%02x");
            $overlay_bg = "rgba($r, $g, $b, $overlay_opacity)";
            ?>
            <div class="mpb-md-overlay mpb-md-overlay-<?php echo esc_attr($post_id); ?>" <?php if ('onclick' === $show_modal): ?>
                    style="display:none; background: <?php echo esc_attr($overlay_bg); ?>;"
                <?php else: ?>
                    style="background: <?php echo esc_attr($overlay_bg); ?>;"
                <?php endif; ?>>
            </div>
        </div><!-- /.mpb-modal-wrapper -->

        <?php if ('onclick' === $show_modal): ?>
            <div class="mpb-trigger-wrap">
                <div class="mpb-md-trigger mpb-md-setperspective btn-bg-<?php echo esc_attr($post_id); ?> <?php echo esc_attr($button_size); ?> mpb-text-center"
                    data-modal="modal-<?php echo esc_attr($post_id); ?>" role="button" tabindex="0" aria-haspopup="dialog">
                    <?php echo esc_html($button_text); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php

        // Modern FSE-friendly dynamic style injection.
        $dynamic_css = $this->get_dynamic_css($post_id, $settings);
        ?>
        <style id="mpb-style-<?php echo esc_attr($post_id); ?>">
            <?php echo $dynamic_css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </style>
        <?php
    }

    /**
     * Get dynamic CSS for a specific modal.
     *
     * @param int    $post_id  Modal post ID.
     * @param array  $settings Modal settings.
     * @return string Dynamic CSS.
     */
    private function get_dynamic_css($post_id, $settings)
    {
        $width = isset($settings['mpb_width']) ? absint($settings['mpb_width']) : 600;
        $height = isset($settings['mpb_height']) ? absint($settings['mpb_height']) : 400;
        $btn_color = isset($settings['mpb_main_button_color']) ? sanitize_hex_color($settings['mpb_main_button_color']) : '#337ab7';
        $btn_txt = isset($settings['mpb_main_button_text_color']) ? sanitize_hex_color($settings['mpb_main_button_text_color']) : '#fff';
        $custom_css = isset($settings['mpb_custom_css']) ? wp_strip_all_tags($settings['mpb_custom_css']) : '';
        $close_icon_color = isset($settings['mpb_close_icon_color']) ? sanitize_hex_color($settings['mpb_close_icon_color']) : '#333';
        $close_btn_color = isset($settings['mpb_button2_color']) ? sanitize_hex_color($settings['mpb_button2_color']) : '#ddd';
        $close_btn_txt = isset($settings['mpb_button2_text_color']) ? sanitize_hex_color($settings['mpb_button2_text_color']) : '#333';

        $css = "
            .mpb-modal-{$post_id} {
                width: {$width}% !important;
            }
            .mpb-md-modal-{$post_id}.mpb-md-content-{$post_id} {
                height: {$height}px;
                overflow-y: auto;
                position: relative;
                border-radius: 3px;
                margin: 0 auto;
            }
            .btn-bg-{$post_id} {
                background-color: {$btn_color} !important;
                color: {$btn_txt} !important;
                cursor: pointer;
            }
            .btn-bg-{$post_id}:hover {
                opacity: 0.9;
            }
            .btn-close-bg-{$post_id} {
                background-color: {$close_btn_color} !important;
                color: {$close_btn_txt} !important;
                cursor: pointer;
            }
            .btn-close-bg-{$post_id}:hover {
                opacity: 0.9;
            }
            .mpb-close-x {
                position: absolute;
                top: 10px;
                right: 14px;
                background-color: {$settings['mpb_close_btn_bg_color']} !important;
                border: none;
                font-size: 22px;
                cursor: pointer;
                color: {$close_icon_color} !important;
                line-height: 1;
                padding: 4px 8px;
                opacity: 0.7;
                transition: all 0.2s ease;
                border: 1px solid transparent;
                border-radius: 4px;
            }
            .mpb-close-x:hover {
                opacity: 1;
                background-color: {$settings['mpb_close_btn_bg_color']} !important;
                border-color: {$close_icon_color} !important;
            }
            #mpb-wrapper-{$post_id} .mpb-md-overlay {
                background: rgba(0, 0, 0, 0.7) !important;
            }
            .mpb-content-body {
                padding: 15px;
            }
            .mpb-buttons {
                padding: 10px 15px 15px;
            }
            .mpb-trigger-wrap {
                display: inline-block;
            }
            {$custom_css}
        ";

        return $css;
    }
}
