<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MonthlySheetController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()?->role;

    if ($role === 'admin') {
        return redirect()->route('dashboard.admin');
    }

    return redirect()->route('dashboard.user');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/user', [DashboardController::class, 'index'])
        ->name('dashboard.user');

    Route::get('/activities', [ActivityController::class, 'index'])
        ->name('activities.index');
    Route::get('/activities/create', [ActivityController::class, 'create'])
        ->name('activities.create');
    Route::post('/activities', [ActivityController::class, 'store'])
        ->name('activities.store');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])
        ->name('activities.edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])
        ->name('activities.update');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])
        ->name('activities.destroy');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
    Route::get('/sheets', [SheetController::class, 'show'])->name('sheets.show');

    Route::middleware('ensureAdmin')->group(function () {
        Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
            ->name('dashboard.admin');

        Route::get('/reports/system', [ReportController::class, 'system'])
            ->name('reports.system');
        Route::get('/reports/system/print', [ReportController::class, 'systemPrint'])
            ->name('reports.system.print');
        Route::get('/reports/system/export', [ReportController::class, 'systemExport'])
            ->name('reports.system.export');

        Route::get('/admin/sheets', [MonthlySheetController::class, 'index'])
            ->name('admin.sheets.index');
        Route::post('/admin/sheets', [MonthlySheetController::class, 'store'])
            ->name('admin.sheets.store');
        Route::patch('/admin/sheets/{monthlySheet}/activate', [MonthlySheetController::class, 'activate'])
            ->name('admin.sheets.activate');
        Route::delete('/admin/sheets/{monthlySheet}', [MonthlySheetController::class, 'destroy'])
            ->name('admin.sheets.destroy');

        Route::resource('/admin/users', UserManagementController::class)
            ->names('admin.users')
            ->except('show');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
