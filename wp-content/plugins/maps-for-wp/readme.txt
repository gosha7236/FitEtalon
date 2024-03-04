=== Maps for WP ===
Contributors: icopydoc
Donate link: https://pay.cloudtips.ru/p/45d8ff3f
Tags: yandex, google, maps, map, yandex maps
Requires at least: 4.4.2
Tested up to: 6.2.2
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A handy plugin for inserting Yandex and Google maps using shortcode.

== Description ==

A handy plugin for inserting Yandex and Google maps using shortcode.

= Adds Yandex or Google Map with one point =

[MapOnePoint id="" type="" lon="" lat="" zoom="" h="" img="" thover="" tclick=""]

*   "id" (required) - unique id
*   "type" (not required) - map layer (roadmap, satellite, hybrid, terrain)
*   "lon" (required) - longitude of the center of the map
*   "lat" (required) - latitude of the center of the map
*   "mstyle" (not required) - style of maps (default, blackwhite, blackout, сolorinversion)
*   "h" (not required) - Map height in pixels
*   "img" (not required) - URL image markers
*   "thover" (not required) - Text when pointing to a point
*   "tclick" (not required) - Text when clicking on a point

Example:

`[MapOnePoint id="m1" type="hybrid" lon="55.75197479670444" lat="37.617726067459024" zoom="5" h="200" img="http://site.ru/1.png" thover="Text when pointing to a point" tclick="Text when clicking on a poin. Some text"]`

= Adds Yandex or Google map with many points =

[MapManyPoints id="" type="" lat="" lon="" zoom="" h="" img="" points=""]

*   "id" (required) - unique id
*   "type" (not required) - map layer (roadmap, satellite, hybrid, terrain)
*   "lon" (required) - longitude of the center of the map
*   "lat" (required) - latitude of the center of the map
*   "mstyle" (not required) - style of maps (default, blackwhite, blackout, сolorinversion)
*   "h" (not required) - Map height in pixels
*   "img" (not required) - URL image markers
*   "points" - [lat point 1],[lon point 1],[text on hover 1],[text on click 1];[lat point 2],[lon point 2],[text on hover 2],[text on click 2] and so on...

Example:

`[[MapManyPoints id="m2" type="roadmap" lat="25" lon="30" zoom="2" h="250" points="25,-1,Text on hover this point, Text on click this point;-5,13,Text on hover this point, Text on click this point"]`


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the entire `yandex-maps-for-wp` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Yandex Maps->Settings screen to configure the plugin
1. Add the shortcode (`[MapOnePoint]` or `[MapManyPoints]`) to the page topic

== Frequently Asked Questions ==

= Is it possible for one page to contain 2 of the shortcode [OneManyPoints]? =

Yes. These shortcodes can be an unlimited number. Provided that the parameters 'id' are different.

= Is it possible for one page to contain 2 of the shortcode [MapManyPoints]? =

Yes.

== Screenshots ==

1. screenshot-1.png

== Changelog ==

= 1.2.1 =
* Fix bugs

= 1.2.0 =
* Added map styles

= 1.1.5 =
* Fix bugs.

= 1.1.4 =
* Fix bugs.

= 1.1.3 =
* Fix bugs.

= 1.1.2 =
* Fix bugs.

= 1.1.1 =
* Fix bugs.

= 1.1.0 =
Important: Version 1.1. not compatible with previous versions! It is not recommended to update the plugin from version 1.0.2!
* Fix bugs.
* Fixed plugin settings.
* Completely modified code.
* Added support for Google Maps!
* Changed the logic of the shortcode `[MapManyPoints]`.

= 1.0.2 =
* Fixed plugin settings.

= 1.0.1 =
* Fixed a bug in which maps appear at the top of the page.

= 1.0.0 =
* First relise.

== Upgrade Notice ==

= 1.2.1 =
* Fix bugs