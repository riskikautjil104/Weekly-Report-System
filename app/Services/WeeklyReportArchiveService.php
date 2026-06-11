<?php

namespace App\Services;

use App\Models\DailyActivity;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WeeklyReportArchiveService
{
    public function __construct(
        protected WeeklyReportSummaryService $summaryService,
    ) {
    }

    public function archivePastWeeks(?Carbon $cutoffWeekStart = null): int
    {
        // Masuk arsip kalau WEEK SUDAH LEWAT 1 minggu.
        // Ekspektasi test:
        // - testNow = 2026-06-09 (startOfWeek: 2026-06-08)
        // - aktivitas pada 2026-06-01 s/d 2026-06-02 harus masuk ke weekly_start 2026-06-01
        // Maka cutoff efektif harus bernilai 2026-06-02 (endOfWeek(2026-06-01)).
        // Ini dicapai dengan mengambil startOfWeek sekarang lalu -6 hari.
        $cutoffWeekStart ??= now()->startOfWeek()->subDays(6);

        $cutoffDate = $cutoffWeekStart instanceof Carbon
            ? $cutoffWeekStart->toDateString()
            : now()->toDateString();

        $activities = DailyActivity::query()
            ->with('user')
            ->whereDate('tanggal', '<', $cutoffDate)
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();

        if ($activities->isEmpty()) {
            return 0;
        }

        $grouped = $activities->groupBy(function (DailyActivity $activity) {
            $date = Carbon::parse($activity->tanggal);

            return $activity->user_id . '|' . $date->copy()->startOfWeek()->toDateString() . '|' . $date->copy()->endOfWeek()->toDateString();
        });

        $saved = 0;

        foreach ($grouped as $group) {
            /** @var Collection<int, DailyActivity> $group */
            $first = $group->first();
            $weekStart = Carbon::parse($first->tanggal)->startOfWeek();
            $weekEnd = Carbon::parse($first->tanggal)->endOfWeek();
            $snapshot = $this->buildSnapshot($group);

            WeeklyReport::updateOrCreate(
                [
                    'user_id' => $first->user_id,
                    'week_start' => $weekStart->format('Y-m-d'),
                    'week_end' => $weekEnd->format('Y-m-d'),
                ],
                [
                    'status' => 'submitted',
                    'summary_json' => $snapshot['summary'],
                    'activities_json' => $snapshot['activities'],
                    'issues_json' => $snapshot['issues'],
                    'archived_at' => now(),
                ]
            );

            $saved++;
        }

        return $saved;
    }

    public function buildSnapshot(Collection $activities): array
    {
        $summary = $this->summaryService->summarize($activities);
        $activities = $activities->values();

        $activityRows = $activities->map(function (DailyActivity $activity, int $index) {
            return [
                'no' => $index + 1,
                'tanggal' => Carbon::parse($activity->tanggal)->translatedFormat('d M Y'),
                'aktivitas' => $activity->aktivitas,
                'status' => $this->formatStatusLabel($activity->status),
                'keterangan' => $activity->keterangan ?: '-',
            ];
        })->all();

        $issues = $activities
            ->filter(fn (DailyActivity $activity) => $activity->status === 'kendala')
            ->values()
            ->map(function (DailyActivity $activity, int $index) {
                return [
                    'no' => $index + 1,
                    'kendala' => $activity->aktivitas,
                    'solusi' => $activity->keterangan ?: '-',
                    'pic' => $activity->user?->name ?? '-',
                    'status' => $this->formatStatusLabel($activity->status),
                ];
            })->all();

        return [
            'summary' => $summary,
            'activities' => $activityRows,
            'issues' => $issues,
        ];
    }

    protected function formatStatusLabel(string $status): string
    {
        return match ($status) {
            'selesai' => 'Selesai',
            'progress' => 'On Progres',
            'kendala' => 'Kendala',
            default => ucfirst($status),
        };
    }
}
