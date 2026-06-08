# TODO - Weekly Report System (UI sesuai template_desain)

## Tahap 1: Stabilitas
- [x] Migrasi DB (daily_activities, weekly_reports, dll) sudah jalan
- [x] Fix route yang dipanggil sidebar (hindari 500)
- [x] `php artisan test` sukses (25 passed)

## Tahap 2: UI Alignment dengan template_desain
- [x] Ubah `resources/views/dashboard/user.blade.php` mengikuti layout template:
  - CTA “Input Activity Today”
  - 4 kartu summary (Total/Selesai/Progress/Kendala)
  - tabel “Recent Daily Activity”
  - kartu “Weekly Report Preview/Generation” (jika belum ada di view saat ini)
  - “Report Progress” snapshot/badge (jika ada/atau dibuat sesuai data)
- [x] Ubah `resources/views/activities/create.blade.php` mengikuti template:
  - heading + draft auto-saved pill
  - form layout + styling
  - draft table section (jika perlu di-render dari drafts yang ada)
- [x] Ubah `resources/views/reports/system.blade.php` mengikuti template:
  - filter bar + export buttons (UI)
  - 4 kartu summary
  - table “System Status Table”
- [x] Ubah `resources/views/admin/users/index.blade.php` mengikuti template:
  - search/filters UI (UI)
  - table columns + status badges

## Tahap 3: Validasi
- [ ] Jalankan `php artisan view:clear`
- [ ] Jalankan `php artisan test`
- [ ] Cek rendering manual untuk route:
  - `/dashboard/user`
  - `/activities/create`
  - `/reports/system`
  - `/admin/users`

