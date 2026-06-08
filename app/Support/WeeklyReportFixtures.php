<?php

namespace App\Support;

use Illuminate\Support\Carbon;

class WeeklyReportFixtures
{
    public static function weekLabel(): string
    {
        return 'Week 23, 2026';
    }

    public static function trend(): array
    {
        return [
            ['label' => 'Sen', 'value' => 4],
            ['label' => 'Sel', 'value' => 5],
            ['label' => 'Rab', 'value' => 3],
            ['label' => 'Kam', 'value' => 6],
            ['label' => 'Jum', 'value' => 4],
            ['label' => 'Sab', 'value' => 2],
        ];
    }

    public static function reminders(): array
    {
        return [
            'Isi aktivitas harian sebelum jam 16:00.',
            'Pastikan status sudah benar sebelum submit weekly report.',
            'Selesaikan kendala yang belum di-update ke admin.',
        ];
    }

    public static function draftActivities(): array
    {
        return [
            ['time' => '09:15', 'aktivitas' => 'Meeting sprint planning', 'status' => 'selesai'],
            ['time' => '11:00', 'aktivitas' => 'Integrasi API login', 'status' => 'progress'],
            ['time' => '14:30', 'aktivitas' => 'Review bug dashboard', 'status' => 'kendala'],
        ];
    }

    public static function activities(): array
    {
        return [
            ['tanggal' => Carbon::today()->subDays(2)->toDateString(), 'aktivitas' => 'Membuat wireframe dashboard user', 'status' => 'selesai', 'keterangan' => 'Disetujui stakeholder'],
            ['tanggal' => Carbon::today()->subDays(2)->toDateString(), 'aktivitas' => 'Menyiapkan skema migration awal', 'status' => 'progress', 'keterangan' => 'Menunggu final field'],
            ['tanggal' => Carbon::today()->subDays(1)->toDateString(), 'aktivitas' => 'Debug validasi form aktivitas', 'status' => 'kendala', 'keterangan' => 'Masih ada edge case tanggal'],
            ['tanggal' => Carbon::today()->subDays(1)->toDateString(), 'aktivitas' => 'Update layout user management', 'status' => 'selesai', 'keterangan' => 'Tampilan sudah konsisten'],
            ['tanggal' => Carbon::today()->toDateString(), 'aktivitas' => 'Menulis dokumentasi weekly report', 'status' => 'progress', 'keterangan' => 'Sedang finalisasi'],
            ['tanggal' => Carbon::today()->toDateString(), 'aktivitas' => 'Mengecek reminder scheduler', 'status' => 'selesai', 'keterangan' => 'Scaffold command siap'],
            ['tanggal' => Carbon::today()->toDateString(), 'aktivitas' => 'Meninjau tampilan mobile', 'status' => 'progress', 'keterangan' => 'Perlu adjustment spacing'],
        ];
    }

    public static function adminActivities(): array
    {
        return [
            ['user' => 'Alex Rivera', 'tanggal' => Carbon::today()->toDateString(), 'aktivitas' => 'Review laporan tim engineering', 'status' => 'selesai', 'department' => 'Engineering'],
            ['user' => 'Maya Santoso', 'tanggal' => Carbon::today()->toDateString(), 'aktivitas' => 'Menyiapkan copy reminder WA', 'status' => 'progress', 'department' => 'Operations'],
            ['user' => 'Raka Pratama', 'tanggal' => Carbon::today()->subDay()->toDateString(), 'aktivitas' => 'Perbaikan dashboard report', 'status' => 'kendala', 'department' => 'Product'],
            ['user' => 'Dina Putri', 'tanggal' => Carbon::today()->subDay()->toDateString(), 'aktivitas' => 'Rekap weekly KPI', 'status' => 'selesai', 'department' => 'HR'],
            ['user' => 'Bima Nugraha', 'tanggal' => Carbon::today()->subDays(2)->toDateString(), 'aktivitas' => 'Audit data input harian', 'status' => 'progress', 'department' => 'Finance'],
            ['user' => 'Siska Amelia', 'tanggal' => Carbon::today()->subDays(2)->toDateString(), 'aktivitas' => 'Menentukan format export PDF', 'status' => 'selesai', 'department' => 'Admin'],
            ['user' => 'Tio Mahendra', 'tanggal' => Carbon::today()->subDays(3)->toDateString(), 'aktivitas' => 'Sinkronisasi data user', 'status' => 'kendala', 'department' => 'Engineering'],
            ['user' => 'Nadia Wulandari', 'tanggal' => Carbon::today()->subDays(3)->toDateString(), 'aktivitas' => 'Validasi role akses', 'status' => 'selesai', 'department' => 'Operations'],
        ];
    }

    public static function reports(): array
    {
        return [
            ['periode' => '1 - 7 Jun 2026', 'total' => 18, 'selesai' => 9, 'progress' => 6, 'kendala' => 3, 'rate' => '50%'],
            ['periode' => '25 - 31 May 2026', 'total' => 22, 'selesai' => 13, 'progress' => 7, 'kendala' => 2, 'rate' => '59%'],
            ['periode' => '18 - 24 May 2026', 'total' => 20, 'selesai' => 12, 'progress' => 5, 'kendala' => 3, 'rate' => '60%'],
            ['periode' => '11 - 17 May 2026', 'total' => 16, 'selesai' => 8, 'progress' => 5, 'kendala' => 3, 'rate' => '50%'],
        ];
    }

    public static function systemReports(): array
    {
        return [
            ['user' => 'Alex Rivera', 'periode' => '1 - 7 Jun 2026', 'status' => 'selesai', 'submission_rate' => '100%', 'open_blockers' => 0],
            ['user' => 'Maya Santoso', 'periode' => '1 - 7 Jun 2026', 'status' => 'progress', 'submission_rate' => '86%', 'open_blockers' => 1],
            ['user' => 'Raka Pratama', 'periode' => '1 - 7 Jun 2026', 'status' => 'kendala', 'submission_rate' => '71%', 'open_blockers' => 2],
            ['user' => 'Dina Putri', 'periode' => '1 - 7 Jun 2026', 'status' => 'selesai', 'submission_rate' => '93%', 'open_blockers' => 0],
            ['user' => 'Bima Nugraha', 'periode' => '1 - 7 Jun 2026', 'status' => 'progress', 'submission_rate' => '79%', 'open_blockers' => 1],
        ];
    }

    public static function users(): array
    {
        return [
            ['name' => 'Alex Rivera', 'email' => 'alex@weeklyreport.test', 'role' => 'admin', 'department' => 'Engineering', 'status' => 'ACTIVE', 'last_seen' => 'Today 08:45'],
            ['name' => 'Maya Santoso', 'email' => 'maya@weeklyreport.test', 'role' => 'user', 'department' => 'Operations', 'status' => 'ACTIVE', 'last_seen' => 'Today 07:50'],
            ['name' => 'Raka Pratama', 'email' => 'raka@weeklyreport.test', 'role' => 'user', 'department' => 'Product', 'status' => 'ACTIVE', 'last_seen' => 'Yesterday 18:10'],
            ['name' => 'Dina Putri', 'email' => 'dina@weeklyreport.test', 'role' => 'user', 'department' => 'HR', 'status' => 'ACTIVE', 'last_seen' => 'Yesterday 16:30'],
            ['name' => 'Bima Nugraha', 'email' => 'bima@weeklyreport.test', 'role' => 'user', 'department' => 'Finance', 'status' => 'PENDING', 'last_seen' => 'Today 09:05'],
            ['name' => 'Siska Amelia', 'email' => 'siska@weeklyreport.test', 'role' => 'user', 'department' => 'Admin', 'status' => 'ACTIVE', 'last_seen' => 'Today 10:20'],
        ];
    }

    public static function profile(): array
    {
        return [
            'name' => 'Alex Rivera',
            'role' => 'System Admin',
            'email' => 'alex@weeklyreport.test',
            'department' => 'Engineering',
            'phone' => '+62 812-3456-7890',
            'initials' => 'AR',
        ];
    }

    public static function adminMetrics(): array
    {
        return [
            ['label' => 'Total Reports', 'value' => '124', 'note' => '+12% from last week', 'icon' => 'description', 'tone' => 'primary'],
            ['label' => 'Submission Rate', 'value' => '88%', 'note' => '14 pending entries', 'icon' => 'task_alt', 'tone' => 'success'],
            ['label' => 'Open Blockers', 'value' => '9', 'note' => '3 need immediate attention', 'icon' => 'priority_high', 'tone' => 'warning'],
            ['label' => 'Active Users', 'value' => '31', 'note' => '2 new users this week', 'icon' => 'groups', 'tone' => 'neutral'],
        ];
    }

    public static function teamPerformance(): array
    {
        return [
            ['name' => 'Engineering', 'completed' => 92, 'progress' => 6, 'kendala' => 2],
            ['name' => 'Operations', 'completed' => 84, 'progress' => 10, 'kendala' => 6],
            ['name' => 'Product', 'completed' => 76, 'progress' => 14, 'kendala' => 10],
            ['name' => 'Admin', 'completed' => 95, 'progress' => 4, 'kendala' => 1],
        ];
    }

    public static function reportFilters(): array
    {
        return [
            'dateRange' => '1 Jun 2026 - 7 Jun 2026',
            'departments' => ['All Departments', 'Engineering', 'Operations', 'Product', 'HR', 'Finance', 'Admin'],
            'statuses' => ['All Status', 'selesai', 'progress', 'kendala'],
        ];
    }

    public static function userFilters(): array
    {
        return [
            'roles' => ['All Roles', 'admin', 'user'],
            'departments' => ['All Departments', 'Engineering', 'Operations', 'Product', 'HR', 'Finance', 'Admin'],
        ];
    }
}
