<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($pageTitle); ?></title>
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

        /* ── Toolbar (screen only) ── */
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

        /* ── Page / Section ── */
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

        /* ── Header: 3-kolom grid
             [logo] [nama + tagline tengah] [Weekly Report kanan-bawah]
        ── */
        .header-row {
            display: grid;
            grid-template-columns: 100px 1fr 130px;
            align-items: center;
            margin-bottom: 0;
        }
        .header-logo img {
            width: 80px;
            height: auto;
            display: block;
        }
        .header-identity {
            text-align: center;
        }
        .company-name {
            font-family: "Times New Roman", Times, serif;
            font-size: 26px;
            font-weight: bold;
            line-height: 1.1;
            margin: 0;
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
            color: #8496b0;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        /* ── Divider image (full width) ── */
        .company-line {
            display: block;
            width: 100%;
            max-width: 100%;
            margin: 8px 0 0;
        }

        /* ── Report title centered ── */
        .report-title-center {
            text-align: center;
            font-size: 20px;
            font-weight: 900;
            letter-spacing: 0.04em;
            margin: 18px 0 14px;
            text-transform: uppercase;
        }

        /* ── Info table ── */
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
            font-size: 14px;
        }
        .info-table .label {
            width: 30%;
            background: var(--blue);
            color: #fff;
            font-weight: 700;
        }

        /* ── Ringkasan heading ── */
        .summary-heading {
            margin: 18px 0 10px;
            font-size: 24px;
            font-weight: 900;
            font-style: italic;
        }

        /* ── Summary table ── */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
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
            font-weight: 700;
            padding: 8px 10px;
        }

        /* ── Section titles ── */
        .section-title {
            margin: 16px 0 10px;
            font-size: 22px;
            font-weight: 900;
            font-style: italic;
        }

        /* ── Activity table ── */
        .activity-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .activity-table th {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            font-size: 14px;
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
        .activity-table .no {
            width: 50px;
            text-align: center;
        }
        .activity-table .status {
            width: 110px;
            text-align: center;
        }
        .activity-table td.status {
            text-decoration: underline;
        }

        /* ── Issue table ── */
        .issue-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .issue-table th {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            font-size: 14px;
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
        .issue-table .no {
            width: 50px;
            text-align: center;
        }
        .issue-table .pic {
            width: 110px;
            text-align: center;
        }
        .issue-table .status {
            width: 100px;
            text-align: center;
        }

        .muted { color: var(--muted); }

        /* ── Print ── */
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
                <h1><?php echo e($pageTitle); ?></h1>
                <p><?php echo e($pageLead); ?></p>
            </div>
            <a href="javascript:window.print()">
                <span>Print</span>
            </a>
        </div>

        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="report-section">

                
                <div class="header-row">
                    
                    <div class="header-logo">
                        <?php if(!empty($logoDataUri)): ?>
                            <img src="<?php echo e($logoDataUri); ?>" alt="Logo">
                        <?php endif; ?>
                    </div>

                    
                    <div class="header-identity">
                        <p class="company-name">PT KEMALA INTI SOLUSI</p>
                        <p class="tagline">"We Make IT Happen"</p>
                    </div>

                    
                    <div class="header-right">
                        <p class="report-label-top">Weekly Report</p>
                    </div>
                </div>

                
                <?php if(!empty($dividerDataUri)): ?>
                    <img class="company-line" src="<?php echo e($dividerDataUri); ?>" alt="">
                <?php endif; ?>

                
                <div class="report-title-center">Weekly Report RSCHB</div>

                
                <table class="info-table">
                    <tr>
                        <td class="label">Periode Report</td>
                        <td><?php echo e($section['period_label']); ?></td>
                    </tr>
                    <tr>
                        <td class="label">Tim / PiC</td>
                        <td><?php echo e($section['user']); ?></td>
                    </tr>
                </table>

                
                <div class="summary-heading">A.Ringkasan</div>

                <table class="summary-table">
                    <tr>
                        <td><?php echo e($section['summary']['total_tasks']); ?></td>
                        <td><?php echo e($section['summary']['selesai']); ?></td>
                        <td><?php echo e($section['summary']['progress']); ?></td>
                        <td><?php echo e($section['summary']['kendala']); ?></td>
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
                        <?php $__empty_1 = true; $__currentLoopData = $section['activities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="no"><?php echo e($activity['no']); ?></td>
                                <td><?php echo e($activity['aktivitas']); ?></td>
                                <td class="status"><?php echo e($activity['status']); ?></td>
                                <td><?php echo e($activity['keterangan']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="no">-</td>
                                <td>-</td>
                                <td class="status">-</td>
                                <td>-</td>
                            </tr>
                        <?php endif; ?>
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
                        <?php $__empty_1 = true; $__currentLoopData = $section['issues']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="no"><?php echo e($issue['no']); ?></td>
                                <td><?php echo e($issue['kendala']); ?></td>
                                <td><?php echo e($issue['solusi']); ?></td>
                                <td class="pic"><?php echo e($issue['pic']); ?></td>
                                <td class="status"><?php echo e($issue['status']); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="no">-</td>
                                <td>-</td>
                                <td>-</td>
                                <td class="pic">-</td>
                                <td class="status">-</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</body>
</html><?php /**PATH /Users/rizkihiibrahim/Downloads/folder tanpa judul/projects/weekly-report/resources/views/reports/system-print.blade.php ENDPATH**/ ?>