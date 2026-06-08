<?php

use App\Models\DailyActivity;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Config::set('services.waha.base_url', 'http://waha.test');
    Config::set('services.waha.api_key', 'secret-key');
    Config::set('services.waha.session', 'default');

    Http::preventStrayRequests();
});

test('daily reminder sends only to users without activity today', function () {
    Http::fake([
        'waha.test/api/sendText' => Http::response(['ok' => true]),
    ]);

    User::factory()->create([
        'name' => 'Target User',
        'whatsapp_number' => '081234567890',
    ]);

    $alreadySubmitted = User::factory()->create([
        'whatsapp_number' => '081111111111',
    ]);

    User::factory()->create([
        'whatsapp_number' => null,
    ]);

    DailyActivity::create([
        'user_id' => $alreadySubmitted->id,
        'tanggal' => today()->toDateString(),
        'aktivitas' => 'Mengerjakan laporan harian',
        'status' => 'selesai',
    ]);

    $this->artisan('weekly-report:daily-reminder')
        ->assertExitCode(0);

    Http::assertSentCount(1);
    Http::assertSent(function ($request) {
        return $request->url() === 'http://waha.test/api/sendText'
            && $request->hasHeader('X-Api-Key', 'secret-key')
            && $request['session'] === 'default'
            && $request['chatId'] === '6281234567890@c.us'
            && $request['text'] !== '';
    });
});

test('weekly reminder sends to every user with whatsapp number', function () {
    Http::fake([
        'waha.test/api/sendText' => Http::response(['ok' => true]),
    ]);

    User::factory()->create(['whatsapp_number' => '081234567890']);
    User::factory()->create(['whatsapp_number' => '082222222222']);
    User::factory()->create(['whatsapp_number' => null]);

    $this->artisan('weekly-report:weekly-reminder')
        ->assertExitCode(0);

    Http::assertSentCount(2);
});
