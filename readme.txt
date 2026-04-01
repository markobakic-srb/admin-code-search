=== Admin Code Search ===
Contributors: marbak
Tags: developer, code, search, admin tools, debugging
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.2.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Search code across active plugins, themes, and MU plugins directly from the WordPress admin.

== Description ==

Admin Code Search is a lightweight developer tool that lets you search code directly from the WordPress admin area — no FTP or terminal access required.

It scans active plugins, themes, and MU plugins line-by-line and shows matching results with file paths and line numbers.

Designed for quick debugging, code tracing, and locating specific hooks, functions, or strings across a site.

A simple, fast code search tool for developers working inside WordPress.

== Why use Admin Code Search? ==

Searching through plugin and theme files manually is slow and often requires FTP, file manager access, or local copies.

Admin Code Search brings that functionality directly into wp-admin, allowing you to:

– Search plugin and theme code instantly  
– Locate functions, hooks, and strings across files  
– Debug third-party plugins more efficiently  
– Work directly on live environments without leaving WordPress

== Features ==

- Search inside active plugins, themes, and MU plugins
- Case-sensitive or case-insensitive search
- Partial match or exact line match
- Custom file extensions (e.g. php, js, css)
- Line-by-line scanning for better performance on large codebases
- Displays file path, line number, and highlighted match
- Excludes common heavy directories (vendor, node_modules, uploads, cache, .git, .svn)
- Admin-only access for security

== Typical Use Cases ==

- Locate where a function or hook is defined
- Find all occurrences of a specific string
- Debug custom integrations or third-party plugins
– Debug issues without FTP access  
- Quickly explore unfamiliar codebases without leaving wp-admin

== Who is this for? ==

– WordPress developers  
– Freelancers working on client sites  
– Agencies maintaining multiple projects  
– Anyone who needs quick code search inside WordPress  

== Notes ==

Large searches may take longer on sites with many plugins or large codebases. Results are processed in real time.

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
The plugin scans active plugin files, the active theme, the parent theme (if different), and MU plugins.

= What is the difference between partial match and exact line match? =
Partial match finds the search term anywhere within a line. Exact line match only returns results where the entire trimmed line exactly matches the search term.

= Can I search file types other than PHP? =
Yes. You can enter comma-separated extensions such as `php,js,css,inc`.

= Will this affect site performance? =
Search runs on demand and only when triggered by an admin. On very large sites, searches may take a few seconds.

= Does it search WordPress core files? =
No. The plugin is limited to plugins, themes, and MU plugins.

= Is this plugin safe to use on production sites? =
Yes. It is read-only and does not modify any files or data.

== Screenshots ==

1. Admin Code Search interface in Tools → Code Search
2. Search input with custom file extensions
3. Results showing matches across plugin and theme files
4. Detailed result with file path, line number, and highlighted match

== Changelog ==

= 1.2.1 =
* Added whole word match option.
* Renamed exact line match option to “Match entire line exactly” for clarity.
* Improved match mode labeling in the search results.

= 1.2.0 =
* Added partial match and exact line match options.
* Added MU Plugins scanning option.
* Improved search controls for better precision.

= 1.1.0 =
* Added case-sensitive search option.
* Added result count summary.
* Improved scanner handling for readable files.

= 1.0.0 =
* Initial public release.