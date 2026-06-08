# Weekly Report System

Laravel 13 scaffold for the Weekly Report System, built from the docs in `claude.md`, `design.md`, `flow.md`, `prompt.md`, and `warna.md`, with UI aligned to the HTML templates in `template_desain/` and branding from `public/logo.png`.

## What’s included

- User dashboard with weekly summary cards and activity trend.
- Daily activity input form with validation.
- My Reports and System Reports pages.
- Admin dashboard and user management screens.
- Profile/settings page.
- Daily activity model, migration, summary service, and reminder command stubs.

## Key routes

- `/dashboard`
- `/activities/create`
- `/reports`
- `/reports/system`
- `/admin/dashboard`
- `/admin/users`
- `/profile`

## Run it

```bash
php artisan serve
```

## Check it

```bash
php artisan test
php artisan view:cache
```

## Reminder commands

- `php artisan weekly-report:daily-reminder`
- `php artisan weekly-report:weekly-reminder`

## Notes

- The current scaffold uses the provided design language directly in Blade, so it renders without requiring a frontend build step first.
- `public/logo.png` is the shared brand asset used in the sidebar and topbar.
