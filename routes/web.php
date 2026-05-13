<?php

use App\Http\Controllers\DepositController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditUpdateController; // Keep this line
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SummaryReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login'); // Points directly to your login page
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Cache Invalidation Route
 */
Route::get('/system/clear-cache', function () {
    Artisan::call('optimize:clear');
    Artisan::call('view:clear');
    return "System cache and views have been successfully cleared.";
})->middleware(['auth', 'admin'])->name('system.cache.clear');

Route::middleware(['auth', 'last_seen'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('transactions/export-excel', [TransactionController::class, 'exportExcel'])->name('transactions.export-excel');
    Route::resource('transactions', TransactionController::class);
    Route::resource('deposits', DepositController::class);
    
    /**
     * Admin-Only Modules
     * These routes are restricted to users with the 'admin' role.
     */
    Route::middleware(['admin'])->group(function () {
        // Accounts Module (User Management)
        Route::resource('user-management', UserManagementController::class);

        // Edit/Update Module
        Route::resource('edit-update', EditUpdateController::class)->only(['index', 'edit', 'update', 'destroy'])->parameters([
            'edit-update' => 'id'
        ]);
    });
    
    Route::get('reports', [SummaryReportController::class, 'index'])->name('reports.index');
    Route::get('reports/summary', [SummaryReportController::class, 'generate'])->name('reports.summary');
    Route::get('reports/export', [SummaryReportController::class, 'export'])->name('summary.report.export');
    Route::get('reports/soe', [SummaryReportController::class, 'generateSOE'])->name('reports.soe');
    Route::get('reports/soe/download', [SummaryReportController::class, 'downloadSOE'])->name('reports.soe.download');
    Route::get('reports/cdr', [SummaryReportController::class, 'generateCDR'])->name('reports.cdr');
    Route::get('reports/cdr/download', [SummaryReportController::class, 'downloadCDR'])->name('reports.cdr.download');
});

require __DIR__.'/auth.php';
