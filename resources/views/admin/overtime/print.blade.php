<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Lembur - {{ $filters['period_label'] }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111; margin: 24px; font-size: 12px; }
        h1 { font-size: 20px; margin: 0 0 4px; }
        .meta { color: #555; margin-bottom: 20px; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat { border: 1px solid #ddd; border-radius: 8px; padding: 12px; }
        .stat-label { font-size: 10px; text-transform: uppercase; color: #666; }
        .stat-value { font-size: 18px; font-weight: bold; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top; }
        th { background: #f5f5f5; font-size: 10px; text-transform: uppercase; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: bold; }
        .badge-submitted { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        @media print {
            body { margin: 12px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 16px;">
        <button onclick="window.print()" style="padding: 10px 16px; cursor: pointer;">Print / Save as PDF</button>
    </div>

    <h1>Laporan Lembur</h1>
    <p class="meta">
        Periode: {{ $filters['period_label'] }}<br>
        Dicetak: {{ $generatedAt->format('d M Y H:i') }}
    </p>

    <div class="stats">
        <div class="stat">
            <div class="stat-label">Total Laporan</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">Disetujui</div>
            <div class="stat-value">{{ $stats['approved'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">Menunggu</div>
            <div class="stat-value">{{ $stats['submitted'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">Total Jam Disetujui</div>
            <div class="stat-value">{{ intdiv($stats['total_minutes'], 60) }}j {{ $stats['total_minutes'] % 60 }}m</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Durasi</th>
                <th>Alasan</th>
                <th>Status</th>
                <th>Lokasi</th>
                <th>Hash Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($overtimes as $index => $overtime)
                @php
                    $meta = $overtime->captureMetadata;
                    $badgeClass = match ($overtime->status) {
                        'approved' => 'badge-approved',
                        'rejected' => 'badge-rejected',
                        default => 'badge-submitted',
                    };
                    $statusLabel = match ($overtime->status) {
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => 'Menunggu',
                    };
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $overtime->user->name }}</td>
                    <td>{{ $overtime->tanggal->format('d/m/Y') }}</td>
                    <td>
                        {{ \Illuminate\Support\Str::of($overtime->jam_mulai)->substr(0, 5) }}
                        - {{ \Illuminate\Support\Str::of($overtime->jam_selesai)->substr(0, 5) }}
                    </td>
                    <td>{{ $overtime->formattedDuration() }}</td>
                    <td>{{ $overtime->alasan }}</td>
                    <td><span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span></td>
                    <td>{{ $meta?->formattedLocation() ?? '—' }}</td>
                    <td style="font-family: monospace; font-size: 10px;">{{ $meta ? \Illuminate\Support\Str::limit($meta->image_hash, 16) : '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 24px;">Tidak ada data lembur untuk filter ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
