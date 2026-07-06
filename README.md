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

## Waha WhatsApp API setup

This project includes a local Waha WhatsApp API service via Docker.

1. Copy the Waha Docker env file and fill credentials:

```bash
cp docker/waha.env.example docker/waha.env
```

2. Start only the Waha service:

```bash
docker compose up -d waha
```

3. Set your app `.env` values:

```dotenv
WAHA_BASE_URL=http://localhost:3000
WAHA_API_KEY=your-waha-api-key
WAHA_SESSION=default
WAHA_TIMEOUT=10
WAHA_DEFAULT_CHAT=6281234567890@g.us
```

4. Open Waha dashboard in your browser if needed and connect your WhatsApp session.

5. In the admin weekly plan form, enable "Kirim ke WhatsApp" and optionally provide a chat id.

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
