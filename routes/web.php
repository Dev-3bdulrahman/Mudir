<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Install\Installer;
use App\Services\DashboardCodeService;

Route::get('/', function () {
    if (file_exists(storage_path('app/license_config.json'))) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('install.index');
});

// Installation Routes
Route::get('/install', Installer::class)->name('install.index');

// Protected Admin Routes
Route::middleware(['web', 'license'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        $dashboardService = app(DashboardCodeService::class);
        $code = $dashboardService->getDashboardCode();
        
        if (!$code) {
            return "Failed to load dashboard core. Please check your license status or contact support.";
        }

        return view('admin.dashboard', ['code' => $code]);
    })->name('admin.dashboard');
});
