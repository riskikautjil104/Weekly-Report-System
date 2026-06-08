<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use App\Models\User;
use App\Services\WeeklyReportSummaryService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index(WeeklyReportSummaryService $summaryService): View
    {
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $activities = DailyActivity::query()
            ->with('user')
            ->whereBetween('tanggal', [$weekStart->toDateString(), $weekEnd->toDateString()])
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        $summary = $summaryService->summarize($activities);
        $trend = $this->buildTrend($activities, $weekStart, $weekEnd);
        $topUsers = $this->buildTopUsers($activities);
        $recentActivities = $this->buildRecentActivities($activities);
        $blockers = $activities->where('status', 'kendala')->count();
        $progress = $activities->where('status', 'progress')->count();
        $activeUsers = $activities->pluck('user_id')->filter()->unique()->count();
        $totalUsers = User::count();
        $adminUsers = User::where('role', 'admin')->count();

        return view('dashboard.admin', [
            'pageTitle' => 'Admin Dashboard',
            'pageLead' => 'Monitoring operasional mingguan lintas user dengan data aktual yang masuk hari ini.',
            'weekLabel' => $weekStart->translatedFormat('d M Y') . ' - ' . $weekEnd->translatedFormat('d M Y'),
            'summary' => $summary,
            'metrics' => [
                [
                    'label' => 'Total Activities',
                    'value' => $summary['total_tasks'],
                    'note' => 'Semua aktivitas pada minggu berjalan',
                    'icon' => 'task_alt',
                    'tone' => 'primary',
                ],
                [
                    'label' => 'Active Users',
                    'value' => $activeUsers,
                    'note' => "{$activeUsers} dari {$totalUsers} akun menyumbang laporan",
                    'icon' => 'groups',
                    'tone' => 'neutral',
                ],
                [
                    'label' => 'Completion Rate',
                    'value' => $summary['completion_rate'] . '%',
                    'note' => 'Rasio aktivitas selesai minggu ini',
                    'icon' => 'check_circle',
                    'tone' => 'success',
                ],
                [
                    'label' => 'Open Blockers',
                    'value' => $blockers,
                    'note' => $progress > 0 ? "{$progress} item masih progress" : 'Tidak ada item progress',
                    'icon' => 'warning',
                    'tone' => 'warning',
                ],
            ],
            'teamPerformance' => $topUsers,
            'trend' => $trend,
            'recentActivities' => $recentActivities,
            'insights' => $this->buildInsights($summary, $topUsers, $adminUsers),
        ]);
    }

    protected function buildTrend(Collection $activities, Carbon $weekStart, Carbon $weekEnd): array
    {
        return collect(CarbonPeriod::create($weekStart, $weekEnd))
            ->map(function (Carbon $date) use ($activities) {
                $dayActivities = $activities->filter(fn (DailyActivity $activity) => Carbon::parse($activity->tanggal)->isSameDay($date));

                return [
                    'label' => $date->locale('id')->translatedFormat('D'),
                    'value' => $dayActivities->count(),
                ];
            })
            ->values()
            ->all();
    }

    protected function buildTopUsers(Collection $activities): array
    {
        return $activities
            ->groupBy('user_id')
            ->map(function (Collection $group) {
                $total = $group->count();
                $completed = $group->where('status', 'selesai')->count();
                $progress = $group->where('status', 'progress')->count();
                $blockers = $group->where('status', 'kendala')->count();
                $completionRate = $total > 0 ? round(($completed / $total) * 100) : 0;
                $user = $group->first()->user;

                return [
                    'name' => $user?->name ?? '-',
                    'role' => $user?->role ?? '-',
                    'initials' => $this->initials($user?->name),
                    'total' => $total,
                    'completed' => $completed,
                    'progress' => $progress,
                    'kendala' => $blockers,
                    'rate' => $completionRate,
                ];
            })
            ->sortByDesc('total')
            ->values()
            ->take(5)
            ->all();
    }

    protected function buildRecentActivities(Collection $activities): array
    {
        return $activities
            ->take(8)
            ->map(function (DailyActivity $activity) {
                return [
                    'user' => $activity->user?->name ?? '-',
                    'role' => $activity->user?->role ?? '-',
                    'tanggal' => Carbon::parse($activity->tanggal),
                    'aktivitas' => $activity->aktivitas,
                    'status' => $activity->status,
                ];
            })
            ->all();
    }

    protected function buildInsights(array $summary, array $topUsers, int $adminUsers): array
    {
        $insights = [];

        $insights[] = $summary['kendala'] > 0
            ? "{$summary['kendala']} aktivitas masih punya kendala yang perlu follow-up."
            : 'Tidak ada blocker aktif pada periode ini.';

        $insights[] = $summary['progress'] > 0
            ? "{$summary['progress']} aktivitas masih progress dan bisa diprioritaskan hari ini."
            : 'Semua item sudah berada di status selesai.';

        if (! empty($topUsers[0])) {
            $insights[] = $topUsers[0]['name'] . ' menjadi contributor paling aktif minggu ini.';
        }

        if ($adminUsers > 0) {
            $insights[] = $adminUsers . ' akun admin aktif tersedia untuk monitoring dan approval.';
        }

        return $insights;
    }

    protected function initials(?string $name): string
    {
        $parts = preg_split('/\s+/', trim((string) $name)) ?: [];
        $letters = array_map(fn ($part) => mb_substr($part, 0, 1), array_slice($parts, 0, 2));

        return strtoupper(implode('', $letters)) ?: 'U';
    }
}
