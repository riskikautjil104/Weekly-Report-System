<?php

namespace App\Services;

class PayrollCalculatorService
{
    public function monthlySalary(?int $override = null): int
    {
        return $override ?? (int) config('payroll.default_monthly_salary');
    }

    public function workingDaysPerMonth(): int
    {
        return (int) config('payroll.working_days_per_month');
    }

    public function hoursPerDay(): int
    {
        return (int) config('payroll.hours_per_day');
    }

    public function overtimeMultiplier(): float
    {
        return (float) config('payroll.overtime_multiplier');
    }

    public function dailyRate(?int $monthlySalary = null): float
    {
        $salary = $this->monthlySalary($monthlySalary);
        $days = max(1, $this->workingDaysPerMonth());

        return $salary / $days;
    }

    public function hourlyRate(?int $monthlySalary = null): float
    {
        return $this->dailyRate($monthlySalary) / max(1, $this->hoursPerDay());
    }

    public function overtimeRate(?int $monthlySalary = null): float
    {
        return $this->hourlyRate($monthlySalary) * $this->overtimeMultiplier();
    }

    public function overtimeCost(int $minutes, ?int $monthlySalary = null): float
    {
        if ($minutes <= 0) {
            return 0;
        }

        return ($minutes / 60) * $this->overtimeRate($monthlySalary);
    }

    public function ratesSummary(?int $monthlySalary = null): array
    {
        return [
            'monthly_salary' => $this->monthlySalary($monthlySalary),
            'working_days_per_month' => $this->workingDaysPerMonth(),
            'hours_per_day' => $this->hoursPerDay(),
            'work_start' => config('payroll.work_start'),
            'work_end' => config('payroll.work_end'),
            'daily_rate' => $this->dailyRate($monthlySalary),
            'hourly_rate' => $this->hourlyRate($monthlySalary),
            'overtime_multiplier' => $this->overtimeMultiplier(),
            'overtime_hourly_rate' => $this->overtimeRate($monthlySalary),
        ];
    }

    public function formatRupiah(float|int $amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }
}
