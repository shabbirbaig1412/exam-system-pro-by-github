# Changelog

## 2026-08-12

### Phase 2 — Authoritative Class Consolidation

- Consolidated `ESP_ResultEngine`, `ESP_GradeEngine`, and `ESP_PositionEngine` under `includes/ResultEngine/`.
- Preserved unique result composition and position-assignment behavior.
- Preserved `ESP_PositionEngine::calculate()` database position recalculation.
- Removed obsolete `includes/Services/` implementations for the three target classes.
- Verified all 431 PHP files pass syntax validation.

### Result Integrity Fixes

- Enforced the configured overall pass percentage together with subject passing marks.
- Changed ranking to standard competition ranking and applied it to result, merit-list, and report paths.
- Added campus ownership fields and session/campus joins to prevent cross-campus or cross-session result mixing.
- Made result regeneration update the existing exam/student result record.
- Removed the development-only `esp_dd()` helper.
- Corrected the upgrade hook to invoke the existing migration class.

## Admin Panel Integration

- Added Campuses and Subject / Teacher Allocation to the active admin menu.
- Repaired admin page callbacks, forms, edit/delete links, notices, and nonce/capability checks.
- Added campus-scoped CRUD/list data and an admin campus switcher.
- Repaired marks selectors, loading, saving, validation navigation, and nonce references.
- Replaced manual result editing with Result Engine generation and read-only result tables.
- Connected report links to the registered Reports admin page and consolidated Settings on the school-settings UI.
- PHP syntax validation passed for 433 files; duplicate-class and missing-reference scans passed.
- Bumped the database version to `1.2.0` so campus ownership columns for classes, teachers, and allocations are migrated.
