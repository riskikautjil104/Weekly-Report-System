<?php

use App\Models\MonthlySheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

uses(RefreshDatabase::class);

it('allows admin to save a monthly sheet link', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($admin)
        ->post(route('admin.sheets.store'), [
            'month' => '2026-06',
            'title' => 'Weekly Report June 2026',
            'sheet_url' => 'https://docs.google.com/spreadsheets/d/19PivCUSMg-2jsJqOTNwwJn3qQ6Dr0WzwrPrXOlRSII8/edit?gid=16849638#gid=16849638',
            'sheet_gid' => '16849638',
            'notes' => 'June sheet',
            'is_active' => 1,
        ])
        ->assertRedirect(route('admin.sheets.index'));

    $this->assertDatabaseHas('monthly_sheets', [
        'title' => 'Weekly Report June 2026',
        'is_active' => true,
    ]);
});

it('shows the active google sheet to users', function () {
    Http::preventStrayRequests();

    Http::fake([
        'docs.google.com/spreadsheets/d/*/export*' => Http::response("Nama,Status,Catatan\nAlice,Selesai,OK\nBob,Progress,Masih jalan\n", 200),
    ]);

    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    MonthlySheet::create([
        'month' => '2026-06-01',
        'title' => 'Weekly Report June 2026',
        'sheet_url' => 'https://docs.google.com/spreadsheets/d/19PivCUSMg-2jsJqOTNwwJn3qQ6Dr0WzwrPrXOlRSII8/edit?gid=16849638#gid=16849638',
        'sheet_gid' => '16849638',
        'is_active' => true,
        'notes' => 'June sheet',
    ]);

    $this->actingAs($admin)
        ->get(route('sheets.show'))
        ->assertOk()
        ->assertSee('Alice')
        ->assertSee('Bob')
        ->assertSee('Selesai')
        ->assertSee('Progress');
});
