<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonthlySheet;
use App\Services\GoogleSheetReaderService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MonthlySheetController extends Controller
{
    public function index(GoogleSheetReaderService $reader): View
    {
        $sheets = MonthlySheet::query()
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->get();

        $activeSheet = $sheets->firstWhere('is_active', true);

        return view('admin.sheets.index', [
            'pageTitle' => 'Sheet Manager',
            'pageLead' => 'Tambahkan link spreadsheet baru setiap bulan dan pilih mana yang sedang aktif.',
            'sheets' => $sheets,
            'activeSheet' => $activeSheet,
            'sheetData' => $activeSheet ? $reader->read($activeSheet->sheet_url, $activeSheet->sheet_gid) : [
                'ok' => false,
                'title' => 'Google Spreadsheet Reader',
                'source_url' => null,
                'export_url' => null,
                'headers' => [],
                'rows' => [],
                'row_count' => 0,
                'column_count' => 0,
                'fetched_at' => null,
                'error' => 'Belum ada sheet aktif.',
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'month' => ['required', 'date_format:Y-m'],
            'title' => ['required', 'string', 'max:255'],
            'sheet_url' => ['required', 'url', 'max:2048'],
            'sheet_gid' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $isActive = $request->boolean('is_active', true);

        $sheet = MonthlySheet::create([
            'month' => Carbon::createFromFormat('Y-m', $validated['month'])->startOfMonth()->toDateString(),
            'title' => $validated['title'],
            'sheet_url' => $validated['sheet_url'],
            'sheet_gid' => $validated['sheet_gid'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'is_active' => $isActive,
        ]);

        if ($isActive) {
            MonthlySheet::query()
                ->where('id', '!=', $sheet->id)
                ->update(['is_active' => false]);
        }

        return redirect()
            ->route('admin.sheets.index')
            ->with('success', 'Link sheet bulanan berhasil disimpan.');
    }

    public function activate(MonthlySheet $monthlySheet): RedirectResponse
    {
        MonthlySheet::query()->update(['is_active' => false]);
        $monthlySheet->update(['is_active' => true]);

        return redirect()
            ->route('admin.sheets.index')
            ->with('success', 'Sheet aktif berhasil diganti.');
    }

    public function destroy(MonthlySheet $monthlySheet): RedirectResponse
    {
        $wasActive = $monthlySheet->is_active;
        $monthlySheet->delete();

        if ($wasActive) {
            $fallback = MonthlySheet::query()->orderByDesc('month')->orderByDesc('id')->first();

            if ($fallback) {
                MonthlySheet::query()->update(['is_active' => false]);
                $fallback->update(['is_active' => true]);
            }
        }

        return redirect()
            ->route('admin.sheets.index')
            ->with('success', 'Sheet berhasil dihapus.');
    }
}
