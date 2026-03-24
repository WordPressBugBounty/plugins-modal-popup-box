<?php
/**
 * Modal Popup Box — Settings Renderer
 *
 * Renders the admin settings UI tabs and fields.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class MPB_Settings
 */
class MPB_Settings
{

    /**
     * Render the settings interface.
     *
     * @param WP_Post $post Current post object.
     */
    public function render($post)
    {
        $settings = MPB_Data::get_settings($post->ID);

        wp_nonce_field('mpb_save_settings', 'mpb_save_nonce');
        ?>
        <div class="mpb-settings-wrap">
            <nav class="nav-tab-wrapper mpb-tabs">
                <a href="#mpb-tab-trigger" class="nav-tab nav-tab-active">
                    <span class="dashicons dashicons-archive"></span>
                    <?php esc_html_e('Modal Popup', 'modal-popup-box'); ?>
                </a>
                <a href="#mpb-tab-config" class="nav-tab">
                    <span class="dashicons dashicons-admin-generic"></span>
                    <?php esc_html_e('Config', 'modal-popup-box'); ?>
                </a>
                <a href="#mpb-tab-css" class="nav-tab">
                    <span class="dashicons dashicons-editor-code"></span>
                    <?php esc_html_e('Custom CSS', 'modal-popup-box'); ?>
                </a>
                <a href="#mpb-tab-upgrade" class="nav-tab">
                    <span class="dashicons dashicons-cart"></span>
                    <?php esc_html_e('Upgrade to Pro', 'modal-popup-box'); ?>
                </a>
            </nav>

            <div class="mpb-tab-panels">
                <?php
                $this->render_tab_trigger($settings);
                $this->render_tab_config($settings);
                $this->render_tab_css($settings);
                $this->render_tab_upgrade();
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * Render Trigger settings tab.
     *
     * @param array $settings Current settings.
     */
    private function render_tab_trigger($settings)
    {
        ?>
        <div id="mpb-tab-trigger" class="mpb-tab-panel mpb-tab-panel-active">
            <h2 class="mpb-section-header">
                <span class="dashicons dashicons-archive"></span>
                <?php esc_html_e('Modal Popup Settings', 'modal-popup-box'); ?>
            </h2>
            <hr class="mpb-section-divider">
            <table class="form-table mpb-settings-table">
                <tr>
                    <th scope="row">
                        <label>
                            <?php esc_html_e('Show Modal', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Display modal on page load or on button click.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <fieldset class="mpb-radio-group">
                            <label>
                                <input type="radio" name="mpb_show_modal" value="onload" <?php checked($settings['mpb_show_modal'], 'onload'); ?>>
                                <?php esc_html_e('On Page Load', 'modal-popup-box'); ?>
                            </label>
                            <label>
                                <input type="radio" name="mpb_show_modal" value="onclick" <?php checked($settings['mpb_show_modal'], 'onclick'); ?>>
                                <?php esc_html_e('On Button Click', 'modal-popup-box'); ?>
                            </label>
                        </fieldset>
                    </td>
                </tr>
            </table>

            <div class="mpb-onclick-section">
                <table class="form-table mpb-settings-table">
                    <tr>
                        <th scope="row">
                            <label for="mpb_main_button_text">
                                <?php esc_html_e('Button Text', 'modal-popup-box'); ?>
                            </label>
                            <p class="description">
                                <?php esc_html_e('Text displayed on the trigger button.', 'modal-popup-box'); ?>
                            </p>
                        </th>
                        <td>
                            <input type="text" id="mpb_main_button_text" name="mpb_main_button_text"
                                value="<?php echo esc_attr($settings['mpb_main_button_text']); ?>" class="regular-text"
                                placeholder="<?php esc_attr_e('Click Me', 'modal-popup-box'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="mpb_main_button_size">
                                <?php esc_html_e('Button Size', 'modal-popup-box'); ?>
                            </label>
                            <p class="description">
                                <?php esc_html_e('Select the trigger button size.', 'modal-popup-box'); ?>
                            </p>
                        </th>
                        <td>
                            <select id="mpb_main_button_size" name="mpb_main_button_size">
                                <option value="btn btn-xs" <?php selected($settings['mpb_main_button_size'], 'btn btn-xs'); ?>>
                                    <?php esc_html_e('Extra Small', 'modal-popup-box'); ?>
                                </option>
                                <option value="btn btn-sm" <?php selected($settings['mpb_main_button_size'], 'btn btn-sm'); ?>>
                                    <?php esc_html_e('Small', 'modal-popup-box'); ?>
                                </option>
                                <option value="btn btn-default" <?php selected($settings['mpb_main_button_size'], 'btn btn-default'); ?>>
                                    <?php esc_html_e('Medium', 'modal-popup-box'); ?>
                                </option>
                                <option value="btn btn-lg" <?php selected($settings['mpb_main_button_size'], 'btn btn-lg'); ?>>
                                    <?php esc_html_e('Large', 'modal-popup-box'); ?>
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="mpb_main_button_color">
                                <?php esc_html_e('Button Color', 'modal-popup-box'); ?>
                            </label>
                            <p class="description">
                                <?php esc_html_e('Background color of the trigger button.', 'modal-popup-box'); ?>
                            </p>
                        </th>
                        <td>
                            <?php $this->field_color('mpb_main_button_color', $settings['mpb_main_button_color'], '#008EC2'); ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="mpb_main_button_text_color">
                                <?php esc_html_e('Button Text Color', 'modal-popup-box'); ?>
                            </label>
                            <p class="description">
                                <?php esc_html_e('Text color of the trigger button.', 'modal-popup-box'); ?>
                            </p>
                        </th>
                        <td>
                            <?php $this->field_color('mpb_main_button_text_color', $settings['mpb_main_button_text_color'], '#ffffff'); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }

    /**
     * Render Config settings tab.
     *
     * @param array $settings Current settings.
     */
    private function render_tab_config($settings)
    {
        ?>
        <div id="mpb-tab-config" class="mpb-tab-panel">
            <h2 class="mpb-section-header">
                <span class="dashicons dashicons-admin-customizer"></span>
                <?php esc_html_e('General Settings', 'modal-popup-box'); ?>
            </h2>
            <hr class="mpb-section-divider">
            <table class="form-table mpb-settings-table">
                <tr>
                    <th scope="row">
                        <label>
                            <?php esc_html_e('Modal Color Design', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Select a color preset for the modal.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <fieldset class="mpb-radio-group mpb-color-swatches">
                            <label class="mpb-swatch">
                                <input type="radio" name="modal_popup_design" value="color_1" <?php checked($settings['modal_popup_design'], 'color_1'); ?>>
                                <span class="mpb-swatch-color" style="background-color: #008EC2;"
                                    title="<?php esc_attr_e('Blue', 'modal-popup-box'); ?>"></span>
                            </label>
                            <label class="mpb-swatch">
                                <input type="radio" name="modal_popup_design" value="color_2" <?php checked($settings['modal_popup_design'], 'color_2'); ?>>
                                <span class="mpb-swatch-color" style="background-color: #FF0000;"
                                    title="<?php esc_attr_e('Red', 'modal-popup-box'); ?>"></span>
                            </label>
                            <label class="mpb-swatch">
                                <input type="radio" name="modal_popup_design" value="color_3" <?php checked($settings['modal_popup_design'], 'color_3'); ?>>
                                <span class="mpb-swatch-color" style="background-color: #4CAF50;"
                                    title="<?php esc_attr_e('Green', 'modal-popup-box'); ?>"></span>
                            </label>
                            <label class="mpb-swatch">
                                <input type="radio" name="modal_popup_design" value="color_4" <?php checked($settings['modal_popup_design'], 'color_4'); ?>>
                                <span class="mpb-swatch-color" style="background-color: #9C27B0;"
                                    title="<?php esc_attr_e('Purple', 'modal-popup-box'); ?>"></span>
                            </label>
                            <label class="mpb-swatch">
                                <input type="radio" name="modal_popup_design" value="color_5" <?php checked($settings['modal_popup_design'], 'color_5'); ?>>
                                <span class="mpb-swatch-color" style="background-color: #FF9800;"
                                    title="<?php esc_attr_e('Orange', 'modal-popup-box'); ?>"></span>
                            </label>
                            <label class="mpb-swatch">
                                <input type="radio" name="modal_popup_design" value="custom" <?php checked($settings['modal_popup_design'], 'custom'); ?>>
                                <span class="mpb-swatch-color mpb-swatch-custom"
                                    title="<?php esc_attr_e('Custom Color', 'modal-popup-box'); ?>">
                                    <span class="dashicons dashicons-admin-appearance"></span>
                                </span>
                            </label>
                        </fieldset>
                    </td>
                </tr>
                <tr class="mpb-custom-design-section" <?php if ($settings['modal_popup_design'] !== 'custom') echo 'style="display:none;"'; ?>>
                    <th scope="row">
                        <label for="mpb_modal_bg_color">
                            <?php esc_html_e('Custom Modal Background', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Choose any color for the modal background.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <?php $this->field_color('mpb_modal_bg_color', $settings['mpb_modal_bg_color'], '#008EC2'); ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_animation_effect_open_btn">
                            <?php esc_html_e('Open Animation Effect', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Animation when the modal appears.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <select id="mpb_animation_effect_open_btn" name="mpb_animation_effect_open_btn">
                            <option value="mpb-md-effect-1" <?php selected($settings['mpb_animation_effect_open_btn'], 'mpb-md-effect-1'); ?>>
                                <?php esc_html_e('Fade in & Scale', 'modal-popup-box'); ?>
                            </option>
                            <option value="mpb-md-effect-2" <?php selected($settings['mpb_animation_effect_open_btn'], 'mpb-md-effect-2'); ?>>
                                <?php esc_html_e('Slide in (right)', 'modal-popup-box'); ?>
                            </option>

                            <option value="mpb-md-effect-6" <?php selected($settings['mpb_animation_effect_open_btn'], 'mpb-md-effect-6'); ?>>
                                <?php esc_html_e('Side Fall', 'modal-popup-box'); ?>
                            </option>

                            <option value="mpb-md-effect-8" <?php selected($settings['mpb_animation_effect_open_btn'], 'mpb-md-effect-8'); ?>>
                                <?php esc_html_e('3D Flip (Horizontal)', 'modal-popup-box'); ?>
                            </option>

                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_open_delay">
                            <?php esc_html_e('Open Delay (sec)', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Delay before opening (onload only).', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <input type="number" id="mpb_open_delay" name="mpb_open_delay"
                            value="<?php echo esc_attr(isset($settings['mpb_open_delay']) ? $settings['mpb_open_delay'] : 0); ?>"
                            class="regular-text" min="0" max="60" step="1" style="width: 80px;">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_overlay_opacity">
                            <?php esc_html_e('Overlay Opacity', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Background dimming (0-100%).', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <div class="mpb-range-wrap">
                            <input type="range" id="mpb_overlay_opacity" name="mpb_overlay_opacity"
                                value="<?php echo esc_attr(isset($settings['mpb_overlay_opacity']) ? $settings['mpb_overlay_opacity'] : 60); ?>"
                                min="0" max="100" step="5" class="mpb-range">
                            <output class="mpb-range-value">
                                <?php echo esc_html(isset($settings['mpb_overlay_opacity']) ? $settings['mpb_overlay_opacity'] : 60); ?>%
                            </output>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_button2_text">
                            <?php esc_html_e('Close Button Text', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Text on the modal close button.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <input type="text" id="mpb_button2_text" name="mpb_button2_text"
                            value="<?php echo esc_attr($settings['mpb_button2_text']); ?>" class="regular-text"
                            placeholder="<?php esc_attr_e('Close Me', 'modal-popup-box'); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_button2_color">
                            <?php esc_html_e('Close Button Color', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Background color of the close button.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <?php $this->field_color('mpb_button2_color', $settings['mpb_button2_color'], '#666666'); ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_button2_text_color">
                            <?php esc_html_e('Close Button Text Color', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Text color of the close button.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <?php $this->field_color('mpb_button2_text_color', $settings['mpb_button2_text_color'], '#ffffff'); ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_close_icon_color">
                            <?php esc_html_e('Close Icon Color', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Color of the close (X) icon.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <?php $this->field_color('mpb_close_icon_color', $settings['mpb_close_icon_color'], '#666666'); ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_width">
                            <?php esc_html_e('Modal Width', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Width of the modal box (in %).', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <div class="mpb-range-wrap">
                            <input type="range" id="mpb_width" name="mpb_width"
                                value="<?php echo esc_attr($settings['mpb_width']); ?>" min="15" max="100" step="5"
                                class="mpb-range">
                            <output class="mpb-range-value">
                                <?php echo esc_html($settings['mpb_width']); ?>%
                            </output>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="mpb_height">
                            <?php esc_html_e('Modal Height', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Height of the modal box (in px).', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <div class="mpb-range-wrap">
                            <input type="range" id="mpb_height" name="mpb_height"
                                value="<?php echo esc_attr($settings['mpb_height']); ?>" min="200" max="700" step="25"
                                class="mpb-range">
                            <output class="mpb-range-value">
                                <?php echo esc_html($settings['mpb_height']); ?>px
                            </output>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }

    /**
     * Render Custom CSS tab.
     *
     * @param array $settings Current settings.
     */
    private function render_tab_css($settings)
    {
        ?>
        <div id="mpb-tab-css" class="mpb-tab-panel">
            <h2 class="mpb-section-header">
                <span class="dashicons dashicons-editor-code"></span>
                <?php esc_html_e('Custom CSS', 'modal-popup-box'); ?>
            </h2>
            <hr class="mpb-section-divider">
            <table class="form-table mpb-settings-table">
                <tr>
                    <th scope="row">
                        <label for="mpb_custom_css">
                            <?php esc_html_e('Custom CSS', 'modal-popup-box'); ?>
                        </label>
                        <p class="description">
                            <?php esc_html_e('Add your own CSS rules. Do not use &lt;style&gt; tags.', 'modal-popup-box'); ?>
                        </p>
                    </th>
                    <td>
                        <textarea name="mpb_custom_css" id="mpb_custom_css" rows="10" class="large-text code"
                            placeholder="<?php esc_attr_e('.my-modal { color: #333; }', 'modal-popup-box'); ?>"><?php echo esc_textarea($settings['mpb_custom_css']); ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }

    /**
     * Render Upgrade to Pro tab.
     */
    private function render_tab_upgrade()
    {
        $features = array(
            array(
                'icon' => 'welcome-view-site',
                'title' => __('Live Preview', 'modal-popup-box'),
                'desc' => __('See your modal design update in real-time as you change settings — no need to save and reload.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'admin-appearance',
                'title' => __('19 Open Animation Effects', 'modal-popup-box'),
                'desc' => __('Free includes 7 effects. Pro unlocks all 19: Fall, Slide Bottom, 3D Slit, Super Scaled, Just Me, Blur, Rotate, and more.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'migrate',
                'title' => __('Exit Intent Trigger', 'modal-popup-box'),
                'desc' => __('Show the modal when a visitor moves their cursor to leave the page — great for reducing bounce.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'arrow-down-alt',
                'title' => __('Scroll Trigger', 'modal-popup-box'),
                'desc' => __('Trigger the modal after the visitor scrolls a set percentage of the page.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'clock',
                'title' => __('Inactivity Trigger', 'modal-popup-box'),
                'desc' => __('Display the modal after a period of user inactivity — re-engage idle visitors.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'admin-customizer',
                'title' => __('Header Customization', 'modal-popup-box'),
                'desc' => __('Control title font size, color, alignment, background color, animation effect, and border style.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'editor-contract',
                'title' => __('Content Styling', 'modal-popup-box'),
                'desc' => __('Set content font color, background color, and padding independently from the header.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'button',
                'title' => __('Dual Footer Buttons', 'modal-popup-box'),
                'desc' => __('Two fully customizable buttons with individual text, URLs, colors, sizes, and animations.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'art',
                'title' => __('Overlay Color Picker', 'modal-popup-box'),
                'desc' => __('Free has opacity control. Pro adds a full color picker — use any color for the overlay background.', 'modal-popup-box'),
            ),

            array(
                'icon' => 'image-crop',
                'title' => __('Max Width, Radius & Shadow', 'modal-popup-box'),
                'desc' => __('Set a pixel max-width, border radius, and choose from multiple box shadow styles.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'dismiss',
                'title' => __('Close Button Styles', 'modal-popup-box'),
                'desc' => __('Choose between ✕ icon, "Close" text, or both. Customize the close button color.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'hidden',
                'title' => __('Cookie Dismiss', 'modal-popup-box'),
                'desc' => __('After a visitor closes the modal, hide it for a set number of days using a cookie.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'visibility',
                'title' => __('Page-Level Targeting', 'modal-popup-box'),
                'desc' => __('Show or hide modals on specific pages with Include/Exclude rules by post/page ID.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'calendar',
                'title' => __('Schedule & Auto-Close', 'modal-popup-box'),
                'desc' => __('Schedule modals for date ranges. Auto-close after a set number of seconds.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'admin-page',
                'title' => __('Clone / Duplicate Modals', 'modal-popup-box'),
                'desc' => __('Instantly duplicate any modal with all settings — perfect for creating variations.', 'modal-popup-box'),
            ),
            array(
                'icon' => 'download',
                'title' => __('Import / Export Settings', 'modal-popup-box'),
                'desc' => __('Export modal settings as JSON and import them on another site — easy migration.', 'modal-popup-box'),
            ),
        );
        ?>
        <div id="mpb-tab-upgrade" class="mpb-tab-panel">
            <div class="mpb-upgrade-hero">
                <span class="dashicons dashicons-star-filled mpb-upgrade-hero__icon"></span>
                <h2 class="mpb-upgrade-hero__title">
                    <?php esc_html_e('Unlock the Full Power of Modal Popup Box', 'modal-popup-box'); ?>
                </h2>
                <p class="mpb-upgrade-hero__subtitle">
                    <?php esc_html_e('Get advanced triggers, full customization, and premium animation effects.', 'modal-popup-box'); ?>
                </p>
            </div>
            <div class="mpb-upgrade-grid">
                <?php foreach ($features as $f): ?>
                    <div class="mpb-upgrade-card">
                        <div class="mpb-upgrade-card__icon">
                            <span class="dashicons dashicons-<?php echo esc_attr($f['icon']); ?>"></span>
                        </div>
                        <h3 class="mpb-upgrade-card__title"><?php echo esc_html($f['title']); ?></h3>
                        <p class="mpb-upgrade-card__desc"><?php echo esc_html($f['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mpb-upgrade-cta">
                <a href="https://awplife.com/wordpress-plugins/modal-popup-box-wordpress-plugin/" target="_blank"
                    class="mpb-upgrade-cta__btn mpb-upgrade-cta__btn--primary">
                    <span class="dashicons dashicons-star-filled"></span>
                    <?php esc_html_e('Get Premium Version', 'modal-popup-box'); ?>
                </a>
                <a href="https://awplife.com/demo/model-popup-box-premium/" target="_blank"
                    class="mpb-upgrade-cta__btn mpb-upgrade-cta__btn--secondary">
                    <span class="dashicons dashicons-external"></span>
                    <?php esc_html_e('View Live Demo', 'modal-popup-box'); ?>
                </a>
            </div>
        </div>
        <?php
    }
    /**
     * Render a color picker field.
     *
     * @param string $name         Field name.
     * @param string $value        Current value.
     * @param string $default      Default color for reset button.
     */
    private function field_color($name, $value, $default)
    {
        ?>
        <input type="text" id="<?php echo esc_attr($name); ?>" name="<?php echo esc_attr($name); ?>"
            value="<?php echo esc_attr($value); ?>" class="mpb-color-picker"
            data-default-color="<?php echo esc_attr($default); ?>">
        <?php
    }
}
