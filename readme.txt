=== Admin Code Search ===
Contributors: marbak
Tags: developer, code, search, admin tools, debugging
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Search code inside active themes and plugins directly from the WordPress admin area.

== Description ==

Admin Code Search is a lightweight developer utility that lets you search code inside active themes and plugins directly from the WordPress admin. Designed for developers who need quick insight into code without leaving wp-admin.

Useful when you need to quickly locate a function, hook, class, or string without leaving the dashboard or accessing files via FTP or IDE.

Features:
- Admin-only access
- Search across active plugins
- Search active theme (including parent theme)
- Support for custom file extensions
- Line-by-line results
- Highlighted matches
- Clean, readable results table

= Privacy =

This plugin does not send any data to external services.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the Plugins screen in WordPress
3. Go to Tools > Code Search
4. Enter a search term and run a search

== Frequently Asked Questions ==

= Who can use this plugin? =

Only administrators or users with the `manage_options` capability.

= What files are searched? =

The plugin searches files in active plugins, the active theme, and the parent theme (if used).
Inactive plugins and themes are not included.

= Can I search file types other than PHP? =

Yes. You can define custom file extensions (for example: php, js, css, inc).

= Does this affect site performance? =

Search runs only when you perform it manually in the admin.
It does not run in the background or affect frontend performance.

= Does this plugin modify any files? =

No. The plugin is read-only and does not change any files.

= Is any data sent outside my site? =

No. All searches are performed locally on your server.

== Screenshots ==

1. Admin Code Search interface in Tools → Code Search
2. Search input with custom file extensions
3. Results showing matches across plugin and theme files
4. Detailed result with file path, line number, and highlighted match

== Changelog ==

= 1.1.0 =
* Added case-sensitive search option.
* Added result count summary.
* Improved scanner handling for readable files.

= 1.0.0 =
* Initial public release.