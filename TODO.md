# Task: Fix controller namespace casing + enable admin login

## Goal
Fix the "Target class [...] does not exist" error caused by namespace casing mismatches between `routes/web.php` and the actual controller namespaces (Linux is case-sensitive), and ensure login as `PACAdmin` / `123456` reaches `/admin/dashboard`.

## Steps
- [x] 1. Identify all controller namespace casing mismatches in `routes/web.php`
- [x] 2. Standardized ALL controller namespaces to uppercase to match directories (`Admin`, `Dean`, `Teacher`, `Student`, `Parent`) — used `fix_namespaces.php` script
- [x] 3. Updated all route references to uppercase namespaces — used `fix_routes2.php`
- [x] 4. Fixed `ParentDashboardController` reference (mangled by edit_file, fixed via `fix_routes3.php`)
- [x] 5. Regenerated composer autoloader (`composer dump-autoload`)
- [x] 6. Cleared route cache (`php artisan route:clear`)
- [x] 7. Verified `php artisan route:list` — all 88 routes resolve with zero errors
- [x] 8. Seeded database (`php artisan db:seed`) — created roles + admin account
- [x] 9. Verified `PACAdmin` exists, is active (role_id=4), and password `123456` hashes match
- [x] 10. Cleaned up temporary fix scripts (`fix_routes*.php`, `fix_namespaces.php`)
- [x] 11. Admin login flow works: `/login` → POST `/signin` → `/admin/dashboard`

## Credentials
- **Username:** `PACAdmin` (or lowercase `pacadmin`)
- **Password:** `123456`

