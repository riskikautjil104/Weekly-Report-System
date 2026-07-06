<?php

use App\Models\User;
use App\Services\WeeklyReportArchiveService;
use App\Services\WahaClient;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('weekly-report:daily-reminder {--dry-run : Show recipients without sending WhatsApp messages}', function (WahaClient $waha): void {
    $today = today()->toDateString();

    $users = User::query()
        ->whereNotNull('whatsapp_number')
        ->where('whatsapp_number', '!=', '')
        ->whereDoesntHave('dailyActivities', fn($query) => $query->whereDate('tanggal', $today))
        ->orderBy('name')
        ->get();

    $message = 'Halo, jangan lupa isi aktivitas hari ini ya. Biar weekly report minggu ini tetap rapi.';

    if ($this->option('dry-run')) {
        $this->info("Daily reminder {$today}: {$users->count()} user target.");
        $users->each(fn(User $user) => $this->line("- {$user->name} ({$user->whatsapp_number})"));

        return;
    }

    $sent = 0;
    $failed = 0;

    foreach ($users as $user) {
        if ($waha->sendText($user->whatsapp_number, $message)) {
            $sent++;
            continue;
        }

        $failed++;
        $this->warn("Gagal kirim daily reminder ke {$user->name}.");
    }

    $this->info("Daily reminder selesai. Terkirim: {$sent}. Gagal: {$failed}. Target: {$users->count()}.");
})->purpose('Send daily WhatsApp reminders to users who have not submitted activities.');

Artisan::command('weekly-report:weekly-reminder {--dry-run : Show recipients without sending WhatsApp messages}', function (WahaClient $waha): void {
    $users = User::query()
        ->whereNotNull('whatsapp_number')
        ->where('whatsapp_number', '!=', '')
        ->orderBy('name')
        ->get();

    $message = 'Halo, jangan lupa lengkapi weekly report minggu ini ya. Cek lagi aktivitas yang masih progress atau kendala.';

    if ($this->option('dry-run')) {
        $this->info("Weekly reminder: {$users->count()} user target.");
        $users->each(fn(User $user) => $this->line("- {$user->name} ({$user->whatsapp_number})"));

        return;
    }

    $sent = 0;
    $failed = 0;

    foreach ($users as $user) {
        if ($waha->sendText($user->whatsapp_number, $message)) {
            $sent++;
            continue;
        }

        $failed++;
        $this->warn("Gagal kirim weekly reminder ke {$user->name}.");
    }

    $this->info("Weekly reminder selesai. Terkirim: {$sent}. Gagal: {$failed}. Target: {$users->count()}.");
})->purpose('Send weekly reminders to finalize reports.');


Artisan::command('weekly-report:archive', function (WeeklyReportArchiveService $archive): void {
    $saved = $archive->archivePastWeeks();

    $this->info("Archive sync selesai. Disimpan: {$saved} weekly report.");
})->purpose('Archive weekly reports older than the current week.');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('weekly-report:daily-reminder')->dailyAt('16:00');
Schedule::command('weekly-report:weekly-reminder')->fridays()->at('16:00');
Schedule::command('weekly-report:archive')->dailyAt('23:55');
Schedule::command('reminders:send-weekly-plans')->everyMinute()->timezone('Asia/Jayapura');
