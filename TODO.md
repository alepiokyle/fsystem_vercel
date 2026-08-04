# TODO: Change "EGC" branding to "eGrade Connect" with login-form animation & styling

## Steps

- [x] 1. Change `<span class="egc-logo-text">EGC</span>` → `eGrade Connect` in all 11 layout files (components/ + layouts/)
- [x] 2. Ensure `sidebar-popup-enhanced.css` (animation/gradient CSS) is loaded in the active `components/*` layout files
- [x] 3. Update page titles (`FSY | Dashboard` → `eGrade Connect | Dashboard`) in header/layout files
- [x] 4. Update `.env` APP_NAME → `eGrade Connect`
- [x] 5. Clear compiled view cache: `php artisan view:clear`
- [x] 6. Verify CSS animation classes (`egc-shine`/`egc-fadeSlide`) match login form in `sidebar-popup-enhanced.css`
- [x] 7. Copy CSS files to `public/resources/css/` so `asset()` URLs resolve (animation actually loads)

