<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Services\WeeklyReportSummaryService;
use App\Services\WhatsAppLinkService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(WeeklyReportSummaryService $summaryService, WhatsAppLinkService $whatsAppLinkService): View
    {
        $user = auth()->user();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $activities = DailyActivity::query()
            ->where('user_id', $user->id)
            ->whereBetween('tanggal', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get(['tanggal', 'aktivitas', 'status', 'keterangan']);

        $recentActivities = DailyActivity::query()
            ->where('user_id', $user->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(6)
            ->get(['tanggal', 'aktivitas', 'status', 'keterangan']);

        return view('dashboard.user', [
            'pageTitle' => 'User Dashboard',
            'pageLead' => 'Ringkasan aktivitas harian dan status weekly report pribadi untuk periode minggu ini.',
            'weekLabel' => $weekStart->translatedFormat('d M') . ' - ' . $weekEnd->translatedFormat('d M Y'),
            'summary' => $summaryService->summarize($activities),
            'trend' => $this->buildTrend($activities, $weekStart, $weekEnd),
            'recentActivities' => $recentActivities,
            'reminders' => $this->buildReminders($activities),
            'userInitials' => $this->initials($user->name),
            'userRole' => $user->role,
            'userName' => $user->name,
            'whatsappLink' => $whatsAppLinkService->build(
                $user->whatsapp_number,
                'Halo ' . $user->name . ', saya ingin mengirim update aktivitas harian untuk weekly report.'
            ),
            'whatsappNumber' => $whatsAppLinkService->normalize($user->whatsapp_number),
        ]);
    }

    protected function buildTrend($activities, Carbon $weekStart, Carbon $weekEnd): array
    {
        $days = collect(CarbonPeriod::create($weekStart, $weekEnd))->map(function (Carbon $date) use ($activities) {
            $dayActivities = $activities->filter(fn (DailyActivity $activity) => Carbon::parse($activity->tanggal)->isSameDay($date));

            return [
                'label' => $date->locale('id')->translatedFormat('D'),
                'value' => $dayActivities->count(),
            ];
        });

        return $days->values()->all();
    }

    protected function buildReminders($activities): array
    {
        $reminders = [];
        $count = $activities->count();
        $pending = $activities->where('status', 'progress')->count();
        $blockers = $activities->where('status', 'kendala')->count();

        if ($count === 0) {
            $reminders[] = 'Belum ada aktivitas minggu ini. Mulai catat pekerjaan hari ini supaya summary tidak kosong.';
        }

        if ($pending > 0) {
            $reminders[] = "{$pending} aktivitas masih progress. Selesaikan yang paling dekat deadline dulu.";
        }

        if ($blockers > 0) {
            $reminders[] = "{$blockers} aktivitas masih kendala. Follow-up ke tim terkait sebelum akhir hari.";
        }

        $reminders[] = 'Gunakan WhatsApp untuk reminder cepat jika ada update mendadak sebelum report ditutup.';

        if (empty($reminders)) {
            $reminders[] = 'Aman. Semua aktivitas minggu ini terlihat stabil, tinggal jaga ritmenya.';
        }

        return $reminders;
    }

    protected function initials(?string $name): string
    {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $letters = array_map(fn ($part) => mb_substr($part, 0, 1), array_slice($parts, 0, 2));

        return strtoupper(implode('', $letters)) ?: 'U';
    }
}
