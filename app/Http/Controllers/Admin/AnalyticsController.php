<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PayrollCalculatorService;
use App\Services\ReportAnalyticsService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    public function __construct(
        protected ReportAnalyticsService $analyticsService,
        protected PayrollCalculatorService $payrollCalculator,
    ) {}

    public function index(Request $request): View
    {
        $filters = $this->analyticsService->filterValues($request);
        $analytics = $this->analyticsService->analyze($request, $request->user());
        $teamBreakdown = $this->analyticsService->teamBreakdown($request);

        return view('analytics.index', [
            'pageTitle' => 'Analisis Laporan',
            'filters' => $filters,
            'analytics' => $analytics,
            'isAdmin' => true,
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
            'teamBreakdown' => $teamBreakdown,
            'payrollCalculator' => $this->payrollCalculator,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $teamBreakdown = $this->analyticsService->teamBreakdown($request);
        $filters = $this->analyticsService->filterValues($request);
        $payroll = $this->analyticsService->analyze($request, $request->user())['payroll'];

        $fileName = sprintf('analisis-laporan-%s.csv', now()->format('Ymd_His'));

        return response()->streamDownload(function () use ($teamBreakdown, $filters, $payroll): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Analisis Laporan - ' . $filters['period_label']]);
            fputcsv($handle, ['Gaji Bulanan', $payroll['monthly_salary']]);
            fputcsv($handle, ['Hari Kerja/Bulan', $payroll['working_days_per_month']]);
            fputcsv($handle, ['Gaji/Hari', round($payroll['daily_rate'])]);
            fputcsv($handle, ['Gaji/Jam', round($payroll['hourly_rate'])]);
            fputcsv($handle, ['Rate Lembur/Jam (x' . $payroll['overtime_multiplier'] . ')', round($payroll['overtime_hourly_rate'])]);
            fputcsv($handle, []);
            fputcsv($handle, [
                'User', 'Total Task', 'Selesai', 'Progress', 'Kendala', 'Completion %',
                'Hari Input', 'Konsistensi %', 'Lembur (menit)', 'Biaya Lembur',
            ]);

            foreach ($teamBreakdown as $row) {
                fputcsv($handle, [
                    $row['user']->name,
                    $row['summary']['total_tasks'],
                    $row['summary']['selesai'],
                    $row['summary']['progress'],
                    $row['summary']['kendala'],
                    $row['summary']['completion_rate'],
                    $row['days_with_activity'],
                    $row['logging_rate'],
                    $row['overtime_approved_minutes'],
                    round($row['overtime_cost']),
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function print(Request $request): View
    {
        $filters = $this->analyticsService->filterValues($request);
        $analytics = $this->analyticsService->analyze($request, $request->user());
        $teamBreakdown = $this->analyticsService->teamBreakdown($request);

        return view('analytics.print', [
            'filters' => $filters,
            'analytics' => $analytics,
            'teamBreakdown' => $teamBreakdown,
            'payrollCalculator' => $this->payrollCalculator,
            'generatedAt' => Carbon::now(),
        ]);
    }
}
