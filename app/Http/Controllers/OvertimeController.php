<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOvertimeRequest;
use App\Models\OvertimeCaptureMetadata;
use App\Models\OvertimeRequest;
use App\Services\OvertimeFilterService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function __construct(
        protected OvertimeFilterService $filterService
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();
        $filters = $this->filterService->filterValues($request);
        $stats = $this->filterService->stats($request, $user);

        $overtimes = $this->filterService->buildQuery($request, $user)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('overtime.index', [
            'pageTitle' => 'Lembur',
            'overtimes' => $overtimes,
            'stats' => $stats,
            'filters' => $filters,
            'isAdmin' => $user->role === 'admin',
        ]);
    }

    public function create(): View
    {
        return view('overtime.create', [
            'pageTitle' => 'Input Lembur',
            'pageLead' => 'Catat waktu lembur dan ambil foto bukti langsung dari kamera.',
            'defaultDate' => now()->toDateString(),
        ]);
    }

    public function store(StoreOvertimeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();

        $jamMulai = Carbon::createFromFormat('H:i', $data['jam_mulai']);
        $jamSelesai = Carbon::createFromFormat('H:i', $data['jam_selesai']);
        $durasiMenit = $jamMulai->diffInMinutes($jamSelesai);

        $overtime = OvertimeRequest::create([
            'user_id' => $user->id,
            'tanggal' => $data['tanggal'],
            'jam_mulai' => $data['jam_mulai'],
            'jam_selesai' => $data['jam_selesai'],
            'durasi_menit' => $durasiMenit,
            'alasan' => $data['alasan'],
            'status' => 'submitted',
        ]);

        OvertimeCaptureMetadata::create([
            'overtime_request_id' => $overtime->id,
            'image_hash' => $data['image_hash'],
            'image_width' => $data['image_width'],
            'image_height' => $data['image_height'],
            'file_size_bytes' => $data['file_size_bytes'],
            'camera_facing' => $data['camera_facing'] ?? 'unknown',
            'geo_latitude' => $data['geo_latitude'] ?? null,
            'geo_longitude' => $data['geo_longitude'] ?? null,
            'geo_accuracy' => $data['geo_accuracy'] ?? null,
            'device_user_agent' => $data['device_user_agent'],
            'ip_address' => $request->ip() ?? '0.0.0.0',
            'captured_at' => now(),
        ]);

        return redirect()
            ->route('overtime.index')
            ->with('status', 'Laporan lembur berhasil dikirim dan menunggu persetujuan admin.');
    }

    public function show(Request $request, OvertimeRequest $overtimeRequest): View
    {
        $this->authorizeOvertime($request, $overtimeRequest);

        $overtimeRequest->load(['user', 'captureMetadata', 'reviewer']);

        return view('overtime.show', [
            'pageTitle' => 'Detail Lembur',
            'overtime' => $overtimeRequest,
            'isAdmin' => $request->user()->role === 'admin',
        ]);
    }

    protected function authorizeOvertime(Request $request, OvertimeRequest $overtime): void
    {
        $user = $request->user();

        abort_unless($user->role === 'admin' || $overtime->user_id === $user->id, 403);
    }
}
