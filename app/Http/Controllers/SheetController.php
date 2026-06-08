<?php

namespace App\Http\Controllers;

use App\Models\MonthlySheet;
use App\Services\GoogleSheetReaderService;
use Illuminate\Contracts\View\View;

class SheetController extends Controller
{
    public function show(GoogleSheetReaderService $reader): View
    {
        $activeSheet = MonthlySheet::query()
            ->where('is_active', true)
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->first();

        $sheetData = $activeSheet
            ? $reader->read($activeSheet->sheet_url, $activeSheet->sheet_gid)
            : [
                'ok' => false,
                'title' => 'Google Spreadsheet Reader',
                'source_url' => null,
                'export_url' => null,
                'headers' => [],
                'rows' => [],
                'row_count' => 0,
                'column_count' => 0,
                'fetched_at' => null,
                'error' => 'Belum ada sheet aktif yang diinput admin.',
            ];

        $archive = MonthlySheet::query()
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        return view('sheets.show', [
            'pageTitle' => 'Monthly Sheets',
            'pageLead' => 'Lihat data spreadsheet aktif langsung dari web tanpa perlu input manual.',
            'activeSheet' => $activeSheet,
            'sheetData' => $sheetData,
            'archive' => $archive,
        ]);
    }
}
