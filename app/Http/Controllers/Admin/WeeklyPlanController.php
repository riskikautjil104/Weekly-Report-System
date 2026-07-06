<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklyPlan;
use Illuminate\Http\Request;
use App\Services\WahaClient;
use Illuminate\Support\Str;

class WeeklyPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = WeeklyPlan::with('user')
            ->orderByDesc('week_start')
            ->orderByDesc('tanggal')
            ->paginate(15)
            ->withQueryString();

        return view('admin.weekly_plans.index', [
            'pageTitle' => 'Weekly Plans',
            'plans' => $plans,
        ]);
    }

    public function create()
    {
        return view('admin.weekly_plans.create', [
            'pageTitle' => 'Buat Weekly Plan',
        ]);
    }

    public function store(Request $request, WahaClient $waha)
    {
        $data = $request->validate([
            'week_start' => ['required', 'date'],
            'day' => ['nullable', 'string', 'max:50'],
            'tanggal' => ['nullable', 'date'],
            'waktu' => ['nullable', 'date_format:H:i'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $data['user_id'] = $request->user()->id;

        $plan = WeeklyPlan::create($data);

        // Always send to Waha group
        $chat = config('services.waha.default_chat');
        $sent = false;
        $error = null;

        if ($chat) {
            $message = "📅 **JADWAL WEEKLY PLAN**\n\n" .
                "📋 **Title:** " . ($plan->title ?: '-') . "\n" .
                "📅 **Minggu:** " . ($plan->week_start?->toDateString() ?? '-') . "\n" .
                "📆 **Hari:** " . ($plan->day ?: '-') . "\n" .
                "🗓️ **Tanggal:** " . ($plan->tanggal?->toDateString() ?? '-') . "\n" .
                "⏰ **Waktu:** " . ($plan->waktu ?: '-') . "\n" .
                "👤 **Dibuat oleh:** " . ($request->user()->name ?? '-') . "\n\n" .
                "📝 **Deskripsi:**\n" . ($plan->description ? Str::limit($plan->description, 800) : '-');

            try {
                $sent = (bool) $waha->sendText($chat, $message);
            } catch (\Throwable $e) {
                $sent = false;
                $error = $e->getMessage();
            }
        }

        $plan->update([
            'waha_chat_id' => $chat ?? null,
            'sent_to_whatsapp' => (bool) $sent,
            'waha_sent_at' => $sent ? now() : null,
            'waha_send_error' => $error,
        ]);

        $flash = $sent ? 'Weekly plan dibuat dan dikirim ke grup WhatsApp.' : 'Weekly plan dibuat. Pengiriman WhatsApp gagal.';

        return redirect()->route('admin.weekly-plans.index')->with('status', $flash);
    }

    public function edit(WeeklyPlan $weeklyPlan)
    {
        return view('admin.weekly_plans.edit', [
            'pageTitle' => 'Edit Weekly Plan',
            'plan' => $weeklyPlan,
        ]);
    }

    public function update(Request $request, WeeklyPlan $weeklyPlan)
    {
        $data = $request->validate([
            'week_start' => ['required', 'date'],
            'day' => ['nullable', 'string', 'max:50'],
            'tanggal' => ['nullable', 'date'],
            'waktu' => ['nullable', 'date_format:H:i'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $weeklyPlan->update($data);

        return redirect()->route('admin.weekly-plans.index')->with('status', 'Weekly plan diperbarui.');
    }

    public function destroy(WeeklyPlan $weeklyPlan)
    {
        $weeklyPlan->delete();

        return redirect()->route('admin.weekly-plans.index')->with('status', 'Weekly plan dihapus.');
    }
}
