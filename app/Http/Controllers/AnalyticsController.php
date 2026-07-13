<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PayrollCalculatorService;
use App\Services\ReportAnalyticsService;
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
        $user = $request->user();
        $filters = $this->analyticsService->filterValues($request);
        $analytics = $this->analyticsService->analyze($request, $user);

        return view('analytics.index', [
            'pageTitle' => 'Analisis Laporan',
            'filters' => $filters,
            'analytics' => $analytics,
            'isAdmin' => false,
            'users' => collect(),
            'teamBreakdown' => collect(),
            'payrollCalculator' => $this->payrollCalculator,
        ]);
    }
}
