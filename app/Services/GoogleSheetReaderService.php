<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleSheetReaderService
{
    public function read(?string $sourceUrl, ?string $gid = null): array
    {
        $sourceUrl = trim((string) $sourceUrl);
        $gid = trim((string) $gid);

        if ($sourceUrl === '') {
            return $this->errorResult('Link spreadsheet belum tersedia.');
        }

        $spreadsheetId = $this->extractSpreadsheetId($sourceUrl);

        if ($spreadsheetId === null) {
            return $this->errorResult('Link Google Sheet tidak valid.', $sourceUrl);
        }

        $exportUrl = $this->buildExportUrl($spreadsheetId, $gid);
        $response = Http::accept('text/csv')
            ->timeout(15)
            ->retry(2, 250)
            ->get($exportUrl);

        if (! $response->successful()) {
            return $this->errorResult('Spreadsheet tidak bisa diakses. Pastikan link-nya publik atau sudah diizinkan untuk dibaca.', $sourceUrl, $exportUrl);
        }

        $csv = trim($response->body());

        if ($csv === '') {
            return $this->errorResult('Spreadsheet kosong atau belum ada data yang bisa dibaca.', $sourceUrl, $exportUrl);
        }

        $lines = preg_split('/\r\n|\r|\n/', $csv) ?: [];
        $rows = array_values(array_filter(array_map('str_getcsv', $lines), fn (array $row) => $this->rowHasContent($row)));

        if ($rows === []) {
            return $this->errorResult('Spreadsheet tidak memiliki baris data yang bisa ditampilkan.', $sourceUrl, $exportUrl);
        }

        $headers = array_shift($rows);
        $headers = array_map(
            fn ($header, $index) => trim((string) $header) !== '' ? trim((string) $header) : 'Column ' . ($index + 1),
            $headers,
            array_keys($headers)
        );

        if ($headers === []) {
            return $this->errorResult('Baris header spreadsheet tidak ditemukan.', $sourceUrl, $exportUrl);
        }

        $normalizedRows = [];

        foreach ($rows as $row) {
            $normalizedRows[] = $this->normalizeRow($headers, $row);
        }

        $normalizedRows = array_values(array_filter($normalizedRows, fn (array $row) => $this->rowHasContent($row)));

        return [
            'ok' => true,
            'title' => 'Google Spreadsheet Reader',
            'source_url' => $sourceUrl,
            'export_url' => $exportUrl,
            'headers' => $headers,
            'rows' => $normalizedRows,
            'row_count' => count($normalizedRows),
            'column_count' => count($headers),
            'fetched_at' => now(),
            'error' => null,
        ];
    }

    protected function buildExportUrl(string $spreadsheetId, string $gid = ''): string
    {
        $query = ['format' => 'csv'];

        if ($gid !== '') {
            $query['gid'] = $gid;
        }

        return 'https://docs.google.com/spreadsheets/d/' . $spreadsheetId . '/export?' . http_build_query($query);
    }

    protected function extractSpreadsheetId(string $url): ?string
    {
        if (preg_match('#/d/([a-zA-Z0-9-_]+)#', $url, $matches) === 1) {
            return $matches[1];
        }

        return null;
    }

    protected function rowHasContent(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return true;
            }
        }

        return false;
    }

    protected function normalizeRow(array $headers, array $row): array
    {
        $normalized = [];
        $maxColumns = max(count($headers), count($row));

        for ($index = 0; $index < $maxColumns; $index++) {
            $key = trim((string) ($headers[$index] ?? '')) ?: 'Column ' . ($index + 1);
            $normalized[$key] = trim((string) ($row[$index] ?? ''));
        }

        return $normalized;
    }

    protected function errorResult(string $message, ?string $sourceUrl = null, ?string $exportUrl = null): array
    {
        return [
            'ok' => false,
            'title' => 'Google Spreadsheet Reader',
            'source_url' => $sourceUrl,
            'export_url' => $exportUrl,
            'headers' => [],
            'rows' => [],
            'row_count' => 0,
            'column_count' => 0,
            'fetched_at' => null,
            'error' => $message,
        ];
    }
}
