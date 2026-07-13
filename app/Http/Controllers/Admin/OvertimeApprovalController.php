<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OvertimeRequest;
use App\Models\User;
use App\Services\OvertimeFilterService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OvertimeApprovalController extends Controller
{
    public function __construct(
        protected OvertimeFilterService $filterService
    ) {}

    public function index(Request $request): View
    {
        $filters = $this->filterService->filterValues($request);
        $stats = $this->filterService->stats($request, $request->user());

        $overtimes = $this->filterService->buildQuery($request, $request->user())
            ->orderByRaw("CASE status WHEN 'submitted' THEN 0 ELSE 1 END")
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.overtime.index', [
            'pageTitle' => 'Approval Lembur',
            'overtimes' => $overtimes,
            'stats' => $stats,
            'filters' => $filters,
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $filters = $this->filterService->filterValues($request);
        $overtimes = $this->filterService->getFiltered($request, $request->user());

        $fileName = sprintf('laporan-lembur-%s.csv', now()->format('Ymd_His'));

        return response()->streamDownload(function () use ($overtimes): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'User',
                'Email',
                'Tanggal',
                'Jam Mulai',
                'Jam Selesai',
                'Durasi (menit)',
                'Durasi',
                'Alasan',
                'Status',
                'Hash Bukti',
                'Latitude',
                'Longitude',
                'Akurasi GPS (m)',
                'IP Address',
                'Waktu Capture',
                'Reviewed By',
                'Reviewed At',
            ]);

            foreach ($overtimes as $overtime) {
                $meta = $overtime->captureMetadata;

                fputcsv($handle, [
                    $overtime->user->name,
                    $overtime->user->email,
                    $overtime->tanggal->format('Y-m-d'),
                    Carbon::parse($overtime->jam_mulai)->format('H:i'),
                    Carbon::parse($overtime->jam_selesai)->format('H:i'),
                    $overtime->durasi_menit,
                    $overtime->formattedDuration(),
                    $overtime->alasan,
                    $this->statusLabel($overtime->status),
                    $meta?->image_hash,
                    $meta?->geo_latitude,
                    $meta?->geo_longitude,
                    $meta?->geo_accuracy,
                    $meta?->ip_address,
                    $meta?->captured_at?->format('Y-m-d H:i:s'),
                    $overtime->reviewer?->name,
                    $overtime->reviewed_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function print(Request $request): View
    {
        $filters = $this->filterService->filterValues($request);
        $stats = $this->filterService->stats($request, $request->user());
        $overtimes = $this->filterService->getFiltered($request, $request->user());

        return view('admin.overtime.print', [
            'pageTitle' => 'Laporan Lembur PDF',
            'overtimes' => $overtimes,
            'stats' => $stats,
            'filters' => $filters,
            'generatedAt' => now(),
        ]);
    }

    public function show(OvertimeRequest $overtimeRequest): View
    {
        $overtimeRequest->load(['user', 'captureMetadata', 'reviewer']);

        return view('admin.overtime.show', [
            'pageTitle' => 'Review Lembur',
            'overtime' => $overtimeRequest,
        ]);
    }

    public function approve(Request $request, OvertimeRequest $overtimeRequest): RedirectResponse
    {
        if ($overtimeRequest->status !== 'submitted') {
            return back()->with('error', 'Lembur ini sudah diproses sebelumnya.');
        }

        $overtimeRequest->update([
            'status' => 'approved',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('admin.overtime.index', $request->only([
                'filter_type', 'tanggal', 'minggu', 'bulan', 'date_from', 'date_to', 'user_id', 'status',
            ]))
            ->with('status', 'Lembur berhasil disetujui.');
    }

    public function reject(Request $request, OvertimeRequest $overtimeRequest): RedirectResponse
    {
        if ($overtimeRequest->status !== 'submitted') {
            return back()->with('error', 'Lembur ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:5'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $overtimeRequest->update([
            'status' => 'rejected',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'rejection_reason' => $request->input('rejection_reason'),
        ]);

        return redirect()
            ->route('admin.overtime.index', $request->only([
                'filter_type', 'tanggal', 'minggu', 'bulan', 'date_from', 'date_to', 'user_id', 'status',
            ]))
            ->with('status', 'Lembur berhasil ditolak.');
    }

    protected function statusLabel(string $status): string
    {
        return match ($status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Menunggu',
        };
    }
}
