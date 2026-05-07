# Fix Report Module UI Bug - Hidden Text and Boxes

## Plan Overview
Fix wide tables lacking horizontal scroll in CDR/SOE views, enhance responsiveness.

## Steps:
- [x] 1. Add `overflow-x-auto` wrapper around tables in `resources/views/reports/cdr.blade.php`
- [x] 2. Add `overflow-x-auto` wrapper around tables in `resources/views/reports/soe.blade.php`
- [x] 3. Enhance table wrapper in `resources/views/reports/summary.blade.php`
- [x] 4. Remove `overflow-hidden` from cards in `resources/views/reports/index.blade.php`
- [ ] 5. Test responsiveness on different screen sizes
- [ ] 6. Verify no clipping in layout `resources/views/layouts/app.blade.php`
- [ ] 7. Mark complete and attempt_completion

Current progress: 4/7 completed
