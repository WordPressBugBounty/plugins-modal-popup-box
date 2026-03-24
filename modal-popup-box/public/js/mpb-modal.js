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
     * Initialize all modals from the window.MPBModals config array.
     */
    function initModals() {
        if (typeof window.MPBModals === 'undefined' || !window.MPBModals.length) {
            return;
        }

        window.MPBModals.forEach(function (config) {
            initSingleModal(config);
        });
    }

    /**
     * Initialize a single modal instance.
     *
     * @param {Object} config - Modal configuration (id, showModal, animation).
     */
    function initSingleModal(config) {
        var id = config.id;
        var $modal = $('#modal-' + id);
        var $overlay = $('.mpb-md-overlay-' + id);
        var $wrapper = $('#mpb-wrapper-' + id);
        var $triggers = $('[data-modal="modal-' + id + '"]');

        if (!$modal.length) {
            return;
        }

        // ── On Button Click ─────────────────────────────
        if (config.showModal === 'onclick') {
            $triggers.on('click keypress', function (e) {
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
                // Calculate scrollbar width BEFORE hiding it.
                var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

                // Lock scroll BEFORE animation starts.
                $('html, body').addClass('mpb-modal-open');

                // Compensate for removed scrollbar.
                if (scrollbarWidth > 0) {
                    document.documentElement.style.paddingRight = scrollbarWidth + 'px';
                    document.body.style.paddingRight = scrollbarWidth + 'px';
                }

                // Show viewport wrapper.
                $wrapper.addClass('mpb-wrapper-show');

                // Make modal and overlay visible in initial animation state.
                $modal.css({ display: 'block', visibility: 'visible' });
                $overlay.show().css('z-index', '999');

                // Double-rAF: ensures browser PAINTS initial state
                // before adding md-show triggers CSS transition.
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        $modal.addClass('mpb-md-show');

                        var anim = config.animation;
                        if (anim === 'mpb-md-effect-17' || anim === 'mpb-md-effect-18' || anim === 'mpb-md-effect-19') {
                            $('html').addClass('mpb-md-perspective');
                        }
                    });
                });
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
     *
     * @param {jQuery} $modal   Modal element.
     * @param {jQuery} $overlay Overlay element.
     * @param {jQuery} $wrapper Wrapper element.
     * @param {Object} config   Modal config.
     */
    function openModal($modal, $overlay, $wrapper, config) {
        // Calculate scrollbar width BEFORE hiding it.
        var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

        // Lock scroll on both html and body.
        $('html, body').addClass('mpb-modal-open');

        // Compensate for removed scrollbar to prevent content jump.
        if (scrollbarWidth > 0) {
            document.documentElement.style.paddingRight = scrollbarWidth + 'px';
            document.body.style.paddingRight = scrollbarWidth + 'px';
        }

        // Show viewport wrapper.
        if ($wrapper && $wrapper.length) {
            $wrapper.addClass('mpb-wrapper-show');
        }

        // Make modal and overlay visible in initial animation state.
        $modal.css({ display: 'block', visibility: 'visible' });
        $overlay.show().css('z-index', '999');

        // Double-rAF for smooth animation.
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                $modal.addClass('mpb-md-show');

                // Focus first focusable element.
                var $focusable = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                if ($focusable.length) {
                    $focusable.first().focus();
                }
            });
        });
    }

    /**
     * Close a modal.
     *
     * @param {jQuery} $modal    Modal element.
     * @param {jQuery} $overlay  Overlay element.
     * @param {jQuery} $triggers Trigger elements (for focus return).
     * @param {number} id        Modal post ID.
     */
    function closeModal($modal, $overlay, $triggers, id) {
        $modal.removeClass('mpb-md-show');
        $('html').removeClass('mpb-md-perspective');
        $overlay.css('z-index', '0');

        // Hide wrapper.
        var $wrapper = $modal.closest('.mpb-modal-wrapper');
        if ($wrapper.length) {
            $wrapper.removeClass('mpb-wrapper-show');
        }

        // Remove scroll lock if no other modals are open.
        if (!$('.mpb-md-show').length) {
            $('html, body').removeClass('mpb-modal-open');
            // Remove scrollbar compensation.
            document.documentElement.style.paddingRight = '';
            document.body.style.paddingRight = '';
        }

        // Pause YouTube videos.
        pauseYouTubeVideo($modal);

        // Return focus to trigger.
        if ($triggers && $triggers.length) {
            $triggers.first().focus();
        }
    }

    /**
     * Pause any YouTube iframe inside the modal.
     *
     * @param {jQuery} $modal Modal element.
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
                } catch (e) {
                    // cross-origin error
                }
            }
        });
    }

    // ── Init on DOM Ready ───────────────────────────
    $(document).ready(initModals);

})(jQuery);
