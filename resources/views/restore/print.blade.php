<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; color: #111827; }
        h1, h2, h3, p { margin: 0 0 12px; }
        .muted { color: #6b7280; }
        .grid { display: grid; gap: 12px; }
        .metrics { grid-template-columns: repeat(4, minmax(0, 1fr)); margin: 20px 0; }
        .card { border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: left; vertical-align: top; }
        th { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #6b7280; }
        @media print {
            body { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <h1>{{ $pageTitle }}</h1>
    <p class="muted">{{ $pageLead }}</p>
    <p class="muted">Account: {{ $userName }}</p>
    <p class="muted">Range: {{ $filters['dateRange'] }}</p>

    <div class="grid metrics">
        <div class="card">
            <p class="muted">Total Task</p>
            <h2>{{ $summary['total_tasks'] }}</h2>
        </div>
        <div class="card">
            <p class="muted">Selesai</p>
            <h2>{{ $summary['selesai'] }}</h2>
        </div>
        <div class="card">
            <p class="muted">Progress</p>
            <h2>{{ $summary['progress'] }}</h2>
        </div>
        <div class="card">
            <p class="muted">Kendala</p>
            <h2>{{ $summary['kendala'] }}</h2>
        </div>
    </div>

    <h2>Detail Aktivitas</h2>
    @forelse ($activities->groupBy(fn ($activity) => $activity->tanggal?->translatedFormat('d M Y')) as $day => $items)
        <h3 style="margin-top: 18px;">{{ $day }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Aktivitas</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $activity)
                    <tr>
                        <td>{{ $activity->aktivitas }}</td>
                        <td>{{ ucfirst($activity->status) }}</td>
                        <td>{{ $activity->keterangan ?: '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p class="muted">No data found.</p>
    @endforelse
</body>
</html>
