<?php

namespace App\Services;

use App\Models\DailyActivity;
use App\Models\OvertimeRequest;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ReportAnalyticsService
{
    public function __construct(
        protected WeeklyReportSummaryService $summaryService,
        protected PayrollCalculatorService $payrollCalculator,
        protected OvertimeFilterService $overtimeFilterService,
    ) {}

    public function filterValues(Request $request): array
    {
        return $this->overtimeFilterService->filterValues($request);
    }

    public function resolveRange(Request $request): array
    {
        return $this->overtimeFilterService->resolveRange($request);
    }

    public function buildActivityQuery(Request $request, User $viewer): Builder
    {
        $range = $this->resolveRange($request);

        $query = DailyActivity::query()
            ->with('user')
            ->whereBetween('tanggal', [
                $range['from']->toDateString(),
                $range['to']->toDateString(),
            ]);

        if ($viewer->role !== 'admin') {
            $query->where('user_id', $viewer->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        return $query;
    }

    public function analyze(Request $request, User $viewer): array
    {
        $range = $this->resolveRange($request);
        $activities = $this->buildActivityQuery($request, $viewer)
            ->orderBy('tanggal')
            ->get();

        $overtimeQuery = $this->overtimeFilterService->buildQuery($request, $viewer);
        $overtimes = $overtimeQuery->get();
        $approvedOvertimes = $overtimes->where('status', 'approved');

        $workingDays = $this->countWorkingDays($range['from'], $range['to']);
        $daysWithActivity = $activities->pluck('tanggal')->map(fn ($d) => Carbon::parse($d)->toDateString())->unique()->count();
        $approvedMinutes = (int) $approvedOvertimes->sum('durasi_menit');
        $summary = $this->summaryService->summarize($activities);

        return [
            'range' => $range,
            'summary' => $summary,
            'consistency' => [
                'working_days' => $workingDays,
                'days_with_activity' => $daysWithActivity,
                'logging_rate' => $workingDays > 0 ? round($daysWithActivity / $workingDays * 100) : 0,
                'avg_tasks_per_day' => $daysWithActivity > 0 ? round($summary['total_tasks'] / $daysWithActivity, 1) : 0,
            ],
            'weekly_breakdown' => $this->weeklyBreakdown($activities, $range['from'], $range['to']),
            'status_distribution' => [
                'selesai' => $summary['selesai'],
                'progress' => $summary['progress'],
                'kendala' => $summary['kendala'],
            ],
            'overtime' => [
                'total_requests' => $overtimes->count(),
                'approved' => $approvedOvertimes->count(),
                'submitted' => $overtimes->where('status', 'submitted')->count(),
                'rejected' => $overtimes->where('status', 'rejected')->count(),
                'approved_minutes' => $approvedMinutes,
                'approved_hours' => round($approvedMinutes / 60, 1),
                'approved_cost' => $this->payrollCalculator->overtimeCost($approvedMinutes),
            ],
            'payroll' => $this->payrollCalculator->ratesSummary(),
            'insights' => $this->buildInsights($summary, $daysWithActivity, $workingDays, $approvedMinutes, $overtimes),
        ];
    }

    public function teamBreakdown(Request $request): Collection
    {
        $range = $this->resolveRange($request);
        $userId = $request->filled('user_id') ? $request->integer('user_id') : null;

        $users = User::query()
            ->when($userId, fn ($q) => $q->where('id', $userId))
            ->orderBy('name')
            ->get();

        return $users->map(function (User $user) use ($range) {
            $activities = DailyActivity::query()
                ->where('user_id', $user->id)
                ->whereBetween('tanggal', [$range['from']->toDateString(), $range['to']->toDateString()])
                ->get();

            $overtimes = OvertimeRequest::query()
                ->where('user_id', $user->id)
                ->whereBetween('tanggal', [$range['from']->toDateString(), $range['to']->toDateString()])
                ->get();

            $approvedMinutes = (int) $overtimes->where('status', 'approved')->sum('durasi_menit');
            $summary = $this->summaryService->summarize($activities);
            $workingDays = $this->countWorkingDays($range['from'], $range['to']);
            $daysWithActivity = $activities->pluck('tanggal')->map(fn ($d) => Carbon::parse($d)->toDateString())->unique()->count();

            return [
                'user' => $user,
                'summary' => $summary,
                'days_with_activity' => $daysWithActivity,
                'logging_rate' => $workingDays > 0 ? round($daysWithActivity / $workingDays * 100) : 0,
                'overtime_approved_minutes' => $approvedMinutes,
                'overtime_cost' => $this->payrollCalculator->overtimeCost($approvedMinutes),
            ];
        })->filter(fn (array $row) => $row['summary']['total_tasks'] > 0 || $row['overtime_approved_minutes'] > 0)
            ->sortByDesc(fn (array $row) => $row['summary']['total_tasks'])
            ->values();
    }

    protected function weeklyBreakdown(Collection $activities, Carbon $from, Carbon $to): array
    {
        $weeks = [];
        $cursor = $from->copy()->startOfWeek(Carbon::MONDAY);

        while ($cursor->lte($to)) {
            $weekStart = $cursor->copy();
            $weekEnd = $cursor->copy()->endOfWeek(Carbon::MONDAY);

            $weekActivities = $activities->filter(function ($activity) use ($weekStart, $weekEnd) {
                $date = Carbon::parse($activity->tanggal);

                return $date->between($weekStart->startOfDay(), $weekEnd->endOfDay());
            });

            if ($weekActivities->isNotEmpty() || $weekStart->lte($to)) {
                $summary = $this->summaryService->summarize($weekActivities);
                $weeks[] = [
                    'label' => $weekStart->translatedFormat('d M') . ' – ' . $weekEnd->translatedFormat('d M Y'),
                    'week_start' => $weekStart->toDateString(),
                    ...$summary,
                ];
            }

            $cursor->addWeek();
        }

        return $weeks;
    }

    protected function countWorkingDays(Carbon $from, Carbon $to): int
    {
        $workDays = config('payroll.work_days_iso', [1, 2, 3, 4, 5, 6]);
        $count = 0;

        foreach (CarbonPeriod::create($from->copy()->startOfDay(), $to->copy()->startOfDay()) as $date) {
            if (in_array($date->dayOfWeekIso, $workDays, true)) {
                $count++;
            }
        }

        return $count;
    }

    protected function buildInsights(array $summary, int $daysWithActivity, int $workingDays, int $approvedMinutes, Collection $overtimes): array
    {
        $insights = [];

        if ($workingDays > 0) {
            $rate = round($daysWithActivity / $workingDays * 100);
            if ($rate >= 80) {
                $insights[] = "Konsistensi input bagus — {$daysWithActivity} dari {$workingDays} hari kerja tercatat ({$rate}%).";
            } elseif ($rate >= 50) {
                $insights[] = "Input aktivitas {$rate}% dari hari kerja. Usahakan catat setiap hari Senin–Sabtu.";
            } else {
                $insights[] = "Konsistensi input rendah ({$rate}%). Hanya {$daysWithActivity} dari {$workingDays} hari kerja tercatat.";
            }
        }

        if ($summary['completion_rate'] >= 80) {
            $insights[] = "Completion rate {$summary['completion_rate']}% — performa task mingguan solid.";
        } elseif ($summary['kendala'] > 0) {
            $insights[] = "{$summary['kendala']} task masih kendala — perlu eskalasi ke tim terkait.";
        }

        if ($approvedMinutes > 0) {
            $cost = $this->payrollCalculator->formatRupiah($this->payrollCalculator->overtimeCost($approvedMinutes));
            $hours = round($approvedMinutes / 60, 1);
            $insights[] = "Lembur disetujui {$hours} jam dengan estimasi biaya {$cost}.";
        }

        if ($overtimes->where('status', 'submitted')->count() > 0) {
            $pending = $overtimes->where('status', 'submitted')->count();
            $insights[] = "{$pending} laporan lembur masih menunggu approval admin.";
        }

        if (empty($insights)) {
            $insights[] = 'Belum ada data cukup untuk periode ini. Mulai input aktivitas harian.';
        }

        return $insights;
    }
}
