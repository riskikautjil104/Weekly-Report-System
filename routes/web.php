<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MonthlySheetController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequirementCommentController;



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
Route::post('requirements/{requirement}/comments', [RequirementCommentController::class, 'store'])
    ->name('requirements.comments.store');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/user', [DashboardController::class, 'index'])
        ->name('dashboard.user');

    // Requirements Gathering
    Route::resource('requirements', \App\Http\Controllers\RequirementController::class)->only([
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update'
    ]);

    Route::get('/requirements/{requirement}/print', [\App\Http\Controllers\RequirementController::class, 'print'])
        ->name('requirements.print');

    Route::post('/requirements/{requirement}/comments', [\App\Http\Controllers\RequirementCommentController::class, 'store'])
        ->name('requirements.comments.store');


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
    Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');
    Route::get('/archives/{weeklyReport}/print', [ArchiveController::class, 'print'])->name('archives.print');
    Route::get('/archives/print-range', [ArchiveController::class, 'printRange'])->name('archives.printRange');
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
