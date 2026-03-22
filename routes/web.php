<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Child Project — Web Routes
|--------------------------------------------------------------------------
| Architecture:
|   - Public/Frontend routes: NO license check — always accessible
|   - Admin routes: requires auth + valid license from parent
|--------------------------------------------------------------------------
*/

// ─── Public / Frontend ─────────────────────────────────────────────────────
Route::get('/', \App\Livewire\Landing::class)->name('home');

// Language switcher
Route::get('/lang/{locale}/{scope?}', function ($locale, $scope = null) {
    if (!in_array($locale, ['ar', 'en'])) {
        return redirect()->back();
    }
    if (!$scope) {
        $referer = request()->header('referer');
        $scope = ($referer && str_contains($referer, '/admin')) ? 'admin' : 'frontend';
    }
    session()->put($scope === 'admin' ? 'locale_dashboard' : 'locale_landing', $locale);
    session()->save();
    return redirect()->back();
})->name('lang');

// ─── Auth ──────────────────────────────────────────────────────────────────
Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

// ─── Installation ──────────────────────────────────────────────────────────
Route::get('/install', \App\Livewire\Install\Installer::class)->name('install.index');

// ─── Admin (requires valid license + authenticated user) ───────────────────
Route::middleware(['license', 'auth'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');

    // Services & Products
    Route::get('/services', \App\Livewire\Admin\Services\Index::class)->name('admin.services');
    Route::get('/products', \App\Livewire\Admin\Products\Index::class)->name('admin.products');
    Route::get('/portfolio', \App\Livewire\Admin\Portfolio\Index::class)->name('admin.portfolio');
    Route::get('/leads', \App\Livewire\Admin\Leads\Index::class)->name('admin.leads');
    Route::get('/settings', \App\Livewire\Admin\Settings\Index::class)->name('admin.settings');

    // CRM
    Route::get('/clients', \App\Livewire\Admin\Clients\Index::class)->name('admin.clients');
    Route::get('/projects', \App\Livewire\Admin\Projects\Index::class)->name('admin.projects');
    Route::get('/projects/{project}', \App\Livewire\Admin\Projects\Show::class)->name('admin.projects.show');
    Route::get('/project-types', \App\Livewire\Admin\ProjectTypes\Index::class)->name('admin.project_types');

    // Finance
    Route::get('/invoices', \App\Livewire\Admin\Invoices\Index::class)->name('admin.invoices');
    Route::get('/quotations', \App\Livewire\Admin\Quotations\Index::class)->name('admin.quotations');
    Route::get('/contracts', \App\Livewire\Admin\Contracts\Index::class)->name('admin.contracts');
    Route::get('/contract-templates', \App\Livewire\Admin\ContractTemplates\Index::class)->name('admin.contract_templates');

    // Support
    Route::get('/tickets', \App\Livewire\Admin\Tickets\Index::class)->name('admin.tickets');
    Route::get('/tickets/{ticket}', \App\Livewire\Admin\Tickets\Show::class)->name('admin.tickets.show');
    Route::get('/todos', \App\Livewire\Admin\Todos\Index::class)->name('admin.todos');

    // People
    Route::get('/employees', \App\Livewire\Admin\Employees\Index::class)->name('admin.employees');
    Route::get('/profile', \App\Livewire\Common\Profile::class)->name('admin.profile');

    // System
    Route::get('/visitors', \App\Livewire\Admin\Visitors\Index::class)->name('admin.visitors');
});

// ─── Staff Area ────────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('staff')->group(function () {
    Route::get('/', \App\Livewire\Staff\Dashboard::class)->name('staff.dashboard');
    Route::get('/tickets', \App\Livewire\Staff\Tickets\Index::class)->name('staff.tickets');
    Route::get('/tickets/{ticket}', \App\Livewire\Staff\Tickets\Show::class)->name('staff.tickets.show');
    Route::get('/todos', \App\Livewire\Staff\Todos\Index::class)->name('staff.todos');
    Route::get('/projects', \App\Livewire\Staff\Projects\Index::class)->name('staff.projects');
    Route::get('/projects/{project}', \App\Livewire\Staff\Projects\Show::class)->name('staff.projects.show');
    Route::get('/profile', \App\Livewire\Common\Profile::class)->name('staff.profile');
});

// ─── Client Portal ─────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('portal')->group(function () {
    Route::get('/', \App\Livewire\Portal\Dashboard::class)->name('portal.dashboard');
});
