/**
 * Modal Popup Box — Frontend Modal Script
 *
 * Handles modal open, close, overlay, keyboard accessibility,
 * focus trap, scroll lock, YouTube pause, and onload display.
 *
 * @package ModalPopupBox
 * @since   2.0.0
 */

(function ($) {
    'use strict';

    /**
     * Initialize all modals by finding .mpb-modal-wrapper elements in the DOM.
     * This bypasses the need for global window.MPBModals arrays and works better in FSE.
     */
    function initModals() {
        $('.mpb-modal-wrapper').each(function () {
            var $wrapper = $(this);
            var configData = $wrapper.attr('data-mpb-config');

            if (!configData) {
                return;
            }

            try {
                var config = JSON.parse(configData);

                // ── DOM Detachment ──
                // Move the wrapper to the document body to prevent theme clipping (FSE).
                $wrapper.appendTo('body');

                initSingleModal(config, $wrapper);
            } catch (e) {
                console.error('MPB: Invalid modal config', e);
            }
        });
    }

    /**
     * Initialize a single modal instance.
     *
     * @param {Object} config - Modal configuration (id, showModal, animation).
     * @param {jQuery} $wrapper - The specific wrapper element for this modal.
     */
    function initSingleModal(config, $wrapper) {
        var id = config.id;
        var $modal = $wrapper.find('#modal-' + id);
        var $overlay = $wrapper.find('.mpb-md-overlay-' + id);
        var $triggers = $('[data-modal="modal-' + id + '"]');

        if (!$modal.length) {
            return;
        }

        // ── On Button Click ─────────────────────────────
        if (config.showModal === 'onclick') {
            $(document).on('click keypress', '[data-modal="modal-' + id + '"]', function (e) {
                if (e.type === 'keypress' && e.which !== 13 && e.which !== 32) {
                    return;
                }
                e.preventDefault();
                openModal($modal, $overlay, $wrapper, config);
            });
        }

        // ── On Page Load ────────────────────────────────
        if (config.showModal === 'onload') {
            var delayMs = (config.delay || 0) * 1000;

            setTimeout(function () {
                openModal($modal, $overlay, $wrapper, config);
            }, delayMs);
        }

        // ── Close Handlers ──────────────────────────────
        $modal.find('.mpb-md-close').on('click', function (e) {
            e.stopPropagation();
            closeModal($modal, $overlay, $triggers, id);
        });

        $overlay.on('click', function () {
            closeModal($modal, $overlay, $triggers, id);
        });

        // ── ESC Key Close ───────────────────────────────
        $(document).on('keydown.mpb-' + id, function (e) {
            if (e.key === 'Escape' && $modal.hasClass('mpb-md-show')) {
                closeModal($modal, $overlay, $triggers, id);
            }
        });
    }

    /**
     * Open a modal.
     */
    function openModal($modal, $overlay, $wrapper, config) {
        // Calculate scrollbar width
        var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

        // Lock scroll
        $('html, body').addClass('mpb-modal-open');

        if (scrollbarWidth > 0) {
            document.documentElement.style.paddingRight = scrollbarWidth + 'px';
            document.body.style.paddingRight = scrollbarWidth + 'px';
        }

        $wrapper.addClass('mpb-wrapper-show');
        $modal.css({ display: 'block', visibility: 'visible' });
        $overlay.show().css('z-index', '999');

        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                $modal.addClass('mpb-md-show');

                var anim = config.animation;
                if (anim === 'mpb-md-effect-17' || anim === 'mpb-md-effect-18' || anim === 'mpb-md-effect-19') {
                    $('html').addClass('mpb-md-perspective');
                }

                var $focusable = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                if ($focusable.length) {
                    $focusable.first().focus();
                }
            });
        });
    }

    /**
     * Close a modal.
     */
    function closeModal($modal, $overlay, $triggers, id) {
        $modal.removeClass('mpb-md-show');
        $('html').removeClass('mpb-md-perspective');
        $overlay.css('z-index', '0');

        var $wrapper = $modal.closest('.mpb-modal-wrapper');
        if ($wrapper.length) {
            $wrapper.removeClass('mpb-wrapper-show');
        }

        if (!$('.mpb-md-show').length) {
            $('html, body').removeClass('mpb-modal-open');
            document.documentElement.style.paddingRight = '';
            document.body.style.paddingRight = '';
        }

        pauseYouTubeVideo($modal);

        if ($triggers && $triggers.length) {
            $triggers.first().focus();
        }
    }

    /**
     * Pause any YouTube iframe inside the modal.
     */
    function pauseYouTubeVideo($modal) {
        $modal.find('iframe').each(function () {
            var src = $(this).attr('src');
            if (src && (src.indexOf('youtube.com') !== -1 || src.indexOf('youtu.be') !== -1)) {
                try {
                    this.contentWindow.postMessage(
                        JSON.stringify({ event: 'command', func: 'pauseVideo', args: '' }),
                        '*'
                    );
                } catch (e) {}
            }
        });
    }

    // ── Init on DOM Ready ───────────────────────────
    $(document).ready(initModals);

})(jQuery);
