<?php

return [
    'default_monthly_salary' => (int) env('PAYROLL_MONTHLY_SALARY', 3_500_000),
    'working_days_per_month' => (int) env('PAYROLL_WORKING_DAYS', 26),
    'hours_per_day' => (int) env('PAYROLL_HOURS_PER_DAY', 8),
    'work_start' => env('PAYROLL_WORK_START', '08:00'),
    'work_end' => env('PAYROLL_WORK_END', '16:00'),
    'overtime_multiplier' => (float) env('PAYROLL_OVERTIME_MULTIPLIER', 1.5),
    'work_days_iso' => [1, 2, 3, 4, 5, 6],
];
