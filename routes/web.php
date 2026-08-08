<?php

use App\Http\Controllers\RegulationController;
use App\Http\Controllers\Admin\AdminRegulationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\AdminReportController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [RegulationController::class, 'index'])->name('landing');
Route::get('/search', [RegulationController::class, 'search'])->name('search');
Route::get('/regulation/{id}', [RegulationController::class, 'show'])->name('detail');
Route::get('/regulation/{id}/download', [RegulationController::class, 'download'])->name('regulation.download');
Route::post('/regulation/{id}/chat', [RegulationController::class, 'chat'])->name('regulation.chat');
Route::get('/statistics', [RegulationController::class, 'statistics'])->name('stats');
Route::get('/statistics/export', [RegulationController::class, 'exportExcel'])->name('stats.export');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Panel Routes (authenticated)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/regulations/export', [AdminRegulationController::class, 'exportExcel'])->name('regulations.export');
    Route::get('/regulations', [AdminRegulationController::class, 'index'])->name('regulations.index');
    Route::get('/regulations/create', [AdminRegulationController::class, 'create'])->name('regulations.create');
    Route::post('/regulations', [AdminRegulationController::class, 'store'])->name('regulations.store');
    Route::get('/regulations/{id}/edit', [AdminRegulationController::class, 'edit'])->name('regulations.edit');
    Route::put('/regulations/{id}', [AdminRegulationController::class, 'update'])->name('regulations.update');
    Route::delete('/regulations/{id}', [AdminRegulationController::class, 'destroy'])->name('regulations.destroy');
    Route::get('/settings', [AuthController::class, 'showSettingsForm'])->name('settings');
    Route::post('/settings', [AuthController::class, 'updateSettings'])->name('settings.update');
    
    // Reports Management
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::patch('/reports/{id}', [AdminReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{id}', [AdminReportController::class, 'destroy'])->name('reports.destroy');
});

// API Routes (BPHN / JDIHN Harvesting standard)
Route::prefix('api')->group(function () {
    Route::get('/regulations', [ApiController::class, 'index'])->name('api.regulations');
    Route::get('/regulations/{id}', [ApiController::class, 'show'])->name('api.regulations.show');
});
