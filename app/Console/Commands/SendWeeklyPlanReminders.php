<?php

namespace App\Console\Commands;

use App\Models\WeeklyPlan;
use App\Services\WahaClient;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendWeeklyPlanReminders extends Command
{
    protected $signature = 'reminders:send-weekly-plans';
    protected $description = 'Send WhatsApp reminders for weekly plans one day before the scheduled date';

    public function __construct(
        protected WahaClient $waha,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $timezone = config('app.timezone', 'Asia/Jayapura');
        $now = Carbon::now($timezone);
        $currentTime = $now->format('H:i');
        $reminderDate = $now->copy()->addDay()->startOfDay()->toDateString();

        $plans = WeeklyPlan::query()
            ->where('reminder_sent', false)
            ->whereNotNull('tanggal')
            ->whereNotNull('waktu')
            ->whereDate('tanggal', $reminderDate)
            ->where('waktu', 'like', $currentTime . '%')
            ->get();

        if ($plans->isEmpty()) {
            $this->info('No reminder to send at ' . $now->format('Y-m-d H:i') . ' (' . $timezone . ')');
            return self::SUCCESS;
        }

        $defaultChat = config('services.waha.default_chat');

        foreach ($plans as $plan) {
            $chat = $plan->waha_chat_id ?: $defaultChat;

            if (!$chat) {
                $this->warn("Plan {$plan->id} has no chat ID configured");
                continue;
            }

            $message = "🔔 Reminder 1 Hari Sebelum Weekly Plan\n\n" .
                "Jangan lupa, besok ada jadwal berikut:\n\n" .
                "📋 Judul: " . ($plan->title ?: '-') . "\n" .
                "📅 Hari: " . ($plan->day ?: '-') . "\n" .
                "🗓️ Tanggal: " . ($plan->tanggal?->toDateString() ?? '-') . "\n" .
                "⏰ Waktu: " . ($plan->waktu ?: '-') . "\n" .
                "👤 Dibuat oleh: " . ($plan->user->name ?? '-') . "\n\n" .
                "📝 Deskripsi: " . Str::limit($plan->description ?? '', 500);

            try {
                $sent = (bool) $this->waha->sendText($chat, $message);

                if ($sent) {
                    $plan->update([
                        'reminder_sent' => true,
                        'reminder_sent_at' => now(),
                    ]);
                    $this->info("✓ Reminder sent for plan {$plan->id}");
                } else {
                    $plan->update([
                        'waha_send_error' => 'Reminder send returned false',
                    ]);
                    $this->error("✗ Failed to send reminder for plan {$plan->id}");
                }
            } catch (\Throwable $e) {
                $plan->update([
                    'waha_send_error' => $e->getMessage(),
                ]);
                $this->error("✗ Exception sending plan {$plan->id}: " . $e->getMessage());
            }
        }

        return self::SUCCESS;
    }
}
