=== Modal Popup Box — Popup Maker & Popup Builder ===
Contributors: awordpresslife, razipathhan, hanif0991, muhammadshahid, fkfaisalkhan007, sharikkhan007, zishlife, FARAZFRANK
Donate link: https://paypal.me/awplife
Tags: popup builder, popup maker, offer, news, pop up box
Requires at least: 5.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 2.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A fast popup maker to show news, offer, videos, forms, and more. Easily create an amazing popup and modal boxes.

== Description ==

Make easy popup boxes on your WordPress site. Show important news, run an offer, or capture new leads. This popup builder places content in a nice modal.

Create a custom popup maker fast. It uses simple CSS settings. Show images, videos, shortcodes, and more. It is fully responsive on all devices.

### Smart Popup Maker for News and Sales

Use this popup builder to keep readers on your site. Drive attention to a new special offer. Share urgent news updates fast. 

### Key Free Features for Your Offer Popup

*   **Two Trigger Modes** — Open on page load or on button click.
*   **Open Delay Timer** — Set a delay before the popup appears on screen.
*   **5 Color Presets** — Pick blue, red, green, purple, or orange themes.
*   **4 Animation Effects** — Fade & Scale, Slide, Side Fall, and 3D Flip.
*   **Overlay Opacity** — Soften background dimming from 0% to 100%.
*   **Edit Button Text** — Change popup button text, size, and color fast.
*   **Shortcode Maker** — Place your modal popup anywhere with one code.
*   **Mobile Ready** — Your popup looks good on any screen size.
*   **Embed Items** — Show forms, videos, and grids inside the popup maker.
*   **Easy Admin** — Simple settings panel built for normal users.

### Add Any Item to Your Popup Builder

*   **Media:** Rich images, smart galleries, and sliders.
*   **Videos:** Embed YouTube and Vimeo clips with ease.
*   **Forms:** Load Contact Form 7 and other form tools.
*   **Promotions:** Share a unique coupon, sale, or offer.
*   **Social Data:** Connect Facebook, Twitter, or social streams.
*   **News Feeds:** Highlight latest news to visitors right away.

== How To Use This Free Popup Builder? ==

https://www.youtube.com/watch?v=jbYiZNe6kr4

== Installation ==

1.  Install "Modal Popup Box" from the plugin store.
2.  Click Activate.
3.  Go to **Modal Popup Box → Add New** on the side menu.
4.  Enter news or offer text in the editor.
5.  Copy your popup code and paste it to a live page.

== Frequently Asked Questions ==

= How do I make a new popup builder item? =
Go to **Modal Popup Box → Add New**. Add text, pick colors, set your trigger, and hit publish.

= Can I show a special offer popup on load? =
Yes. Go to the **Modal Popup** tab and click "On Page Load". It will fire when the page loads.

= Is this popup maker good for breaking news? =
Yes. You can edit text fast to share new news or an offer right when users enter.

= Does the free popup builder limit animations? =
The free tool has 4 effects. Upgrading unlocks 15 more styles.

= Can I embed a form inside my offer popup? =
Yes. Just copy the form shortcode and paste it right into the popup maker editor.

= Will the popup builder work with Elementor? =
Yes. Use the shortcode in any page builder like Divi or Elementor.

**Still need help with your popup maker?**
Visit the [support forum](https://wordpress.org/support/plugin/modal-popup-box/) for real human support.

== Premium Version & Demos ==

Upgrade to the premium version for advanced features:

*   **19 Open Animation Effects** — Fall, 3D Slit, Super Scaled, Blur, Rotate, and more.
*   **Advanced Triggers** — Exit Intent, Scroll Percentage, and User Inactivity.
*   **Full Color Customization** — Header, content, footer, overlay, and close button colors.
*   **Header & Content Styling** — Font sizes, alignment, background colors, padding, and animations.
*   **Dual Footer Buttons** — Two buttons with individual URLs, colors, sizes, and animations.
*   **Overlay Color Picker** — Choose any color for the overlay background.
*   **Open/Close Speed Control** — Fine-tune transition timing.
*   **Border Radius & Box Shadow** — Rounded corners and shadow depth options.
*   **Close Button Styles** — Icon, text, or both with custom colors.
*   **Cookie Dismiss** — Hide modal for returning visitors using cookies.
*   **Page Targeting** — Include or exclude modals on specific pages.
*   **Scheduling** — Set start/end dates for time-limited modals.
*   **Auto-Close** — Automatically dismiss the modal after a set time.
*   **Clone/Duplicate** — Instantly copy modals with all settings.
*   **Import/Export** — Migrate modal settings between sites via JSON.

*   [Free Version Demo](https://awplife.com/demo/modal-popup-box-free-wordpress-plugin/)
*   [Premium Version Demo](https://awplife.com/demo/model-popup-box-premium/)
*   [Upgrade to Premium](https://awplife.com/wordpress-plugins/modal-popup-box-wordpress-plugin/)

== Screenshots ==

1.  Gallery in a Pop Up Box
2.  YouTube Video in a Pop Up Box
3.  Soundcloud Audio in a Pop Up Box
4.  Contact Form in a Pop Up Box
5.  Instagram-style Gallery in a Pop Up Box
6.  Filterable Portfolio Gallery in a Pop Up Box

== Changelog ==

= 2.1.2 =
* Date: 30 June, 2026
* Fixed: Abrupt exit transitions by adding a 300ms closing delay to allow CSS transitions and overlay fades to play smoothly.
* Fixed: Style loss and overrides when multiple shortcodes are rendered concurrently or stylesheet is printed in the head early by utilizing unique style handles.
* Enhancement: Namespaced close button, body, and button padding rules to target individual modal IDs and prevent cross-modal styling conflicts.

= 2.1.1 =
* Date: 12 May, 2026
* Feature: Integrated high-definition in-dashboard Documentation & Tutorial guide.
* Feature: Added standalone "Our Plugins" & "Our Themes" showcases for broader ecosystem access.
* Enhancement: Modularized logic architecture to isolate settings and doc handlers for cleaner codebase.
* Enhancement: Optimized SEO readability standards across descriptions and saturated key terms (Popup Builder/Maker).
* Security: Completely excised redundant custom CSS inputs in compliance with hardened WordPress.org guidelines.

= 2.1.0 =
* Fix: Implemented full compatibility with WordPress Block Themes (FSE) like Twenty Twenty-Five.

= 2.0.2 =
* Enhancement: Migrated configuration delivery from inline scripts to HTML data-attributes for better reliability in block-based rendering.
* Enhancement: Replaced `wp_add_inline_style()` with native HTML5 `<style>` block injection to ensure per-modal styling renders reliably in FSE themes.
* Enhancement: Refactored JavaScript to automatically detach modal wrappers and append them to the document body, preventing CSS clipping from theme stacking contexts.

= 2.0.1 =
* Security: Implemented granular data sanitization for admin settings and AJAX imports.
* Namespace Safety: Applied 'mpb-' prefix to all generic CSS classes to prevent conflicts.
* Performance: Migrated dynamic CSS to wp_add_inline_style() for CSP compliance.
* Accessibility: Implemented keyboard focus trap and ARIA-compliant HTML structure.
* YouTube Fix: Added automatic 'enablejsapi=1' injection for reliable auto-pause on close.
* Fixed: Critical fatal error related to versioning constant mismatch.
* Fully hardened for WordPress.org repository compliance.

= 2.0.0 =
* Enhancement: Removed Bootstrap dependency and replaced with custom lightweight utility classes to improve performance and prevent theme conflicts.
* New Feature: Added "Custom" color design option with a modal background color picker for greater design flexibility.
* Enhancement: Refined close button customization — removed size selection for a consistent Medium size and added background, text, and icon color settings.
* Enhancement: Added a smooth hover effect for the close icon with a matching border color.
* Improvement: Modernized settings page layout with a responsive 9/3 column grid and a premium-style action bar.
* Major Update: Complete plugin rewrite with modern architecture
* New Feature: 5 color presets (Blue, Red, Green, Purple, Orange)
* New Feature: 4 animation effects (Fade & Scale, Slide Right, Side Fall, 3D Flip)
* New Feature: Open Delay timer (0–60 seconds) for page load trigger
* New Feature: Overlay Opacity control (0–100%)
* New Feature: Redesigned admin dashboard with premium-style UI
* Enhancement: Improved modal centering across all themes
* Enhancement: Removed legacy code and unused dependencies
* Security: Improved data sanitization and escaping throughout
* Security: Fixed PHP Object Injection vulnerability
* Security: Fixed XSS vulnerability in custom CSS output

= 1.6.2 =
* Security Fix: Fixed PHP Object Injection vulnerability (Critical)
* Security Fix: Fixed XSS vulnerability in custom CSS output
* Security Fix: Improved data sanitization with proper escaping functions
* Bug Fix: Fixed undefined variable $columns causing PHP notices
* Bug Fix: Replaced deprecated wp_reset_query() with wp_reset_postdata()
* Bug Fix: Added missing isset() checks on POST data
* Enhancement: Changed capability check to allow editors to save settings
* Enhancement: Improved backward compatibility for legacy data formats
* Testing plugin for WordPress 6.9

= 1.6.1 =
* Testing plugin for WordPress 6.8.3

= 1.6.0 =
* Testing plugin for WordPress 6.8.1

= 1.5.7 =
* WordPress security issues fixed
* Testing plugin for WordPress 6.6.2

= 1.5.5 =
* Testing plugin for WordPress 6.5.5
* Hide/show fixed on settings page
* Admin demo link fixed

= 1.5.3 =
* WordPress security issues fixed
* Testing plugin for WordPress 6.4.3

= 1.5.2 =
* Bug Fix
* Testing plugin for WordPress 6.4.3

== Upgrade Notice ==

= 2.1.2 =
Fixed styling conflicts, resolved style loss for multiple modals, and implemented smooth modal exit transitions.

= 2.1.1 =
Minor Maintenance: Overhauled internal onboarding guide, sanitized redundant input vectors, and integrated unified ecosystem submenus.

= 2.1.0 =
Major update: Implemented full compatibility with WordPress Block Themes (FSE) and Twenty Twenty-Five.
