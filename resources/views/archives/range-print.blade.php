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
            --blue-soft: #a5ceff;
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
        .toolbar h1 { margin: 0; font-size: 18px; }
        .toolbar p  { margin: 4px 0 0; color: var(--muted); font-size: 13px; }
        .toolbar a  {
            display: inline-flex;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            color: #374151;
            background: #fff;
            font-weight: 700;
            text-decoration: none;
            align-items: center;
            gap: 8px;
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

        .header-row {
            display: grid;
            grid-template-columns: 100px 1fr 130px;
            align-items: center;
            margin-bottom: 0;
        }
        .header-logo img {
            width: 75px;
            height: auto;
            display: block;
        }
        .header-identity { text-align: center; }
        .company-name {
            font-family: "Times New Roman", Times, serif;
            font-size: 26px;
            line-height: 1.1;
            margin: 0;
            font-weight: bold;
        }
        .tagline {
            margin: 2px 0 0;
            font-style: italic;
            font-size: 13px;
        }
        .header-right {
            text-align: right;
            align-self: flex-end;
        }
        .report-label-top {
            margin: 0;
            color: #9aa4b2;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .report-title-center {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            letter-spacing: 0.04em;
            margin: 18px 0 14px;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .info-table td {
            border: 1px solid #d1d5db;
            padding: 7px 10px;
            vertical-align: top;
            word-break: break-word;
            font-size: 18px;
        }
        .info-table .label {
            width: 30%;
            background: var(--blue);
            color: #fff;
            font-weight: 700;
        }

        .summary-heading {
            margin: 18px 0 10px;
            font-size: 24px;
            font-weight: bold;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-weight: bold;
        }
        .summary-table td {
            border: 1px solid #d1d5db;
            text-align: center;
            font-weight: 700;
            font-size: 28px;
            padding: 14px 10px;
            vertical-align: middle;
        }
        .summary-table .metric {
            background: var(--blue-soft);
            font-size: 16px;
            padding: 8px 10px;
        }

        .section-title {
            margin: 16px 0 10px;
            font-size: 22px;
            font-weight: bold;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .activity-table th {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            font-size: 17px;
            text-align: center;
            font-weight: 700;
            text-decoration: underline;
            background: #fff;
            vertical-align: top;
        }
        .activity-table td {
            border: 1px solid #d1d5db;
            padding: 7px 10px;
            font-size: 13px;
            vertical-align: top;
            word-break: break-word;
        }
        .activity-table .no { width: 50px; text-align: center; }
        .activity-table .status { width: 110px; text-align: center; }
        .activity-table td.status { text-decoration: underline; }

        .issue-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .issue-table th {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            font-size: 17px;
            text-align: center;
            font-weight: 700;
            background: var(--orange);
            vertical-align: top;
        }
        .issue-table td {
            border: 1px solid #d1d5db;
            padding: 7px 10px;
            font-size: 13px;
            vertical-align: top;
            word-break: break-word;
        }
        .issue-table .no { width: 50px; text-align: center; }
        .issue-table .pic { width: 110px; text-align: center; }
        .issue-table .status { width: 100px; text-align: center; }

        @media print {
            body { background: #fff; }
            .shell { width: 100%; margin: 0; }
            .toolbar { display: none; }
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
            <a href="javascript:window.print()"><span>Print</span></a>
        </div>

        @forelse ($reports as $report)
            @php
                $snapshot = $report['snapshot'];
            @endphp

            <article class="report-section">

                <div class="header-row">
                    <div class="header-logo">
                        <img src="{{ asset('logo.png') }}" alt="Logo">
                    </div>

                    <div class="header-identity">
                        <p class="company-name">PT KEMALA INTI SOLUSI</p>
                        <p class="tagline">"We Make IT Happen"</p>
                    </div>

                    <div class="header-right">
                        <p class="report-label-top">Archive PDF</p>
                    </div>

                {{-- NOTE: Snapshot berasal dari controller untuk tiap periode --}}
                </div>

                <div class="report-title-center">Weekly Report RSCHB</div>

                <table class="info-table">
                    <tr>
                        <td class="label">Periode Report</td>
                        <td>{{ $report['week_start']->translatedFormat('d M Y') }} - {{ $report['week_end']->translatedFormat('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tim / PiC</td>
                        <td>{{ $report['user_name'] ?? '-' }}</td>
                    </tr>
                </table>

                <div class="summary-heading">A.Ringkasan</div>

                <table class="summary-table">
                    <tr>
                        <td>{{ $snapshot['summary']['total_tasks'] ?? 0 }}</td>
                        <td>{{ $snapshot['summary']['selesai'] ?? 0 }}</td>
                        <td>{{ $snapshot['summary']['progress'] ?? 0 }}</td>
                        <td>{{ $snapshot['summary']['kendala'] ?? 0 }}</td>
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
                            <th class="no"><u>No</u></th>
                            <th><u>Aktivitas / Output</u></th>
                            <th class="status"><u>Status</u></th>
                            <th><u>Keterangan</u></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($snapshot['activities'] as $activity)
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
                        @forelse ($snapshot['issues'] as $issue)
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
        @empty
            <div class="text-center text-sm text-on-surface-variant">Belum ada arsip pada range yang dipilih.</div>
        @endforelse

    </div>
</body>
</html>

