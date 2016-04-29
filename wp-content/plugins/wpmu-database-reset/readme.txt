=== WPMU Database Reset ===
Contributors: shazdeh
Plugin Name: WPMU Database Reset
Tags: database, reset, restore, default, developer
Requires at least: 4.4
Tested up to: 4.5
Stable tag: 0.2

Clean up a single site in a WP network, by removing all posts, comments, terms and media files. A clean slate for the site.

== Description ==

The WordPress Database Reset plugin allows you to reset the database back to its default settings without having to delete the site and recreate it.

Useful tool for theme and plugin developers who often have to clean up the mess and start over.

== Installation ==

1. Upload the whole plugin directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Tools > Database Reset
4. Enjoy!

== Screenshots ==

1. Admin interface

== Changelogs ==

= 0.2 =
* Remove custom database tables after reset

= 0.1.3 =
* Preserve Site Title and Site Language after reset

= 0.1.2 =
* Clear wp term meta table after reset
* Fix issue of sufficient permissions error after database reset

= 0.1.1 =
* Fix plugin not functioning