=== Modal Popup Box ===
Contributors: awordpresslife, razipathhan, hanif0991, muhammadshahid, fkfaisalkhan007, sharikkhan007, zishlife, FARAZFRANK
Donate link: https://paypal.me/awplife
Tags: popup builder, modal popup, pop up box, responsive popups, popup maker
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 2.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create and manage customizable modal popup boxes with CSS animations. Embed images, videos, forms, shortcodes, and more.

== Description ==

Modal Popup Box provides an easy way to add versatile popup boxes to your WordPress website. Display announcements, capture leads, showcase products, or embed any content inside a beautifully animated modal.

= Free Version Features =

*   **Two Trigger Modes** — Open on page load or on button click.
*   **Open Delay Timer** — Set a delay (0–60 seconds) before the modal appears on page load.
*   **5 Color Presets** — Blue, Red, Green, Purple, and Orange design themes.
*   **4 Animation Effects** — Fade & Scale, Slide Right, Side Fall, and 3D Flip.
*   **Overlay Opacity Control** — Adjust background dimming from 0% to 100%.
*   **Customizable Button** — Control trigger button text, size, and colors.
*   **Shortcode Support** — Place modals anywhere with a simple shortcode.
*   **Custom CSS** — Add your own styles for full design control.
*   **Responsive Design** — Modals look great on all screen sizes.
*   **Embed Anything** — Images, YouTube/Vimeo videos, Contact Form 7, sliders, galleries, and content from any shortcode-based plugin.
*   **Modern Admin Dashboard** — Clean, tabbed settings interface.

= Embed Any Content =

*   **Media:** Images, galleries, and sliders.
*   **Videos:** YouTube and Vimeo embeds.
*   **Forms:** Contact Form 7 and other form plugins.
*   **Promotions:** Coupon codes, discounts, and announcements.
*   **Social Media:** Facebook, Twitter, and Instagram feeds.
*   **Plugin Content:** Anything with a shortcode.

== How To Use Free Modal Popup Plugin? ==

https://www.youtube.com/watch?v=jbYiZNe6kr4

== Installation ==

1.  Install "Modal Popup Box" from the WordPress plugin directory or upload the plugin files.
2.  Activate the plugin.
3.  Go to **Modal Popup Box → Add New Modal Popup Box** in your dashboard.
4.  Add your content using the WordPress editor, configure your settings, and publish.
5.  Copy the generated shortcode and paste it into any page, post, or widget.

== Frequently Asked Questions ==

= How do I create a modal popup? =
Navigate to **Modal Popup Box → Add New Modal Popup Box**, enter your content, configure the trigger and design settings, then publish.

= Can I show the modal automatically on page load? =
Yes. In the **Modal Popup** tab, select "On Page Load" as the trigger. You can also set a delay timer in the **Config** tab.

= Can I control the overlay darkness? =
Yes. The **Overlay Opacity** slider in the **Config** tab lets you adjust from fully transparent (0%) to fully opaque (100%).

= Does the free version include animations? =
Yes. The free version includes 4 animation effects. The premium version unlocks all 19.

= Can I embed Contact Form 7 inside a modal? =
Yes. Simply paste the Contact Form 7 shortcode into the modal content editor.

= Does it work with page builders? =
Yes. Use the shortcode in any page builder that supports shortcodes (Elementor, Beaver Builder, Divi, etc.).

**Have more questions?**
Visit the [support forum](https://wordpress.org/support/plugin/modal-popup-box/) for help.

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

= 1.5.9 =
* Testing plugin for WordPress 6.7.2

= 1.5.8 =
* Testing plugin for WordPress 6.7.1

= 1.5.7 =
* WordPress security issues fixed
* Testing plugin for WordPress 6.6.2

= 1.5.6 =
* Testing plugin for WordPress 6.6.2

= 1.5.5 =
* Testing plugin for WordPress 6.5.5
* Hide/show fixed on settings page
* Admin demo link fixed

= 1.5.4 =
* Testing plugin for WordPress 6.5.4

= 1.5.3 =
* WordPress security issues fixed
* Testing plugin for WordPress 6.4.3

= 1.5.2 =
* Bug Fix
* Testing plugin for WordPress 6.4.3

= 1.5.1 =
* Bug Fix
* Testing plugin for WordPress 6.4.2

= 1.5.0 =
* Bug Fix
* Testing plugin for WordPress 6.4.2

= 1.4.9 =
* Tested on WordPress 6.3.2

= 1.4.8 =
* Tested on WordPress 6.3.1

= 1.4.7 =
* Tested on WordPress 6.2.2

= 1.4.5 =
* Tested on WordPress 6.1.1

= 1.4.3 =
* Coding bugs fixed
* Tested on WordPress 6.0.3

= 1.4.2 =
* Tested for WordPress 6.0.1

= 1.4.1 =
* Tested for WordPress 5.9.3

= 1.4.0 =
* Disable Bootstrap CSS option added
* Tested for WordPress 5.9

== Upgrade Notice ==

= 2.0.1 =
Minor update: Removed specific animation effects (Newspaper, Sticky Up, 3D Sign) from the settings UI.

= 2.0.0 =