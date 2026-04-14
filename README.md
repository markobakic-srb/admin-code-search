![Admin Code Search Banner](assets/github-banner.png)
# Admin Code Search

Search code inside active themes and plugins directly from the WordPress admin area.

---

## Description

Admin Code Search is a lightweight developer utility that lets you search code inside active themes and plugins without leaving the WordPress admin.

Built for developers who need quick insight into a codebase — whether you're tracking down a function, hook, class, or string — without opening an IDE or connecting via FTP.

---

## Features

- Admin-only access
- Search across active plugins
- Search active theme and parent theme
- Search MU plugins
- Support for custom file extensions (for example: php, js, css, inc)
- Case-sensitive or case-insensitive search
- Partial match, whole word match, or match entire line exactly
- Line-by-line scanning
- Highlighted matches
- Result count summary
- Result limit protection (first 500 matches)
- Clear button to reset search form and results
- Clean, readable results table

---

## Installation

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin
3. Go to **Tools → Code Search**
4. Enter a search term and run a search

---

## Usage

Enter any keyword, function name, hook, or string and scan your active plugins, themes, and MU plugins.

You can also:

- define which file extensions to include
- switch between case-sensitive and case-insensitive search
- choose between partial match, whole word match, and matching the entire line exactly
- clear the form and results with one click

---

## FAQ

**Who can use this plugin?**  
Only administrators or users with the `manage_options` capability.

**What files are searched?**  
Files in active plugins, the active theme, the parent theme (if used), and MU plugins.  
Inactive plugins and themes are not included.

**What is the difference between the match modes?**  
- **Partial match** finds the search term anywhere in a line  
- **Whole word match** finds the term as a distinct word  
- **Match entire line exactly** only returns results where the whole trimmed line exactly matches the search term

**Can I search file types other than PHP?**  
Yes. You can define custom file extensions such as `php, js, css, inc`.

**Does this affect site performance?**  
Search runs only when triggered manually in the admin.  
On very large sites, broad searches may take longer.

**Why do I only see 500 results?**  
To keep searches fast and manageable, the plugin limits output to the first 500 matches. If the limit is reached, refine your search term or narrow the search scope.

**Does this plugin modify any files?**  
No. The plugin is read-only.

**Is any data sent outside my site?**  
No. All searches are performed locally on your server.

---

## Privacy

This plugin does not send any data to external services.

---

## Screenshots

### 1. Admin Code Search interface in Tools → Code Search
![Admin Code Search interface](assets/screenshot-1.png)

### 2. Search input with custom file extensions
![Search input](assets/screenshot-2.png)

### 3. Results showing matches across plugin and theme files
![Results](assets/screenshot-3.png)

### 4. Detailed result with file path, line number, and highlighted match
![Detailed result](assets/screenshot-4.png)

---

## Changelog

### 1.2.2
- Added whole word match.
- Renamed exact line match to “Match entire line exactly” for clarity.
- Added a 500-result limit for broad searches.
- Added a warning when the result limit is reached.
- Added a Clear button to reset the search form and results.

### 1.2.1
- Added whole word match option.
- Renamed exact line match option to “Match entire line exactly” for clarity.
- Improved match mode labeling in the search results.

### 1.2.0
- Added partial match and exact line match options.
- Added MU Plugins scanning option.
- Improved search controls for better precision.

### 1.1.0
- Added case-sensitive search option
- Added result count summary
- Improved scanner handling for readable files
- Internal refactoring and codebase cleanup

### 1.0.0
- Initial public release.

---

## License

GPLv2 or later  
https://www.gnu.org/licenses/gpl-2.0.html
