<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analisis Laporan - {{ $filters['period_label'] }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; margin: 24px; font-size: 12px; }
        h1 { font-size: 20px; margin: 0 0 4px; }
        .meta { color: #555; margin-bottom: 20px; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat { border: 1px solid #ddd; border-radius: 8px; padding: 12px; }
        .stat-label { font-size: 10px; text-transform: uppercase; color: #666; }
        .stat-value { font-size: 16px; font-weight: bold; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; font-size: 10px; text-transform: uppercase; }
        .payroll-box { background: #f0f4ff; border: 1px solid #c2d0f0; border-radius: 8px; padding: 16px; margin-bottom: 20px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 16px;">
        <button onclick="window.print()" style="padding: 10px 16px; cursor: pointer;">Print / Save as PDF</button>
    </div>

    <h1>Analisis Laporan Aktivitas</h1>
    <p class="meta">Periode: {{ $filters['period_label'] }} · Dicetak: {{ $generatedAt->format('d M Y H:i') }}</p>

    @php $p = $analytics['payroll']; $rp = fn ($n) => $payrollCalculator->formatRupiah($n); @endphp

    <div class="payroll-box">
        <strong>Referensi Gaji (Senin–Sabtu)</strong><br>
        Gaji bulanan: {{ $rp($p['monthly_salary']) }} ·
        Per hari: {{ $rp($p['daily_rate']) }} ({{ $p['working_days_per_month'] }} hari) ·
        Per jam: {{ $rp($p['hourly_rate']) }} ·
        Lembur/jam: {{ $rp($p['overtime_hourly_rate']) }} (×{{ $p['overtime_multiplier'] }})
    </div>

    <div class="stats">
        <div class="stat">
            <div class="stat-label">Total Task</div>
            <div class="stat-value">{{ $analytics['summary']['total_tasks'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">Completion Rate</div>
            <div class="stat-value">{{ $analytics['summary']['completion_rate'] }}%</div>
        </div>
        <div class="stat">
            <div class="stat-label">Konsistensi Input</div>
            <div class="stat-value">{{ $analytics['consistency']['logging_rate'] }}%</div>
        </div>
        <div class="stat">
            <div class="stat-label">Biaya Lembur</div>
            <div class="stat-value">{{ $rp($analytics['overtime']['approved_cost']) }}</div>
        </div>
    </div>

    <h2>Performa per User</h2>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Task</th>
                <th>Selesai</th>
                <th>Progress</th>
                <th>Kendala</th>
                <th>Rate</th>
                <th>Konsistensi</th>
                <th>Lembur (jam)</th>
                <th>Biaya Lembur</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teamBreakdown as $row)
                <tr>
                    <td>{{ $row['user']->name }}</td>
                    <td>{{ $row['summary']['total_tasks'] }}</td>
                    <td>{{ $row['summary']['selesai'] }}</td>
                    <td>{{ $row['summary']['progress'] }}</td>
                    <td>{{ $row['summary']['kendala'] }}</td>
                    <td>{{ $row['summary']['completion_rate'] }}%</td>
                    <td>{{ $row['logging_rate'] }}%</td>
                    <td>{{ round($row['overtime_approved_minutes'] / 60, 1) }}</td>
                    <td>{{ $rp($row['overtime_cost']) }}</td>
                </tr>
            @empty
                <tr><td colspan="9" style="text-align:center;padding:24px;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
