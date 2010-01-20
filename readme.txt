=== FadeOut-Thumbshots ===
Contributors: CupRacer
Donate link: http://www.mynakedgirlfriend.de/
Tags: image, plugin, thumbshot, preview, tooltip, thumbnail
Requires at least: 2.9
Tested up to: 2.9.1
Stable tag: 1.4

This plugin dynamically shows a preview tooltip for hyperlinks on your WordPress site.


== Description ==

This plugin displays thumbnails for hyperlinks that exist on a Wordpress page.
It's configurable whether you'd like to preview all, only external or specially
marked hyperlinks.

This plugin uses the thumbshots of http://fadeout.de, a pretty cool site
which offers the thumbnail service for free.

For the tooltip effect a library called "jQuery Tooltip" is used (currently v1.3).
Find more about it here: http://bassistance.de/jquery-plugins/jquery-plugin-tooltip/



== Installation ==

1. Upload the directory 'fadeout' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make your settings through the 'Settings' menu in WordPress

== Frequently Asked Questions ==

= Were there any questions yet =

Nope. :-)


== Screenshots ==

1. This screenshot shows the tooltip preview which is shown while holding the mouse cursor over the WordPress.org hyperlink.


== Changelog ==

= 1.4 =
* Changed opacity from 0.8 to 0.9 for a better image representation.
* Added option to adjust the tooltip opacity.
* Corrected a padding value (at scaling 180px × 212px).

= 1.3 =
* Added the possibility to choose from different tooltip sizes.

= 1.2 =
* Surrounded the wp_head() function with the plugins_loaded() method
  to avoid some issues regarding the "headers already sent" error.
* Added a default configuration.

= 1.1 =
* corrected a dumb mistake (plugin path)

= 1.0 =
* This is the initial version.


== Upgrade Notice ==

= 1.1 =
None.

= 1.0 =
None.

