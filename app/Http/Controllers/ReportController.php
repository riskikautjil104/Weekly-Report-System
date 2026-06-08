<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Services\WeeklyReportSummaryService;
use App\Services\WeeklyReportDocxWriter;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request, WeeklyReportSummaryService $summaryService): View
    {
        $range = $this->resolvedRange($request);
        $activities = $this->filteredActivities($request, $range);
        $weeklyReports = $this->weeklyReports($activities);

        return view('reports.index', [
            'pageTitle' => 'My Reports',
            'pageLead' => 'Lihat rekap weekly report pribadi berdasarkan minggu berjalan atau range tanggal yang dipilih.',
            'weekLabel' => $range['label'],
            'summary' => $summaryService->summarize($activities),
            'filters' => [
                'date_from' => $request->string('date_from')->toString(),
                'date_to' => $request->string('date_to')->toString(),
                'status' => $request->string('status')->toString(),
                'dateRange' => $range['label'],
                'statuses' => ['all', 'selesai', 'progress', 'kendala'],
            ],
            'activities' => $activities,
            'weeklyReports' => $weeklyReports,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $range = $this->resolvedRange($request);
        $activities = $this->filteredActivities($request, $range);
        $fileName = sprintf(
            'weekly-report-%s-%s.csv',
            str_replace(' ', '-', strtolower($request->user()->name ?? 'user')),
            now()->format('Ymd_His')
        );

        return response()->streamDownload(function () use ($activities): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Tanggal', 'Aktivitas', 'Status', 'Keterangan']);

            foreach ($activities as $activity) {
                fputcsv($handle, [
                    Carbon::parse($activity->tanggal)->format('Y-m-d'),
                    $activity->aktivitas,
                    $activity->status,
                    $activity->keterangan,
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function print(Request $request, WeeklyReportSummaryService $summaryService): View
    {
        $range = $this->resolvedRange($request);
        $activities = $this->filteredActivities($request, $range);

        return view('reports.print', [
            'pageTitle' => 'Weekly Report PDF',
            'pageLead' => 'Versi print-friendly untuk disimpan sebagai PDF melalui browser.',
            'weekLabel' => $range['label'],
            'userName' => $request->user()->name,
            'summary' => $summaryService->summarize($activities),
            'activities' => $activities,
            'filters' => [
                'dateRange' => $range['label'],
                'status' => $request->string('status')->toString(),
            ],
        ]);
    }

    public function system(Request $request, WeeklyReportSummaryService $summaryService): View
    {
        $data = $this->buildSystemReportData($request, $summaryService);

        return view('reports.system', [
            'pageTitle' => 'System Reports',
            'pageLead' => 'Monitoring lintas user, status task, dan ringkasan operasional per minggu berjalan.',
            'reports' => $data['reports'],
            'summary' => $data['summary'],
            'activeUsers' => $data['activeUsers'],
            'mostActiveUser' => $data['mostActiveUser'],
            'filters' => [
                'date_from' => $request->string('date_from')->toString(),
                'date_to' => $request->string('date_to')->toString(),
                'status' => $request->string('status')->toString(),
                'dateRange' => $data['range']['label'],
                'statuses' => ['all', 'selesai', 'progress', 'kendala'],
            ],
        ]);
    }

    public function systemPrint(Request $request, WeeklyReportSummaryService $summaryService, WeeklyReportDocxWriter $writer): View
    {
        $data = $this->buildSystemReportData($request, $summaryService);

        return view('reports.system-print', [
            'pageTitle' => 'Weekly Report PDF',
            'pageLead' => 'Versi print-friendly yang mengikuti template perusahaan untuk disimpan sebagai PDF.',
            'periodLabel' => $data['range']['label'],
            'sections' => $data['sections'],
            'logoDataUri' => $writer->assetDataUri('word/media/image1.png'),
            'dividerDataUri' => $writer->assetDataUri('word/media/image2.png'),
        ]);
    }

    public function systemExport(Request $request, WeeklyReportSummaryService $summaryService, WeeklyReportDocxWriter $writer): BinaryFileResponse
    {
        $data = $this->buildSystemReportData($request, $summaryService);
        $fileName = sprintf(
            'weekly-report-system-%s.docx',
            now()->format('Ymd_His')
        );

        $path = tempnam(sys_get_temp_dir(), 'weekly-report-system-');

        if ($path === false) {
            abort(500, 'Unable to create temporary report file.');
        }

        $writer->write($path, [
            'title' => 'Weekly Report System',
            'subject' => 'Admin system weekly report',
            'author' => $request->user()->name ?? 'System Admin',
            'generated_at' => now(),
            'sections' => $data['sections'],
        ]);

        return response()
            ->download($path, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])
            ->deleteFileAfterSend(true);
    }

    protected function buildSystemReportData(Request $request, WeeklyReportSummaryService $summaryService): array
    {
        $range = $this->resolvedRange($request);
        $activities = $this->filteredSystemActivities($request, $range);
        $reports = $this->buildSystemUserRows($activities);
        $summary = $summaryService->summarize($activities);
        $sections = $this->buildSystemSections($activities, $range['label']);

        return [
            'range' => $range,
            'activities' => $activities,
            'reports' => $reports,
            'summary' => $summary,
            'activeUsers' => $reports->count(),
            'mostActiveUser' => $reports->first()['user'] ?? '-',
            'sections' => $sections,
        ];
    }

    protected function filteredActivities(Request $request, ?array $range = null)
    {
        $range ??= $this->resolvedRange($request);

        return DailyActivity::query()
            ->where('user_id', $request->user()->id)
            ->whereBetween('tanggal', [$range['from']->toDateString(), $range['to']->toDateString()])
            ->when($request->filled('status') && $request->string('status')->toString() !== 'all', function ($query) use ($request) {
                $query->where('status', $request->string('status')->toString());
            })
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();
    }

    protected function filteredSystemActivities(Request $request, ?array $range = null): Collection
    {
        $range ??= $this->resolvedRange($request);

        return DailyActivity::query()
            ->with('user')
            ->whereBetween('tanggal', [$range['from']->toDateString(), $range['to']->toDateString()])
            ->when($request->filled('status') && $request->string('status')->toString() !== 'all', function ($query) use ($request) {
                $query->where('status', $request->string('status')->toString());
            })
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();
    }

    protected function buildSystemUserRows(Collection $activities): Collection
    {
        return $activities
            ->groupBy('user_id')
            ->map(function (Collection $group) {
                $total = $group->count();
                $selesai = $group->where('status', 'selesai')->count();
                $progress = $group->where('status', 'progress')->count();
                $kendala = $group->where('status', 'kendala')->count();
                $completionRate = $total > 0 ? round(($selesai / $total) * 100) : 0;

                return [
                    'user' => $group->first()->user?->name ?? '-',
                    'total' => $total,
                    'selesai' => $selesai,
                    'progress' => $progress,
                    'kendala' => $kendala,
                    'submission_rate' => $completionRate,
                    'status' => $this->statusFromCounts($selesai, $progress, $kendala),
                ];
            })
            ->sortByDesc('total')
            ->values();
    }

    protected function buildSystemSections(Collection $activities, string $periodLabel): array
    {
        return $activities
            ->groupBy('user_id')
            ->map(function (Collection $group) use ($periodLabel) {
                $group = $group
                    ->sortBy(function (DailyActivity $activity) {
                        $date = $activity->tanggal?->format('Y-m-d') ?? '1970-01-01';

                        return $date . '-' . str_pad((string) $activity->id, 10, '0', STR_PAD_LEFT);
                    })
                    ->values();

                $userName = $group->first()->user?->name ?? '-';
                $total = $group->count();
                $selesai = $group->where('status', 'selesai')->count();
                $progress = $group->where('status', 'progress')->count();
                $kendala = $group->where('status', 'kendala')->count();

                return [
                    'period_label' => $periodLabel,
                    'user' => $userName,
                    'summary' => [
                        'total_tasks' => $total,
                        'selesai' => $selesai,
                        'progress' => $progress,
                        'kendala' => $kendala,
                    ],
                    'activities' => $group->values()->map(function (DailyActivity $activity, int $index) {
                        return [
                            'no' => $index + 1,
                            'aktivitas' => $activity->aktivitas,
                            'status' => $this->formatStatusLabel($activity->status),
                            'keterangan' => $activity->keterangan ?: '-',
                            'tanggal' => Carbon::parse($activity->tanggal)->translatedFormat('d M Y'),
                        ];
                    })->all(),
                    'issues' => $group
                        ->filter(fn (DailyActivity $activity) => $activity->status === 'kendala')
                        ->values()
                        ->map(function (DailyActivity $activity, int $index) use ($userName) {
                            return [
                                'no' => $index + 1,
                                'kendala' => $activity->aktivitas,
                                'solusi' => $activity->keterangan ?: '-',
                                'pic' => $userName,
                                'status' => $this->formatStatusLabel($activity->status),
                            ];
                        })
                        ->all(),
                ];
            })
            ->sortByDesc(fn (array $section) => $section['summary']['total_tasks'])
            ->values()
            ->all();
    }

    protected function formatStatusLabel(string $status): string
    {
        return match ($status) {
            'selesai' => 'Selesai',
            'progress' => 'On Progress',
            'kendala' => 'Kendala',
            default => ucfirst($status),
        };
    }

    protected function statusFromCounts(int $selesai, int $progress, int $kendala): string
    {
        if ($kendala > 0) {
            return 'kendala';
        }

        if ($progress > 0) {
            return 'progress';
        }

        if ($selesai > 0) {
            return 'selesai';
        }

        return 'pending';
    }

    protected function weeklyReports($activities)
    {
        return $activities
            ->groupBy(function ($activity) {
                $date = Carbon::parse($activity->tanggal);

                return $date->copy()->startOfWeek()->format('Y-m-d') . '|' . $date->copy()->endOfWeek()->format('Y-m-d');
            })
            ->map(function ($group) {
                $first = $group->first();
                $firstDate = Carbon::parse($first->tanggal);
                $weekStart = $firstDate->copy()->startOfWeek();
                $weekEnd = $firstDate->copy()->endOfWeek();
                $total = $group->count();
                $selesai = $group->where('status', 'selesai')->count();
                $progress = $group->where('status', 'progress')->count();
                $kendala = $group->where('status', 'kendala')->count();

                return [
                    'periode' => $weekStart->translatedFormat('d M Y') . ' - ' . $weekEnd->translatedFormat('d M Y'),
                    'total' => $total,
                    'selesai' => $selesai,
                    'progress' => $progress,
                    'kendala' => $kendala,
                    'rate' => $total > 0 ? round($selesai / $total * 100) . '%' : '0%',
                    'week_start' => $weekStart,
                ];
            })
            ->sortByDesc('week_start')
            ->values();
    }

    protected function resolvedRange(Request $request): array
    {
        if ($request->filled('date_from') && $request->filled('date_to')) {
            return [
                'from' => Carbon::parse($request->string('date_from')->toString())->startOfDay(),
                'to' => Carbon::parse($request->string('date_to')->toString())->endOfDay(),
                'label' => Carbon::parse($request->string('date_from')->toString())->translatedFormat('d M Y')
                    . ' - ' .
                    Carbon::parse($request->string('date_to')->toString())->translatedFormat('d M Y'),
            ];
        }

        if ($request->filled('date_from')) {
            $from = Carbon::parse($request->string('date_from')->toString())->startOfDay();

            return [
                'from' => $from,
                'to' => $from->copy()->endOfWeek(),
                'label' => 'From ' . $from->translatedFormat('d M Y'),
            ];
        }

        if ($request->filled('date_to')) {
            $to = Carbon::parse($request->string('date_to')->toString())->endOfDay();

            return [
                'from' => $to->copy()->startOfWeek(),
                'to' => $to,
                'label' => 'Until ' . $to->translatedFormat('d M Y'),
            ];
        }

        $from = Carbon::now()->startOfWeek();
        $to = Carbon::now()->endOfWeek();

        return [
            'from' => $from,
            'to' => $to,
            'label' => $from->translatedFormat('d M Y') . ' - ' . $to->translatedFormat('d M Y'),
        ];
    }
}
