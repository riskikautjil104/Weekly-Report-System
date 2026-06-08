<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard route
// Dashboard
// - Admin: /dashboard/admin + shortcut /dashboard
// - User biasa: /dashboard/user + shortcut /dashboard
Route::get('/dashboard', function () {
    $role = auth()->user()?->role;

    if ($role === 'admin') {
        return redirect()->route('dashboard.admin');
    }

    return redirect()->route('dashboard.user');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // User dashboard
    Route::get('/dashboard/user', [DashboardController::class, 'index'])
        ->name('dashboard.user');

    // Daily activity input (flow)
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

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');

    // Admin only
    Route::middleware('ensureAdmin')->group(function () {
        Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
            ->name('dashboard.admin');

        Route::get('/reports/system', [ReportController::class, 'system'])
            ->name('reports.system');
        Route::get('/reports/system/print', [ReportController::class, 'systemPrint'])
            ->name('reports.system.print');
        Route::get('/reports/system/export', [ReportController::class, 'systemExport'])
            ->name('reports.system.export');

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
