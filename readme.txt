=== Orange Confort+ ===
Contributors: RavanH
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ravanhagen%40gmail%2ecom&item_name=Orange%20Confort%20Plus
Tags: accessibility, orange confort, confort+, WP Consent API
Tested up to: 6.5
Stable tag: 0.5
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add the Orange Confort+ accessibility toolbar to your WordPress site.

== Description ==

[Orange Confort+](https://confort-plus.orange.com/index_en.html) aims to enhance user experience on your website. It works best when your website is fully accessible.

Orange Confort+ does **not** fix website accessibility issues: blocking points stay blocking points, with or without Orange Confort+.

= Toolbar features =

* Typography: font size, word-spacing, letter-spacing, line-height, font-face (Arial, Luciole, Open Sans, Open Dyslexic and Accessible DfA).
* Layout: cancel layout, force left-aligned text, number list items, customize links appearance, display a reading mask.
* Colors: modify foreground and background colors.
* Behavior: direct access to main content on page load, automatic selection of page clickable elements with a user defined delay, page scrolling on simple user on hover.

= Plugin features =

* Toolbar and button position can be set on Settings > Reading.
* Compatible with many Cookie Consent plugins when used in combination with [WP Consent API](https://wordpress.org/plugins/wp-consent-api/)
* WordPress Multisite compatible.
* Custom button position with a shortcode.

= Shortcode =

A shortcode **ocplus_button** is available to allow giving the Orange Confort+ button a custom location.

	[ocplus_button style="outline" color="black" background_color="" /]

Add this shortcode (header, sidebar or footer) where you wish the button to appear. The shortcode will generate a Button block with one button "Confort +".

These parameters are available to make it match your site theme more closely:

* **style** for the button style; can be set to fill or outline (default).
* **color** set the text color and (if applicable) outline color (default black, note that the + sign will remain orange)
* **bgcolor** sets the button background color.

= Privacy / GDPR =

This plugin does not collect any user or visitor data. The Orange Confort+ accessibility toolbar uses two functional browser cookies, used for storing user selected accessibility options.

* UCI42 - Stores user toolbar settings; set at page load; domain specific; expires after 1 year.
* uci-bl - Stores toolbar on/off toggle; set when toolbar toggle is used; domain specific; session only.

Please update your site's GDPR/Cookie Consent documentation to reflect this information.

This plugin is compatible with any Cookie Consent plugin that supports the WP Consent API. At this time, the WP Consent API proposal has not been merged into core yet, so you'll need to install and acivate the [WP Consent API](https://wordpress.org/plugins/wp-consent-api/) plugin.

== Screenshots ==

1. The Orange Confort+ accessibility toolbar.
2. Enlarging characters, changing the fonts and the spacing in the text: useful for dyslexic users, users with vision problems, or simply subject to visual fatigue.
3. Changing the layout, displaying a reading rule: mainly useful for visually impaired and cognitively impaired users who have difficulty identifying the information on the page, as well as motor disabled users who can’t use the mouse or those using keyboard navigation only.
4. Choosing a custom palette for the text color and page background.
5. Advanced behavior tools and options.

== Changelog ==

= 0.5 =
20240629
* New toolbar position: Window top
* Shortcode with parameters style, color, bgcolor for custom button position.

= 0.4 =
20240609
* Toolbar Positions: Top/bottom, left/right

= 0.3 =
20240607
* WP Consent API compatibility

= 0.2 =
20240607
* Button position: bottom screen (fixed)

= 0.1 =
20240605
* Initial implementation, Orange Confort+ script version 4.3.3
