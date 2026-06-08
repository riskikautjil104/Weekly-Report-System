<?php

namespace App\Services;

use Illuminate\Support\Collection;

class WeeklyReportSummaryService
{
    public function summarize(iterable $activities): array
    {
        $collection = $activities instanceof Collection ? $activities : collect($activities);

        if ($collection->isEmpty()) {
            return [
                'total_tasks' => 0,
                'selesai' => 0,
                'progress' => 0,
                'kendala' => 0,
                'completion_rate' => 0,
            ];
        }

        $first = $collection->first();

        if (is_array($first) && array_key_exists('total', $first) && array_key_exists('selesai', $first)) {
            $totalTasks = (int) $collection->sum('total');
            $selesai = (int) $collection->sum('selesai');
            $progress = (int) $collection->sum('progress');
            $kendala = (int) $collection->sum('kendala');

            return [
                'total_tasks' => $totalTasks,
                'selesai' => $selesai,
                'progress' => $progress,
                'kendala' => $kendala,
                'completion_rate' => $totalTasks > 0 ? round($selesai / $totalTasks * 100) : 0,
            ];
        }

        return [
            'total_tasks' => $collection->count(),
            'selesai' => $collection->where('status', 'selesai')->count(),
            'progress' => $collection->where('status', 'progress')->count(),
            'kendala' => $collection->where('status', 'kendala')->count(),
            'completion_rate' => $collection->count() > 0
                ? round($collection->where('status', 'selesai')->count() / $collection->count() * 100)
                : 0,
        ];
    }
}
