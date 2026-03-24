/**
 * Modal Popup Box — Admin JavaScript
 *
 * Handles tabs, color pickers, range sliders, and copy-to-clipboard.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

(function ($) {
    'use strict';

    $(document).ready(function () {

        // ── Tab Navigation ──────────────────────────────
        $('.mpb-tabs .nav-tab').on('click', function (e) {
            e.preventDefault();

            var $tab = $(this);
            var targetId = $tab.attr('href');

            // Switch active tab.
            $tab.siblings('.nav-tab').removeClass('nav-tab-active');
            $tab.addClass('nav-tab-active');

            // Switch active panel.
            $('.mpb-tab-panel').removeClass('mpb-tab-panel-active');
            $(targetId).addClass('mpb-tab-panel-active');
        });

        // ── Color Pickers ───────────────────────────────
        $('.mpb-color-picker').each(function () {
            $(this).wpColorPicker();
        });

        // Re-initialize after AJAX (e.g., Gutenberg save).
        $(document).ajaxComplete(function () {
            $('.mpb-color-picker').filter(function () {
                return !$(this).closest('.wp-picker-container').length;
            }).wpColorPicker();
        });

        // ── Range Sliders ───────────────────────────────
        function updateRangeSlider($el) {
            var val = $el.val();
            var min = $el.attr('min') || 0;
            var max = $el.attr('max') || 100;
            var pct = ((val - min) / (max - min)) * 100;

            $el.css('--range-pct', pct + '%');

            var $output = $el.siblings('.mpb-range-value');
            if ($output.length) {
                var suffix = '';
                var id = $el.attr('id');
                if (id === 'mpb_width' || id === 'mpb_overlay_opacity') {
                    suffix = '%';
                } else if (id === 'mpb_height') {
                    suffix = 'px';
                }
                $output.text(val + suffix);
            }
        }

        $('.mpb-range').on('input change', function () {
            updateRangeSlider($(this));
        });

        // Initialize values on load.
        $('.mpb-range').each(function () {
            updateRangeSlider($(this));
        });

        // ── Conditional Settings Sections ───────────────
        function toggleConditionalSections() {
            // Trigger section.
            var triggerVal = $('input[name="mpb_show_modal"]:checked').val();
            if (triggerVal === 'onload') {
                $('.mpb-onclick-section').slideUp(200);
            } else {
                $('.mpb-onclick-section').slideDown(200);
            }

            // Custom design section.
            var designVal = $('input[name="modal_popup_design"]:checked').val();
            if (designVal === 'custom') {
                $('.mpb-custom-design-section').slideDown(200);
            } else {
                $('.mpb-custom-design-section').slideUp(200);
            }
        }

        toggleConditionalSections();
        $('input[name="mpb_show_modal"], input[name="modal_popup_design"]').on('change', toggleConditionalSections);

        // ── Copy to Clipboard ───────────────────────────
        $(document).on('click', '.mpb-copy-shortcode', function () {
            var $btn = $(this);
            var targetSel = $btn.data('target');
            var $input = $(targetSel);
            var text = $input.val();

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function () {
                    showCopySuccess($btn);
                });
            } else {
                // Fallback for older browsers.
                $input[0].select();
                document.execCommand('copy');
                showCopySuccess($btn);
            }
        });

        function showCopySuccess($btn) {
            var $msg = $btn.siblings('.mpb-copy-success');
            if ($msg.length) {
                $msg.fadeIn(200).delay(1500).fadeOut(400);
            } else {
                // Column button — brief visual feedback.
                var origText = $btn.text();
                $btn.text(mpb_admin_vars.copied_text || 'Copied!');
                setTimeout(function () {
                    $btn.text(origText);
                }, 1500);
            }
        }

        // ── Hide slug editor ────────────────────────────
        $('#edit-slug-box').hide();
    });

})(jQuery);
