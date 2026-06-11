<?php

namespace App\Http\Controllers;

use App\Models\WeeklyReport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArchiveController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $archives = WeeklyReport::query()
            ->with('user')
            ->when($user->role !== 'admin', fn ($query) => $query->where('user_id', $user->id))
            ->whereNotNull('archived_at')
            ->orderByDesc('week_start')
            ->orderByDesc('id')
            ->get();

        return view('archives.index', [
            'pageTitle' => 'Arsip Weekly Report',
            'pageLead' => 'Lihat report mingguan yang sudah lewat dari satu minggu, lengkap dengan periode dan file PDF-nya.',
            'archives' => $archives,
            'isAdmin' => $user->role === 'admin',
        ]);
    }

    public function print(WeeklyReport $weeklyReport, Request $request): View
    {
        $this->authorizeWeeklyReport($request, $weeklyReport);

        $snapshot = $this->snapshotFor($weeklyReport);

        return view('archives.print', [
            'pageTitle' => 'Archive PDF',
            'pageLead' => 'Versi print-friendly untuk menyimpan arsip weekly report sebagai PDF.',
            'report' => $weeklyReport,
            'snapshot' => $snapshot,
            'logoDataUri' => null,
            'dividerDataUri' => null,
        ]);
    }

    public function printRange(Request $request): View
    {
        $user = $request->user();

        $weekStart = $request->filled('week_start')
            ? $request->date('week_start')->startOfDay()->toDateString()
            : null;

        $weekEnd = $request->filled('week_end')
            ? $request->date('week_end')->endOfDay()->toDateString()
            : null;

        abort_unless($weekStart && $weekEnd, 422);

        // Filter berdasarkan week_start/week_end yang tersinkron dalam range.
        $reports = WeeklyReport::query()
            ->with('user')
            ->when($user->role !== 'admin', fn ($query) => $query->where('user_id', $user->id))
            ->whereNotNull('archived_at')
            ->where(function ($query) use ($weekStart, $weekEnd) {
                // Overlap range
                $query
                    ->where('week_start', '<=', $weekEnd)
                    ->where('week_end', '>=', $weekStart);
            })
            ->orderByDesc('week_start')
            ->orderByDesc('id')
            ->get();

        $reportsPayload = $reports->map(function (WeeklyReport $report) {
            $snapshot = $this->snapshotFor($report);

            return [
                'week_start' => $report->week_start,
                'week_end' => $report->week_end,
                'user_name' => $report->user?->name ?? '-',
                'snapshot' => $snapshot,
            ];
        })->values();

        return view('archives.range-print', [
            'pageTitle' => 'Archive PDF Range',
            'pageLead' => 'Versi print-friendly untuk menyimpan arsip weekly report dalam beberapa periode sebagai PDF.',
            'reports' => $reportsPayload,
        ]);
    }

    protected function snapshotFor(WeeklyReport $weeklyReport): array
    {
        return [
            'summary' => $weeklyReport->summary_json ?? [
                'total_tasks' => 0,
                'selesai' => 0,
                'progress' => 0,
                'kendala' => 0,
                'completion_rate' => 0,
            ],
            'activities' => $weeklyReport->activities_json ?? [],
            'issues' => $weeklyReport->issues_json ?? [],
        ];
    }

    protected function authorizeWeeklyReport(Request $request, WeeklyReport $weeklyReport): void
    {
        $user = $request->user();

        abort_unless($user->role === 'admin' || $weeklyReport->user_id === $user->id, 403);
    }
}

