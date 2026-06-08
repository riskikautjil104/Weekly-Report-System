<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <style>
        :root {
            --ink: #111827;
            --muted: #6b7280;
            --blue: #548dd4;
            --blue-soft: #c6d9f1;
            --orange: #fabf8f;
            --paper: #ffffff;
            --page: #f3f4f6;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--page);
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
        }

        .shell {
            width: min(1120px, calc(100vw - 24px));
            margin: 12px auto 24px;
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 18px;
            margin-bottom: 16px;
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.06);
        }

        .toolbar h1 {
            margin: 0;
            font-size: 18px;
        }

        .toolbar p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .toolbar a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            color: #374151;
            background: #fff;
            font-weight: 700;
        }

        .report-section {
            background: var(--paper);
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 22px 24px 26px;
            margin-bottom: 18px;
            box-shadow: 0 10px 30px rgba(17, 24, 39, 0.06);
            page-break-after: always;
        }

        .report-section:last-child {
            page-break-after: auto;
            margin-bottom: 0;
        }

        .company-line {
            display: block;
            width: 100%;
            max-width: 100%;
            margin: 2px 0 10px;
        }

        .header-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 8px;
        }

        .company-name {
            font-family: "Times New Roman", Times, serif;
            font-size: 28px;
            line-height: 1.05;
            text-align: center;
            margin: 0;
        }

        .tagline {
            margin: 4px 0 0;
            text-align: center;
            font-style: italic;
            font-size: 14px;
        }

        .report-title {
            margin: 8px 0 0;
            text-align: right;
            color: #8496b0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .info-table, .summary-table, .activity-table, .issue-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .info-table td, .summary-table td, .activity-table td, .activity-table th, .issue-table td, .issue-table th {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            vertical-align: top;
            word-break: break-word;
        }

        .info-table .label {
            width: 30%;
            background: var(--blue);
            color: #fff;
            font-weight: 700;
        }

        .section-title {
            margin: 18px 0 12px;
            font-size: 26px;
            font-weight: 800;
        }

        .summary-heading {
            margin: 16px 0 10px;
            font-size: 26px;
            font-weight: 800;
            text-decoration: underline;
        }

        .summary-table td {
            text-align: center;
            font-weight: 700;
            font-size: 28px;
            padding: 16px 10px;
        }

        .summary-table .metric {
            background: var(--blue-soft);
            font-size: 18px;
        }

        .table-title {
            margin: 16px 0 10px;
            font-size: 24px;
            font-weight: 800;
        }

        .activity-table th {
            background: var(--orange);
            font-size: 16px;
            text-align: center;
        }

        .activity-table td {
            font-size: 14px;
        }

        .activity-table .no {
            width: 60px;
            text-align: center;
        }

        .activity-table .status,
        .activity-table .pic {
            width: 140px;
            text-align: center;
        }

        .issue-table th {
            background: var(--orange);
            font-size: 16px;
            text-align: center;
        }

        .issue-table td {
            font-size: 14px;
        }

        .issue-table .no {
            width: 60px;
            text-align: center;
        }

        .issue-table .status,
        .issue-table .pic {
            width: 120px;
            text-align: center;
        }

        .muted {
            color: var(--muted);
        }

        @media print {
            body {
                background: #fff;
            }

            .shell {
                width: 100%;
                margin: 0;
            }

            .toolbar {
                display: none;
            }

            .report-section {
                box-shadow: none;
                border-radius: 0;
                border: none;
                margin: 0;
                padding: 0 0 10mm;
            }

            .report-section + .report-section {
                page-break-before: always;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="shell">
        <div class="toolbar">
            <div>
                <h1>{{ $pageTitle }}</h1>
                <p>{{ $pageLead }}</p>
            </div>
            <a href="javascript:window.print()">
                <span>Print</span>
            </a>
        </div>

        @foreach ($sections as $index => $section)
            <article class="report-section">
                <div class="header-row">
                    <div style="flex: 1 1 auto;">
                        <p class="company-name">PT KEMALA INTI SOLUSI</p>
                        <p class="tagline">“We Make IT Happen”</p>
                        @if (!empty($dividerDataUri))
                            <img class="company-line" src="{{ $dividerDataUri }}" alt="Company line">
                        @endif
                    </div>
                    @if (!empty($logoDataUri))
                        <div style="flex: 0 0 96px; text-align: right;">
                            <img src="{{ $logoDataUri }}" alt="Logo" style="width: 72px; height: auto;">
                        </div>
                    @endif
                </div>

                <p class="report-title">Weekly Report RSCHB</p>

                <table class="info-table">
                    <tr>
                        <td class="label">Periode Report</td>
                        <td>{{ $section['period_label'] }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tim / PiC</td>
                        <td>{{ $section['user'] }}</td>
                    </tr>
                </table>

                <div class="summary-heading">Ringkasan</div>

                <table class="summary-table">
                    <tr>
                        <td>{{ $section['summary']['total_tasks'] }}</td>
                        <td>{{ $section['summary']['selesai'] }}</td>
                        <td>{{ $section['summary']['progress'] }}</td>
                        <td>{{ $section['summary']['kendala'] }}</td>
                    </tr>
                    <tr>
                        <td class="metric">Total Taks</td>
                        <td class="metric">Selesai</td>
                        <td class="metric">On Progres</td>
                        <td class="metric">Tertunda / Kendala</td>
                    </tr>
                </table>

                <div class="section-title">Aktivitas / Output</div>
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>Aktivitas / Output</th>
                            <th class="status">Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($section['activities'] as $activity)
                            <tr>
                                <td class="no">{{ $activity['no'] }}</td>
                                <td>{{ $activity['aktivitas'] }}</td>
                                <td class="status">{{ $activity['status'] }}</td>
                                <td>{{ $activity['keterangan'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="no">-</td>
                                <td>-</td>
                                <td class="status">-</td>
                                <td>-</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="section-title" style="margin-top: 18px;">Kendala dan Solusi</div>
                <table class="issue-table">
                    <thead>
                        <tr>
                            <th class="no">No</th>
                            <th>Kendala</th>
                            <th>Solusi / Tindak Lanjut</th>
                            <th class="pic">PiC</th>
                            <th class="status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($section['issues'] as $issue)
                            <tr>
                                <td class="no">{{ $issue['no'] }}</td>
                                <td>{{ $issue['kendala'] }}</td>
                                <td>{{ $issue['solusi'] }}</td>
                                <td class="pic">{{ $issue['pic'] }}</td>
                                <td class="status">{{ $issue['status'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="no">-</td>
                                <td>-</td>
                                <td>-</td>
                                <td class="pic">-</td>
                                <td class="status">-</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </article>
        @endforeach
    </div>
</body>
</html>
