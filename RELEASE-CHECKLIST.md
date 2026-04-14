# Release Checklist

## Before release

1. Update version in `admin-code-search.php`
2. Update `ADCOSE_VERSION`
3. Update `Stable tag` in `readme.txt`
4. Update changelog in `readme.txt`
5. Update changelog in `README.md`
6. Test plugin locally
7. Run Plugin Check if needed
8. Check `WP_DEBUG` / `debug.log`
9. Commit and push to GitHub
10. Create installable ZIP from `admin-code-search/`

## WordPress.org release

11. Copy updated plugin files to SVN `/trunk/`
12. Commit trunk
13. Copy trunk to `/tags/x.x.x/`
14. Add and commit tag
15. Verify plugin page on WordPress.org

## Optional but recommended

16. Create GitHub Release
17. Upload installable ZIP to GitHub Release
18. Verify screenshots, banner, and icon still display correctly on WordPress.org