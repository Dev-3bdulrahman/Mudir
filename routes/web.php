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
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/services', \App\Livewire\Admin\Services\Index::class)->name('admin.services');
    Route::get('/clients', \App\Livewire\Admin\Clients\Index::class)->name('admin.clients');
    Route::get('/projects', \App\Livewire\Admin\Projects\Index::class)->name('admin.projects');
    Route::get('/portfolio', \App\Livewire\Admin\Portfolio\Index::class)->name('admin.portfolio');
    Route::get('/invoices', \App\Livewire\Admin\Invoices\Index::class)->name('admin.invoices');
    Route::get('/tickets', \App\Livewire\Admin\Tickets\Index::class)->name('admin.tickets');
    Route::get('/contracts', \App\Livewire\Admin\Contracts\Index::class)->name('admin.contracts');
    Route::get('/subscribers', \App\Livewire\Admin\Subscribers\Index::class)->name('admin.subscribers');
});
