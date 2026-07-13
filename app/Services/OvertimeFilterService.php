<?php

namespace App\Services;

use App\Models\OvertimeRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OvertimeFilterService
{
    public function resolveRange(Request $request): array
    {
        $filterType = $request->string('filter_type', 'month')->toString();

        return match ($filterType) {
            'day' => $this->resolveDayRange($request),
            'week' => $this->resolveWeekRange($request),
            'range' => $this->resolveCustomRange($request),
            default => $this->resolveMonthRange($request),
        };
    }

    public function filterValues(Request $request): array
    {
        $range = $this->resolveRange($request);

        return [
            'filter_type' => $request->string('filter_type', 'month')->toString(),
            'tanggal' => $request->string('tanggal')->toString(),
            'minggu' => $request->string('minggu')->toString(),
            'bulan' => $request->string('bulan')->toString(),
            'date_from' => $request->string('date_from')->toString(),
            'date_to' => $request->string('date_to')->toString(),
            'user_id' => $request->string('user_id')->toString(),
            'status' => $request->string('status', 'all')->toString(),
            'period_label' => $range['label'],
        ];
    }

    public function buildQuery(Request $request, User $viewer): Builder
    {
        $range = $this->resolveRange($request);

        $query = OvertimeRequest::query()
            ->with(['user', 'captureMetadata', 'reviewer'])
            ->whereBetween('tanggal', [
                $range['from']->toDateString(),
                $range['to']->toDateString(),
            ]);

        if ($viewer->role !== 'admin') {
            $query->where('user_id', $viewer->id);
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        $status = $request->string('status', 'all')->toString();
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        return $query;
    }

    public function getFiltered(Request $request, User $viewer): Collection
    {
        return $this->buildQuery($request, $viewer)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();
    }

    public function stats(Request $request, User $viewer): array
    {
        $items = $this->getFiltered($request, $viewer);

        return [
            'total' => $items->count(),
            'submitted' => $items->where('status', 'submitted')->count(),
            'approved' => $items->where('status', 'approved')->count(),
            'rejected' => $items->where('status', 'rejected')->count(),
            'total_minutes' => $items->where('status', 'approved')->sum('durasi_menit'),
        ];
    }

    protected function resolveDayRange(Request $request): array
    {
        $date = $request->filled('tanggal')
            ? Carbon::parse($request->string('tanggal')->toString())
            : Carbon::today();

        return [
            'from' => $date->copy()->startOfDay(),
            'to' => $date->copy()->endOfDay(),
            'label' => 'Harian · ' . $date->translatedFormat('d M Y'),
        ];
    }

    protected function resolveWeekRange(Request $request): array
    {
        $date = $request->filled('minggu')
            ? Carbon::parse($request->string('minggu')->toString())
            : Carbon::now();

        $from = $date->copy()->startOfWeek(Carbon::MONDAY);
        $to = $date->copy()->endOfWeek(Carbon::MONDAY);

        return [
            'from' => $from->startOfDay(),
            'to' => $to->endOfDay(),
            'label' => 'Mingguan · ' . $from->translatedFormat('d M') . ' – ' . $to->translatedFormat('d M Y'),
        ];
    }

    protected function resolveMonthRange(Request $request): array
    {
        if ($request->filled('bulan')) {
            $from = Carbon::createFromFormat('Y-m', $request->string('bulan')->toString())->startOfMonth();
        } else {
            $from = Carbon::now()->startOfMonth();
        }

        $to = $from->copy()->endOfMonth();

        return [
            'from' => $from->startOfDay(),
            'to' => $to->endOfDay(),
            'label' => 'Bulanan · ' . $from->translatedFormat('F Y'),
        ];
    }

    protected function resolveCustomRange(Request $request): array
    {
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $from = Carbon::parse($request->string('date_from')->toString())->startOfDay();
            $to = Carbon::parse($request->string('date_to')->toString())->endOfDay();

            return [
                'from' => $from,
                'to' => $to,
                'label' => 'Custom · ' . $from->translatedFormat('d M Y') . ' – ' . $to->translatedFormat('d M Y'),
            ];
        }

        if ($request->filled('date_from')) {
            $from = Carbon::parse($request->string('date_from')->toString())->startOfDay();

            return [
                'from' => $from,
                'to' => $from->copy()->endOfDay(),
                'label' => 'Custom · ' . $from->translatedFormat('d M Y'),
            ];
        }

        $from = Carbon::now()->startOfMonth();
        $to = Carbon::now()->endOfMonth();

        return [
            'from' => $from->startOfDay(),
            'to' => $to->endOfDay(),
            'label' => 'Custom · ' . $from->translatedFormat('d M Y') . ' – ' . $to->translatedFormat('d M Y'),
        ];
    }
}
