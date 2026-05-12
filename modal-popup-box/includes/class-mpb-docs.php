<?php
/**
 * Modal Popup Box — Documentation Renderer
 *
 * Renders the standalone Docs / How to Use interface.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class MPB_Docs
 */
class MPB_Docs
{

    /**
     * Render the documentation page interface.
     */
    public function render()
    {
        ?>
        <div class="wrap mpb-docs-wrap">
            <h1 class="screen-reader-text"><?php esc_html_e('Modal Popup Box — Responsive Popup Maker & Popup Builder', 'modal-popup-box'); ?></h1>

            <div class="mpb-docs-header">
                <div class="mpb-docs-branding">
                    <span class="dashicons dashicons-archive"></span>
                    <div>
                        <h2><?php esc_html_e('Welcome to your Popup Maker', 'modal-popup-box'); ?></h2>
                        <p><?php esc_html_e('Fast Popup Builder for a New Offer or News', 'modal-popup-box'); ?></p>
                    </div>
                </div>
            </div>

            <div class="mpb-docs-grid">
                <!-- Left Column: Main Tutorial -->
                <div class="mpb-docs-main">
                    
                    <div class="mpb-doc-card">
                        <h3><span class="dashicons dashicons-editor-help"></span> <?php esc_html_e('Fast Start Guide for your Popup', 'modal-popup-box'); ?></h3>
                        <ol class="mpb-steps-list">
                            <li>
                                <strong><?php esc_html_e('Make a New Popup:', 'modal-popup-box'); ?></strong>
                                <?php esc_html_e('Go to Modal Popup Box > Add New. Type in your important news or special offer text.', 'modal-popup-box'); ?>
                            </li>
                            <li>
                                <strong><?php esc_html_e('Pick Your Settings:', 'modal-popup-box'); ?></strong>
                                <?php esc_html_e('Scroll down and pick colors. Set your trigger style and size for this popup builder.', 'modal-popup-box'); ?>
                            </li>
                            <li>
                                <strong><?php esc_html_e('Save & Publish:', 'modal-popup-box'); ?></strong>
                                <?php esc_html_e('Click the blue Publish button. Your first offer popup is now ready to use.', 'modal-popup-box'); ?>
                            </li>
                        </ol>
                    </div>

                    <div class="mpb-doc-card">
                        <h3><span class="dashicons dashicons-shortcode"></span> <?php esc_html_e('Adding a Popup to your Site', 'modal-popup-box'); ?></h3>
                        <p><?php esc_html_e('This popup maker is simple to use. Just copy the shortcode from the list table.', 'modal-popup-box'); ?></p>
                        
                        <div class="mpb-code-example">
                            <code>[MPBOX id=123]</code>
                        </div>

                        <h4><?php esc_html_e('Where to paste the code:', 'modal-popup-box'); ?></h4>
                        <ul>
                            <li><strong><?php esc_html_e('Blocks:', 'modal-popup-box'); ?></strong> <?php esc_html_e('Use a shortcode block to place your offer anywhere.', 'modal-popup-box'); ?></li>
                            <li><strong><?php esc_html_e('Classic:', 'modal-popup-box'); ?></strong> <?php esc_html_e('Paste code directly into the normal text box editor.', 'modal-popup-box'); ?></li>
                            <li><strong><?php esc_html_e('Widgets:', 'modal-popup-box'); ?></strong> <?php esc_html_e('Drop your popup code into sidebars or footers.', 'modal-popup-box'); ?></li>
                        </ul>
                    </div>

                    <div class="mpb-doc-card">
                        <h3><span class="dashicons dashicons-admin-appearance"></span> <?php esc_html_e('Types of Popup Behavior', 'modal-popup-box'); ?></h3>
                        <div class="mpb-feature-split">
                            <div>
                                <strong><?php esc_html_e('On Page Load:', 'modal-popup-box'); ?></strong>
                                <p><?php esc_html_e('The popup opens automatically when a visitor loads your page. Great for share new news.', 'modal-popup-box'); ?></p>
                            </div>
                            <div>
                                <strong><?php esc_html_e('On Click:', 'modal-popup-box'); ?></strong>
                                <p><?php esc_html_e('A custom button makes the popup open. Perfect for a special user offer.', 'modal-popup-box'); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Reference Card -->
                    <div class="mpb-doc-card">
                        <h3><span class="dashicons dashicons-list-view"></span> <?php esc_html_e('Dictionary for your Popup Builder', 'modal-popup-box'); ?></h3>
                        <p><?php esc_html_e('Find out how to manage each setting in this popup maker list below:', 'modal-popup-box'); ?></p>
                        
                        <div class="mpb-settings-reference">
                            <h4><?php esc_html_e('Tab 1: Popup Settings', 'modal-popup-box'); ?></h4>
                            <dl>
                                <dt><?php esc_html_e('Show Popup', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Sets when your box appears — either fire it right away or wait for a click.', 'modal-popup-box'); ?></dd>
                                
                                <dt><?php esc_html_e('Button Text & Size', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Pick simple text and scale for the button that loads your popup builder.', 'modal-popup-box'); ?></dd>
                                
                                <dt><?php esc_html_e('Colors', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Pick a primary hex shade to match the style of your site.', 'modal-popup-box'); ?></dd>
                            </dl>

                            <h4><?php esc_html_e('Tab 2: General Config', 'modal-popup-box'); ?></h4>
                            <dl>
                                <dt><?php esc_html_e('Color Theme', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Pick 1 of 5 nice presets or add a custom brand shade easily.', 'modal-popup-box'); ?></dd>
                                
                                <dt><?php esc_html_e('Entry Effect', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Pick how the offer box flies in (Fade, Slide, Fall, or Flip).', 'modal-popup-box'); ?></dd>

                                <dt><?php esc_html_e('Delay timer', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Set how many seconds to wait before the popup appears to show news.', 'modal-popup-box'); ?></dd>

                                <dt><?php esc_html_e('Background Mask', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Control the level of dark shadow behind the popup window.', 'modal-popup-box'); ?></dd>

                                <dt><?php esc_html_e('Close Tools', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Style your close X button so guests can dismiss the box fast.', 'modal-popup-box'); ?></dd>

                                <dt><?php esc_html_e('Width & Height', 'modal-popup-box'); ?></dt>
                                <dd><?php esc_html_e('Limit total box size bounds. This keeps your popup builder view looking clean.', 'modal-popup-box'); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="mpb-docs-sidebar">
                    <div class="mpb-sidebar-promo">
                        <span class="dashicons dashicons-awards"></span>
                        <h4><?php esc_html_e('Get More Popup Features', 'modal-popup-box'); ?></h4>
                        <p><?php esc_html_e('Get the Pro version now. Adds 19 more effects, exit intent tools, and fast help.', 'modal-popup-box'); ?></p>
                        <a href="https://awplife.com/wordpress-plugins/modal-popup-box-wordpress-plugin/" target="_blank" class="button button-primary button-hero">
                            <?php esc_html_e('View Pro Builder Offer', 'modal-popup-box'); ?>
                        </a>
                    </div>

                    <div class="mpb-sidebar-links">
                        <h4><?php esc_html_e('More Simple Links', 'modal-popup-box'); ?></h4>
                        <ul>
                            <li><a href="https://awplife.com/demo/model-popup-box-premium/" target="_blank"><span class="dashicons dashicons-sos"></span> <?php esc_html_e('See Real Demos', 'modal-popup-box'); ?></a></li>
                            <li><a href="https://wordpress.org/support/plugin/modal-popup-box/" target="_blank"><span class="dashicons dashicons-groups"></span> <?php esc_html_e('Join the Help Forum', 'modal-popup-box'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
