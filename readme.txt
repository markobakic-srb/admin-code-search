=== Admin Code Search ===
Contributors: markobakic-srb
Tags: developer, code, search, admin tools, debugging
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Search code inside active themes and plugins directly from the WordPress admin area.

== Description ==

Admin Code Search is a lightweight developer utility for searching text inside active theme and plugin files from wp-admin.

Features:
- Admin-only access
- Search active plugins
- Search active theme and parent theme
- Custom file extensions
- Line-by-line matching
- Highlighted matches
- Clean results table

This plugin does not send data to external services.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the Plugins screen in WordPress
3. Go to Tools > Code Search
4. Enter a search term and run a search

== Frequently Asked Questions ==

= Who can use this plugin? =

Only administrators or users with the `manage_options` capability.

= What files are searched? =

The plugin searches active plugin files, the active theme, and the parent theme if different.

= Can I search file types other than PHP? =

Yes. Enter comma-separated extensions such as `php,inc,module`.

== Changelog ==

= 1.0.0 =
* Initial public release.

== Screenshots ==

1. Admin Code Search interface in Tools → Code Search.
2. Search results showing matching lines inside plugin and theme files.
