<?php

use App\Models\DailyActivity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('archives past weeks into weekly reports', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-09 10:00:00'));

    $user = User::factory()->create([
        'role' => 'user',
        'email_verified_at' => now(),
    ]);

    DailyActivity::create([
        'user_id' => $user->id,
        'tanggal' => '2026-06-01',
        'aktivitas' => 'Membuat laporan mingguan',
        'status' => 'selesai',
        'keterangan' => 'Sudah selesai',
    ]);

    DailyActivity::create([
        'user_id' => $user->id,
        'tanggal' => '2026-06-02',
        'aktivitas' => 'Follow up kendala API',
        'status' => 'kendala',
        'keterangan' => 'Menunggu balasan',
    ]);

    $this->artisan('weekly-report:archive')
        ->expectsOutputToContain('Archive sync selesai')
        ->assertExitCode(0);

    $this->assertDatabaseHas('weekly_reports', [
        'user_id' => $user->id,
        // week_start/week_end disimpan dalam bentuk datetime (00:00:00)
        'week_start' => '2026-06-01 00:00:00',
        'week_end' => '2026-06-07 00:00:00',
    ]);
});

it('shows archive index and printable archive page', function () {
    Carbon::setTestNow(Carbon::parse('2026-06-09 10:00:00'));

    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $user = User::factory()->create([
        'role' => 'user',
        'email_verified_at' => now(),
    ]);

    DailyActivity::create([
        'user_id' => $user->id,
        'tanggal' => '2026-06-01',
        'aktivitas' => 'Membuat laporan mingguan',
        'status' => 'selesai',
        'keterangan' => 'Sudah selesai',
    ]);

    DailyActivity::create([
        'user_id' => $user->id,
        'tanggal' => '2026-06-02',
        'aktivitas' => 'Follow up kendala API',
        'status' => 'kendala',
        'keterangan' => 'Menunggu balasan',
    ]);

    $this->artisan('weekly-report:archive')->assertExitCode(0);

    $archive = \App\Models\WeeklyReport::firstOrFail();

    $this->actingAs($admin)
        ->get(route('archives.index'))
        ->assertOk()
        ->assertSee('Weekly Report Archive')
        ->assertSee('Print / PDF');

    $this->actingAs($admin)
        ->get(route('archives.print', $archive))
        ->assertOk()
        ->assertSee('Weekly Report RSCHB')
        ->assertSee('A.Ringkasan')
        ->assertSee('Membuat laporan mingguan');
});
